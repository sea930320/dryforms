<?php

namespace App\Http\Requests\Equipments;

use App\Http\Requests\BaseIndexRequest;

class EquipmentIndex extends BaseIndexRequest
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
            'status_id' => 'nullable|exists:equipment_statuses,id',
            'model_id' => 'nullable|exists:equipment_models,id',
            'team_id' => 'nullable|exists:teams,id',
            'per_page' => 'nullable|integer',
            'filter' => 'nullable|string',
            'sort_by' => 'nullable|string',
            'sort_type' => 'nullable|in:asc,desc',
            'id_from' => 'nullable|integer',
        ];
    }
}