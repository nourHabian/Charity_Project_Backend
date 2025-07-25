<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    //
    protected $guarded = [];

    public function projects() {
        return $this->hasMany(Project::class);
    }

    public function beneficiaryRequests() {
        return $this->hasMany(BeneficiaryRequest::class);
    }
}
