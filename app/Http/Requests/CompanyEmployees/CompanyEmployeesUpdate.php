<?php
namespace App\Http\Requests\CompanyEmployees;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class CompanyEmployeesUpdate extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|numeric|exists:company_employees,id',
            'company_id' => 'required|numeric|exists:companies,id',
            'status_id' => 'required|numeric|exists:employees_statuses,id',
            'role_id' => 'required|numeric|exists:roles,id',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email'
        ];
    }
}
