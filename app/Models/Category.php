<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

class Category extends Model
{
    protected $fillable = [
        'name',
    ];
    protected $table = 'categories';

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'category_task');
    }
}
