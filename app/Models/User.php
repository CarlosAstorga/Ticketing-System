<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $with = ['roles'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    public function submittedTickets()
    {
        return $this->hasMany('App\Models\Ticket', 'submitter_id', 'id');
    }

    public function assignedTickets()
    {
        return $this->hasMany('App\Models\Ticket', 'submitter_id', 'id');
    }

    public function projects()
    {
        return $this->belongsToMany('App\Models\Project');
    }

    public function getRoleAttribute()
    {
        return $this->roles()->orderBy('role_id')->first()->title;
    }

    public function avatar()
    {
        if (file_exists(public_path("images/{$this->profile_picture}"))) {
            return "/images/{$this->profile_picture}";
        } else {
            return '/images/profile_picture.png';
        }
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('title', $role)->first()) {
            return true;
        }

        return false;
    }

    public function hasAnyRoles($roles)
    {
        if ($this->roles()->whereIn('title', $roles)->first()) {
            return true;
        }

        return false;
    }

    public function isAdmin()
    {
        return $this->hasRole('Administrador');
    }
}
