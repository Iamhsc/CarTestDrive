#试驾试乘管理系统

- 基于[snake](https://github.com/nick-bai/snake "snake")实现的试驾试乘管理系统。  

- [snake](https://github.com/nick-bai/snake "snake")是thinkphp5.1 + layui 实现的带rbac的基础管理后台

- 目录结构
````

├─application                  应用主目录
│  ├─admin                     admin模块   （后台，管理员使用）
│  │  ├─controller             后台控制器目录
│  │  ├─model                  后台模型目录
│  │  ├─validate               后台验证器目录
│  │  └─view                   后台视图目录
│  │      ├─car                汽车管理目录 （汽车列表、添加、修改三个页面）
│  │      ├─car_brand          汽车品牌管理 （列表、添加、编辑）
│  │      ├─drive              试驾试乘管理 
│  │      ├─index              后台首页     （首页、导航、密码修改三个页面）
│  │      ├─log                日志管理     （查看或操作系统日志）
│  │      ├─login              后台登录
│  │      ├─manager            管理员管理   （列表、添加、编辑）
│  │      ├─member             会员管理     （会员列表、添加、编辑）
│  │      ├─node               节点管理     （后台的所有操作菜单）
│  │      ├─role               角色管理     （列表、添加、编辑）
│  │      └─tpl                错误页面
│  └─home                      home模块     （前台，用户使用）
│      ├─controller            前台控制器目录
│      ├─model                 前台模型目录
│      └─view                  前台视图目录
│          ├─common            公共视图      （包含头部header.html和底部footer.html）
│          ├─index             首页         （包含首页、登录、注册等页面）
│          ├─member            用户         （个人中心、修改资料）
│          └─service           服务         （添加驾驶证、试驾试乘）
├─public                       
│  ├─static                    静态资源目录  （存放css js img)
│  └─uploads                   上传目录   
├─runtime                      运行缓存、日志、
├─thinkphp                     tp核心目录
````

###配置访问 
######1.把项目放到www目录
######2.修改配置文件vhosts.conf为

```xml
<VirtualHost *:876>
    DocumentRoot "E:\0000\XXX"
    ServerName XXX.XXX.com   
    ServerAlias 
  <Directory "E:\0000\XXX">
      Options FollowSymLinks ExecCGI
      AllowOverride All
      Order allow,deny
      Allow from all
     Require all granted
  </Directory>
</VirtualHost>
```
######3. 如果是本地，在C:\Windows\System32\drivers\etc\hosts 最后一行添加127.0.0.1       XXX.XXX.com
######4.浏览器输入你配置的域名进入首页，如：http://local.web.com；域名后面加/admin 即可进入后台    

默认用户名 密码  admin admin  
用户注册
