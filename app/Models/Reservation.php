<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'frame_plan_id'];

    public function framePlan()
    {
        return $this->belongsTo(FramePlan::class, 'frame_plan_id');
    }
}
