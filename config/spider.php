<?php

return [
    'spider_url' => [
        'fun_base_url' => 'https://www.ixigua.com', // 搞笑的原始网站
        'game' => [
            'wangzherongyao' => 'https://v.qq.com/x/search/?q=%E7%8E%8B%E8%80%85%E8%8D%A3%E8%80%80&stag=0&smartbox_ab=&cur=', // 王者荣耀
            'lol' => 'https://v.qq.com/x/search/?q=%E7%8E%8B%E8%80%85%E8%8D%A3%E8%80%80&stag=0&smartbox_ab=&cur=', // 王者荣耀
        ],
//        'fun' => 'http://m.ixigua.com/?channel=subv_funny#channel=subv_funny', // 搞笑
        'fun' => 'https://www.ixigua.com/channel/gaoxiao/', // 搞笑
        'ent' => 'https://m.v.qq.com/x/channel/video/recreation', // 娱乐
        'comic' => 'https://v.qq.com/x/search/?q=%E5%8A%A8%E6%BC%AB&stag=0&smartbox_ab=&cur=', // 动漫
    ],
    'category' => [
        'game' => 1,
        'ent' => 2, //娱乐
        'fun' => 3,
        'comic' => 4, // 动漫
    ],
    'fun' => [
        'class' => '.cards-flex  .card-container', // 要查找的类标签，查找original_url
        'element' => '.player',  // 需要精确查找的标签，查找url
    ],
    'comic' => [
        'class' => '.cards-flex  .card-container', // 要查找的类标签，查找original_url
        'element' => '.player',  // 需要精确查找的标签，查找url
    ],
];
