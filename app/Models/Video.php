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
            $query->where('category_id', $filters['category_id']);
        }

        if (isset($filters['title'])) {
            $query->where('title', 'like', '%'.$filters['title'].'%');
        }

        if (isset($filters['date'])) {
            $query->whereBetween('date', $filters['date']);
        }

        if (isset($filters['openid'])) {
            $user = User::where('openid', $filters['openid'])->first();

            if (!$user) {
                $user = User::create([
                    'name' => '',
                    'email' => '',
                    'password' => '',
                    'phone' => '',
                    'openid' => $filters['openid'],
                    'qq' => '',
                    'nickname' => '',
                    'unionid' => '',
                ]);
            }
            $userCategoryIds = UserCategory::where('user_id', $user->id)->pluck('category_id');

            $query->whereIn('category_id', $userCategoryIds);
        }

        return $query->where('status', 0);
    }
}
