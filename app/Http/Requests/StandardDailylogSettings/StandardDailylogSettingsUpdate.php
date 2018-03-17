<?php

namespace App\Http\Requests\StandardDailylogSettings;

use App\Http\Requests\BaseRequest;

class StandardDailylogSettingsUpdate extends BaseRequest
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
            'id' => 'required|exists:standard_dailylog_settings,id',
            'company_id' => 'required|exists:companies,id',
            'automatically_copy' => 'required|in:0,1'
        ];
    }
}
