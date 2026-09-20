<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlertRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->isAdmin();
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:120',
            'message' => 'required|string|max:2000',
            'urgency' => 'required|in:info,attention,urgent',
            'neighborhood' => 'required|string|max:100',
        ];
    }
}
