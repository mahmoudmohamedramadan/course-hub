<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
        /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'updatePassword';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'current_password' => ['required', 'current_password'],
           'password'         => ['required', Password::defaults(), 'confirmed']
        ];
    }
}
