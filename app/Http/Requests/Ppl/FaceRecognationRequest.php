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
            'file2'   => '',
            'file3'   => '',
            'file4'   => '',
            'file5'   => '',
            'nik'     => 'required|integer|digits:16',
            'phone'   => '',
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
            'nik.digits'           => 'Panjang NIK Tidak Sama Dengan 16',
            'nik.integer'          => 'NIK Harus Berupa Angka',
        ];
    }
}
