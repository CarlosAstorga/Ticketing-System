<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
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
        if (Storage::disk('public')->exists("images/avatar/{$this->id}/{$this->profile_picture}")) {
            return Storage::url("images/avatar/{$this->id}/{$this->profile_picture}");
        } else {
            return Storage::url("images/avatar/profile_picture.png");
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

    public function hasPermission($permission)
    {
        return $this->roles()->whereHas('permissions', function($query) use ($permission) {
            $query->where('title', 'like', '%' . $permission . '%');
        })->count();
    }
}
