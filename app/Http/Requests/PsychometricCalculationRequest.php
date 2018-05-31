<?php
namespace App\Http\Requests;

class PsychometricCalculationRequest extends BaseRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'temperature' => ['required', 'integer', 'min:1'],
            'rh' => ['required', 'integer', 'min:1'],
        ];
    }
}