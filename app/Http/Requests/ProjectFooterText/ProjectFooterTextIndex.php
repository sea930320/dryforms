<?php

namespace App\Http\Requests\ProjectFooterText;

use App\Http\Requests\BaseRequest;

class ProjectFooterTextIndex extends BaseRequest
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
            'form_id' => 'required|exists:forms,id'
        ];
    }
}
