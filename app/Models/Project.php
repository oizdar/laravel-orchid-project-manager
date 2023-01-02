<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Project extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $fillable = [
        'subject',
        'description',
        'start_date',
        'end_date'
    ];

    protected $allowedSorts = [
      'subject',
      'start_date',
      'end_date'
    ];

    protected $allowedFilters = [
        'subject',
        'start_date',
        'end_date'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

}
