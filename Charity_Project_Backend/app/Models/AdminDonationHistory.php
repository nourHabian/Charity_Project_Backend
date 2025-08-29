<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminDonationHistory extends Model
{
    protected $fillable = ['admin_id', 'project_id', 'amount'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
