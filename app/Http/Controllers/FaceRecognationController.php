<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ppl\FaceRecognationRequest;
use App\Models\Data_penduduk;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;

class FaceRecognationController extends Controller
{
    protected $tpsController;

    public function __construct(
        TpsController $tpsController
        )
    {
        $this->tpsController        = $tpsController;
    }

    private function apiCall($data,$route){
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://tpspintar.com/face'.$route,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
        ));

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);
        return [$response, $httpcode];
    }

    private function uploadImage($image)
    {
        $base64File = $image;

        // decode the base64 file
        $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64File));

        // save it to temporary dir first.
        $tmpFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString();
        file_put_contents($tmpFilePath, $fileData);

        // this just to help us get file info.
        $tmpFile = new File($tmpFilePath);

        $file = new UploadedFile(
            $tmpFile->getPathname(),
            $tmpFile->getFilename(),
            $tmpFile->getMimeType(),
            0,
            true // Mark it as test, since the file isn't from real HTTP POST.
        );
        return $file;
    }

    public function getFaceRecognation()
    {
        return view('ppl.facerecognation.index');
    }

    public function daftarFaceRecognation()
    {
        return view('ppl.facerecognation.daftar');
    }

    public function getFaceRecognationAkhir($id)
    {
        $data['id'] = $id;

        return view('ppl.facerecognation.selesai', $data);
    }

    public function postFaceRecognationAwal(FaceRecognationRequest $request)
    {
        $user           = Auth::user();
        $tps            = $this->tpsController->getTpsByUser($user);
        $flag_penduduk  = Data_penduduk::where('nik', $request['nik'])->where('tps_id', $tps->id)->first();

        if (!$flag_penduduk) {
            return redirect('/ppl/face-recognation')->withErrors(["error" => "Anda Tidak Dapat Mencoblos Di TPS Ini, Silahkan Memilih Di TPS Yang Sudah Disesuaikan"]);
        } elseif ($flag_penduduk->status == -1) {
            return redirect('/ppl/face-recognation')->withErrors(["error" => "Anda Tidak Mendaftar Pemilihan Umum"]);
        } elseif ($flag_penduduk->status == 2) {
            return redirect('/ppl/face-recognation')->withErrors(["error" => "Anda Sudah Mencoblos"]);
        } else {
            for ($i=1; $i < 2; $i++) { 
                $imageFile = $this->uploadImage($request['file' . $i]);
                $imageFile->storeAs('/public/predict/image/' . $request['nik'], '/image' . $i . '.' . $imageFile->extension());
            }

            //API CALL
            $data = array('id' => $request['nik'],'image_name' => 'image1.' . $imageFile->extension());
            $response = $this->apiCall($data, '/recognition/predictById');

            if ($response[1]!=200){
                return redirect('/ppl/face-recognation')->withErrors(["error" => "NIK dan Gambar tidak serasi"]);
            }

            $flag_bilik = Data_penduduk::where('tps_id', $tps->id)->orderBy('antrean', 'desc')->first()->antrean;
            if ($flag_bilik == '-') {
                $flag_bilik = 0;
            }
            if ($flag_bilik < $tps->jumlah) {
                $flag_bilik += 1;
            } else {
                for ($i = 1; $i < $tps->jumlah; $i++) { 
                    $flag_antrean = Data_penduduk::where('tps_id', $tps->id)->where('antrean', $i)->first();
                    if (!$flag_antrean) {
                        $flag_bilik = $i;
                        $i = $tps->jumlah;
                    } else {
                        $flag_bilik = '-';
                    }
                }
            }
            
            Data_penduduk::where('nik', $request['nik'])->where('tps_id', $tps->id)->update(['status' => 1, 'antrean' => $flag_bilik]);
            return redirect('/ppl/face-recognation');
        }
    }

    public function postFaceRecognationDaftar(FaceRecognationRequest $request)
    {
        $user           = Auth::user();
        $tps            = $this->tpsController->getTpsByUser($user);
        $flag_penduduk  = Data_penduduk::where('nik', $request['nik'])->first();

        if (!$flag_penduduk) {
            return redirect('/ppl/face-recognation/daftar')->withErrors(["error" => "Data NIK Anda Tidak Ada Di Database, Silahkan Hubungi Kantor KPU Pusat"]);
        } elseif ($flag_penduduk->status == 0) {
            return redirect('/ppl/face-recognation')->withErrors(["error" => "Anda Sudah Mendaftar"]);
        } else {
            for ($i=1; $i < 6; $i++) { 
                $imageFile = $this->uploadImage($request['file' . $i]);
                $imageFile->storeAs('/public/upload/image/' . $request['nik'], '/image' . $i . '.' . $imageFile->extension());
            }
            
            //API CALL
            $data = array('id' => $request['nik']);
            $response = $this->apiCall($data, '/recognition/trainById');

            if ($response[1]!=200){
                return redirect('/ppl/face-recognation')->withErrors(["error" => "Terdapat gangguan, Silahkan coba lagi"]);
            }

            Data_penduduk::where('nik', $request['nik'])->update(['status' => 0]);
            return redirect('/ppl/face-recognation/daftar');
        }
    }

    public function postFaceRecognationAkhir(FaceRecognationRequest $request)
    {
        $user           = Auth::user();
        $tps            = $this->tpsController->getTpsByUser($user);
        $data_penduduk  = $this->tpsController->getListAntrean($tps->id);
        $flag_penduduk  = Data_penduduk::where('nik', $request['nik'])->first();

        if ($data_penduduk[0]->antrean == '-') {
            Data_penduduk::where('nik', $data_penduduk[0]->nik)->update(['antrean' => $flag_penduduk->antrean]);
        }
        Data_penduduk::where('nik', $request['nik'])->update(['status' => 2, 'antrean' => '-']);
        return redirect('/ppl/antrean');
    }
}
