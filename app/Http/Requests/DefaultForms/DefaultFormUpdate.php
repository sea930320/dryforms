<?php

namespace App\Http\Requests\DefaultForms;

use App\Http\Requests\BaseRequest;

class DefaultFormUpdate extends BaseRequest
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
        $rules = [
            'form_id' => 'sometimes|required|exists:forms,id',
            'name' => 'nullable|string',
            'title' => 'nullable|string',
            'additional_notes_show' => 'sometimes|required|in:0,1',
            'footer_text_show' => 'sometimes|required|in:0,1',
            'insured_signature' => 'nullable|string',
            'company_signature' => 'nullable|string',
            'footer_text' => 'nullable|string'
        ];

        if ($this->request->has('statements')) {
            foreach ($this->request->get('statements') as $key => $value) {
                $rules['statements.' . $key . '.id'] = 'sometimes|nullable|exists:default_statements,id';
                $rules['statements.' . $key . '.form_id'] = 'required|exists:forms,id';
                $rules['statements.' . $key . '.title'] = 'nullable|string';
                $rules['statements.' . $key . '.statement'] = 'nullable|string';
            }
        }

        return $rules;
    }
}