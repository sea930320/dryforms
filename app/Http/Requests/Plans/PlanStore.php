<?php
namespace App\Http\Requests\Plans;

use Illuminate\Foundation\Http\FormRequest;

class PlanStore extends FormRequest
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
            'name' => 'required|string',
            'amount' => 'required',
            'trial_period_days' => 'nullable',
            'interval' => 'required|in:day,week,month,year',
        ];
    }
}
