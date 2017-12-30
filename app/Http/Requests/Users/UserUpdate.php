<?php
namespace App\Http\Requests\Users;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UserUpdate extends BaseRequest
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
            'id' => 'required|exists:users,id',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->input('id')),
            ],
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

    /**
     * @return array
     */
    public function validationData()
    {
        $this->merge(
            [
                'id' => $this->route('user')
            ]
        );

        return parent::validationData();
    }
}