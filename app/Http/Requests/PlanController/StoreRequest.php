<?php

namespace App\Http\Requests\PlanController;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'description' => ['required'],
            'min_price' => ['required', 'numeric', 'min:0'],
            'max_price' => ['required', 'numeric', 'min:'.$this->input('min_price')],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ];        
    }
}
