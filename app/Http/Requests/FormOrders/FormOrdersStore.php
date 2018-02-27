<?php

namespace App\Http\Requests\FormOrders;

use App\Http\Requests\BaseRequest;

class FormOrdersStore extends BaseRequest
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

        foreach ($this->request->get('formsOrder') as $key => $value) {
            $rules['formsOrder.' . $key . '.id'] = 'required|exists:form_orders,id';
            $rules['formsOrder.' . $key . '.form_id'] = 'required|exists:forms,id';
            $rules['formsOrder.' . $key . '.company_id'] = 'in:' . auth()->user()->company_id;
        }
        
        return $rules;
    }
}
