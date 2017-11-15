<?php

namespace App\Http\Requests\Teams;;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class TeamUpdate extends BaseRequest
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
            'team_id' => 'exists:equipment_teams,id',
            'name' => [
                'required',
                'string',
                Rule::unique('equipment_teams')->ignore($this->input('team_id'), 'id')
            ],
        ];
    }
}
