<?php

namespace App\Http\Requests\Projects;

use App\Http\Requests\BaseRequest;

class ProjectStore extends BaseRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'company_id' => 'required|exists:companies,id',
            'owner_id' => 'required|exists:users,id',
            'assigned_to' => 'nullable|exists:teams,id',
            'address' => 'nullable',
            'phone' => 'nullable',
            'status' => 'nullable',
        ];
    }
}