<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $fillable = ['contact_id'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
