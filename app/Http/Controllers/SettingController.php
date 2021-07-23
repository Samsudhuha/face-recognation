<?php

namespace App\Http\Controllers;

use App\Http\Requests\Kpu\GetPendudukRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SettingController extends Controller
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

    public function getSettingAksi()
    {
        return view('kpu.setting.aksi');
    }   

    public function postSettingAksi(Request $request)
    {
        $user      = Auth::user();
        $setting   = $request->aksi;
        $kota_kab = $this->wilayahController->getKotaKabById(substr($user->username, 3, 3));
        if ($setting == 'pendaftaran') {
            User::where('id', $user->id)->update(['role' => '00']);
            User::where('kota_kab', $kota_kab->nama)->update(['role' => '03']);
        } else {
            User::where('id', $user->id)->update(['role' => '01']);
            User::where('kota_kab', $kota_kab->nama)->update(['role' => '02']);
        }

        return redirect('/kpu/setting/aksi');
    }
}
