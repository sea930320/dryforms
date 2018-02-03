<?php
namespace App\Http\Requests\Account;

use App\Http\Requests\BaseRequest;

class SubscribeRequest extends BaseRequest
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
            'stripeToken' => 'required'
        ];
    }
}