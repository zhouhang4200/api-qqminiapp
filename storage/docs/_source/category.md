
### 获取视频分类

#### 请求

`POST` /category

#### 请求参数

无

#### 响应

```
{
    "code": 0,
    "data": [
        {
            "id": 1,
            "pid": 0,
            "name": "游戏",
        },
        {
            "id": 2,
            "pid": 0,
            "name": "娱乐",
        },
        {
            "id": 3,
            "pid": 0,
            "name": "搞笑",
        },
        {
            "id": 4,
            "pid": 0,
            "name": "动漫",
        },
        {
            "id": 5,
            "pid": 1,
            "name": "王者荣耀",
        },
        {
            "id": 6,
            "pid": 1,
            "name": "英雄联盟",
        },
        {
            "id": 7,
            "pid": 1,
            "name": "和平精英",
        },
        {
            "id": 8,
            "pid": 1,
            "name": "绝地求生",
        },
        {
            "id": 9,
            "pid": 1,
            "name": "第五人格",
        }
    ],
    "message": "success"
}
```
### 用户订阅

#### 请求

`POST` /category/subscribe

#### 请求参数

| 参数名      | 说明 |
| -------- | -----:  |
| category_id     | 1游戏2娱乐3搞笑4动漫5王者荣耀6英雄联盟7和平精英8绝地求生9第五人格 |
   |    
#### 响应
```
{
    "code": 0,
    "data": [
    ],
    "message": "success"
}
```
