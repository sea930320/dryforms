<?php
namespace App\Http\Requests\Teams;

use App\Http\Requests\BaseRequest;

class TeamsIndex extends BaseRequest
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