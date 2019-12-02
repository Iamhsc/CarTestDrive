# Host: 47.112.31.40  (Version 5.5.60-MariaDB)
# Date: 2019-12-02 13:20:40
# Generator: MySQL-Front 6.1  (Build 1.26)


#
# Structure for table "ctd_admin"
#

CREATE TABLE `ctd_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理员id',
  `admin_name` varchar(55) NOT NULL COMMENT '管理员名字',
  `admin_password` varchar(32) NOT NULL COMMENT '管理员密码',
  `role_id` int(11) DEFAULT NULL COMMENT '所属角色',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 禁用 1 启用',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  `last_login_time` datetime DEFAULT NULL COMMENT '上次登录时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`admin_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='管理员表';

#
# Data for table "ctd_admin"
#

INSERT INTO `ctd_admin` VALUES (1,'admin','21232f297a57a5a743894a0e4a801fc3',1,1,'2019-09-03 13:31:20','2019-12-02 12:50:36',NULL);

#
# Structure for table "ctd_car_brand"
#

CREATE TABLE `ctd_car_brand` (
  `brand_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '品牌id',
  `brand_name` varchar(50) NOT NULL DEFAULT '' COMMENT '类型名称',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_del` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='车辆品牌表';

#
# Data for table "ctd_car_brand"
#

#
# Structure for table "ctd_car_model"
#

CREATE TABLE `ctd_car_model` (
  `car_model_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '车辆id',
  `car_model_name` varchar(60) NOT NULL DEFAULT '' COMMENT '车辆型号',
  `car_brand_id` int(11) NOT NULL DEFAULT '0' COMMENT '车辆品牌id',
  `car_number` varchar(15) NOT NULL DEFAULT '' COMMENT '车牌号',
  `car_age` varchar(20) NOT NULL DEFAULT '' COMMENT '汽车使用时长',
  `image` varchar(255) DEFAULT NULL COMMENT '图',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '汽车是否在使用',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_del` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`car_model_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='汽车型号表';

#
# Data for table "ctd_car_model"
#

#
# Structure for table "ctd_drive"
#

CREATE TABLE `ctd_drive` (
  `drive_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `order_number` varchar(50) NOT NULL DEFAULT '' COMMENT '订单号',
  `member_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员id（关联会员表）',
  `car_id` int(11) NOT NULL DEFAULT '0' COMMENT '汽车id（关联汽车表）',
  `use_type` tinyint(3) NOT NULL DEFAULT '2' COMMENT '使用类型：1为试驾，2为试乘',
  `driver_license` varchar(255) DEFAULT NULL COMMENT '驾驶证',
  `begin_time` int(11) NOT NULL DEFAULT '0' COMMENT '开始使用时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '使用结束时间',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '使用状态：1使用中，2已结束',
  `is_del` tinyint(3) NOT NULL DEFAULT '0' COMMENT '删除标记',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`drive_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='试驾试乘表';

#
# Data for table "ctd_drive"
#


#
# Structure for table "ctd_driver_license"
#

CREATE TABLE `ctd_driver_license` (
  `driver_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `member_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员id（关联会员表）',
  `driver_number` varchar(255) NOT NULL DEFAULT '' COMMENT '编号',
  `apply_place` varchar(55) NOT NULL DEFAULT '' COMMENT '申请地点',
  `apply_date` date DEFAULT '0000-00-00' COMMENT '申请日期',
  `expiry_date` date NOT NULL DEFAULT '0000-00-00' COMMENT '到期日期',
  `driver_type` varchar(10) NOT NULL DEFAULT 'C1' COMMENT '准驾车型',
  `photo` varchar(255) DEFAULT NULL COMMENT '驾驶证照片',
  PRIMARY KEY (`driver_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='驾驶证';

#
# Data for table "ctd_driver_license"
#

#
# Structure for table "ctd_login_log"
#

CREATE TABLE `ctd_login_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志id',
  `login_user` varchar(55) NOT NULL COMMENT '登录用户',
  `login_ip` varchar(15) NOT NULL COMMENT '登录ip',
  `login_area` varchar(55) DEFAULT NULL COMMENT '登录地区',
  `login_user_agent` varchar(155) DEFAULT NULL COMMENT '登录设备头',
  `login_time` datetime DEFAULT NULL COMMENT '登录时间',
  `login_status` tinyint(1) DEFAULT '1' COMMENT '登录状态 1 成功 2 失败',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='登录日志';

#
# Data for table "ctd_login_log"
#

#
# Structure for table "ctd_member"
#

CREATE TABLE `ctd_member` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(50) NOT NULL DEFAULT '' COMMENT '用户密码',
  `real_name` varchar(25) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `sex` tinyint(3) NOT NULL DEFAULT '1' COMMENT '性别 1男，2女',
  `member_mobile` varchar(14) NOT NULL DEFAULT '' COMMENT '手机号',
  `member_email` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `member_address` varchar(60) DEFAULT NULL COMMENT '地址',
  `member_id_number` varchar(20) NOT NULL DEFAULT '' COMMENT '身份证号',
  `sign` text COMMENT '签名',
  `avatar` varchar(255) DEFAULT '' COMMENT '头像',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `last_login_ip` varchar(50) NOT NULL DEFAULT '' COMMENT '上次登录ip',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用',
  `is_del` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='会员表';

#
# Data for table "ctd_member"
#

#
# Structure for table "ctd_node"
#

CREATE TABLE `ctd_node` (
  `node_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `node_name` varchar(55) NOT NULL COMMENT '节点名称',
  `node_path` varchar(55) NOT NULL COMMENT '节点路径',
  `node_pid` int(11) NOT NULL COMMENT '所属节点',
  `node_icon` varchar(55) DEFAULT NULL COMMENT '节点图标',
  `is_menu` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否是菜单项 1 不是 2 是',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态',
  `add_time` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`node_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='菜单表（节点表）';

#
# Data for table "ctd_node"
#

INSERT INTO `ctd_node` VALUES (1,'主页','#',0,'layui-icon layui-icon-home',2,1,'2019-09-03 14:17:38'),(2,'后台首页','index/index',1,'',1,1,'2019-09-03 14:18:24'),(3,'修改密码','index/editpwd',1,'',1,1,'2019-09-03 14:19:03'),(4,'系统管理','#',0,'layui-icon layui-icon-template',2,1,'2019-09-03 14:19:34'),(5,'节点管理','node/index',4,'',2,1,'2019-10-09 21:42:06'),(6,'添加节点','node/add',5,'',1,1,'2019-10-09 21:42:51'),(7,'编辑节点','node/edit',5,'',1,1,'2019-10-09 21:43:29'),(8,'删除节点','node/delete',5,'',1,1,'2019-10-09 21:43:44'),(9,'日志管理','#',0,'layui-icon layui-icon-template-1',2,0,'2019-10-08 16:07:36'),(10,'系统日志','log/system',9,'',2,0,'2019-10-08 16:24:55'),(11,'登录日志','log/login',9,'',2,0,'2019-10-08 16:26:27'),(12,'操作日志','log/operate',9,'',2,0,'2019-10-08 17:02:10'),(13,'用户管理','#',0,'layui-icon layui-icon-user',2,1,'2019-11-14 17:22:30'),(14,'角色管理','role/index',13,'',2,1,'2019-10-09 21:35:54'),(15,'添加角色','role/add',14,'',1,1,'2019-10-09 21:40:06'),(16,'编辑角色','role/edit',14,'',1,1,'2019-10-09 21:40:53'),(17,'删除角色','role/delete',14,'',1,1,'2019-10-09 21:41:07'),(18,'权限分配','role/assignauthority',14,'',1,1,'2019-10-09 21:41:38'),(19,'管理员管理','manager/index',13,'',2,1,'2019-11-14 14:27:42'),(20,'添加管理员','manager/addadmin',19,'',1,1,'2019-11-14 14:28:26'),(21,'编辑管理员','manager/editadmin',19,'',1,1,'2019-11-14 14:28:43'),(22,'删除管理员','manager/deladmin',19,'',1,1,'2019-11-14 14:29:14'),(23,'会员管理','member/index',13,'',2,1,'2019-11-14 17:24:31'),(24,'会员编辑','member/edit',23,'',1,1,'2019-11-14 17:25:21'),(25,'会员删除','member/del',23,'',1,1,'2019-11-14 17:26:54'),(26,'汽车管理','#',0,'layui-icon layui-icon-component',2,1,'2019-11-15 11:19:29'),(27,'车辆管理','car/index',26,'',2,1,'2019-11-15 11:20:25'),(28,'车辆编辑','car/edit',27,'',1,1,'2019-11-15 11:21:55'),(29,'车辆删除','car/del',27,'',1,1,'2019-11-15 11:22:29'),(30,'车辆添加','car/add',27,'',1,1,'2019-11-15 11:23:17'),(31,'试驾管理','#',0,'layui-icon layui-icon-console',2,1,'2019-11-15 11:27:52'),(32,'管理试驾','drive/index',31,'',2,1,'2019-11-15 11:31:06'),(33,'删除试驾','drive/del',32,'',1,1,'2019-11-15 11:32:32'),(34,'品牌管理','car_brand/index',26,'',2,1,'2019-11-16 20:29:24'),(35,'品牌编辑','car_brand/edit',34,'',1,1,'2019-11-16 20:30:09'),(36,'品牌删除','car_brand/del',34,'',1,1,'2019-11-16 20:30:44'),(37,'品牌添加','car_brand/add',34,'',1,1,'2019-11-16 20:31:48');

#
# Structure for table "ctd_operate_log"
#

CREATE TABLE `ctd_operate_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '操作日志id',
  `operator` varchar(55) NOT NULL COMMENT '操作用户',
  `operator_ip` varchar(15) NOT NULL COMMENT '操作者ip',
  `operate_method` varchar(100) NOT NULL COMMENT '操作方法',
  `operate_desc` varchar(155) NOT NULL COMMENT '操作简述',
  `operate_time` datetime NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='操作日志表';

#
# Data for table "ctd_operate_log"
#


#
# Structure for table "ctd_role"
#

CREATE TABLE `ctd_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `role_name` varchar(55) NOT NULL COMMENT '角色名称',
  `role_node` varchar(255) NOT NULL COMMENT '角色拥有的权限节点',
  `role_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '角色状态 1 启用 2 禁用',
  PRIMARY KEY (`role_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='角色表';

#
# Data for table "ctd_role"
#

INSERT INTO `ctd_role` VALUES (1,'超级管理员','#',1);
