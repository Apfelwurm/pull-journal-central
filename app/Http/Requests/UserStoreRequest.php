<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\UserRoleEnum;

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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|min:2|max:255|unique:users',
            'password' => 'required|min:8|max:255',
            // TODO: fix validation
            'role' => [
                "required",
                new Enum(UserRoleEnum::class)
           ],
        ];
    }

}
