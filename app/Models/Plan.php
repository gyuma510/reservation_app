<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function frames()
    {
        return $this->belongsToMany(Frame::class, 'frame_plans')
            ->withPivot('price', 'id')
            ->withTimestamps();
    }

    public function framePlan()
    {
        return $this->hasMany(FramePlan::class);
    }

    public function scopeAvailable($query)
    {
        return $query->whereHas('frames', function ($query) {
            $query->where('is_reserved', false);
        });
    }
}
