
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

