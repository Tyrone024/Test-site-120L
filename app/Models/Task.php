<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    use HasFactory;

    protected $fillable = [
        'name', 'detail', 'is_completed', 'workspace_id'
    ];

    // Define relationship to Workspace (if needed)
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
