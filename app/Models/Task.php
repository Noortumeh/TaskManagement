<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'is_completed',
        'priority',
        'user_id',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
    ];

    protected $table = 'tasks';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_task');
    }
}
