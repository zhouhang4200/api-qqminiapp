<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Video extends Model
{
    protected $fillable = [
        'category_id', 'title', 'thumb', 'url', 'original_url',
        'date', 'status', 'play_count', 'play_time', 'source_id',
        'source_name'
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
                $date = Carbon::now()->toDateString();
                $count = Video::where('category_id', 4)->where('date', $date)->count();

                if ($count < 400) {
                    $categoryIds = Category::find(1)->children()->pluck('id')->merge(4);
                    $query->whereIn('category_id', $categoryIds)->latest('play_count');
                } else {
                    $query->where('category_id', $filters['category_id']);
                }
            } elseif($filters['category_id'] == 1) { // 游戏，游戏接口不稳定，取不到的时候，取子分类游戏
                $date = Carbon::now()->toDateString();
                $count = Video::where('category_id', 1)->where('date', $date)->count();

                if ($count < 400) {
                    $categoryIds = Category::find(1)->children()->pluck('id');
                    $query->whereIn('category_id', $categoryIds)->latest('play_count');
                } else {
                    $query->where('category_id', $filters['category_id']);
                }
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

        if (isset($filters['token'])) {
            $user = User::where('token', $filters['token'])->first();
            $userCategoryIds = $user->categories()->pluck('categories.id');
            $query->whereIn('category_id', $userCategoryIds);
        }

//        if ($user = Auth::guard('api')->user()) {
//            $userCategoryIds = $user->categories()->pluck('id');
//
//            $query->whereIn('category_id', $userCategoryIds);
//        }

        return $query->where('status', 1);
    }
}
