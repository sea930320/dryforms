<?php

namespace App\Http\Requests\StandardForms;

use App\Http\Requests\BaseRequest;

class StatementStore extends BaseRequest
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
            'title' => 'required|string'
        ];
    }
}