<?php

namespace App\Http\Requests\Materials;

use App\Http\Requests\BaseRequest;

class MaterialIndex extends BaseRequest
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