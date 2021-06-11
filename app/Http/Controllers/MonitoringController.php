<?php

namespace App\Http\Controllers;

use App\Http\Requests\Kpu\GetPendudukRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{
    protected $wilayahController;
    protected $pendudukController;
    protected $tpsController;

    public function __construct(
        WilayahController $wilayahController,
        TpsController $tpsController,
        PendudukController $pendudukController
        )
    {
        $this->wilayahController    = $wilayahController;
        $this->tpsController        = $tpsController;
        $this->pendudukController   = $pendudukController;
    }

    public function getMonitoringPemilu()
    {
        switch (Auth::user()->role) {
            case '01':
                return $this->getMonitoringPemiluKPU();
                break;
            case '02':
                return $this->getMonitoringPemiluPPL();
                break;
            default:
                return view('layouts.404');
        }
    }   

    public function getMonitoringPemiluPPL()
    {
        $user              = Auth::user();
        $tps_id            = $this->tpsController->getTpsByUser($user)->id;
        $data["total"]     = count($this->pendudukController->getListPenduduk($tps_id));
        $data["sedang"]    = count($this->tpsController->getListAntrean($tps_id));
        $data["sudah"]     = count($this->tpsController->getListSudah($tps_id));
        $data["belum"]     = $data["total"] - $data["sedang"] - $data["sudah"];

        return view('ppl.monitoring.pemilu', $data);
    }

    public function getMonitoringPemiluKPU()
    {
        $data['provincies'] = $this->wilayahController->getProvinsi();
        $data['method'] = 'get';

        return view('kpu.monitoring.pemilu', $data);
    }


    public function postMonitoringPemilu(GetPendudukRequest $data)
    {
        $data['provincies'] = $this->wilayahController->getProvinsi();
        $data['kota_kabs']  = $this->wilayahController->getKotaKab($data['provinsi_id']);
        $data['kecamatans'] = $this->wilayahController->getKecamatan($data['kota_kab_id']);
        $data['kelurahans'] = $this->wilayahController->getKelurahan($data['kecamatan_id']);
        $data['tpss']       = $this->tpsController->getListTps($data['provinsi_id'], $data['kota_kab_id'], $data['kecamatan_id'], $data['kelurahan_id']);
        $data['datas']      = $this->pendudukController->getListPenduduk($data['tps_id']);
        $data['method']     = 'post';
        $data["total"]      = count($this->pendudukController->getListPenduduk($data['tps_id']));
        $data["sedang"]     = count($this->tpsController->getListAntrean($data['tps_id']));
        $data["sudah"]      = count($this->tpsController->getListSudah($data['tps_id']));
        $data["belum"]      = $data["total"] - $data["sedang"] - $data["sudah"];

        return view('kpu.monitoring.pemilu', $data);
    }
}
