<?php
namespace App\Http\Requests\Structures;

use App\Http\Requests\BaseRequest;

class StructureUpdate extends BaseRequest
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
            'structure_id' => 'exists:standard_structures,id',
            'title' => 'required|string',
            'type' => 'required|in:system,company',
            'company_id' => 'required|exists:companies,id'
        ];
    }
}