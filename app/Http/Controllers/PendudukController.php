<?php

namespace App\Http\Controllers;

use App\Http\Requests\Kpu\GetPendudukRequest;
use App\Http\Requests\Kpu\ImportFilePendudukRequest;
use App\Http\Requests\Kpu\StorePendudukRequest;
use App\Http\Requests\Kpu\WilayahRequest;
use App\Models\Log_penduduk;
use App\Models\Data_penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Box\Spout\Common\Type;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

class PendudukController extends Controller
{
    protected $wilayahController;
    protected $tpsController;

    public function __construct(
        WilayahController $wilayahController,
        TpsController $tpsController
        )
    {
        $this->wilayahController    = $wilayahController;
        $this->tpsController        = $tpsController;
    }

    public function getPenduduk()
    {
        switch (Auth::user()->role) {
            case '00':
            case '01':
                return $this->getPendudukKPU();
                break;
            case '02':
                return $this->getPendudukPPL();
                break;
            default:
                return view('layouts.404');
        }
    }

    public function getPendudukPPL()
    {
        $user              = Auth::user();
        $tps_id            = $this->tpsController->getTpsByUser($user)->id;
        $data["datas"]     = $this->getListPenduduk($tps_id);

        return view('ppl.penduduk.index', $data);
    }

    public function getPendudukKPU()
    {
        $user               = Auth::user();
        $kota_kab_id        = substr($user->username, 3, 3);
        if (substr($kota_kab_id, 0, 2) == '00') {
            $kota_kab_id = substr($kota_kab_id, 2, 1);
        } elseif (substr($kota_kab_id, 0, 1) == '0') {
            $kota_kab_id = substr($kota_kab_id, 1, 2);
        }

        $data['kota']      = $this->wilayahController->getKotaKabById($kota_kab_id);
        $data['kecamatans'] = $this->wilayahController->getKecamatan($kota_kab_id);
        $data['method']     = 'get';

        return view('kpu.penduduk.index', $data);
    }

    public function postPenduduk(GetPendudukRequest $data, $flag = null)
    {
        $data['kota']       = $this->wilayahController->getKotaKabById($data['kota_kab_id']);
        $data['provinsi_id']= $data['kota']->provinsi_id;
        $data['kecamatans'] = $this->wilayahController->getKecamatan($data['kota_kab_id']);
        $data['kelurahans'] = $this->wilayahController->getKelurahan($data['kecamatan_id']);
        $data['tpss']       = $this->tpsController->getListTps($data['kota_kab_id'], $data['kecamatan_id'], $data['kelurahan_id']);
        $data['datas']      = $this->getListPenduduk($data['tps_id']);
        $data['method']     = 'post';

        if ($flag == 'error') {
            return view('kpu.penduduk.index', $data)->withErrors(["error" => "Melebih Batas Maximal"]);
        } elseif ($flag == 'success') {
            return view('kpu.penduduk.index', $data)->with('success', 'Berhasil Menambah Data Penduduk');
        }

        return view('kpu.penduduk.index', $data);
    }

    public function storePenduduk(StorePendudukRequest $data, GetPendudukRequest $data2)
    {
        $dataPenduduk = [
            'nama'      => $data['nama'],
            'nik'       => $data['nik'],
            'kk'        => $data['kk'],
            'antrean'   => '-',
            'tps_id'    => $data['tps_id'],
            'status'    => -1
        ];
        
        Data_penduduk::create($dataPenduduk);

        $log = [
            'username'      => Auth::user()->username,
            'info'          => 'Menambahkan Data Penduduk',
            'description'   => 'Nama : ' . $data['nama'] . ' - NIK : ' . $data['nik'] . ' - KK : ' . $data['kk'] . ' - TPS : ' . $data['tps_id'] 
        ];

        Log_penduduk::create($log);

        return $this->postPenduduk($data2, 'success');
    }

    public function getListPenduduk($tps_id)
    {
        return Data_penduduk::where('tps_id', $tps_id)->get();
    }
    
    public function exportPenduduk()
    {
        return Storage::download('public/tamplate-excel-penduduk.xlsx');
    }

    public function importPenduduk(ImportFilePendudukRequest $request, GetPendudukRequest $data2)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');// get file
            $reader = ReaderEntityFactory::createXLSXReader();
            $reader->open($file);
            $data = [];
            // loop semua sheet dan dapatkan sheet orders
            foreach ($reader->getSheetIterator() as $sheet) {
                $idx = 0;
                foreach ($sheet->getRowIterator() as $i => $row) {
                    if ($i>1) { // skip baris pertama excel (Judul)
                        $row = $row->toArray();
                        
                        $data[$idx] = [
                            'nama' => $row[0],
                            'nik' => $row[1],
                            'kk' => $row[2],
                        ];
                        $idx+=1;
                    }
                }
            }
            $errors = [];
            $flag_add = 0;
            for ($i=0; $i < count($data); $i++) { 
                $validate = $this->validateExcel($data[$i], $i+2);
                if (count($validate) == 0) {
                    $flag_add = 1;
                    $dataPenduduk = [
                        'nama'      => $data[$i]['nama'],
                        'nik'       => $data[$i]['nik'],
                        'kk'        => $data[$i]['kk'],
                        'antrean'   => '-',
                        'tps_id'    => $data2['tps_id'],
                        'status'    => 0
                    ];
                    
                    Data_penduduk::create($dataPenduduk);

                    $log = [
                        'username'      => Auth::user()->username,
                        'info'          => 'Menambahkan Data Penduduk',
                        'description'   => 'Nama : ' . $data[$i]['nama'] . ' - NIK : ' . $data[$i]['nik'] . ' - KK : ' . $data[$i]['kk'] . ' - TPS : ' . $data2['tps_id'] 
                    ];
    
                    Log_penduduk::create($log);
                } else {
                    $errors[$i] = $validate[$i+2];
                }
            }
            $reader->close();
            return $this->postPenduduk($data2, 'success')->with('success', 'Berhasil Menambah Data Penduduk')->withErrors($errors);
            if ($flag_add == 1) {
                return $this->postPenduduk($data2, 'success')->with('success', 'Berhasil Menambah Data Penduduk')->withErrors($errors);
            }
            return $this->postPenduduk($data2, 'success')->withErrors($errors);
        }
    
        return $this->postPenduduk($data2, 'error')->with('error','Please Check your file, Something is wrong there.');
    }

    public function validateExcel($data, $i)
    {
        $errors = [];
        if ($data['nama'] == '') {
            $errors[$i] = ['error'=>'Field nama tidak ada pada row ' . $i];
        }
        if ($data['nik'] == '') {
            $errors[$i] = ['error'=>'Field nik tidak ada pada row ' . $i];
        } else {
            if (!is_numeric($data['nik']) || $data['nik'] < 1 || strlen($data['nik']) != 16) {
                $errors[$i] = ['error'=>'Field nik tidak sesuai pada row ' . $i];
            }
            if (Data_penduduk::where('nik', $data['nik'])->first() != null) {
                $errors[$i] = ['error'=>'Data nik sudah ada di database pada row ' . $i];
            }
        }
        if ($data['kk'] == '') {
            $errors[$i] = ['error'=>'Field kk tidak ada pada row ' . $i];
        } else {
            if (!is_numeric($data['kk']) || $data['kk'] < 1 || strlen($data['kk']) != 16) {
                $errors[$i] = ['error'=>'Field kk tidak sesuai pada row ' . $i];
            }
        }
        return $errors;
    }
}
