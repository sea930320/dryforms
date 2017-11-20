<?php

namespace App\Http\Requests\Models;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ModelUpdate extends BaseRequest
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
            'model_id' => 'exists:equipment_models,id',
            'category_id' => 'exists:equipment_categories,id',
            'name' => [
                'required',
                'string',
                Rule::unique('equipment_models')->ignore($this->input('model_id'), 'id')
            ],
            'description' => 'nullable|string',
        ];
    }

    /**
     * @return array
     */
    public function validationData()
    {
        $this->merge(
            [
                'model_id' => $this->route('model')
            ]
        );

        return parent::validationData();
    }
}
