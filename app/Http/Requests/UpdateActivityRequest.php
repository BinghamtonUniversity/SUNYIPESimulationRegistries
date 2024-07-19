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
            "title" => ["required", "string", "max:255"],
            "description" => ["required", "string", "max:500"],
            "type"=>["required", "string", "in:ipe,simulation,ipe_simulation"],
            "submitter_id"=>["required","integer"],
            "contact_name" => ["required", "string", "max:255"],
            "contact_email" => ["required", "email"],
//            "contact_phone" => ["required", "phone:NL"],
            "participating_programs" => ["required", "string", "max:255"],
            "ksa_requirement" => ["required", "string", "max:255"],
            "focus_areas" => ["required", "string", "max:255"],
            "learning_objectives"=>["required", "string", "max:255"],
            "is_new"=>["required", "boolean"],
            "number_of_learners"=>["required", "integer"],
            "status"=>["required", "string", "in:submitted,review,approved"]
        ];
    }
}
