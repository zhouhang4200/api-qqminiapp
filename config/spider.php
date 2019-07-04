<?php

return [
    'source' => [
        1 => 'https://m.v.qq.com',
        2 => 'https://ixigua.com'
    ],
    'spider_url' => [
        'xigua_base_url' => 'https://www.ixigua.com', // 搞笑的原始网站
        'qq_base_url' => 'https://v.qq.com', // 搞笑的原始网站
        'game'         => [
            'wzry' => 'https://v.qq.com/x/search/?q=%E7%8E%8B%E8%80%85%E8%8D%A3%E8%80%80&stag=0&smartbox_ab=&cur=', // 王者荣耀
            'lol'  => 'https://v.qq.com/x/search/?q=%E8%8B%B1%E9%9B%84%E8%81%94%E7%9B%9F&stag=0&smartbox_ab=&cur=', // 英雄联盟
            'hpjy' => 'https://v.qq.com/x/search/?q=%E5%92%8C%E5%B9%B3%E7%B2%BE%E8%8B%B1&stag=0&smartbox_ab=&cur=', // 和平经营
            'jdqs' => 'https://v.qq.com/x/search/?q=%E7%BB%9D%E5%9C%B0%E6%B1%82%E7%94%9F&stag=0&smartbox_ab=&cur=', // 绝地求生
            'dwrg' => 'https://v.qq.com/x/search/?q=%E7%AC%AC%E4%BA%94%E4%BA%BA%E6%A0%BC&stag=0&smartbox_ab=&cur=', // 第五人格
        ],
        'fun'          => 'https://www.ixigua.com/channel/gaoxiao/', // 搞笑
        'ent'          => 'https://www.ixigua.com/api/feed/channel?_signature=DvzWWAAgEA.guokTHfzp2A781kAAFPm&channelId=61887739374&count=15&maxTime=1562213858', // 娱乐
        'comic'        => 'https://v.qq.com/x/search/?q=%E5%8A%A8%E6%BC%AB&stag=0&smartbox_ab=&cur=', // 动漫
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
    'fun'        => [
        'class'   => '.cards-flex  .card-container', // 要查找的类标签，查找original_url
        'element' => '.player',  // 需要精确查找的标签，查找url
    ],
    'comic'      => [
        'class'   => '.result_item', // 要查找的类标签，查找original_url
        'element' => 'video',  // 需要精确查找的标签，查找url
    ],
    'ent'      => [
        'class'   => '.cards-flex  .card-container', // 要查找的类标签，查找original_url
        'element' => 'video',  // 需要精确查找的标签，查找url
    ],
];
