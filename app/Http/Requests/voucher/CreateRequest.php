<?php

namespace App\Http\Requests\voucher;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CreateRequest extends FormRequest
{
    public $validator = null;
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
                'id_customer' => 'required',
                'id_promo' => 'required',
                'jumlah' => 'required',
                'jumlah_nominal' => 'required',
                'tanggal_mulai' => 'required',
                'periode_selesai' => 'nullable',
                'catatan' => 'required',
        ];
    }
    
    public function failedValidation(Validator $validator)
    {
       $this->validator = $validator;
    }

    public function attributes()
    {
        return [
            'id_customer' => 'Customer',
            'id_promo' => 'voucher'
        ];
    }
}
