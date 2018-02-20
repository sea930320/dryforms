<?php
namespace App\Http\Requests\Materials;

use App\Http\Requests\BaseRequest;

class MaterialUpdate extends BaseRequest
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
            'material_id' => 'exists:standard_materials,id',
            'title' => 'required|string',
            'company_id' => 'required|exists:companies,id'
        ];
    }
}