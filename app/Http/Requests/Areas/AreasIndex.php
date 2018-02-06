<?php

namespace App\Http\Requests\Areas;

use App\Http\Requests\BaseRequest;

class AreasIndex extends BaseRequest
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
        return [];
    }
}