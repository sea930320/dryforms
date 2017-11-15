<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    /**
     * @return array
     */
    public function validatedOnly(): array
    {
        return array_filter($this->only(array_keys($this->rules())));
    }

    /**
     * @return bool
     */
    public function expectsJson(): bool
    {
        return true;
    }
}