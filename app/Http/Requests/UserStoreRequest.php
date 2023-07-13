<?php

namespace App\Http\Requests;

use App\Enums\UserRoleEnum;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

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
            'role' => [
                "required",
                new Enum(UserRoleEnum::class)
           ],
           'organisation_id' => 'required|exists:organisations,id',
        ];
    }

}
