<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Workspace extends Model
{
    use HasFactory;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'detail'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($userSpace) {
            $userSpace->uuid = (string) Str::uuid(); // Generate UUID
        });
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'userspaces', 'workspace_id', 'user_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function userspaces()
    {
        return $this->hasMany(Userspace::class);
    }
}
