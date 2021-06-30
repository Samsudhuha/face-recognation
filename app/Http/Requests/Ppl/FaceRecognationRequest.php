<?php

namespace App\Http\Requests\Ppl;

use Illuminate\Foundation\Http\FormRequest;

class FaceRecognationRequest extends FormRequest
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
            'file1'   => 'required',
            'file2'   => 'required',
            'file3'   => 'required',
            'file4'   => 'required',
            'file5'   => 'required',
            'nik'     => 'required|integer|digits:16',
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
            'file1.required'       => 'Foto Harus Sebanyak 5 Kali',
            'file2.required'       => 'Foto Harus Sebanyak 5 Kali',
            'file3.required'       => 'Foto Harus Sebanyak 5 Kali',
            'file4.required'       => 'Foto Harus Sebanyak 5 Kali',
            'file5.required'       => 'Foto Harus Sebanyak 5 Kali',
            'nik.digits'           => 'Panjang NIK Tidak Sama Dengan 16',
            'nik.integer'          => 'NIK Harus Berupa Angka',
        ];
    }
}
