<?php
namespace App\Http\Requests\Areas;

use App\Http\Requests\BaseRequest;

class AreaUpdate extends BaseRequest
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
            'area_id' => 'exists:areas,id',
            'title' => 'required|string',
            'company_id' => 'required|exists:companies,id'
        ];
    }

    /**
     * @return array
     */
    public function validationData()
    {
        $this->merge(
            [
                'area_id' => $this->route('area')
            ]
        );

        return parent::validationData();
    }
}