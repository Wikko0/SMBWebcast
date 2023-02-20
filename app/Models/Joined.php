<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joined extends Model
{
    use HasFactory;
    protected $guarded;

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'meeting_id');
    }
}
