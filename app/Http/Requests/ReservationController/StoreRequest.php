<?php

namespace App\Http\Requests\ReservationController;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'email', 'max:255'],
            'address'    => ['required', 'string', 'max:255'],
            'phone'      => ['required', 'string', 'max:255'],
            'message'    => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date', 'after:start_date'],
            'cancel'     => ['nullable'],
            'memo'       => ['nullable', 'string', 'max:255'],
        ];        
    }
}
