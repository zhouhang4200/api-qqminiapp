
### 获取分类

#### 请求

`GET` /category

#### 请求参数

| 参数名      | 类型| 说明 | 必传|
| -------- | --- |-------- |-----:  |
| category_id | int|主分类id | 否 |

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

| 参数名      |类型| 说明 | 必传 |
| -------- |------ | --------| -----:  | 
| token     |  string|身份识别串 | 是 |
| category_id  |string   |  子分类id,英文逗号拼接：11,12,13 | 是 |
     
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

| 参数名      |类型| 说明 | 必传 |
| -------- | ------- | --------| -----:  | 
| token     |  string|身份识别串 | 是 |
     
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

### 分类明细

| id      | pid|名称 |
| -------- |------ |  -----:  |
| 1 | 0|游戏 | 
| 2 | 0|娱乐 | 
| 3 | 0|搞笑 | 
| 4 | 0|动漫 | 
| 5 | 1|王者荣耀 | 
| 6 | 1|英雄联盟 | 
| 7 | 1|和平精英 | 
| 8 | 1|绝地求生 | 
| 9 | 1|第五人格 | 
| 10 | 4|柯南 | 
| 11 | 4|海贼王 | 
| 12 | 4|火影忍者 | 
| 13 | 4|斗罗大陆 | 
| 14 | 4|魔道祖师 | 
| 15 | 2|周杰伦 | 
| 16 | 2|火箭少女 | 
| 17 | 2|易洋千玺 | 
| 18 | 2|赵丽颖 | 
| 19 | 2|朱一龙 | 
