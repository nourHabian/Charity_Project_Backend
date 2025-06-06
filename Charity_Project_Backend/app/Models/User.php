<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use function PHPSTORM_META\type;

class User extends Authenticatable
{
    /* @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /* The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected  $guarded = [];

    /* The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /* Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // 'email_verified_at' => 'datetime',
            // 'password' => 'hashed',
        ];
    }

    public function feedbacks() {
        return $this->hasMany(Feedback::class);
    }

    public function notifications() {
        return $this->hasMany(Notification::class);
    }

    public function beneficiaryRequests() {
        return $this->hasMany(BeneficiaryRequest::class);
    }

    public function favouriteProjects() {
        return $this->belongsToMany(Project::class, 'favourites')->withTimestamps();
    }

    public function donations() {
        return $this->hasMany(Donation::class);
    }

    public function volunteeredProjects() {
        return $this->belongsToMany(Project::class, 'volunteers')->withTimestamps();
    }


    
}
