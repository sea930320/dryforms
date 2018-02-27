<?php
namespace App\Http\Requests\Areas;

use App\Http\Requests\BaseRequest;

class AreaStore extends BaseRequest
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
            'title' => 'required|string'
        ];
    }
}