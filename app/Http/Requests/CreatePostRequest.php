<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2048',
            'contact_phone' => 'required|string|max:15',
            'user_id' => 'required|exists:users,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Title is required.',
            'title.max' => 'Title cannot exceed 255 characters.',
            'description.required' => 'Description is required.',
            'description.max' => 'Description cannot exceed 2048 characters (2KB).',
            'contact_phone.required' => 'Contact phone is required.',
            'contact_phone.max' => 'Contact phone cannot exceed 20 characters.',
        ];
    }
}
