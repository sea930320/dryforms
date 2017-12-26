<?php
namespace App\Http\Requests\Categories;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class CategoryUpdate extends BaseRequest
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
            'category_id' => 'exists:equipment_categories,id',
            'name' => [
                'required',
                'string',
                Rule::unique('equipment_categories')->ignore($this->input('category_id'), 'id')
            ],
            'prefix' => 'required|string',
            'description' => 'nullable|string',
            'company_id' => 'required|exists:companies,id'
        ];
    }

    /**
     * @return array
     */
    public function validationData()
    {
        $this->merge(
            [
                'category_id' => $this->route('category')
            ]
        );

        return parent::validationData();
    }
}
