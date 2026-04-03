<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProcessRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'bpmn_xml'    => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'El nombre del proceso es obligatorio.',
            'name.max'          => 'El nombre no puede superar los 100 caracteres.',
            'bpmn_xml.required' => 'El diagrama BPMN es obligatorio.',
        ];
    }
}