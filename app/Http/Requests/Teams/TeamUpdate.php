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
            'team_id' => 'exists:teams,id',
            'name' => [
                'required',
                'string',
                Rule::unique('teams')->ignore($this->input('team_id'), 'id')
            ],
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
                'team_id' => $this->route('team')
            ]
        );

        return parent::validationData();
    }
}
