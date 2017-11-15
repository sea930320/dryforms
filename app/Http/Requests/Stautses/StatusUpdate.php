<?php

namespace App\Http\Requests\Statuses;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class StatusUpdate extends BaseRequest
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
            'status_id' => 'exists:equipment_statuses,id',
            'name' => [
                'required',
                'string',
                Rule::unique('equipment_models')->ignore($this->input('model_id'), 'id')
            ],
        ];
    }
}
