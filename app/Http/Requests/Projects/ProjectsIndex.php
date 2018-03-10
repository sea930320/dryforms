<?php
namespace App\Http\Requests\Projects;

use App\Http\Requests\BaseRequest;

class ProjectsIndex extends BaseRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'status' => 'nullable|exists:project_status,id',            
            'page' => 'nullable|integer',
            'per_page' => 'nullable|integer',
            'filter' => 'nullable|string',
            'year' => 'nullable|integer'
        ];
    }
}