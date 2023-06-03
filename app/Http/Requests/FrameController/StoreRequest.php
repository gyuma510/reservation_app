<?php

namespace App\Http\Requests\FrameController;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => ['required'],
            'number' => ['required', 'numeric'],
        ];
    }
}
