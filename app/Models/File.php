<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'uploader_id', 'ticket_id'
    ];

    public function uploader()
    {
        return $this->hasOne('App\Models\User', 'id', 'uploader_id');
    }

    public function ticket()
    {
        return $this->belongsTo('App\Models\Ticket');
    }
}
