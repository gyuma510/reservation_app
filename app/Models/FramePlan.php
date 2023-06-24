<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class FramePlan extends Pivot
{
    use HasFactory;
    protected $table = 'frame_plans';
    protected $guarded = ['id', 'frame_id', 'plan_id'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function frame()
    {
        return $this->belongsTo(Frame::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
