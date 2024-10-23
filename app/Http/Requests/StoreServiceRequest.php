<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
            'price' => 'required',
            'service_catalogue_id' => 'gt:0',
            'room_catalogue_id' => 'gt:0'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên dịch vụ không được để trống',
            'price.required' => 'Giá dịch vụ không được để trống',
            'service_catalogue_id.gt' => 'Bạn cần chọn nhóm dịch vụ',
            'room_catalogue_id.gt' => 'Bạn cần chọn nhóm phòng cho dịch vụ'
        ];
    }
}
