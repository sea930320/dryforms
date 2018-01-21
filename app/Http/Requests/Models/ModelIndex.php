<?php

namespace App\Http\Requests\Models;

use App\Http\Requests\BaseIndexRequest;

class ModelIndex extends BaseIndexRequest
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
            'category_id' => 'nullable|exists:equipment_categories,id',
            'per_page' => 'nullable|integer',
            'category_name' => 'nullable|string',
            'model_name' => 'nullable|string',
            'sort_by' => 'nullable|string',
            'sort_type' => 'nullable|in:asc,desc',
        ];
    }
}