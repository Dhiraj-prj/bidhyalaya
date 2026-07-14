<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProgramRequestForm extends FormRequest
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
        $rules = [
            // Rules for Input field validation
            'name' => ['required', 'string', 'max:200'],
            'slug' => ['required', 'string', 'max:200'],
            'description' => ['nullable'],
            'levelType'=> ['required'],
            'meta_title' => ['required', 'string', 'max:200'],
            'meta_description' => ['required', 'string'],
            'meta_keyword' => ['required', 'string'],
            'navbarHiddenStatus' => ['nullable'],
            'hideStatus' => ['nullable'],
        ];

        // If the request is not updating (i.e., creating a new Program), make image required
        if ($this->isMethod('post')) {
            $rules['image'] = ['nullable', 'mimes:jpg,jpeg,png', 'max:2500'];
        } else {
            // For updating, image is optional
            $rules['image'] = ['nullable', 'mimes:jpg,jpeg,png', 'max:2500'];
        }

        return $rules;
    }
}
