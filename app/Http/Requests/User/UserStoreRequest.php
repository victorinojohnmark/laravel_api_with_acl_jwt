<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class UserStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required',
            'roles' => 'nullable|array',
            'permissions' => 'nullable|array'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $emailExists = User::where('email', $this->input('email'))->exists();
            if ($emailExists) {
                $validator->errors()->add('email', 'OMG, Email address already exists');
            }
        });
    }
}
