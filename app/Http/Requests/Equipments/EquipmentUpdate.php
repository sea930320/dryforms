<?php

namespace App\Http\Requests\Equipments;

use App\Http\Requests\BaseRequest;

class EquipmentUpdate extends BaseRequest
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
            'equipment_id' => 'exists:equipments,id',
            'status_id' => 'exists:equipment_statuses,id',
            'team_id' => 'exists:equipment_teams,id',
            'location' => 'sometimes|string',
        ];
    }
}
