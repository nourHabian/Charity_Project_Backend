<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $guarded = [];
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function volunteers()
    {
        return $this->hasMany(Volunteer::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'volunteers', 'project_id', 'user_id');
    }

    public function favouritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favourites')->withTimestamps();
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function adminDonations()
    {
        return $this->belongsToMany(Admin::class, 'admin_donation_histories', 'project_id', 'admin_id')
            ->withPivot('amount', 'created_at');
    }
}
