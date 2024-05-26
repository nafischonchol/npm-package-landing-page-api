<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

   
    public function rules(): array
    {
        return [
            'email' =>"nullable|email",
            'phone' => 'nullable|string',
            'name' => 'nullable|string|max:255', 
            'subject' => 'required|string|max:255', 
            'text' => 'required|string', 
        ];
    }
}
