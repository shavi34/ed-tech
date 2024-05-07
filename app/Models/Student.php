<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'grade',
        'user_id',
        'course_id'
    ];

    protected $appends = ['name'];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function activities():HasMany
    {
        return  $this->hasMany(Activity::class);
    }

    public function getNameAttribute():string
    {
       return $this->user->name;
    }
}

