<?php

namespace App\Models;

use App\Exceptions\QqException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Video extends Model
{
    protected $fillable = [
        'category_id', 'title', 'thumb', 'url', 'original_url',
        'date', 'status', 'play_count', 'play_time', 'source_id',
        'source_name', 'created_at', 'updated_at', 'sort',
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
            // 游戏，娱乐，动漫
            if (in_array($filters['category_id'], [1, 2, 4])) {
                $date  = Carbon::now()->toDateString();
                $count = Video::where('category_id', $filters['category_id'])->where('date', $date)->count();

                if ($count < 400) {
                    $categoryIds = Category::find($filters['category_id'])->children()->pluck('id')->merge($filters['category_id']);
                    $query->whereIn('category_id', $categoryIds)->latest('sort');
                } else {
                    $query->where('category_id', $filters['category_id']);
                }
            } elseif ($filters['category_id'] == 'gz') { // 关注
                if (isset($filters['token'])) {
                    $user            = Cache::get($filters['token']);

                    if (!$user) {
                        throw new QqException('token错误');
                    }
                    $userCategoryIds = $user->categories()->pluck('categories.id');
                    $query->whereIn('category_id', $userCategoryIds)->latest('sort');
                } else {
                    throw new QqException('token参数不可为空');
                }
            } elseif ($filters['category_id'] == 'tj') { // 推荐
                $query->latest('sort');
            } else {
                $query->where('category_id', $filters['category_id']);
            }
        }

        if (isset($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        if (isset($filters['date'])) {
            $query->whereBetween('date', $filters['date']);
        }

//        if ($user = Auth::guard('api')->user()) {
//            $userCategoryIds = $user->categories()->pluck('id');
//
//            $query->whereIn('category_id', $userCategoryIds);
//        }

        return $query->where('status', 1);
    }
}
