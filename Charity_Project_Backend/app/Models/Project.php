<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    public function donations() {
        return $this->hasMany(Donation::class);
    }

    public function type() {
        return $this->belongsTo(Type::class);
    }

    public function volunteers() {
        return $this->belongsToMany(User::class, 'volunteers')->withTimestamps();
    }

    public function favouritedByUsers() {
        return $this->belongsToMany(User::class, 'favourites')->withTimestamps();
    }

}
