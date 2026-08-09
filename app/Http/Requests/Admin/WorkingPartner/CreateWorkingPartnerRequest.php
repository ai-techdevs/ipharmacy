<?php

namespace App\Http\Requests\Admin\WorkingPartner;

use Illuminate\Foundation\Http\FormRequest;

class CreateWorkingPartnerRequest extends FormRequest
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
            'name'=> 'required|max:255',
            'image'=> 'required|mimes:jpg,jpeg,png,gif,svg|max:500',
        ];
    }
}
