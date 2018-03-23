<?php

namespace App\Http\Requests\ProjectForm;

use App\Http\Requests\BaseRequest;

class ProjectFormSignatureUpdate extends BaseRequest
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
            'form_id' => 'required|exists:forms,id',
            'insured_signature' => 'sometimes|nullable|string',
            'company_signature' => 'sometimes|nullable|string'
        ];
    }
}
