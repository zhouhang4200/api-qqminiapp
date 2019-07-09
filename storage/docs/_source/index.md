# 今日好看
------

#### 参数说明

测试地址（hosts中需要添加 10.0.4.44  miniapp.test ）: http://api.miniapp.test/api

#### 认证流程

客户端调用登录接口发送认证请求

服务器验证客户端的认证信息, 验证成功之后, 服务器向客户端返回一个token

客户端存储这个 token, 在之后每次向服务器发送请求时, 在Header中加入这个 token,

header 的 key 名为 Authorization 值为 Bearer + token (注意：Bearer 与token 中间有空格)

服务器验证这个 token 的合法性, 只要验证通过, 服务器就认为该请求是一个合法的请求

#### 请求说明

不需要验证身份的接口正常传参

需要验证身份的接口，在header头部需要传入auth认证信息，示例如下：

$.ajax({
    headers: {
        Authorization: "Bearer xxxxxxxxxxxxx"，
        Accept:application/json
    }
});

#### 响应说明

客户端的每次请求服务器会返回固定的响应格式(json）

status：为响应状态码，0表示正常，其他非0状态均为错误码

info：响应说明

data：响应数据，如无返回值则为空
