<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'pid',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_categories', 'user_id', 'category_id');
    }
}
