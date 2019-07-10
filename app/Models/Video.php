<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Video extends Model
{
    protected $fillable = [
        'category_id', 'title', 'thumb', 'url', 'original_url', 'date', 'status', 'play_count', 'play_time', 'source_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * socpe 查询
     *
     * @param $query
     * @param array $filters
     * @return mixed
     */
    public static function scopeFilter($query, $filters = [])
    {
        if (isset($filters['category_id'])) {
            if ($filters['category_id'] == 4) { // 动漫取所有
                $categoryIds = Category::find(4)->children()->pluck('id')->merge(4);
                $query->whereIn('category_id', $categoryIds);
            } else {
                $query->where('category_id', $filters['category_id']);
            }
        }

        if (isset($filters['title'])) {
            $query->where('title', 'like', '%'.$filters['title'].'%');
        }

        if (isset($filters['date'])) {
            $query->whereBetween('date', $filters['date']);
        }

        if ($user = Auth::guard('api')->user()) {
            $userCategoryIds = $user->categories()->pluck('id');

            $query->whereIn('category_id', $userCategoryIds);
        }

        return $query->where('status', 1);
    }
}
