<?php



namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;


class Admin extends Authenticatable
{
     use HasApiTokens;

    protected $fillable = ['full_name', 'email', 'password'];
    protected $hidden = ['password'];
}

