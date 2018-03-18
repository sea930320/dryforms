<?php

namespace App\Http\Requests\ProjectDailylog;

use App\Http\Requests\BaseRequest;

class ProjectDailylogUpdate extends BaseRequest
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
            'id' => 'required|exists:project_dailylogs,id',
            'form_id' => 'sometimes|required|exists:forms,id',
            'company_id' => 'sometimes|required|exists:companies,id',
            'project_id' => 'sometimes|required|exists:projects,id',
            'is_copied'=>'sometimes|required|in:0,1',            
            'notes'=>'nullable|string'
        ];
    }
}
