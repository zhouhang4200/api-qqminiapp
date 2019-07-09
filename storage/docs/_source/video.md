
### 获取相关视频

#### 请求

`POST` /video

#### 请求参数

| 参数名      | 说明 |
| -------- | -----:  |
| category_id | 1游戏2娱乐3搞笑4动漫5王者荣耀6英雄联盟7和平精英8绝地求生9第五人格 |

#### 响应

```
{
    "status": 0,
    "info": "获取成功",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "date": "2019-07-08",
                "status": 0,
                "category_id": 3,
                "title": "美女超市买辣条，一连两天买100包，老板做法太逗了",
                "thumb": "http://p9-xg.byteimg.com/img/tos-cn-i-0000/8414bd14916911e9b0ca0cc47af43c90~c5_q75_576x324.jpeg",
                "original_url": "https://www.ixigua.com/i6703678578044699150/",
                "url": "",
                "play_count": "0",
                "play_time": "03:14",
                "source_id": 2,
                "created_at": "2019-07-08 17:48:30",
                "updated_at": "2019-07-08 17:48:30"
            },
            {
                "id": 2,
                "date": "2019-07-08",
                "status": 0,
                "category_id": 3,
                "title": "奇葩老师让学生吃雪碧泡火鸡面，不料吃货女同学连吃四袋，太逗了",
                "thumb": "http://p9-xg.byteimg.com/img/tos-cn-i-0000/55e480c697d311e9ab7bac1f6b0b0a7e~c5_q75_576x324.jpeg",
                "original_url": "https://www.ixigua.com/i6706707199835505156/",
                "url": "",
                "play_count": "0",
                "play_time": "05:31",
                "source_id": 2,
                "created_at": "2019-07-08 17:48:30",
                "updated_at": "2019-07-08 17:48:30"
            }
        ],
        "first_page_url": "http://api.qq-program.test/api/video?page=1",
        "from": 1,
        "last_page": 55,
        "last_page_url": "http://api.qq-program.test/api/video?page=55",
        "next_page_url": "http://api.qq-program.test/api/video?page=2",
        "path": "http://api.qq-program.test/api/video",
        "per_page": 2,
        "prev_page_url": null,
        "to": 2,
        "total": 109
    }
}
```

### 搜索视频

#### 请求

`POST` /video/search

#### 请求参数

| 参数名      | 说明 |
| -------- | -----:  |
| title     | 标题名 |

#### 响应

```
{
    "status": 0,
    "info": "获取成功",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 2,
                "date": "2019-07-08",
                "status": 0,
                "category_id": 3,
                "title": "奇葩老师让学生吃雪碧泡火鸡面，不料吃货女同学连吃四袋，太逗了",
                "thumb": "http://p9-xg.byteimg.com/img/tos-cn-i-0000/55e480c697d311e9ab7bac1f6b0b0a7e~c5_q75_576x324.jpeg",
                "original_url": "https://www.ixigua.com/i6706707199835505156/",
                "url": "",
                "play_count": "0",
                "play_time": "05:31",
                "source_id": 2,
                "created_at": "2019-07-08 17:48:30",
                "updated_at": "2019-07-08 17:48:30"
            },
            {
                "id": 5,
                "date": "2019-07-08",
                "status": 0,
                "category_id": 3,
                "title": "老师让学生念作文，没想学生写的作文一个比一个有趣，太奇葩了",
                "thumb": "http://p9-xg.byteimg.com/img/mosaic-legacy/1d5d70000a74e1c60e97b~c5_q75_576x324.jpeg",
                "original_url": "https://www.ixigua.com/i6671961152890601997/",
                "url": "",
                "play_count": "0",
                "play_time": "03:05",
                "source_id": 2,
                "created_at": "2019-07-08 17:48:30",
                "updated_at": "2019-07-08 17:48:30"
            }
        ],
        "first_page_url": "http://api.qq-program.test/api/video?page=1",
        "from": 1,
        "last_page": 2,
        "last_page_url": "http://api.qq-program.test/api/video?page=2",
        "next_page_url": "http://api.qq-program.test/api/video?page=2",
        "path": "http://api.qq-program.test/api/video",
        "per_page": 2,
        "prev_page_url": null,
        "to": 2,
        "total": 3
    }
}
```

### 更多推荐视频

#### 请求

`POST` /video/recommend

#### 请求参数

无

#### 响应

