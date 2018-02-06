<?php

namespace App\Http\Requests\Projects;

use App\Http\Requests\BaseRequest;

class ProjectUpdate extends BaseRequest
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
            'project_id' => 'required|exists:projects,id',
            'company_id' => 'required|exists:companies,id',
            'owner_id' => 'required|exists:users,id',
            'assigned_to' => 'nullable|exists:users,id',
            'address' => 'nullable',
            'phone' => 'nullable',
            'status' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function validationData()
    {
        $this->merge(
            [
                'project_id' => $this->route('project')
            ]
        );

        return parent::validationData();
    }
}