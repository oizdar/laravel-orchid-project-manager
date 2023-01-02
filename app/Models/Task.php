<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Task extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
        'user_id',
        'project_id',
    ];

    protected $allowedSorts = [
        'name',
        'start_date',
        'end_date',
        'status',
        'user_id',
        'project_id',
    ];

    protected $allowedFilters = [
        'name',
        'start_date',
        'end_date',
        'status',
        'user_id',
        'project_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
