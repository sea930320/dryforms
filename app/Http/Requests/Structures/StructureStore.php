<?php
namespace App\Http\Requests\Structures;

use App\Http\Requests\BaseRequest;

class StructureStore extends BaseRequest
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