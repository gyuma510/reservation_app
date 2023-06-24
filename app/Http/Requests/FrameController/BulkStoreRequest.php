<?php

namespace App\Http\Requests\FrameController;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Frame;

class BulkStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'room_id'    => ['required'],
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date', 'after_or_equal:start_date'],
            'number'     => ['required', 'integer', 'max:10'],
        ];
    }
}
