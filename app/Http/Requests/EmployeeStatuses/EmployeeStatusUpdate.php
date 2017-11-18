<?php
namespace App\Http\Requests\EmployeeStatuses;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class EmployeeStatusUpdate extends BaseRequest
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
            'id' => 'exists:employees_statuses,id',
            'name' => [
                'required',
                'string',
                Rule::unique('employees_statuses')->ignore($this->input('id'), 'id')
            ],
        ];
    }

    /**
     * @return array
     */
    public function validationData()
    {
        $this->merge(
            [
                'category_id' => $this->route('category')
            ]
        );

        return parent::validationData();
    }
}
