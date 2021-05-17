<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $appends = ['row_class'];
    protected $with = [
        'submitter',
        'priority',
        'status',
        'category',
        'developer',
        'project',
        'files'
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
    protected $casts = [
        'due_date' => 'date:d/m/Y'
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

    public function files()
    {
        return $this->hasMany('App\Models\File', 'ticket_id', 'id');
    }

    // public function comments()
    // {
    //     return $this->hasMany('App\Models\Comment', 'ticket_id', 'id');
    // }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('d/m/Y');
    }

    public function getRowClassAttribute()
    {
        if ($this->status_id == 4)                              return 'table-primary text-primary';
        if ($this->priority_id == 3 && $this->status_id != 4)   return 'table-danger text-danger';
    }

    public function scopeFiltered($query, $filter)
    {
        return $query->where(function ($ticket) use ($filter) {
            $ticket->where('title', 'LIKE', '%' . $filter . '%')
                ->orWhere('created_at', 'LIKE', '%' . $filter . '%')
                ->orWhereHas('priority', function ($relation) use ($filter) {
                    $relation->where('title', 'LIKE', '%' . $filter . '%');
                })->orWhereHas('status', function ($relation) use ($filter) {
                    $relation->where('title', 'LIKE', '%' . $filter . '%');
                })->orWhereHas('category', function ($relation) use ($filter) {
                    $relation->where('title', 'LIKE', '%' . $filter . '%');
                })->orWhereHas('project', function ($relation) use ($filter) {
                    $relation->where('title', 'LIKE', '%' . $filter . '%');
                })->orWhereHas('developer', function ($relation) use ($filter) {
                    $relation->where('name', 'LIKE', '%' . $filter . '%');
                });
        });
    }
}
