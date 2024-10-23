<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicationRequest extends FormRequest
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
            'medication_catalogue_id' => 'gt:0',
            'price' => 'required',
            'measure' => 'required',
            'measure_count' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên dược không được để trống',
            'medication_catalogue_id.gt' => 'Bạn cần chọn nhóm dược',
            'price.required' => 'Giá tiền không được để trống',
            'measure.required' => 'Đơn vị không được để trống',
            'measure_count.required' => 'Số lượng dược theo đơn vị không được để trống'
        ];
    }
}
