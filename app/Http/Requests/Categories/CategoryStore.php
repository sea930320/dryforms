<?php
namespace App\Http\Requests\Categories;

use App\Http\Requests\BaseRequest;

class CategoryStore extends BaseRequest
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
            'name' => 'required|string|unique:equipment_categories,name',
            'prefix' => 'required|string',
            'description' => 'nullable|string',
        ];
    }
}
