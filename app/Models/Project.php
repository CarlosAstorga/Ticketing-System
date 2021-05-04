<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description'
    ];

    protected $casts = [
        'created_at' => 'date:d/m/Y H:i',
        'updated_at' => 'date:d/m/Y H:i'
    ];

    public function tickets()
    {
        return $this->hasMany('App\Models\Ticket');
    }

    public function users()
    {
        return $this->belongsToMany("App\Models\User");
    }
}
