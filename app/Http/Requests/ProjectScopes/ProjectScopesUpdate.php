<?php

namespace App\Http\Requests\ProjectScopes;

use App\Http\Requests\BaseRequest;

class ProjectScopesUpdate extends BaseRequest
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
            'project_id' => 'required|exists:projects,id',
            'project_area_id' => 'nullable|exists:project_areas,id',
            'selected' => 'sometimes|required|in:0,1',
            'service' => 'nullable|string',
            'is_header' => 'sometimes|required|in:0,1',
            'qty' => 'nullable|string',
            'uom' => 'nullable|exists:units_of_measure',
            'page' => 'sometimes|required|numeric',
            'no' => 'sometimes|required|numeric'
        ];
    }
}
