<?php

namespace TypiCMS\Modules\Subscriptions\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionsProfileUpdate extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'street' => 'required|string',
            'number' => 'required|string',
            'zip' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
        ];
    }
}
