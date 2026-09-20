<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncidentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'incident_type_id' => 'required|exists:incident_types,id',
            'title' => 'required|string|max:120',
            'description' => 'required|string|max:2000',
            'neighborhood' => 'required|string|max:100',
            'severity' => 'required|in:faible,moyenne,elevee',
            'occurred_at' => 'required|date',
            'photo' => 'nullable|image|max:2048',
        ];
    }
}
