<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Meeting extends Model
{
    use HasApiTokens ,HasFactory, SoftDeletes;

    protected $guarded;

    public function joined()
    {
        return $this->hasMany(Joined::class, 'meeting_id', 'meeting_id');
    }
}
