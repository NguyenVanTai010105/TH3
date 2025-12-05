<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected static function newFactory()
    {
        return UserFactory::new();
    }
    protected $fillable = [
        'username',
        'email',
        'password'
    ];
    //
}
