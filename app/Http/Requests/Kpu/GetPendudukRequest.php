<?php

namespace App\Http\Requests\Kpu;

use Illuminate\Foundation\Http\FormRequest;

class GetPendudukRequest extends FormRequest
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
            'tps_id' => 'required',
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
            'provinsi_id.required'  => 'Pilih Provinsi Terlebih Dahulu',
            'kota_kab_id.required'  => 'Pilih Kota / Kabupaten Terlebih Dahulu',
            'kecamatan_id.required' => 'Pilih Kecamatan Terlebih Dahulu',
            'kelurahan_id.required' => 'Pilih Kelurahan Terlebih Dahulu',
            'tps_id.required'       => 'Pilih TPS Terlebih Dahulu',
        ];
    }
}
