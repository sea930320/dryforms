<?php
namespace App\Http\Requests\Dew;

use Illuminate\Foundation\Http\FormRequest;

class CalculateRequest extends FormRequest
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
            'temperature' => ['required', 'integer'],
            'rh' => ['required', 'integer']
        ];
    }
}