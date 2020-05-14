<?php

namespace TypiCMS\Modules\Subscriptions\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'id' => 'integer',
        ];
    }
}
