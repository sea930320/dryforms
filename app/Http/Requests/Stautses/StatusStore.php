<?php

namespace App\Http\Requests\Statuses;

use App\Http\Requests\BaseRequest;

class StatusStore extends BaseRequest
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
            'name' => 'required|string|unique:equipment_statuses,name',
        ];
    }
}
