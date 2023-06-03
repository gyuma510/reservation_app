<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Frame extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'room_id'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'frame_plans')
            ->using(FramePlan::class)
            ->withPivot('price', 'id')
            ->withTimestamps();
    }

    public function framePlan()
    {
        return $this->hasMany(FramePlan::class);
    }
}
