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

        ];
    }
}