
### 获取openid和token

#### 请求

`POST` /code

#### 请求参数

| 参数名      | 说明 |
| -------- | -----:  |
| code     | qq小程序code |

#### 响应

```
{
    "status": 0,
    "data": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImNiYzJkNmQ2MTMzYzk2NjgzNzcxZGVjY2JkNzZmNjkyYmJhNzQ4ZGU0NDk3ODZiNjc1MDRhZjJjMWE0NDUzMGE2NTY2ZmRkNWVlOGRhZWQ3In0.eyJhdWQiOiIxIiwianRpIjoiY2JjMmQ2ZDYxMzNjOTY2ODM3NzFkZWNjYmQ3NmY2OTJiYmE3NDhkZTQ0OTc4NmI2NzUwNGFmMmMxYTQ0NTMwYTY1NjZmZGQ1ZWU4ZGFlZDciLCJpYXQiOjE1NjI3NDMxMjIsIm5iZiI6MTU2Mjc0MzEyMiwiZXhwIjoxNTk0MzY1NTIyLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.uy9SFQrLhCU7TVpc4OppB8WQjVF5WH8gcsHHRgIz0C2GnJ4t0Plm7rE8CnelkOENYHZhQ7J5JgXNmKheWzsw8DFwuV2LYckvA7J_daYZvqPZyjD6KkgzbVLiJZuAwwCXLGZDNK6Jk4gkrfFvFyNVMQ-kKzRwo8PW4aYPiemJL5eU7HHQ_S-E2hi4UmsP3OpXqBjc72RlA4vIyCa035lcU1cIsCx31oyN0SnTFUpCIXGi91QnfRYWQyWPRzwX0P02hUkidEZromb4Ow09IwPCxpMyur7zzmV7GtCWICi-ZpwWuADM8JpMb73EzeD15KJYQrkh0XT0PiYeW8fxKhqgR2xA8zrdSyD7CdEh0asDtAMLvPL9EXGJqgorVWhRmL38-Mq3Yx0g_7K7Zo3tsp_UCmWrzN4t1aSXjzBadyCnUweGdqHZQwjt71FEmcCiqLTQVllYjKOXRp4vXCGk54rYtGtP_UQyga4KbFtblq_z0VaCtb3OhLWKo0o2L6USS5JrYAHSB8OndVkvemks9yvpjPhCBt8hBqT4CXaxZc2zcjFZXQY_C6uSjrUk84P8Ob_tIwq9G0pScmJz0PWYHjkgPkjX6MwSmLSY_piFENqLnb8r_xzKrLsajLbrxa5pa8gz9xoQ5JA6XmzraBcI961aT6ZKTMMj_I1vFlbBHceDHKg"
    },
    "info": "success"
}
```
