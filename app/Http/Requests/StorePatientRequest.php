<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'name' => 'required',
            'cccd_number' => 'required',
            'birthday' => 'required',
            'address' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên bệnh nhân không được để trống',
            'cccd_number.required' => 'Số căn cước công dân không được để trống',
            'birthday.required' => 'Ngày sinh không được để trống',
            'address' => 'Địa chỉ không được để trống'
        ];
    }
}
