<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            # required information
            'user_name' => 'required',
            'password' => 'required',
            'company_name' => 'required',
            'type' => 'required|integer|in:1,2',   # (1) refer to indvidual (2 ) related to company

            # end required


            'email' => 'nullable|email|unique:users,email,NULL,id,deleted_at,NULL',
            'primary_email' => 'nullable|email|unique:users,primary_email,NULL,id,deleted_at,NULL',
            'first_name' => 'required',
            'last_name' => 'nullable',


            # contacts phone


            'home_number' => 'required_with:home_code|required_without_all:office_number,office1_number,cell_number',
            'home_code' => 'required_with:home_number',

            'office_number' => 'required_with:office_code|required_without_all:home_number,office1_number,cell_number',
            'office_code' => 'required_with:office_number',

            'office1_number' => 'required_with:office1_code|required_without_all:home_number,office_number,cell_number',
            'office1_code' => 'required_with:office1_number',

            'cell_number' => 'required_with:cell_code|required_without_all:home_number,office_number,office1_number',
            'cell_code' => 'required_with:cell_number',

            #end contacts

            # Home information

            'website_url' => 'nullable|url|unique:users,website_url,NULL,id,deleted_at,NULL',
            'country' => 'nullable',
            'state' => 'nullable',
            'city' => 'nullable',
            'street' => 'nullable',
            'street1' => 'nullable',
            'postcode' => 'nullable',
            'note' => 'nullable',
            'company_id' => 'required_if:type,2',
            'image' => 'mimes:jpg,png,jpeg',

            #end infomation
        ];




    }
}
