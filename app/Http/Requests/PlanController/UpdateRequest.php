<?php

namespace App\Http\Requests\PlanController;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'min_price'   => ['required', 'numeric', 'min:0'],
            'max_price'   => ['required', 'numeric', 'min:'.$this->input('min_price')],
            'start_date'  => ['required', 'date'],
            'end_date'    => ['required', 'date', 'after_or_equal:start_date'],
        ];        
    }
}
