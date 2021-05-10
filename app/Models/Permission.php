<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $with = ['modules'];

    public function modules()
    {
        return $this->belongsTo('App\Models\Module', 'module_id', 'id');
    }
}
