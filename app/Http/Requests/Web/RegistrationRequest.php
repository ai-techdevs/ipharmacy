<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ReCaptcha;

class RegistrationRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $this->merge([
            'mobile' => preg_replace('/\D/', '', $this->mobile)
        ]);
    }
    public function rules(): array
    {
        return [
            'first_name'            => 'required|string|max:100',
            'last_name'             => 'required|string|max:100',
            'email'                 => 'required|email|unique:users,email',
            //'mobile' => ['required','regex:/^\\+[0-9]{1,3} [0-9]{3}-[0-9]{3}-[0-9]{4}$/', 'unique:users,mobile'],
            'mobile'                => ['required', 'regex:/^[0-9]{10}$/', 'unique:users,mobile'],
            'age_group'             => 'required|in:18-30,31-45,46-60,60+',
            'gender'                => 'required|in:male,female',
            'address1'              => 'required|string',
            'address2'              => 'nullable|string',
            'city'                  => 'required|string',
            'state'                 => 'required|string',
            'zip'                   => 'required|string',
            'password'              => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*#?&])?[A-Za-z\d@$!%*#?&]+$/'],
            'terms'                 => 'accepted',
            'g-recaptcha-response' => 'required',
            //'g-recaptcha-response' => ['required', new ReCaptcha]
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required'  => 'Last name is required.',
            'email.required'      => 'Email address is required.',
            'email.email'         => 'Please provide a valid email address.',
            'email.unique'        => 'This email is already registered.',
            'mobile.required'     => 'Mobile number is required.',
            'mobile.regex'        => 'Please enter a valid mobile number. format should be:   +1 ###-###-#### ',
            'age_group.required'  => 'Select your age group.',
            'age_group.in'        => 'Selected age group is invalid.',
            'gender.required'     => 'Gender is required.',
            'gender.in'           => 'Selected gender is invalid.',
            'address1.required'   => 'Address line 1 is required.',
            'city.required'       => 'City is required.',
            'state.required'      => 'State is required.',
            'zip.required'        => 'ZIP code is required.',
            'password.required'   => 'Password is required.',
            'password.min'        => 'Password must be at least :min characters.',
            'password.confirmed'  => 'Password and confirmation password does not matched.',
            'password.regex' => 'The password must be at least 8 characters long and contain at least one uppercase letter and one number.',
            'terms.accepted'      => 'You must agree to the terms of service and privacy policy.',
        ];
    }

    public function attributes(): array
    {
        return [
            'first_name' => 'First Name',
            'last_name'  => 'Last Name',
            'zip'        => 'ZIP code',
        ];
    }
}
