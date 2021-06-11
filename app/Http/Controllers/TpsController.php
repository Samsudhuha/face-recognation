<?php

namespace App\Http\Controllers;

use App\Http\Requests\Kpu\WilayahRequest;
use App\Http\Requests\Ppl\UpdateTPSRequest;
use App\Models\Data_penduduk;
use App\Models\Log_tps;
use App\Models\Tps;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TpsController extends Controller
{
    protected $wilayahController;

    public function __construct(
        WilayahController $wilayahController
        )
    {
        $this->wilayahController    = $wilayahController;
    }

    public function getTPS()
    {
        switch (Auth::user()->role) {
            case '01':
                return $this->getTPSKPU();
                break;
            case '02':
                return $this->getTPSPPL();
                break;
            default:
                return view('layouts.404');
        }
    }

    public function getTPSKPU()
    {
        $data['provincies'] = $this->wilayahController->getProvinsi();
        $data['method'] = 'get';

        return view('kpu.tps.index', $data);
    }

    public function getTPSPPL()
    {
        $user              = Auth::user();
        $data["data"]      = $this->getTpsByUser($user);

        return view('ppl.tps.index', $data);
    }

    public function postTPS(WilayahRequest $data, $flag = null)
    {
        $data['provincies'] = $this->wilayahController->getProvinsi();
        $data['kota_kabs'] = $this->wilayahController->getKotaKab($data['provinsi_id']);
        $data['kecamatans'] = $this->wilayahController->getKecamatan($data['kota_kab_id']);
        $data['kelurahans'] = $this->wilayahController->getKelurahan($data['kecamatan_id']);
        $data['datas'] = $this->getListTps($data['provinsi_id'], $data['kota_kab_id'], $data['kecamatan_id'], $data['kelurahan_id']);
        $data['method'] = 'post';

        if ($flag == 'error') {
            return view('kpu.tps.index', $data)->withErrors(["error" => "Melebih Batas Maximal"]);
        } elseif ($flag == 'success') {
            return view('kpu.tps.index', $data)->with('success', 'Berhasil Menambah Data TPS');
        }

        return view('kpu.tps.index', $data);
    }

    public function updateTPS(UpdateTPSRequest $data)
    {
        Tps::where('id', $data['id'])->update(['jumlah' => $data['jumlah']]);

        $log = [
            'username'      => Auth::user()->username,
            'info'          => 'Mengubah Data TPS',
            'description'   => 'Mengubah Jumlah Bilik Menjadi ' . $data['jumlah']
        ];

        Log_tps::create($log);

        return redirect('/ppl/tps');
    }

    public function storeTps(WilayahRequest $data)
    {
        $countTPS = count($this->getListTps($data['provinsi_id'], $data['kota_kab_id'], $data['kecamatan_id'], $data['kelurahan_id']));

        if ($countTPS < 9) {
            $tps = '0' . $countTPS + 1;
        } elseif ($countTPS < 99) {
            $tps = $countTPS + 1;
        } else {
            return $this->postTps($data, 'error');
        }

        $dataTPS = [
            'provinsi_id'   => $data['provinsi_id'],
            'kota_kab_id'   => $data['kota_kab_id'],
            'kecamatan_id'  => $data['kecamatan_id'],
            'kelurahan_id'  => $data['kelurahan_id'],
            'tps'           => $tps,
            'jumlah'        => '-'
        ];
        
        Tps::create($dataTPS);
        
        if ($data['provinsi_id'] < 10) {
            $provinsi = '0' . $data['provinsi_id'];
        } else {
            $provinsi = $data['provinsi_id'];
        }

        $kota_kab    = $this->wilayahController->getKotaKabById($data['kota_kab_id']);
        $kecamatan   = $this->wilayahController->getKecamatanById($data['kecamatan_id']);
        $kelurahan   = $this->wilayahController->getKelurahanById($data['kelurahan_id']);

        $user = [
            'username'  => 'PPL' . $provinsi . $kota_kab->kode_kota_kab . $kecamatan->kode_kecamatan . $kelurahan->kode_kelurahan . $tps,
            'password'  => Hash::make('password'),
            'kota_kab'  => $kota_kab->nama,
            'kecamatan' => $kecamatan->nama,
            'kelurahan' => $kelurahan->nama,
            'role'      => '02'
        ];

        User::create($user);

        $log = [
            'username'      => Auth::user()->username,
            'info'          => 'Menambahkan Data TPS',
            'description'   => 'Lokasi : ' . $provinsi . ' - ' . $kota_kab->kode_kota_kab . ' - ' . $kecamatan->kode_kecamatan . ' - ' . $kelurahan->kode_kelurahan 
        ];

        Log_tps::create($log);
        return $this->postTps($data, 'success');
    }

    public function getAntrean()
    {
        $user              = Auth::user();
        $tps               = $this->getTpsByUser($user);
        $data["datas"]     = $this->getListAntrean($tps->id);
        $data["jumlah"]    = $tps->jumlah;

        return view('ppl.tps.antrean', $data);
    }
    
    public function getListTps($provinsi_id, $kota_kab_id, $kecamatan_id, $kelurahan_id)
    {
        return Tps::where('provinsi_id', $provinsi_id)->where('kota_kab_id', $kota_kab_id)->where('kecamatan_id', $kecamatan_id)->where('kelurahan_id', $kelurahan_id)->get();
    }

    public function getTpsByUser($user)
    {
        $kode              = $this->wilayahController->getAllKodeByUser($user);

        if (substr($kode['kode_provinsi'],1,1) == '0') {
            $provinsi_id = substr($kode['kode_provinsi'],2,1);
        } else {
            $provinsi_id = $kode['kode_provinsi'];
        }

        $kota_kab_id       = $this->wilayahController->getKotaKabByKode($kode['kode_kota_kab'], $provinsi_id)->id;
        $kecamatan_id      = $this->wilayahController->getKecamatanByKode($kode['kode_kecamatan'], $kota_kab_id)->id;
        $kelurahan_id      = $this->wilayahController->getKelurahanByKode($kode['kode_kelurahan'], $kecamatan_id)->id;

        return Tps::where('provinsi_id', $provinsi_id)->where('kota_kab_id', $kota_kab_id)->where('kecamatan_id', $kecamatan_id)->where('kelurahan_id', $kelurahan_id)->where('tps', $kode['kode_tps'])->first();
    }

    public function getListAntrean($tps_id)
    {
        return Data_penduduk::where('tps_id', $tps_id)->where('status', 1)->get();
    }

    public function getListSudah($tps_id)
    {
        return Data_penduduk::where('tps_id', $tps_id)->where('status', 2)->get();
    }
}
