<?php



namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;


class Admin extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = ['full_name', 'email', 'password'];
    protected $hidden = ['password'];

    public function donationHistories()
    {
        return $this->hasMany(AdminDonationHistory::class, 'admin_id');
    }

    public function donatedProjects()
    {
        return $this->belongsToMany(Project::class, 'admin_donation_histories', 'admin_id', 'project_id')
            ->withPivot('amount', 'created_at');
    }
}
