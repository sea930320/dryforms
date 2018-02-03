<?php

namespace App\Http\Requests\Equipments;

use App\Http\Requests\BaseRequest;

class EquipmentStore extends BaseRequest
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
            'status_id' => 'exists:equipment_statuses,id',
            'model_id' => 'exists:equipment_models,id',
            'team_id' => 'nullable|exists:teams,id',
            'quantity' => 'required|numeric|min:1',
            'serials' => 'nullable|array',
            'serials.*.value' => 'integer',
            'company_id' => 'required|exists:companies,id',
            'auto_assign' => 'required|in:yes,no'
        ];
    }
}
