<?php

namespace App\Http\Requests\Structures;

use App\Http\Requests\BaseRequest;

class StructureIndex extends BaseRequest
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