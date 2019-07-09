<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'pid',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_categories', 'category_id', 'user_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'pid', 'id');
    }

    public static function scopeFilter($query, $filters = [])
    {
        if (isset($filters['category_id'])) {
            $query->where('id', $filters['category_id']);
        }

        return $query;
    }
}
