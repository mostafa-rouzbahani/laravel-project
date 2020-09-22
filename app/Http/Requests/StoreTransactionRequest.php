<?php

namespace App\Http\Requests;

use App\Advertisement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class StoreTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * The auth user and owner of ad must be different.
     * The request amount must be between the ad amounts.
     *
     * @return bool
     */
    public function authorize()
    {

        if (Auth::check()
            && Auth::id() != Advertisement::findorfail(Request::input('advertisement_id'))->user->id
            && Request::input('s_amount') >= Advertisement::findorfail(Request::input('advertisement_id'))->amount_from
            && Request::input('s_amount') <= Advertisement::findorfail(Request::input('advertisement_id'))->amount_to
        )
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
            's_amount' => 'required|numeric',
            'b_amount' => 'required|numeric',
            'advertisement_id' => 'required'
        ];
    }
}
