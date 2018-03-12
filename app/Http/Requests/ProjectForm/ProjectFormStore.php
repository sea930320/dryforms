<?php

namespace App\Http\Requests\ProjectForm;

use App\Http\Requests\BaseRequest;

class ProjectFormStore extends BaseRequest
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
        $rules = [];

        if ($this->request->has('project_forms')) {
            foreach ($this->request->get('project_forms') as $key => $project_form) {
                $rules['project_forms.' . $key . '.form_id'] = 'required|exists:forms,id';
                $rules['project_forms.' . $key . '.company_id'] = 'required|exists:companies,id';
                $rules['project_forms.' . $key . '.project_id'] = 'required|exists:projects,id';
            }
        }

        return $rules;
    }
}
