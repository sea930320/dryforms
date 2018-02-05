<?php
namespace App\Http\Requests\StandardForms;

use App\Http\Requests\BaseRequest;

class StandardFormsIndex extends BaseRequest
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

        ];
    }
}