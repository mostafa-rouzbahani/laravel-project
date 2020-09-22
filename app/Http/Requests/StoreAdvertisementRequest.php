<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreAdvertisementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check())
            return true;
        else
            return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
//            'p_currency_id' => 'required|exists:currencies,id|different:r_currency_id', //create_old
            'p_currency_id' => 'required|exists:currencies,id|different:r_currency_id|notIn:2',
//            'p_country_id' => 'required|exists:countries,id|different:r_country_id', //create_old
            'p_country_id' => 'required|exists:countries,id|different:r_country_id|notIn:2',
            'amount_from' => 'required|numeric|min:1',
            'amount_to' => 'required|numeric|gt:amount_from',
//            'r_currency_id' => 'required|exists:currencies,id|different:p_currency_id', //create_old
            'r_currency_id' => 'required|exists:currencies,id|different:p_currency_id|in:2',
//            'r_country_id' => 'required|exists:countries,id|different:p_country_id'   //create_old
            'r_country_id' => 'required|exists:countries,id|different:p_country_id|in:2'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'amount_from.min' => 'کمترین مقدار عدد 1 می باشد.',
            'amount_to.gt' => 'باید از کمترین مبلغ(فیلد بالایی) بیشتر باشد.',
            'p_currency_id.different' => 'ارز دریافتی و پرداختی باید متفاوت باشند.',
            'r_currency_id.different' => 'ارز دریافتی و پرداختی باید متفاوت باشند.',
            'p_country_id.different' => 'کشور دریافتی و پرداختی باید متفاوت باشند.',
            'r_country_id.different' => 'کشور دریافتی و پرداختی باید متفاوت باشند.',
        ];
    }
}
