<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionRequest extends FormRequest
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
            'keyword' => 'required|unique:permissions,keyword,' . $this->route('permission'),
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên quyền không được để trống',
            'keyword.required' => 'Từ khóa không được để trống',
            'keyword.unique' => 'Từ khóa đã tồn tại, vui lòng sử dụng từ khóa khác',
        ];
    }
}
