## 聊天室

使用php 7.0 + [swoole 1.7.19]+redis (http://www.swoole.com/)开发的客服系统。

###导入数据库,更新数据库配置文件
	数据库文件是data.sql
	数据库配置文件 core/config/database.php
	
### 启动 Redis Server

### 服务端
```
php server.php

```

### WEB端
```
http://localhost:8000/mychat/client/index.html

根据数据库初始一些会员名和密码登陆。
为方便测试，WEB端可以登陆N个会员或者客服
```
