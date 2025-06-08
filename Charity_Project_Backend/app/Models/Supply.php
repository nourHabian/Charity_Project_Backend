<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    //
    protected $guarded = [];
    public function beneficiaryRequests() {
        return $this->belongsToMany(BeneficiaryRequest::class, 'requested_supplies')->withTimestamps();
    }
}
