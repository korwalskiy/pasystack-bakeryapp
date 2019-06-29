<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required|string",
            "email" => "required|email|unique:customers,email",
            "account_number" => "required|digits:10|unique:recipients,account_number",
            "bank_code" => "required|string",
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Name is required, can't be blank!",
            "name.string" => "Name contains invalid characters, try again!",
            "email.required" => "Email is required, can't be blank!",
            "email.email" => "Invalid email address, try again!",
            "email.unique" => "Duplicate email address found, use another!",
            "account_number.required" => "Account number is required, can't be blank!",
            "account_number.digits" => "Invalid account number, expecting 10 digits only, try again!",
            "account_number.unique" => "Duplicate account number found, use another!",
            "bank_code.required" => "Choose a bank from the list, can't be blank!",
            "bank_code.string" => "Invalid bank code, expecting alphanumerics only, try again!",
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (count($validator->errors())) {
                // $validator->errors()->add('field', 'Something is wrong with this field!');
                $this->session()->flash('flash_notification.level', 'danger');
                $this->session()->flash('flash_notification.message', $validator->errors()->values());
            }
        });
    }
}
