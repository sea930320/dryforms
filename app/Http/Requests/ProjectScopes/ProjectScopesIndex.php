<?php

namespace App\Http\Requests\ProjectScopes;

use App\Http\Requests\BaseRequest;

class ProjectScopesIndex extends BaseRequest
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
            'project_area_id' => 'sometimes|required|exists:project_areas,id',
            'curPageNum'=> 'nullable|numeric'
        ];
    }
}
