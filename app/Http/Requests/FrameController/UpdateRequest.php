<?php

namespace App\Http\Requests\FrameController;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Frame;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date'   => ['required'],
            'number' => ['required', 'numeric', 'min:1'],
        ];
    }
}
