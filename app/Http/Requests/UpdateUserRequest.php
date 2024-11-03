<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'cccd' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->route('user'),
            'password' => 'required|min:6|max:12',
            'position_id' => 'gt:0',
            'department_id' => 'gt:0',
            'address' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên nhân viên không được để trống',
            'cccd.required' => 'Số căn cước công dân của nhân viên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại, vui lòng sử dụng email khác',
            'password' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có tối thiểu 6 kí tự',
            'password.max' => 'Mật khẩu phải có tối đa 12 kí tự',
            'position_id.gt' => 'Bạn cần chọn chức danh cho nhân viên',
            'department_id.gt' => 'Bạn cần chọn khoa cho nhân viên',
            'address.required' => 'Địa chỉ không được để trống'
        ];
    }
}
