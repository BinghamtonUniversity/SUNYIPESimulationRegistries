<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityRequest extends FormRequest
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
            "id"=>["required","integer","exists:activities,id"],
            "title" => ["required", "string", "max:255"],
            "description" => ["required", "string", "max:65535"],
            "is_ipe"=>["boolean"],
            "is_simulation"=>["boolean"],
            "contact_name" => ["required", "string", "max:255"],
            "contact_email" => ["required", "email"],
            "ksa_knowledge" => ["required", "string", "max:65535"],
            "ksa_skills" => ["required", "string", "max:65535"],
            "ksa_attitudes" => ["required", "string", "max:65535"],
            "learning_objectives"=>["required", "string", "max:65535"],
            "number_of_learners"=>["required", "integer"],
        ];
    }
}
