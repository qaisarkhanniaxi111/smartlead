<?php

namespace App\Http\Requests\Auth\ResponseTraining;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:255'],
            'company_description' => ['required', 'string', 'max:30000'],
            'event_name' => ['required', 'string', 'max:255'],
            'event_duration' => ['required', 'numeric', 'max:120'],

            'reply_from_lead' => ['required', 'array'],
            'reply_from_lead.*' => ['required', 'string', 'max:255'],

            'ideal_sdr_response' => ['required', 'array'],
            'ideal_sdr_response.*' => ['required', 'string', 'max:30000'],

            'links_key' => ['required', 'array'],
            'links_key.*' => ['required', 'string', 'max:255'],

            'links_value' => ['required', 'array'],
            'links_value.*' => ['required', 'string', 'max:30000'],
        ];
    }
}
