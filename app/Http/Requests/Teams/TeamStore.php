<?php

namespace App\Http\Requests\Teams;

use App\Http\Requests\BaseRequest;

class TeamStore extends BaseRequest
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
            'name' => 'required|string|unique:teams,name',
            'description' => 'nullable|string',
        ];
    }
}
