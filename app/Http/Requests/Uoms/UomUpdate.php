<?php

namespace App\Http\Requests\Uoms;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UomUpdate extends BaseRequest
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
            'uom_id' => 'required|exists:units_of_measure,id',
            'title' => [
                'required',
                'string',
                'max:150',
                Rule::unique('units_of_measure')->ignore($this->input('uom_id'), 'id')
            ]
        ];
    }

    /**
     * @return array
     */
    public function validationData()
    {
        $this->merge(
            [
                'uom_id' => $this->segment(3)
            ]
        );

        return parent::validationData();
    }
}