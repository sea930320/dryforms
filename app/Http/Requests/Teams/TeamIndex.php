<?php

namespace App\Http\Requests\Teams;

use App\Http\Requests\BaseIndexRequest;

class TeamIndex extends BaseIndexRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'per_page' => 'nullable|integer',
            'sort_by' => 'nullable|string',
            'sort_type' => 'nullable|in:asc,desc'
        ];
    }
}