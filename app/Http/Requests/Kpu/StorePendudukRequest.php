<?php

namespace App\Http\Requests\Kpu;

use Illuminate\Foundation\Http\FormRequest;

class StorePendudukRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'provinsi_id'  => 'required',
            'kota_kab_id'  => 'required',
            'kecamatan_id' => 'required',
            'kelurahan_id' => 'required',
            'nama'         => 'required',
            'nik'          => 'required|integer|unique:data_penduduks,nik|digits:16',
            'kk'           => 'required|integer|digits:16',
            'tps_id'       => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nik.unique'            => 'Data NIK Sudah Ada DiDatabase',
            'kk.unique'             => 'Data KK Sudah Ada DiDatabase',
            'nik.digits'            => 'Panjang NIK Tidak Sama Dengan 16',
            'kk.digits'             => 'Panjang KK Tidak Sama Dengan 16',
            'nik.integer'           => 'NIK Harus Berupa Angka',
            'kk.integer'            => 'KK Harus Berupa Angka',
        ];
    }
}
