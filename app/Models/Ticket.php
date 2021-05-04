<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $with = [
        'submitter',
        'priority',
        'status',
        'category',
        'developer',
        'project'
    ];
    protected $fillable = [
        'title',
        'description',
        'submitter_id',
        'priority_id',
        'status_id',
        'category_id',
        'project_id',
        'developer_id',
        'due_date'
    ];

    public function submitter()
    {
        return $this->belongsTo('App\Models\User', 'submitter_id', 'id')
            ->select('id', 'name');
    }

    public function priority()
    {
        return $this->hasOne('App\Models\Priority', 'id', 'priority_id')
            ->select('id', 'title');
    }

    public function status()
    {
        return $this->hasOne('App\Models\Status', 'id', 'status_id')
            ->select('id', 'title');
    }

    public function category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'category_id')
            ->select('id', 'title');
    }

    public function developer()
    {
        return $this->belongsTo('App\Models\User', 'developer_id', 'id')
            ->select('id', 'name');
    }

    public function project()
    {
        return $this->hasOne('App\Models\Project', 'id', 'project_id')
            ->select('id', 'title');
    }

    // public function files()
    // {
    //     return $this->hasMany('App\Models\File', 'ticket_id', 'id');
    // }

    // public function comments()
    // {
    //     return $this->hasMany('App\Models\Comment', 'ticket_id', 'id');
    // }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('d/m/Y g:i:s');
    }
}
