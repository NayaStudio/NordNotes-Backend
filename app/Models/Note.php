<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Note extends Model
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'id',
        'title',
        'note',
        'user_id',
        'shared',
        'share_password'
    ];
}
