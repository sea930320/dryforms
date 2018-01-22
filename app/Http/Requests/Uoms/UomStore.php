<?php
namespace App\Http\Requests\Uoms;

use App\Http\Requests\BaseRequest;

class UomStore extends BaseRequest
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
            'title' => 'required|unique:units_of_measure,title|string|max:150'
        ];
    }
}