```
{
    "status": 0,
    "info": "获取成功",
    "data": [
        {
            "id": 21,
            "date": "2019-07-08",
            "status": 0,
            "category_id": 3,
            "title": "搞笑视频集锦：敢和大妈在广场舞斗舞的，一看就不是一般人！",
            "thumb": "http://p3-xg.byteimg.com/img/tos-cn-i-0000/735ede1a7d6811e9b5adac1f6b0ac8de~c5_q75_576x324.jpeg",
            "original_url": "https://www.ixigua.com/i6689693355883889166/",
            "url": "",
            "play_count": "0",
            "play_time": "01:34",
            "source_id": 2,
            "created_at": "2019-07-08 17:48:30",
            "updated_at": "2019-07-08 17:48:30"
        },
        {
            "id": 22,
            "date": "2019-07-08",
            "status": 0,
            "category_id": 3,
            "title": "学生考试内容是绝地求生，没想全班都是满分，太有趣了",
            "thumb": "http://p9-xg.byteimg.com/img/tos-cn-i-0000/a9aab8748b2611e997d20cc47af43c90~c5_q75_576x324.jpeg",
            "original_url": "https://www.ixigua.com/i6700721836180636174/",
            "url": "",
            "play_count": "0",
            "play_time": "03:21",
            "source_id": 2,
            "created_at": "2019-07-08 17:48:30",
            "updated_at": "2019-07-08 17:48:30"
        },
        {
            "id": 23,
            "date": "2019-07-08",
            "status": 0,
            "category_id": 3,
            "title": "城里美女到乡下问路不礼貌，被高智商老农民恶搞，这大哥太有才了",
            "thumb": "http://p3-xg.byteimg.com/img/tos-cn-i-0000/070e63b89d1411e99187ac1f6b0b0a7e~c5_q75_576x324.jpeg",
            "original_url": "https://www.ixigua.com/i6709187719379026436/",
            "url": "",
            "play_count": "0",
            "play_time": "03:18",
            "source_id": 2,
            "created_at": "2019-07-08 17:48:30",
            "updated_at": "2019-07-08 17:48:30"
        },
        {
            "id": 24,
            "date": "2019-07-08",
            "status": 0,
            "category_id": 3,
            "title": "河南方言：村口酒瓶抽钱游戏，没想来个高手小朋友，老板赔惨了！",
            "thumb": "http://p3-xg.byteimg.com/img/tos-cn-i-0000/b759f06a8dc511e9864c6c92bf9f9826~c5_q75_576x324.jpeg",
            "original_url": "https://www.ixigua.com/i6701928011161141768/",
            "url": "",
            "play_count": "0",
            "play_time": "04:36",
            "source_id": 2,
            "created_at": "2019-07-08 17:48:30",
            "updated_at": "2019-07-08 17:48:30"
        },
        {
            "id": 25,
            "date": "2019-07-08",
            "status": 0,
            "category_id": 3,
            "title": "人字加一笔，写出11个奖励1000,，农村骗局被夫妻俩看透",
            "thumb": "http://p9-xg.byteimg.com/img/tos-cn-i-0004/77c9fe8acb6241669f33b493d589adff~c5_q75_576x324.jpeg",
            "original_url": "https://www.ixigua.com/i6681926584997249549/",
            "url": "",
            "play_count": "0",
            "play_time": "03:33",
            "source_id": 2,
            "created_at": "2019-07-08 17:48:30",
            "updated_at": "2019-07-08 17:48:30"
        },
        {
            "id": 26,
            "date": "2019-07-08",
            "status": 0,
            "category_id": 3,
            "title": "智能机器人ATM机，取钱需要吃粽子，吃的越多取的越多，太有趣了",
            "thumb": "http://p3-xg.byteimg.com/img/tos-cn-i-0000/4f981cbc88fd11e98f650cc47af43c90~c5_q75_576x324.jpeg",
            "original_url": "https://www.ixigua.com/i6699701082299302408/",
            "url": "",
            "play_count": "0",
            "play_time": "05:12",
            "source_id": 2,
            "created_at": "2019-07-08 17:48:30",
            "updated_at": "2019-07-08 17:48:30"
        },
        {
            "id": 27,
            "date": "2019-07-08",
            "status": 0,
            "category_id": 3,
            "title": "老师弄丢试卷，让全班学生重考一遍，没想个个都考试100分",
            "thumb": "http://p9-xg.byteimg.com/img/tos-cn-i-0000/983e733e7fad11e9b1117cd30adcc7ba~c5_q75_576x324.jpeg",
            "original_url": "https://www.ixigua.com/i6695247919148171783/",
            "url": "",
            "play_count": "0",
            "play_time": "04:40",
            "source_id": 2,
            "created_at": "2019-07-08 17:48:30",
            "updated_at": "2019-07-08 17:48:30"
        },
        {
            "id": 28,
            "date": "2019-07-08",
            "status": 0,
            "category_id": 3,
            "title": "搞笑视频集锦，吃饭喝水的时候千万别看！第一个就笑得不行了！",
            "thumb": "http://p3-xg.byteimg.com/img/tos-cn-i-0000/f7c1969e85f511e9ba900cc47af43c90~c5_q75_576x324.jpeg",
            "original_url": "https://www.ixigua.com/i6698270826342384136/",
            "url": "",
            "play_count": "0",
            "play_time": "01:21",
            "source_id": 2,
            "created_at": "2019-07-08 17:48:30",
            "updated_at": "2019-07-08 17:48:30"
        },
        {
            "id": 29,
            "date": "2019-07-08",
            "status": 0,
            "category_id": 3,
            "title": "自助超辣火鸡面，一次1元随便吃，没想小学生把一锅全吃完了",
            "thumb": "http://p9-xg.byteimg.com/img/tos-cn-i-0000/ccb56e2488c211e9b50d6c92bfa0f25c~c5_q75_576x324.jpeg",
            "original_url": "https://www.ixigua.com/i6699593147606893063/",
            "url": "",
            "play_count": "0",
            "play_time": "02:57",
            "source_id": 2,
            "created_at": "2019-07-08 17:48:30",
            "updated_at": "2019-07-08 17:48:30"
        },
        {
            "id": 30,
            "date": "2019-07-08",
            "status": 0,
            "category_id": 3,
            "title": "只字加一笔，大学生都写不出来，来个傻姑娘一气呵成，老板要哭了",
            "thumb": "http://p9-xg.byteimg.com/img/tos-cn-i-0000/3c6868fe8cfe11e9bba76c92bf9f9826~c5_q75_576x324.jpeg",
            "original_url": "https://www.ixigua.com/i6701591734079455758/",
            "url": "",
            "play_count": "0",
            "play_time": "05:15",
            "source_id": 2,
            "created_at": "2019-07-08 17:48:30",
            "updated_at": "2019-07-08 17:48:30"
        },
        {
            "id": 31,
            "date": "2019-07-08",
            "status": 0,
            "category_id": 3,
            "title": "美女卖辣条，身高一米二以下免费吃，不料小伙带来爷爷奶奶",
            "thumb": "http://p3-xg.byteimg.com/img/tos-cn-i-0000/a7166cb287a611e98f290cc47af43c90~c5_q75_576x324.jpeg",
            "original_url": "https://www.ixigua.com/i6688574692602675720/",
            "url": "",
            "play_count": "0",
            "play_time": "02:46",
            "source_id": 2,
            "created_at": "2019-07-08 17:48:30",
            "updated_at": "2019-07-08 17:48:30"
        },
        {
            "id": 32,
            "date": "2019-07-08",
            "status": 0,
            "category_id": 3,
            "title": "学生名字全是歌名，老师点一个名字学生唱一首歌，结局太逗了",
            "thumb": "http://p9-xg.byteimg.com/img/tos-cn-i-0004/a85f3b6f9c814849bec29c3ac7b3040b~c5_q75_576x324.jpeg",
            "original_url": "https://www.ixigua.com/i6690390847357190660/",
            "url": "",
            "play_count": "0",
            "play_time": "03:49",
            "source_id": 2,
            "created_at": "2019-07-08 17:48:30",
            "updated_at": "2019-07-08 17:48:30"
        },
        {
            "id": 33,
            "date": "2019-07-08",
            "status": 0,
            "category_id": 3,
            "title": "小字加一笔，写出五个送手机，没想农民小伙提笔就是五个，太有才",
            "thumb": "http://p9-xg.byteimg.com/img/tos-cn-i-0000/d8daad267ed211e9b9e40cc47af43c90~c5_q75_576x324.jpeg",
            "original_url": "https://www.ixigua.com/i6694900382994268680/",
            "url": "",
            "play_count": "0",
            "play_time": "03:34",
            "source_id": 2,
            "created_at": "2019-07-08 17:48:30",
            "updated_at": "2019-07-08 17:48:30"
        },
        {
            "id": 34,
            "date": "2019-07-08",
            "status": 0,
            "category_id": 3,
            "title": "美女给老板5毛钱冲方便面，没想抠门老板只冲调料不放面，太逗了",
            "thumb": "http://p3-xg.byteimg.com/img/tos-cn-i-0004/6560ed940a9943d2bfa2e15ef7dc218d~c5_q75_576x324.jpeg",
            "original_url": "https://www.ixigua.com/i6654447511169663501/",
            "url": "",
            "play_count": "0",
            "play_time": "03:17",
            "source_id": 2,
            "created_at": "2019-07-08 17:48:30",
            "updated_at": "2019-07-08 17:48:30"
        },
        {
            "id": 35,
            "date": "2019-07-08",
            "status": 0,
            "category_id": 3,
            "title": "学生课堂偷吃泡面被抓，没想老师用这招惩罚他，看完笑的肚子痛",
            "thumb": "http://p9-xg.byteimg.com/img/tos-cn-i-0004/2fa81ad34b904437bf1446d9f6889a96~c5_q75_576x324.jpeg",
            "original_url": "https://www.ixigua.com/i6685211768815354375/",
            "url": "",
            "play_count": "0",
            "play_time": "05:05",
            "source_id": 2,
            "created_at": "2019-07-08 17:48:30",
            "updated_at": "2019-07-08 17:48:30"
        }
    ]
}
```
