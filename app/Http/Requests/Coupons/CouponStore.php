<?php
namespace App\Http\Requests\Coupons;

use Illuminate\Foundation\Http\FormRequest;

class CouponStore extends FormRequest
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
            'id' => 'required|string',
            'duration' => 'required|in:forever,once,repeating',
            'amount_off' => 'nullable|required_without:percent_off|min:0',
            'percent_off' => 'nullable|required_without:amount_off|min:0|max:100',
            'max_redemptions' => 'nullable',
            'duration_in_months' => 'nullable|required_if:duration,repeating|min:0'
        ];
    }
}