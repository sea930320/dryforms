<?php

namespace App\Http\Requests\ProjectStatement;

use App\Http\Requests\BaseRequest;

class ProjectStatementIndex extends BaseRequest
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
            'form_id' => 'required|exists:forms,id'
        ];
    }
}
