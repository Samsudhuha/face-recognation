<?php

namespace App\Http\Requests\Ppl;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTPSRequest extends FormRequest
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
            'jumlah'   => 'required|integer|min:1',
            'id'       => 'required',
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
            'jumlah.integer'       => 'Jumlah Bilik Harus Berupa Angka',
            'jumlah.min'           => 'Jumlah Bilik Tidak Boleh Kurang Dari Satu (1)',
        ];
    }
}
