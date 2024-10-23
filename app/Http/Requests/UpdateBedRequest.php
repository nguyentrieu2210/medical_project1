<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBedRequest extends FormRequest
{
    /**
     * Determine if the Roo is authorized to make this request.
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
            'code' => 'required|unique:beds,code,' . $this->route('bed'),
            'room_id' => 'gt:0'
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Mã giường không được để trống',
            'code.unique' => 'Mã giường đã tồn tại, vui lòng sử dụng mã giường khác',
            'room_id.gt' => 'Bạn cần chọn phòng',
        ];
    }
}
