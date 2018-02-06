<?php
namespace App\Http\Requests\Users;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

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
            'address' => 'sometimes|required|string',
            'city' => 'sometimes|required|string',
            'state' => 'sometimes|required|string',
            'zip' => 'sometimes|required|numeric',
            'phone' => 'sometimes|required|string',
            'company_id' => 'required|exists:companies,id',
            'role_id' => [
                'required',
                Rule::exists('roles', 'id')
                    ->where(function ($query) {
                        $query->where('name', '!=', 'Super Admin');
                    })
            ],
            'team_id' => 'nullable|exists:teams,id'
        ];
    }
}