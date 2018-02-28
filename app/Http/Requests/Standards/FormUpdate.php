<?php

namespace App\Http\Requests\Standards;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class FormUpdate extends BaseRequest
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
        $rules = [
            'form_id' => 'exists:forms,id',
            'name' => ['required', 'string'],
            'title' => ['required', 'string']
        ];
        if ($this->request->has('statement_ids')) {
            foreach ($this->request->get('statement_ids') as $key => $value) {
                $rules['statement_ids.' . $key] = 'sometimes|required|exists:default_statements,id';
                $rules['statement_titles.' . $key] = 'sometimes|required|string';
                $rules['statement_texts.' . $key] = 'sometimes|nullable|string';
            }
        }

        return $rules;
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
