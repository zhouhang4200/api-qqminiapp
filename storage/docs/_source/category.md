
### 获取分类

#### 请求

`POST` /category

#### 请求参数

| 参数名      | 说明 |
| -------- | -----:  |
| category_id     | 1游戏2娱乐3搞笑4动漫 |

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
            "children": []
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
            "children": []
        }
    ],
    "info": "success"
}
```
### 用户点击订阅

#### 请求

`POST` /category/subscribe

#### 请求参数

| 参数名      | 说明 |
| -------- | -----:  |
| category_id     | 1游戏2娱乐3搞笑4动漫5王者荣耀6英雄联盟7和平精英8绝地求生9第五人格,逗号拼接 |
     
#### 响应
```
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

无，头部需传token
     
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
                "id": 7,
                "pid": 1,
                "name": "和平精英",
                "created_at": null,
                "updated_at": null,
                "pivot": {
                    "user_id": 1,
                    "category_id": 7
                }
            }
        ]
    },
    "info": "success"
}
```
