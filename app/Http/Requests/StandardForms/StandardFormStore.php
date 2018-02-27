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
        $rules = [
            'form_id' => 'sometimes|required|exists:forms,id',
            'company_id' => 'sometimes|required|exists:companies,id',
            'name' => 'nullable|string',
            'title' => 'nullable|string',
            'additional_notes_show' => 'sometimes|required|in:0,1',
            'footer_text_show' => 'sometimes|required|in:0,1',
            'insured_signature' => 'sometimes|nullable|string',
            'company_signature' => 'sometimes|nullable|string',
            'footer_text' => 'nullable|string'
        ];

        if ($this->request->has('statements')) {
            foreach ($this->request->get('statements') as $key => $value) {
                $rules['statements.' . $key . '.id'] = 'sometimes|nullable|exists:standard_statements,id';
                $rules['statements.' . $key . '.form_id'] = 'required|exists:forms,id';
                $rules['statements.' . $key . '.company_id'] = 'in:' . auth()->user()->company_id;
                $rules['statements.' . $key . '.title'] = 'nullable|string';
                $rules['statements.' . $key . '.statement'] = 'nullable|string';
            }
        }

        return $rules;
    }
}