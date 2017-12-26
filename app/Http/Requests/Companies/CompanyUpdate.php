<?php
namespace App\Http\Requests\Companies;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class CompanyUpdate extends BaseRequest
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
            'company_id' => 'exists:companies,id',
            'user_id' => 'required|numeric|exists:users,id',
            'name' => 'required|string|unique:companies,name',
            'logo' => 'nullable|string',
            'email' => 'required|email|unique:users,email',
            'street' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip' => 'required|string',
            'phone' => 'required|string',
            'cloud_link' => 'nullable|string',
        ];
    }

    /**
     * @return array
     */
    public function validationData()
    {
        $this->merge(
            [
                'company_id' => $this->route('company')
            ]
        );

        return parent::validationData();
    }
}
