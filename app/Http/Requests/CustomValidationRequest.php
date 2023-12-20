<?php 


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomValidationRequest extends FormRequest
{
    public function authorize()
    {
        return true;  
    }

    public function rules()
    {
        $tableName = $this->get('table_name');
        $uniqueRule = Rule::unique($tableName, $tableName == 'pages' ? 'page_name' : 'phone_number');
        return [
            'page_title' => 'required',
            $tableName == 'pages' ? 'page_name' : 'phone_number' => ['required', $uniqueRule, 'max:255'],
            // Add rules for other fields as needed for different tables.
        ];
    }

    public function messages()
    {
        return [
            'page_title.required' => 'Please enter page title.',
            'page_name.required' => 'Please enter page name.',
            'phone_number.required' => 'Please enter phone number.',
            // Add messages for other fields as needed for different tables.
        ];
    }
}

