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
            'company_id' => 'required|exists:companies,id'
        ];
    }
}
