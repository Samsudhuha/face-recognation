<?php

namespace App\Http\Controllers;

use App\Http\Requests\Kpu\GetPendudukRequest;
use App\Http\Requests\Kpu\StorePendudukRequest;
use App\Models\Log_penduduk;
use App\Models\Data_penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $data['provincies'] = $this->wilayahController->getProvinsi();
        $data['method'] = 'get';

        return view('kpu.penduduk.index', $data);
    }

    public function postPenduduk(GetPendudukRequest $data, $flag = null)
    {
        $data['provincies'] = $this->wilayahController->getProvinsi();
        $data['kota_kabs']  = $this->wilayahController->getKotaKab($data['provinsi_id']);
        $data['kecamatans'] = $this->wilayahController->getKecamatan($data['kota_kab_id']);
        $data['kelurahans'] = $this->wilayahController->getKelurahan($data['kecamatan_id']);
        $data['tpss']       = $this->tpsController->getListTps($data['provinsi_id'], $data['kota_kab_id'], $data['kecamatan_id'], $data['kelurahan_id']);
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
            'status'    => 0
        ];
        
        Data_penduduk::create($dataPenduduk);
        
        if ($data['provinsi_id'] < 10) {
            $provinsi = '0' . $data['provinsi_id'];
        } else {
            $provinsi = $data['provinsi_id'];
        }

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
}
