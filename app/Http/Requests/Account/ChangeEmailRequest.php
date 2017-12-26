<?php
namespace App\Http\Requests\Account;

use App\Http\Requests\BaseRequest;

class ChangeEmailRequest extends BaseRequest
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
            'old_email' => 'required|email|exists:users,email',
            'new_email' => 'required|email|confirmed'
        ];
    }
}