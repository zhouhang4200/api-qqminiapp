
### 获取分类

#### 请求

`GET` /category

#### 请求参数

| 参数名      | 说明 |
| -------- | -----:  |
| category_id     | 父分类ID，可选：1游戏2娱乐3搞笑4动漫 |

#### 响应

```
{
    "status": 0,
    "data": [
        {
            "id": 1,
            "pid": 0,
            "name": "游戏",
            "created_at": null,
            "updated_at": null,
            "children": [
                {
                    "id": 5,
                    "pid": 1,
                    "name": "王者荣耀",
                    "created_at": null,
                    "updated_at": null
                },
                {
                    "id": 6,
                    "pid": 1,
                    "name": "英雄联盟",
                    "created_at": null,
                    "updated_at": null
                },
                {
                    "id": 7,
                    "pid": 1,
                    "name": "和平精英",
                    "created_at": null,
                    "updated_at": null
                },
                {
                    "id": 8,
                    "pid": 1,
                    "name": "绝地求生",
                    "created_at": null,
                    "updated_at": null
                },
                {
                    "id": 9,
                    "pid": 1,
                    "name": "第五人格",
                    "created_at": null,
                    "updated_at": null
                }
            ]
        },
        {
            "id": 2,
            "pid": 0,
            "name": "娱乐",
            "created_at": null,
            "updated_at": null,
            "children": [
                {
                    "id": 15,
                    "pid": 2,
                    "name": "周杰伦",
                    "created_at": null,
                    "updated_at": null
                },
                {
                    "id": 16,
                    "pid": 2,
                    "name": "火箭少女",
                    "created_at": null,
                    "updated_at": null
                },
                {
                    "id": 17,
                    "pid": 2,
                    "name": "易洋千玺",
                    "created_at": null,
                    "updated_at": null
                },
                {
                    "id": 18,
                    "pid": 2,
                    "name": "赵丽颖",
                    "created_at": null,
                    "updated_at": null
                },
                {
                    "id": 19,
                    "pid": 2,
                    "name": "朱一龙",
                    "created_at": null,
                    "updated_at": null
                }
            ]
        },
        {
            "id": 3,
            "pid": 0,
            "name": "搞笑",
            "created_at": null,
            "updated_at": null,
            "children": []
        },
        {
            "id": 4,
            "pid": 0,
            "name": "动漫",
            "created_at": null,
            "updated_at": null,
            "children": [
                {
                    "id": 10,
                    "pid": 4,
                    "name": "柯南",
                    "created_at": null,
                    "updated_at": null
                },
                {
                    "id": 11,
                    "pid": 4,
                    "name": "海贼王",
                    "created_at": null,
                    "updated_at": null
                },
                {
                    "id": 12,
                    "pid": 4,
                    "name": "火影忍者",
                    "created_at": null,
                    "updated_at": null
                },
                {
                    "id": 13,
                    "pid": 4,
                    "name": "斗罗大陆",
                    "created_at": null,
                    "updated_at": null
                },
                {
                    "id": 14,
                    "pid": 4,
                    "name": "魔道祖师",
                    "created_at": null,
                    "updated_at": null
                }
            ]
        }
    ],
    "info": "success"
}
```
### 用户点击订阅

#### 请求

`POST` /category/subscribe

#### 请求参数

头部需传Authorization

| 参数名      | 说明 |
| -------- | -----:  |
| category_id     | 1游戏2娱乐3搞笑4动漫5王者荣耀6英雄联盟7和平精英8绝地求生9第五人格,逗号拼接 |
     
#### 响应
```
{
    "code": 10000,
    "message": "token已过期，请重新登录",
    "data": ""
}
或
{
    "status": 0,
    "data": "",
    "info": "订阅成功"
}
```
### 用户订阅的分类

#### 请求

`POST` /category/user

#### 请求参数

无，头部需传Authorization
     
#### 响应
```
{
    "status": 0,
    "data": {
        "id": 1,
        "openid": "123456",
        "unionid": "",
        "name": null,
        "phone": null,
        "qq": null,
        "nickname": null,
        "email": null,
        "created_at": null,
        "updated_at": null,
        "categories": [
            {
                "id": 2,
                "pid": 0,
                "name": "娱乐",
                "created_at": null,
                "updated_at": null,
                "pivot": {
                    "user_id": 1,
                    "category_id": 2
                }
            },
            {
                "id": 3,
                "pid": 0,
                "name": "搞笑",
                "created_at": null,
                "updated_at": null,
                "pivot": {
                    "user_id": 1,
                    "category_id": 3
                }
            },
            {
                "id": 4,
                "pid": 0,
                "name": "动漫",
                "created_at": null,
                "updated_at": null,
                "pivot": {
                    "user_id": 1,
                    "category_id": 4
                }
            },
            {
                "id": 5,
                "pid": 1,
                "name": "王者荣耀",
                "created_at": null,
                "updated_at": null,
                "pivot": {
                    "user_id": 1,
                    "category_id": 5
                }
            },
            {
                "id": 6,
                "pid": 1,
                "name": "英雄联盟",
                "created_at": null,
                "updated_at": null,
                "pivot": {
                    "user_id": 1,
                    "category_id": 6
                }
            }
        ]
    },
    "info": "success"
}
```
