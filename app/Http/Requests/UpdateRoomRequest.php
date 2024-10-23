<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
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
            'room_catalogue_id' => 'gt:0',
            'department_id' => 'gt:0',
            'code' => 'required|unique:rooms,code,' . $this->route('room'),
        ];
    }

    public function messages()
    {
        return [
            'room_catalogue_id.gt' => 'Bạn cần chọn nhóm phòng',
            'department_id.gt' => 'Bạn cần chọn khoa',
            'code.required' => 'Mã phòng không được để trống',
            'code.unique' => 'Mã phòng đã tồn tại, vui lòng sử dụng mã phòng khác',
        ];
    }
}
