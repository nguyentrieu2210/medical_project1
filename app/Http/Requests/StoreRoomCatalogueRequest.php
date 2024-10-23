<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomCatalogueRequest extends FormRequest
{
    /**
     * Determine if the RoomCatalogue is authorized to make this request.
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
            'keyword' => 'required|unique:room_catalogues,keyword',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên nhóm phòng không được để trống',
            'keyword.required' => 'Từ khóa không được để trống',
            'keyword.unique' => 'Từ khóa đã tồn tại, vui lòng sử dụng từ khóa khác',
        ];
    }
}
