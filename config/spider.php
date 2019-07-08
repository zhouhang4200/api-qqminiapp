<?php

return [
    'api_domain' => env('API_DOMAIN', 'api.miniapp.test'),
    'source' => [
        1 => 'https://m.v.qq.com',
        2 => 'https://ixigua.com'
    ],
    'spider_url' => [
        'xigua_base_url' => 'https://www.ixigua.com', // 搞笑的原始网站
        'qq_base_url' => 'https://v.qq.com', // 搞笑的原始网站
        'game'         => [
            'wzry' => 'https://www.ixigua.com/i6704242702633927175/', // 王者荣耀
            'lol'  => 'https://www.ixigua.com/i6707793361656349197/', // 英雄联盟
            'hpjy' => 'https://www.ixigua.com/i6702286767841608200/', // 和平精英
            'jdqs' => 'https://www.ixigua.com/i6709236154866074125/', // 绝地求生
            'dwrg' => 'https://www.ixigua.com/i6709318423500816910/', // 第五人格
        ],
        'fun'          => 'https://www.ixigua.com/i6533362934725214734/', // 搞笑
        'ent'          => 'https://www.ixigua.com/i6710048847986426381/', // 娱乐
//        'ent'          => 'https://www.ixigua.com/api/feed/channel?_signature=DvzWWAAgEA.guokTHfzp2A781kAAFPm&channelId=61887739374&count=15&maxTime=1562213858', // 娱乐
        'comic'        => 'https://www.ixigua.com/i6706705261110755854/', // 动漫
//        'comic'        => 'https://www.ixigua.com/api/search/complex/%E5%8A%A8%E6%BC%AB/20?_signature=AOSMoAAgEADuotPrH8DYZADkjLAAF3.', // 动漫
    ],
    'category'   => [
        'game'  => 1, // 游戏
        'ent'   => 2, // 娱乐
        'fun'   => 3, // 搞笑
        'comic' => 4, // 动漫
        'wzry'  => 5, // 王者荣耀
        'lol'   => 6, // 英雄联盟
        'hpjy'  => 7, // 和平精英
        'jdqs'  => 8, // 绝地求生
        'dwrg'  => 9, // 第五人格
    ],
    'document'        => [
        'class'   => '.card-list-vertical .card-container .card-cont', // 要查找的类标签，查找original_url
        'element' => '.card-cont__bg',  // 需要精确查找的标签，查找url
    ],
//    'comic'      => [
//        'class'   => '.result_item', // 要查找的类标签，查找original_url
//        'element' => 'video',  // 需要精确查找的标签，查找url
//    ],
//    'ent'      => [
//        'class'   => '.cards-flex  .card-container', // 要查找的类标签，查找original_url
//        'element' => 'video',  // 需要精确查找的标签，查找url
//    ],
];
