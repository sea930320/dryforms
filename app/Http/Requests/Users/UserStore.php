<?php
namespace App\Http\Requests\Users;

use App\Http\Requests\BaseRequest;

class UserStore extends BaseRequest
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
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip' => 'required|numeric',
            'phone' => 'required|string',
            'company_id' => 'required|exists:companies,id',
            'role_id' => 'required|exists:roles,id',
            'team_id' => 'required|exists:teams,id'
        ];
    }
}