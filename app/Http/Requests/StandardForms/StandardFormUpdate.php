<?php

namespace App\Http\Requests\StandardForms;

use App\Http\Requests\BaseRequest;

class StandardFormUpdate extends BaseRequest
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
            'id' => 'exists:standard_forms,id',
            'form_id' => 'sometimes|required|exists:forms,id',
            'company_id' => 'sometimes|required|exists:companies,id',
            'name' => 'nullable|string',
            'title' => 'nullable|string',
            'statement' => 'nullable|string',
        ];
    }

    /**
     * @return array
     */
    public function validationData()
    {
        $this->merge(
            [
                'id' => $this->route('form')
            ]
        );

        return parent::validationData();
    }
}