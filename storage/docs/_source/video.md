
### 视频（用户未订阅或已订阅）

#### 请求

`GET` /video

#### 请求参数

| 参数名      | 说明 |
| -------- | -----:  |
| category_id | 分类，可选：1游戏2娱乐3搞笑4动漫5王者荣耀6英雄联盟7和平精英8绝地求生9第五人格 |
| title | 标题, 可选 |
| token | 可选 |

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
                "date": "2019-07-10",
                "status": 1,
                "category_id": 3,
                "title": "茂名德仔\u0005搞笑\u0006配音视频-相睇，笑死人",
                "thumb": "http://puui.qpic.cn/qqvideo_ori/0/j0896ev19qj_496_280/0",
                "original_url": "http://m.v.qq.com/page/j/0/j/j0896ev19qj.html",
                "url": "https://apd-84a834bccdc9b377386448c4228b8d89.v.smtcdns.com/vhot2.qqvideo.tc.qq.com/A0pscuHYP81mV99oMlYg9ZPhT4Q2WswfvK_V9EbKI8zg/uwMROfz2r5zCIaQXGdGnC2dfhzk_jigLCkkLvI0zErHWpl3G/j0896ev19qj.m701.mp4?vkey=F376232A043B545A06D5DF9C896B37594576F7AEFF56796D7AD306F19080D068F5A7DEFDDAE5BA1BF4136D0995BCD134D4144425FE0103FB0CD5D5EBA49C084A16AFD76E00B0E86CAF05457018B93850226A06535BC91004C22944DD7E706AD17AB86A9D309046F13726DF579FA6BFE9BA56CE891F731B4B839F26017FA522E6",
                "play_count": "2060",
                "play_time": "257",
                "source_id": 1,
                "created_at": "2019-07-10 12:48:20",
                "updated_at": "2019-07-10 12:48:20",
                "category": {
                    "id": 3,
                    "pid": 0,
                    "name": "搞笑",
                    "created_at": null,
                    "updated_at": null
                }
            },
            {
                "id": 2,
                "date": "2019-07-10",
                "status": 1,
                "category_id": 3,
                "title": "鲨鱼哥与美人鱼\u0005搞笑\u0006动画：鲨鱼哥跪求导演给个机会",
                "thumb": "http://puui.qpic.cn/qqvideo_ori/0/o08965hjvqs_496_280/0",
                "original_url": "http://m.v.qq.com/page/o/0/s/o08965hjvqs.html",
                "url": "https://apd-334eb9e53c181e78ffb0cafdcf9b4b72.v.smtcdns.com/om.tc.qq.com/ArdSfzwAGyMtjErvYUvZrxU6rx9GGHXAXs9bUhS4eTIw/uwMROfz2r5zEIaQXGdGnC2dfhzkPz8itARfiFgGOU57BRa9q/o08965hjvqs.m701.mp4?vkey=4BC0B9F19343729C59549B9B20C4500FBADFDBB497019262265F70F5123FBA65A5EF5C9C3B7B5F7995CD7FF3EC09383B186E8CC1FA5E6895580083BE04978ECDA12EF8136708F87BA61456E841FBF84953A505DD2A06CFF31BEA4CD5B7B516E8F4DE5E4AB006E03412623E14A2E186F19487168904B4D777B37F1E123161F70B",
                "play_count": "0",
                "play_time": "179",
                "source_id": 1,
                "created_at": "2019-07-10 12:48:22",
                "updated_at": "2019-07-10 12:48:22",
                "category": {
                    "id": 3,
                    "pid": 0,
                    "name": "搞笑",
                    "created_at": null,
                    "updated_at": null
                }
            },
            {
                "id": 3,
                "date": "2019-07-10",
                "status": 1,
                "category_id": 3,
                "title": "少年派：妹妹意外听到妙妙秘密妙妙竟这样威胁妹妹\u0005搞笑\u0006了",
                "thumb": "http://puui.qpic.cn/qqvideo_ori/0/k08965iaqdo_496_280/0",
                "original_url": "http://m.v.qq.com/page/k/0/o/k08965iaqdo.html",
                "url": "https://apd-909072b4af93c36bbefa3ac0e3c292ad.v.smtcdns.com/om.tc.qq.com/AUIbyjyVI-2VGfkEF-Q3quicdUCqDOMfPL7jQKLUr8o0/uwMROfz2r5zCIaQXGdGnC2dfhzk_jigLCkkLvI0zErHWpl3G/k08965iaqdo.m701.mp4?vkey=5B91E2737A78DA5F3786B7A425BBAC920A1F4F94CBDD9D8BCA50EDB4A6397FBCD2B03241697F537A48A26F3B7BCAAE491EBEF26EA446FA91F99E249CD8010412A0FFBFD019B45FA50D69852242752D7F151B4C83BB7CA4FA344D81F1E93FA2B4D041C8B6D90447A816CC85867030C136526F93BCFD9D3FA481D2E352622E0E13",
                "play_count": "0",
                "play_time": "207",
                "source_id": 1,
                "created_at": "2019-07-10 12:48:24",
                "updated_at": "2019-07-10 12:48:24",
                "category": {
                    "id": 3,
                    "pid": 0,
                    "name": "搞笑",
                    "created_at": null,
                    "updated_at": null
                }
            }
        ],
        "first_page_url": "http://api.qq-program.test/api/video?page=1",
        "from": 1,
        "last_page": 963,
        "last_page_url": "http://api.qq-program.test/api/video?page=963",
        "next_page_url": "http://api.qq-program.test/api/video?page=2",
        "path": "http://api.qq-program.test/api/video",
        "per_page": 3,
        "prev_page_url": null,
        "to": 3,
        "total": 2889
    }
}
```

### 更多相关视频

#### 请求

`GET` /video/recommend

#### 请求参数

| 参数名      | 说明 |
| -------- | -----:  |
| video_id | video视频的id |

#### 响应

```
{
    "status": 0,
    "info": "获取成功",
    "data": [
        {
            "id": 34,
            "date": "2019-07-10",
            "status": 1,
            "category_id": 3,
            "title": "迷你世界 天天村长\u0005搞笑\u0006版离人愁",
            "thumb": "http://puui.qpic.cn/qqvideo_ori/0/q0896e652iy_496_280/0",
            "original_url": "http://m.v.qq.com/page/q/0/y/q0896e652iy.html",
            "url": "https://apd-889f99abe922d924156835f82af11cb8.v.smtcdns.com/om.tc.qq.com/Ak225uPDICfthJjjyeSeA2Y_AK4JqiwidHcfQFei5AvI/uwMROfz2r5zIIaQXGdGnC2dfDmb_xYKxrIGz_bGUg2Lja6ru/q0896e652iy.mp4?vkey=B6C6745EB871B4D49D8CDE74F07556EFAB67045F73E8FE1DD3477DEEB988D57D875B35F6FEFBEF7EB491D7F42FCAAA459D173734DD18B76371F1A625690AB9C06C2C35501A523B82D7D9E02145201B28C6FC468907B5FC9BEE44C383AB8772A739947E49BF965B1162168330987F787019F2B2022B8DD614FDB98E5206439394",
            "play_count": "0",
            "play_time": "26",
            "source_id": 1,
            "created_at": "2019-07-10 12:49:35",
            "updated_at": "2019-07-10 12:49:35",
            "category": {
                "id": 3,
                "pid": 0,
                "name": "搞笑",
                "created_at": null,
                "updated_at": null
            }
        },
        {
            "id": 35,
            "date": "2019-07-10",
            "status": 1,
            "category_id": 3,
            "title": "黑衣女选手来闯关，落水画面被多次回放，节目组太\u0005搞笑\u0006了",
            "thumb": "http://puui.qpic.cn/qqvideo_ori/0/k0896zvvout_496_280/0",
            "original_url": "http://m.v.qq.com/page/k/0/t/k0896zvvout.html",
            "url": "https://apd-889f99abe922d924156835f82af11cb8.v.smtcdns.com/om.tc.qq.com/Ayb5_7nGFXn7ldHMCc6RQXiu8AqwUNynGcihSauVtRDc/uwMROfz2r5zEIaQXGdGnC2dfhzkPz8itARfiFgGOU57BRa9q/k0896zvvout.m701.mp4?vkey=A9491B0D36956A0E122EE0FE411090FEF670C8A8CA329C2211AAB28A656B617DD59001A556FE302FDB600CC93B198D206AA76D08BF5D6EE6F555DC1FF9E299FEC3C92D630568E82718C1CF9D498971091AB9528895E918EA17067A9FAE2FB09ED87CEDB784363D9403E650EF5C2CE84F14E683E722A12B5975DF0025A44DAC7D",
            "play_count": "0",
            "play_time": "124",
            "source_id": 1,
            "created_at": "2019-07-10 12:49:38",
            "updated_at": "2019-07-10 12:49:38",
            "category": {
                "id": 3,
                "pid": 0,
                "name": "搞笑",
                "created_at": null,
                "updated_at": null
            }
        },
        {
            "id": 36,
            "date": "2019-07-10",
            "status": 1,
            "category_id": 3,
            "title": "新闺蜜时代：美女故意恶搞好闺蜜，看到闺蜜出丑，简直太\u0005搞笑\u0006了！",
            "thumb": "http://puui.qpic.cn/qqvideo_ori/0/c08968ft6cq_496_280/0",
            "original_url": "http://m.v.qq.com/page/c/0/q/c08968ft6cq.html",
            "url": "https://apd-334eb9e53c181e78ffb0cafdcf9b4b72.v.smtcdns.com/om.tc.qq.com/A2oT3Y_hz5XuIrHV8h75mqw8IdJE7fnbA0FZEKVab9PU/uwMROfz2r5zEIaQXGdGnC2dfhzkPz8itARfiFgGOU57BRa9q/c08968ft6cq.m701.mp4?vkey=48CA3793E41E271279C6C3E840DE0AF729971B290C16BD4D2D275494B8BBE35B3B46FE565A6D411AE9360A7F8B5D7DA26C3F32DD0FBB0A95AF9C8650F7527732CF3BA25E143E8A0701D8FCBCFF47EED2559195FC3463102F17DB42941FB9D7DB8C3C59F3A5CF2E41001366B3D8C473B86402DF3C4E8B2F5FFD6EF367FC218A36",
            "play_count": "0",
            "play_time": "168",
            "source_id": 1,
            "created_at": "2019-07-10 12:49:40",
            "updated_at": "2019-07-10 12:49:40",
            "category": {
                "id": 3,
                "pid": 0,
                "name": "搞笑",
                "created_at": null,
                "updated_at": null
            }
        }
    ]
}
```
