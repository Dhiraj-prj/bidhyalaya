<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'subProgram' => ['required'],
            'Program_id' => ['required', 'integer'],
            'postType' => ['required'],
            'slug' => ['required', 'string', 'unique:post,slug'],
            'description' => ['required'],
            'yt_iframe' => ['nullable', 'string'],
            'meta_title' => ['required', 'string'],
            'meta_description' => ['nullable', 'string'],
            'meta_keyword' => ['nullable', 'string'],
            'hideStatus' => 'nullable|boolean',  // Use boolean validation for the status

            // File validation
            'files' => ['nullable', 'array'],
            'files.*' => ['file', 'mimes:jpeg,png,jpg,pdf,docx', 'max:2048'],  // Max file size is 2MB
        ];
    }

}
