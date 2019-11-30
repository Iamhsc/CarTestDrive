#试驾试乘管理系统

基于ThinkPHP5.1框架及Layui2.5.4前端框架实现的一套带有权限管理的试驾试乘管理系统。  

- 所有页面数据的显示都通过model（模型）在数据库中获取，再经过controller（控制器）处理数据，最后渲染到页面中；  
- 表单的提交通过AJAX以JSON的形式提交，经过控制器验证后再交由模型存到数据库

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

###数据字典

- 管理员表 
 
|字段|类型|允许空|默认|注释| 
 |:----    |:-------    |:--- |----|------      | 
 |admin_id |int(11) |NO | NULL | 管理员id  | 
 |admin_name |varchar(55) |NO | NULL | 管理员名字  | 
 |admin_password |varchar(32) |NO | NULL | 管理员密码  | 
 |role_id |int(11) |YES | NULL | 所属角色  | 
 |status |tinyint(1) |NO | 1 | 0 禁用 1 启用  | 
 |add_time |datetime |NO | NULL | 添加时间  | 
 |last_login_time |datetime |YES | NULL | 上次登录时间  | 
 |update_time |datetime |YES | NULL | 更新时间  | 
 
 - 操作日志表 
  
 |字段|类型|允许空|默认|注释| 
  |:----    |:-------    |:--- |----|------      | 
  |log_id |int(11) |NO | NULL | 操作日志id  | 
  |operator |varchar(55) |NO | NULL | 操作用户  | 
  |operator_ip |varchar(15) |NO | NULL | 操作者ip  | 
  |operate_method |varchar(100) |NO | NULL | 操作方法  | 
  |operate_desc |varchar(155) |NO | NULL | 操作简述  | 
  |operate_time |datetime |NO | NULL | 操作时间  | 
  
  - 菜单表（节点表） 
   
  |字段|类型|允许空|默认|注释| 
   |:----    |:-------    |:--- |----|------      | 
   |node_id |int(11) |NO | NULL | 角色id  | 
   |node_name |varchar(55) |NO | NULL | 节点名称  | 
   |node_path |varchar(55) |NO | NULL | 节点路径  | 
   |node_pid |int(11) |NO | NULL | 所属节点  | 
   |node_icon |varchar(55) |YES | NULL | 节点图标  | 
   |is_menu |tinyint(1) |NO | 1 | 是否是菜单项 1 不是 2 是  | 
   |status |tinyint(1) |YES | 1 | 状态  | 
   |add_time |datetime |YES | NULL | 添加时间  | 
   
   - 会员表 
    
   |字段|类型|允许空|默认|注释| 
    |:----    |:-------    |:--- |----|------      | 
    |member_id |int(11) |NO | NULL | id  | 
    |username |varchar(50) |NO |  | 用户名  | 
    |password |varchar(50) |NO |  | 用户密码  | 
    |real_name |varchar(25) |NO |  | 真实姓名  | 
    |sex |tinyint(3) |NO | 1 | 性别 1男，2女  | 
    |member_mobile |varchar(14) |NO |  | 手机号  | 
    |member_email |varchar(50) |YES | NULL | 邮箱  | 
    |member_address |varchar(60) |YES | NULL | 地址  | 
    |member_id_number |varchar(20) |NO |  | 身份证号  | 
    |sign |text |YES | NULL | 签名  | 
    |avatar |varchar(255) |YES |  | 头像  | 
    |create_time |int(11) |NO | 0 | 创建时间  | 
    |update_time |int(11) |YES | NULL | 更新时间  | 
    |last_login_time |int(11) |NO | 0 | 上次登录时间  | 
    |last_login_ip |varchar(50) |NO |  | 上次登录ip  | 
    |status |tinyint(1) |NO | 1 | 是否启用  | 
    |is_del |tinyint(3) |NO | 0 | 是否删除  | 
    
- 登录日志 
 
|字段|类型|允许空|默认|注释| 
 |:----    |:-------    |:--- |----|------      | 
 |log_id |int(11) |NO | NULL | 日志id  | 
 |login_user |varchar(55) |NO | NULL | 登录用户  | 
 |login_ip |varchar(15) |NO | NULL | 登录ip  | 
 |login_area |varchar(55) |YES | NULL | 登录地区  | 
 |login_user_agent |varchar(155) |YES | NULL | 登录设备头  | 
 |login_time |datetime |YES | NULL | 登录时间  | 
 |login_status |tinyint(1) |YES | 1 | 登录状态 1 成功 2 失败  | 


