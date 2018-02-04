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
        return [
            'form_id' => 'exists:forms,id',
            'name' => ['required', 'string'],
            'title' => ['required', 'string'],
            'statement' => ['nullable', 'string'],
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
