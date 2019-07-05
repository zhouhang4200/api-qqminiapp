<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'category_id', 'title', 'thumb', 'url', 'original_url', 'date', 'status', 'play_count', 'play_time'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
