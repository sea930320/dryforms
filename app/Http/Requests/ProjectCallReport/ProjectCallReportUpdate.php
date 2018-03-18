<?php

namespace App\Http\Requests\ProjectCallReport;

use App\Http\Requests\BaseRequest;

class ProjectCallReportUpdate extends BaseRequest
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
            'call_report_id' => 'required|exists:project_call_reports,id',
            'project_id' => 'required|exists:projects,id',
            'company_id' => 'sometimes|required|exists:companies,id',
            'contact_name' => 'required|string',
            'contact_phone' => 'required|string',
            'site_phone' => 'nullable|string',
            'date_contacted' => 'nullable|date_format:"Y-m-d"',
            'time_contacted' => 'nullable|date_format:"H:i:s"',
            'date_loss' => 'nullable|date_format:"Y-m-d"',
            'point_loss' => 'nullable|string',
            'date_completed' => 'nullable|date_format:"Y-m-d"',
            'category' => 'nullable|string',
            'class' => 'nullable|string',
            'job_address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zip_code' => 'nullable|string',
            'cross_streets' => 'nullable|string',
            'apartment_name' => 'nullable|string',
            'building_no' => 'nullable|string',
            'apartment_no' => 'nullable|string',
            'gate_code' => 'nullable|string',
            'assigned_to' => 'nullable|integer',
            'is_residential' => 'nullable|integer',
            'is_commercial' => 'nullable|integer',
            'is_insured' => 'nullable|integer',
            'is_tenant' => 'nullable|integer',
            'is_water' => 'nullable|integer',
            'is_sewage' => 'nullable|integer',
            'is_mold' => 'nullable|integer',
            'is_fire' => 'nullable|integer',
            'insured_name' => 'nullable|string',
            'billing_address' => 'nullable|string',
            'insured_city' => 'nullable|string',
            'insured_state' => 'nullable|string',
            'insured_zip_code' => 'nullable|string',
            'insured_home_phone' => 'nullable|string',
            'insured_cell_phone' => 'nullable|string',
            'insured_work_phone' => 'nullable|string',
            'insured_email' => 'nullable|email',
            'insured_fax' => 'nullable|string',
            'insurance_claim_no' => 'nullable|string',
            'insurance_company' => 'nullable|string',
            'insurance_policy_no' => 'nullable|string',
            'insurance_deductible' => 'nullable|string',
            'insurance_adjuster' => 'nullable|string',
            'insurance_address' => 'nullable|string',
            'insurance_city' => 'nullable|string',
            'insurance_state' => 'nullable|string',
            'insurance_zip_code' => 'nullable|string',
            'insurance_work_phone' => 'nullable|string',
            'insurance_cell_phone' => 'nullable|string',
            'insurance_email' => 'nullable|email',
            'insurance_fax' => 'nullable|string'
        ];
    }

    /**
     * @return array
     */
    public function validationData()
    {
        $this->merge(
            [
                'call_report_id' => $this->route('call_report')
            ]
        );

        return parent::validationData();
    }
}
