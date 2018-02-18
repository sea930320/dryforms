<?php
namespace App\Http\Requests\Materials;

use App\Http\Requests\BaseRequest;

class MaterialStore extends BaseRequest
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
            'title' => 'required|string',
            'type' => 'required|in:system,company'
        ];
    }
}