- 驾驶证 
 
|字段|类型|允许空|默认|注释| 
 |:----    |:-------    |:--- |----|------      | 
 |driver_id |int(11) |NO | NULL | id  | 
 |member_id |int(11) |NO | 0 | 会员id（关联会员表）  | 
 |driver_number |varchar(255) |NO |  | 编号  | 
 |apply_place |varchar(55) |NO |  | 申请地点  | 
 |apply_date |date |YES | 0000-00-00 | 申请日期  | 
 |expiry_date |date |NO | 0000-00-00 | 到期日期  | 
 |driver_type |varchar(10) |NO | C1 | 准驾车型  | 
 |photo |varchar(255) |YES | NULL | 驾驶证照片  | 
 
- 试驾试乘表 
 
|字段|类型|允许空|默认|注释| 
 |:----    |:-------    |:--- |----|------      | 
 |drive_id |int(11) |NO | NULL | Id  | 
 |order_number |varchar(50) |NO |  | 订单号  | 
 |member_id |int(11) |NO | 0 | 会员id（关联会员表）  | 
 |car_id |int(11) |NO | 0 | 汽车id（关联汽车表）  | 
 |use_type |tinyint(3) |NO | 2 | 使用类型：1为试驾，2为试乘  | 
 |driver_license |varchar(255) |YES | NULL | 驾驶证  | 
 |begin_time |int(11) |NO | 0 | 开始使用时间  | 
 |end_time |int(11) |NO | 0 | 使用结束时间  | 
 |status |tinyint(3) |NO | 1 | 使用状态：1使用中，2已结束  | 
 |is_del |tinyint(3) |NO | 0 | 删除标记  | 
 |create_time |int(11) |NO | 0 | 创建时间  | 
 |update_time |int(11) |NO | 0 | 更新时间  | 
 
 
- 汽车型号表 
 
|字段|类型|允许空|默认|注释| 
 |:----    |:-------    |:--- |----|------      | 
 |car_model_id |int(11) |NO | NULL | 车辆id  | 
 |car_model_name |varchar(60) |NO |  | 车辆型号  | 
 |car_brand_id |int(11) |NO | 0 | 车辆品牌id  | 
 |car_number |varchar(15) |NO |  | 车牌号  | 
 |car_age |varchar(20) |NO |  | 汽车使用时长  | 
 |status |tinyint(3) |NO | 0 | 汽车是否在使用  | 
 |create_time |int(11) |NO | 0 | 创建时间  | 
 |update_time |int(11) |NO | 0 | 更新时间  | 
 |is_del |tinyint(3) |NO | 0 | 是否删除  | 
 
 
- 车辆品牌表 
 
|字段|类型|允许空|默认|注释| 
 |:----    |:-------    |:--- |----|------      | 
 |brand_id |int(11) |NO | NULL | 品牌id  | 
 |brand_name |varchar(50) |NO |  | 类型名称  | 
 |create_time |int(11) |NO | 0 | 创建时间  | 
 |update_time |int(11) |NO | 0 | 更新时间  | 
 |is_del |tinyint(3) |NO | 0 | 是否删除  | 


- 角色表 
 
|字段|类型|允许空|默认|注释| 
 |:----    |:-------    |:--- |----|------      | 
 |role_id |int(11) |NO | NULL | 角色id  | 
 |role_name |varchar(55) |NO | NULL | 角色名称  | 
 |role_node |varchar(255) |NO | NULL | 角色拥有的权限节点  | 
 |role_status |tinyint(1) |NO | 1 | 角色状态 1 启用 2 禁用  | 
 

###配置访问 
######1.把项目放到www目录
######2.修改配置文件vhosts.conf为
```xml
<VirtualHost _default_:8088>
DocumentRoot "你的项目位置\CarTestDrive\public"
  <Directory "你的项目位置\CarTestDrive\public">
    Options -Indexes +FollowSymLinks +ExecCGI
    AllowOverride All
    Order allow,deny
    Allow from all
    Require all granted
  </Directory>
</VirtualHost>
```
######3.浏览器输入你配置的域名进入首页；域名后面加/admin 即可进入后台    

默认用户名 密码  admin admin  
用户注册
