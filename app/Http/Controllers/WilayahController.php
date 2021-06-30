<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Kota_kab;
use App\Models\Provincies;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function getProvinsi()
    {
        return Provincies::all();
    }

    public function getKotaKab($provinsi_id)
    {
        return Kota_kab::where('provinsi_id', $provinsi_id)->get();
    }

    public function getKecamatan($kota_kab_id)
    {
        return Kecamatan::where('kota_kab_id', $kota_kab_id)->get();
    }

    public function getKelurahan($kecamatan_id)
    {
        return Kelurahan::where('kecamatan_id', $kecamatan_id)->get();
    }

    public function getProvinsiById($provinsi_id)
    {
        return Provincies::where('id', $provinsi_id)->first();
    }

    public function getKotaKabById($kota_kab_id)
    {
        return Kota_kab::where('id', $kota_kab_id)->first();
    }

    public function getKecamatanById($kecamatan_id)
    {
        return Kecamatan::where('id', $kecamatan_id)->first();
    }

    public function getKelurahanById($kelurahan_id)
    {
        return Kelurahan::where('id', $kelurahan_id)->first();
    }

    public function getKotaKabByKode($kota_kab_kode, $provinsi_id)
    {
        return Kota_kab::where('kode_kota_kab', $kota_kab_kode)->where('provinsi_id', $provinsi_id)->first();
    }

    public function getKecamatanByKode($kecamatan_kode, $kota_kab_id)
    {
        return Kecamatan::where('kode_kecamatan', $kecamatan_kode)->where('kota_kab_id', $kota_kab_id)->first();
    }

    public function getKelurahanByKode($kelurahan_kode, $kecamatan_id)
    {
        return Kelurahan::where('kode_kelurahan', $kelurahan_kode)->where('kecamatan_id', $kecamatan_id)->first();
    }

    public function getAllKodeByUser($user)
    {
        if (strlen($user->username) == 15) {
            $data["kode_provinsi"]  = substr($user->username, 3, 2);
            $data["kode_kota_kab"]  = substr($user->username, 5, 2);
            $data["kode_kecamatan"] = substr($user->username, 7, 2);
            $data["kode_kelurahan"] = substr($user->username, 9, 4);
            $data["kode_tps"]       = substr($user->username, 13, 2);
        } elseif (strlen($user->username) == 14) {
            $data["kode_provinsi"]  = substr($user->username, 3, 2);
            $data["kode_kota_kab"]  = substr($user->username, 5, 1);
            $data["kode_kecamatan"] = substr($user->username, 6, 2);
            $data["kode_kelurahan"] = substr($user->username, 8, 4);
            $data["kode_tps"]       = substr($user->username, 12, 2);
        }

        return $data;
    }
}
