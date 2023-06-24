<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EmailChangeRequest extends FormRequest
{
    public function rules(): array
    {
        $userEmail = Auth::user()->email;
        return [
            'current_email'          => ['required', 'email', 'in:' . $userEmail],
            'new_email'              => ['required', 'email', 'different:current_email'],
            'new_email_confirmation' => ['required', 'email', 'same:new_email'],
        ];
    }
}
