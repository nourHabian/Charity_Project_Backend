<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeneficiaryRequest extends Model
{
    //
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function supplies() {
        return $this->belongsToMany(Supply::class, 'requested_supplies')->withTimestamps();
    }

    public function type() {
        return $this->belongsTo(Type::class);
    }
}
