<?php

namespace App\Http\Requests\StandardForms;

use App\Http\Requests\BaseRequest;

class StandardFormStore extends BaseRequest
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
            'form_id' => 'required|exists:forms,id',
            'company_id' => 'required|exists:companies,id',
            'name' => 'nullable|string',
            'title' => 'nullable|string',
            'statement' => 'nullable|string',
        ];
    }
}