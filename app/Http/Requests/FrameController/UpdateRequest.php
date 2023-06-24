<?php

namespace App\Http\Requests\FrameController;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Frame;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => [
                'required',
                function ($attribute, $value, $fail) {
                    $exists = Frame::where('room_id', $this->room_id)
                        ->where('date', $value)
                        ->exists();
    
                    if ($exists) {
                        $fail('同じ部屋名と日付の組み合わせで予約枠が既に存在します。');
                    }
                },
            ],
            'number' => ['required', 'numeric', 'min:1'],
        ];
    }
}
