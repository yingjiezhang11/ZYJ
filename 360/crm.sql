# Host: localhost  (Version: 5.5.53)
# Date: 2017-09-14 14:00:24
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "article"
#

DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(10) unsigned NOT NULL COMMENT '栏目ID',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `image` varchar(200) DEFAULT NULL COMMENT '缩率图',
  `keyword` varchar(255) DEFAULT NULL COMMENT '关键字',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `templates` varchar(30) NOT NULL COMMENT '模板',
  `content` text COMMENT '内容',
  `status` int(5) unsigned NOT NULL COMMENT '文章状态',
  `listorder` smallint(10) unsigned NOT NULL COMMENT '排序',
  `addtime` int(11) unsigned NOT NULL COMMENT '添加时间',
  `updatetime` int(11) unsigned NOT NULL COMMENT '更新时间',
  `userid` int(11) unsigned NOT NULL COMMENT '发布用户',
  `type` int(5) unsigned NOT NULL COMMENT '类型',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章';

#
# Data for table "article"
#


#
# Structure for table "column"
#

DROP TABLE IF EXISTS `column`;
CREATE TABLE `column` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned DEFAULT NULL COMMENT '上级栏目',
  `cname` varchar(50) DEFAULT NULL COMMENT '栏目名称',
  `image` varchar(200) DEFAULT NULL COMMENT '栏目缩略图',
  `keyword` varchar(200) NOT NULL COMMENT '栏目关键字',
  `description` varchar(255) NOT NULL COMMENT '栏目描述',
  `type` int(5) unsigned NOT NULL COMMENT '栏目类型',
  `module` varchar(50) NOT NULL COMMENT '模型名称',
  `addtime` int(11) unsigned NOT NULL COMMENT '添加时间',
  `userid` int(10) unsigned NOT NULL COMMENT '添加用户',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='栏目表';

#
# Data for table "column"
#


#
# Structure for table "customer"
#

DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `share` int(2) unsigned NOT NULL COMMENT '是否共享',
  `shop_id` int(5) unsigned NOT NULL COMMENT '门店ID',
  `type` int(5) NOT NULL COMMENT '客户类型',
  `department` int(5) unsigned NOT NULL COMMENT '所属部门',
  `company` varchar(200) NOT NULL COMMENT '客户名称',
  `mobile` varchar(30) NOT NULL COMMENT '客户电话',
  `mobile2` varchar(30) NOT NULL COMMENT '电话2号',
  `weixin` varchar(50) NOT NULL COMMENT '微信',
  `status` int(5) unsigned NOT NULL COMMENT '客户状态',
  `province` varchar(50) NOT NULL COMMENT '省',
  `city` varchar(50) NOT NULL COMMENT '市',
  `address` varchar(200) NOT NULL COMMENT '地址',
  `photo` varchar(200) NOT NULL COMMENT '店铺门头',
  `map_lat` varchar(30) NOT NULL COMMENT '坐标lat',
  `map_lng` varchar(30) NOT NULL COMMENT '坐标lng',
  `addtime` int(11) unsigned NOT NULL COMMENT '添加时间',
  `updatetime` int(11) unsigned NOT NULL COMMENT '更新时间',
  `remark` text NOT NULL COMMENT '备注信息',
  `userid` int(5) unsigned NOT NULL COMMENT '添加用户',
  `sales` int(5) unsigned NOT NULL COMMENT '业务员',
  `service` int(5) unsigned NOT NULL COMMENT '客服人员',
  `comefrom` int(5) unsigned NOT NULL COMMENT '客户来源',
  `retime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "customer"
#

INSERT INTO `customer` VALUES (1,0,1,3,0,'杭州四季润加湿设备有限公司','13989888076','0571-63666666','13989888076',1,'浙江省','杭州市','板桥','','','',1505299712,0,'',1,3,3,2,1505731712),(2,0,1,1,0,'个人','13956852565','','13956852565',2,'福建省','厦门市','xxx','','','',1505299778,0,'',1,7,8,3,1505731778);

#
# Structure for table "customer_track"
#

DROP TABLE IF EXISTS `customer_track`;
CREATE TABLE `customer_track` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(10) unsigned NOT NULL COMMENT '客户ID',
  `shop_id` int(10) unsigned NOT NULL COMMENT '门店ID',
  `userid` int(10) unsigned NOT NULL COMMENT '跟踪人员',
  `addtime` int(11) unsigned NOT NULL COMMENT '跟踪时间',
  `linkman` varchar(50) NOT NULL COMMENT '对接人员',
  `type` int(5) unsigned NOT NULL COMMENT '对接方式',
  `remark` text NOT NULL COMMENT '对接记录',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "customer_track"
#


#
# Structure for table "log"
#

DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) unsigned NOT NULL,
  `app` char(20) NOT NULL,
  `controller` char(20) NOT NULL,
  `action` char(20) NOT NULL,
  `addtime` int(11) unsigned NOT NULL COMMENT '操作时间',
  `data` varchar(200) NOT NULL COMMENT '参数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "log"
#


#
# Structure for table "member"
#

DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) unsigned NOT NULL COMMENT '门店编号',
  `pid` int(5) unsigned NOT NULL DEFAULT '0',
  `realname` varchar(50) NOT NULL COMMENT '姓名',
  `username` varchar(100) NOT NULL COMMENT '用户名',
  `mobile` varchar(30) NOT NULL COMMENT '手机号码',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `gender` int(3) unsigned NOT NULL COMMENT '性别',
  `birthday` int(11) unsigned NOT NULL COMMENT '出生年月',
  `photo` varchar(200) NOT NULL COMMENT '头像',
  `addtime` int(11) unsigned NOT NULL COMMENT '注册时间',
  `lasttime` int(11) unsigned NOT NULL COMMENT '上次登录时间',
  `ip` varchar(30) NOT NULL COMMENT '登录IP',
  `remark` text NOT NULL COMMENT '用户备注',
  `status` int(5) NOT NULL COMMENT '用户状态',
  `is_admin` int(5) NOT NULL COMMENT '是否超管',
  `openid` varchar(200) NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `type` int(5) unsigned NOT NULL COMMENT '人员类型',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='用户表';

#
# Data for table "member"
#

INSERT INTO `member` VALUES (1,1,0,'','admin','','11629b1be5b6d07a80c52fe8e983d994',0,0,'',0,1505363368,'','',0,0,'',4,3),(2,1,0,'高江峰','13868050566','','03ea11be6a3c94ee40653bc2a896a424',1,2017,'',0,0,'','<p>系统管理员<br></p>',0,0,'',11,0),(3,1,0,'鲍莉菁','13396512674','','03ea11be6a3c94ee40653bc2a896a424',2,2017,'',0,0,'','<p>电子商务操盘手<br></p>',0,0,'',15,0),(4,1,0,'孙俪','13486189761','','03ea11be6a3c94ee40653bc2a896a424',2,2017,'',0,0,'','<p>财务部<br></p>',0,0,'',12,0),(5,1,0,'韦周幕','15057105370','','03ea11be6a3c94ee40653bc2a896a424',2,2017,'',0,0,'','<p>采购<br></p>',0,0,'',13,0),(6,1,0,'毛庆丰','18072872884','','03ea11be6a3c94ee40653bc2a896a424',1,2017,'',0,0,'','<p>仓管<br></p>',0,0,'',14,0),(7,1,0,'周勇','13386504241','','03ea11be6a3c94ee40653bc2a896a424',1,2017,'',0,0,'','<p>业务员<br></p>',0,0,'',15,0),(8,1,0,'李水芬','13376838814','','03ea11be6a3c94ee40653bc2a896a424',2,2017,'',0,0,'','<p>商务做单助理<br></p>',0,0,'',15,0);

#
# Structure for table "orders"
#

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '订单ID',
  `shop_id` int(5) unsigned NOT NULL COMMENT '门店编号',
  `userid` int(10) unsigned NOT NULL COMMENT '开单用户',
  `sales` int(10) NOT NULL COMMENT '业务员',
  `addtime` int(11) unsigned NOT NULL COMMENT '添加时间',
  `billtime` int(11) unsigned NOT NULL COMMENT '开单时间',
  `cid` int(10) unsigned NOT NULL COMMENT '客户编号',
  `order_sn` varchar(30) NOT NULL COMMENT '订单编号',
  `total_quantity` decimal(10,2) NOT NULL COMMENT '总数量',
  `total_discount` decimal(10,2) NOT NULL COMMENT '总折扣金额',
  `total_money` decimal(10,2) NOT NULL COMMENT '总金额',
  `remark` text NOT NULL COMMENT '订单备注',
  `payment` int(5) NOT NULL COMMENT '付款方式',
  `received` decimal(8,2) NOT NULL COMMENT '已收款金额',
  `unpaid` decimal(8,2) NOT NULL COMMENT '未收款金额',
  `status` int(5) NOT NULL COMMENT '订单状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "orders"
#

INSERT INTO `orders` VALUES (1,1,1,3,1505304569,1505232000,1,'dd00001',1.00,0.00,1940.00,'',1,0.00,1940.00,1);

#
# Structure for table "orders_back"
#

DROP TABLE IF EXISTS `orders_back`;
CREATE TABLE `orders_back` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `shop_id` int(5) NOT NULL COMMENT '门店编号',
  `orderid` int(10) unsigned NOT NULL COMMENT '订单编号',
  `userid` int(5) unsigned NOT NULL COMMENT '操作用户',
  `datetime` int(11) unsigned NOT NULL COMMENT '操作时间',
  `remark` text NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "orders_back"
#

INSERT INTO `orders_back` VALUES (1,1,1024,1,1499914874,'深度发杀到发多少发到付');

#
# Structure for table "orders_data"
#

DROP TABLE IF EXISTS `orders_data`;
CREATE TABLE `orders_data` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `shop_id` int(5) NOT NULL COMMENT '门店编号',
  `orderid` int(8) NOT NULL COMMENT '订单ID',
  `pid` int(8) NOT NULL COMMENT '产品编号',
  `quantity` decimal(8,2) NOT NULL COMMENT '产品数量',
  `price` decimal(8,2) NOT NULL COMMENT '产品单价',
  `discount_rate` decimal(8,2) NOT NULL COMMENT '折扣率',
  `discount_money` decimal(8,2) NOT NULL COMMENT '折扣金额',
  `money` decimal(8,2) NOT NULL COMMENT '总价',
  `remark` text NOT NULL COMMENT '备注',
  `status` int(4) NOT NULL COMMENT '订单情况',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='订单数据';

#
# Data for table "orders_data"
#

INSERT INTO `orders_data` VALUES (1,1,1,9,1.00,1940.00,0.00,0.00,1940.00,'',1);

#
# Structure for table "role"
#

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(5) unsigned NOT NULL COMMENT '门店',
  `name` varchar(20) NOT NULL,
  `remark` varchar(20) NOT NULL,
  `auth` text NOT NULL,
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `delete_time` int(10) unsigned DEFAULT NULL,
  `type` int(5) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

#
# Data for table "role"
#

INSERT INTO `role` VALUES (1,0,'超级管理员','','[\"system\",\"system-list\",\"system-log\",\"system-attachment\",\"system-attachment-auth-delete\",\"user\",\"user-list\",\"user-list-auth-edit\",\"user-list-auth-delete\",\"user-role\",\"content\",\"content-list\",\"content-list-auth-add\",\"content-list-auth-edit\",\"content-list-auth-delete\",\"content-article\",\"content-article-auth-add\",\"content-article-auth-edit\",\"content-article-auth-delete\",\"content-page\",\"weixin\",\"weixin-list\",\"weixin-list-auth-edit\",\"weixin-list-auth-delete\"]',0,1496804891,1497590177,NULL,0),(2,0,'普通用户','','[\"system\",\"system-list\",\"system-log\",\"system-attachment\",\"system-attachment-auth-delete\",\"user\",\"user-list\",\"user-list-auth-edit\",\"user-list-auth-delete\",\"user-role\",\"content\",\"content-list\",\"content-list-auth-add\",\"content-list-auth-edit\",\"content-list-auth-delete\",\"content-article\",\"content-article-auth-add\",\"content-article-auth-edit\",\"content-article-auth-delete\",\"content-page\",\"weixin\",\"weixin-list\",\"weixin-list-auth-edit\",\"weixin-list-auth-delete\"]',0,1496806722,1497590185,NULL,0),(3,1,'普通用户','','[\"index\",\"customer\",\"customer-list\",\"customer-list-auth-add\",\"customer-list-auth-edit\",\"customer-track\",\"customer-track-auth-add\",\"customer-track-auth-edit\",\"customer-visit\",\"customer-visit-auth-add\",\"customer-visit-auth-edit\",\"customer-search\"]',0,1497590564,1499225026,NULL,1),(4,1,'管理员用户','','[\"index\",\"sales\",\"sales-add\",\"sales-list\",\"sales-list-auth-add\",\"sales-list-auth-edit\",\"sales-list-auth-delete\",\"sales-returnorder\",\"sales-unsubscribe\",\"customer\",\"customer-list\",\"customer-list-auth-all\",\"customer-list-auth-add\",\"customer-list-auth-edit\",\"customer-list-auth-delete\",\"customer-track\",\"customer-track-auth-add\",\"customer-track-auth-edit\",\"customer-track-auth-delete\",\"customer-visit\",\"customer-visit-auth-add\",\"customer-visit-auth-edit\",\"customer-visit-auth-delete\",\"customer-search\",\"stock\",\"stock-orders\",\"stock-storage\",\"stock-storage-auth-add\",\"stock-inventory\",\"stock-product\",\"stock-setting\",\"finance\",\"finance-audit\",\"finance-auditok\",\"finance-report\",\"user\",\"user-list\",\"user-list-auth-add\",\"user-list-auth-edit\",\"user-list-auth-delete\",\"user-role\",\"user-role-auth-add\",\"user-role-auth-edit\",\"user-role-auth-delete\",\"shop\",\"shop-list\"]',0,1497946934,1499997593,NULL,1),(7,0,'默认用户组别','','[\"index\",\"user\",\"user-list\",\"user-list-auth-add\",\"user-list-auth-edit\",\"user-list-auth-delete\",\"user-role\",\"user-role-auth-add\",\"user-role-auth-edit\",\"user-role-auth-delete\",\"systems\",\"systems-list\"]',0,1498110242,1498110254,NULL,1),(8,2,'管理','','[\"index\",\"sales\",\"sales-add\",\"sales-list\",\"sales-list-auth-add\",\"sales-list-auth-edit\",\"sales-list-auth-delete\",\"sales-returnorder\",\"customer\",\"customer-list\",\"customer-list-auth-all\",\"customer-list-auth-add\",\"customer-list-auth-edit\",\"customer-list-auth-delete\",\"customer-track\",\"customer-track-auth-add\",\"customer-track-auth-edit\",\"customer-track-auth-delete\",\"customer-visit\",\"customer-visit-auth-add\",\"customer-visit-auth-edit\",\"customer-visit-auth-delete\",\"customer-search\",\"stock\",\"stock-orders\",\"stock-storage\",\"stock-storage-auth-add\",\"stock-inventory\",\"stock-product\",\"stock-setting\",\"finance\",\"finance-audit\",\"user\",\"user-list\",\"user-list-auth-add\",\"user-list-auth-edit\",\"user-list-auth-delete\",\"user-role\",\"user-role-auth-add\",\"user-role-auth-edit\",\"user-role-auth-delete\",\"shop\",\"shop-list\"]',0,1498274307,1501642020,NULL,1),(9,2,'普通员工','','[\"index\",\"customer\",\"customer-list\",\"customer-list-auth-add\",\"customer-list-auth-edit\",\"customer-track\",\"customer-track-auth-add\",\"customer-track-auth-edit\",\"customer-search\"]',0,1498274612,1498274612,NULL,1),(10,3,'管理','','[\"index\",\"customer\",\"customer-list\",\"customer-list-auth-add\",\"customer-list-auth-edit\",\"customer-list-auth-delete\",\"customer-track\",\"customer-track-auth-add\",\"customer-track-auth-edit\",\"customer-track-auth-delete\",\"customer-search\",\"user\",\"user-list\",\"user-list-auth-add\",\"user-list-auth-edit\",\"user-list-auth-delete\",\"user-role\",\"user-role-auth-add\",\"user-role-auth-edit\",\"user-role-auth-delete\",\"shop\",\"shop-list\"]',0,1498274307,1498282581,NULL,1),(11,1,'总经理','总经理','[\"index\",\"sales\",\"sales-add\",\"sales-list\",\"sales-list-auth-add\",\"sales-list-auth-edit\",\"sales-list-auth-delete\",\"sales-returnorder\",\"sales-unsubscribe\",\"customer\",\"customer-list\",\"customer-list-auth-all\",\"customer-list-auth-add\",\"customer-list-auth-edit\",\"customer-track\",\"customer-track-auth-add\",\"customer-track-auth-edit\",\"customer-visit\",\"customer-visit-auth-add\",\"customer-visit-auth-edit\",\"customer-search\",\"stock\",\"stock-orders\",\"stock-storage\",\"stock-storage-auth-add\",\"stock-inventory\",\"stock-product\",\"stock-setting\",\"finance\",\"finance-audit\",\"finance-auditok\",\"finance-report\",\"user\",\"user-list\",\"user-list-auth-add\",\"user-list-auth-edit\",\"user-list-auth-delete\",\"user-role\",\"user-role-auth-add\",\"user-role-auth-edit\",\"user-role-auth-delete\",\"shop\",\"shop-list\"]',0,1499225826,1505295852,NULL,1),(12,1,'财务部','财务部','[\"sales\",\"sales-add\",\"sales-list\",\"sales-list-auth-add\",\"sales-list-auth-edit\",\"sales-list-auth-delete\",\"sales-returnorder\",\"sales-unsubscribe\",\"customer\",\"customer-list\",\"customer-list-auth-all\",\"customer-list-auth-add\",\"customer-list-auth-edit\",\"customer-list-auth-delete\",\"customer-track\",\"customer-track-auth-add\",\"customer-track-auth-edit\",\"customer-track-auth-delete\",\"customer-visit\",\"customer-visit-auth-add\",\"customer-visit-auth-edit\",\"customer-visit-auth-delete\",\"customer-search\",\"finance\",\"finance-audit\",\"finance-auditok\",\"finance-report\",\"user\",\"user-list\",\"user-list-auth-add\",\"user-list-auth-edit\",\"user-list-auth-delete\",\"user-role\",\"user-role-auth-add\",\"user-role-auth-edit\",\"user-role-auth-delete\"]',2,1505295649,1505295649,NULL,1),(13,1,'采购部','采购部','[\"stock\",\"stock-orders\",\"stock-storage\",\"stock-storage-auth-add\",\"stock-inventory\",\"stock-product\",\"stock-setting\",\"finance\",\"finance-audit\",\"finance-auditok\",\"finance-report\"]',2,1505295692,1505295692,NULL,1),(14,1,'仓库部','仓库部','[\"sales\",\"sales-add\",\"sales-list\",\"sales-list-auth-add\",\"sales-list-auth-edit\",\"sales-list-auth-delete\",\"sales-returnorder\",\"sales-unsubscribe\",\"customer\",\"customer-list\",\"customer-list-auth-all\",\"customer-list-auth-add\",\"customer-list-auth-edit\",\"customer-list-auth-delete\",\"customer-track\",\"customer-track-auth-add\",\"customer-track-auth-edit\",\"customer-track-auth-delete\",\"customer-visit\",\"customer-visit-auth-add\",\"customer-visit-auth-edit\",\"customer-visit-auth-delete\",\"customer-search\"]',3,1505295732,1505295732,NULL,1),(15,1,'销售部','销售部','[\"sales\",\"sales-add\",\"sales-list\",\"sales-list-auth-add\",\"sales-list-auth-edit\",\"sales-list-auth-delete\",\"sales-returnorder\",\"sales-unsubscribe\",\"customer\",\"customer-list\",\"customer-list-auth-all\",\"customer-list-auth-add\",\"customer-list-auth-edit\",\"customer-list-auth-delete\",\"customer-track\",\"customer-track-auth-add\",\"customer-track-auth-edit\",\"customer-track-auth-delete\",\"customer-visit\",\"customer-visit-auth-add\",\"customer-visit-auth-edit\",\"customer-visit-auth-delete\",\"customer-search\"]',4,1505295788,1505295788,NULL,1);

#
# Structure for table "shop"
#

DROP TABLE IF EXISTS `shop`;
CREATE TABLE `shop` (
  `shop_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL COMMENT '店铺名称',
  `mobile` varchar(30) NOT NULL COMMENT '店铺电话',
  `logo` varchar(200) NOT NULL,
  `map_lat` char(20) NOT NULL COMMENT '坐标',
  `map_lng` char(20) NOT NULL COMMENT '坐标',
  `province` char(30) NOT NULL,
  `city` char(30) NOT NULL,
  `area` char(30) NOT NULL,
  `address` varchar(250) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `addtime` int(11) unsigned NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`shop_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "shop"
#

INSERT INTO `shop` VALUES (1,'杭州临安瑞菱自动化设备有限公司','0571-56703218','','26.137283','119.313896','浙江省','杭州市','临安市','筑境商业街46-50号','&lt;p&gt;公司简介\r\n&lt;/p&gt;&lt;p&gt;杭州临安瑞菱自动化设备有限公司位于风景优美、交通便捷的杭州临安。瑞菱自动化是一家专业代理日本三菱电机(MITSUBISHI)、台湾威纶通、台达，易能电气，深圳显控等系列产品。产品包含:触摸屏、可编程控制器PLC，伺服系统、变频器、张力控制等工业自动化产品。\r\n&lt;/p&gt;&lt;p&gt;865409427044558294副本.jpg   公司长期致力于工业电气化自动控制化领域的产品推广和技术开发。产品广泛应用于冶金、石油工、纺',1505295290,1),(2,'宝仕尼南通','13773836017','','','','江苏省','南通市','','','',1501515126,16),(3,'上海宝仕尼','','','','','','','','','',111,18);

#
# Structure for table "slide"
#

DROP TABLE IF EXISTS `slide`;
CREATE TABLE `slide` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL COMMENT '幻灯标题',
  `image` varchar(255) NOT NULL COMMENT '幻灯图片',
  `url` varchar(255) NOT NULL COMMENT '链接',
  `type` varchar(20) NOT NULL COMMENT '分类',
  `extime` int(11) unsigned NOT NULL COMMENT '过期时间',
  `addtime` int(11) unsigned NOT NULL COMMENT '添加时间',
  `userid` int(11) unsigned NOT NULL COMMENT '添加用户',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "slide"
#


#
# Structure for table "stock_inventory"
#

DROP TABLE IF EXISTS `stock_inventory`;
CREATE TABLE `stock_inventory` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(5) unsigned NOT NULL COMMENT '门店编号',
  `userid` int(5) unsigned NOT NULL COMMENT '盘点人',
  `addtime` int(11) unsigned NOT NULL COMMENT '盘点日期',
  `remark` varchar(255) NOT NULL COMMENT '盘点备注',
  `jiandu` int(5) unsigned NOT NULL COMMENT '监督用户',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "stock_inventory"
#

INSERT INTO `stock_inventory` VALUES (1,1,1,1501689600,'',1);

#
# Structure for table "stock_inventory_data"
#

DROP TABLE IF EXISTS `stock_inventory_data`;
CREATE TABLE `stock_inventory_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(5) unsigned NOT NULL COMMENT '门店编号',
  `iid` int(5) unsigned NOT NULL COMMENT '盘点ID',
  `pid` int(10) unsigned NOT NULL COMMENT '产品ID',
  `old_amount` int(10) unsigned NOT NULL COMMENT '盘点前数量',
  `new_amount` int(10) unsigned NOT NULL COMMENT '盘点后数量',
  `addtime` int(11) unsigned NOT NULL COMMENT '时间',
  `remark` varchar(200) NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "stock_inventory_data"
#


#
# Structure for table "stock_product"
#

DROP TABLE IF EXISTS `stock_product`;
CREATE TABLE `stock_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(5) unsigned NOT NULL COMMENT '门店编号',
  `gid` int(5) unsigned NOT NULL COMMENT '供应商编号',
  `fid` int(5) unsigned NOT NULL COMMENT '分类编号',
  `pname` varchar(50) NOT NULL COMMENT '产品名称',
  `spec` varchar(20) NOT NULL COMMENT '规格',
  `selling_price` decimal(10,2) NOT NULL COMMENT '销售价',
  `buying_price` decimal(10,2) NOT NULL COMMENT '进货价',
  `sn` varchar(30) NOT NULL COMMENT '产品编码',
  `unit` varchar(10) NOT NULL COMMENT '产品单位',
  `bar_code` varchar(50) NOT NULL COMMENT '条形码',
  `safeline` varchar(5) NOT NULL COMMENT '安全线',
  `photo` varchar(250) NOT NULL COMMENT '产品图片',
  `status` int(3) unsigned NOT NULL COMMENT '产品状态',
  `remark` text NOT NULL COMMENT '产品介绍',
  `listorder` int(4) unsigned NOT NULL COMMENT '排序',
  `addtime` int(11) unsigned NOT NULL COMMENT '添加时间',
  `updatetime` int(11) unsigned NOT NULL COMMENT '更新时间',
  `userid` int(10) unsigned NOT NULL COMMENT '添加用户',
  `amount` int(10) unsigned NOT NULL COMMENT '数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

#
# Data for table "stock_product"
#

INSERT INTO `stock_product` VALUES (1,1,7,6,'三菱PLC','FX3U-16MR/ES-A',4150.00,3950.00,'42049965','台','','','',1,'',0,1505298963,1505298985,1,0),(2,1,7,6,'三菱PLC','FX3U-16MT/ES-A',4240.00,4050.00,'42049985','台','','','',1,'',0,1505299043,0,1,0),(3,1,7,6,'三菱PLC','FX3U-32MR/ES-A',5180.00,4950.00,'42049964','台','','','',1,'',0,1505299095,0,1,0),(4,1,7,6,'三菱PLC','FX3U-32MT/ES-A',5290.00,5090.00,'42049984','台','','','',1,'',0,1505299176,0,1,0),(5,1,8,5,' 三菱伺服','MR-KN13J-S100',3400.00,3200.00,'520495693','台','','','',1,'',0,1505299265,0,1,0),(6,1,8,5,' 三菱伺服','MR-KN23J-S100',4210.00,3900.00,'520495694','台','','','',1,'',0,1505299313,0,1,0),(7,1,9,4,'人机界面','TK6050IP',1500.00,1300.00,'5256580','台','','','',1,'',0,1505299378,0,1,0),(8,1,9,4,'人机界面','MT6070IE',2500.00,2200.00,'5256581','台','','','',1,'',0,1505299433,0,1,0),(9,1,10,3,'三菱变频器','FR-D740-1.5K',1940.00,1750.00,'5455457011','台','','','',1,'',0,1505299524,0,1,0),(10,1,10,3,'三菱变频器','FR-D740-2.2K',2390.00,2100.00,'5455457012','台','','','',1,'',0,1505299580,0,1,0);

#
# Structure for table "stock_set"
#

DROP TABLE IF EXISTS `stock_set`;
CREATE TABLE `stock_set` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(5) unsigned NOT NULL COMMENT '门店编号',
  `type` int(5) unsigned NOT NULL COMMENT '类型',
  `cname` varchar(50) NOT NULL COMMENT '值',
  `pid` int(5) unsigned NOT NULL COMMENT '上级栏目',
  `listorder` int(5) unsigned NOT NULL COMMENT '排序',
  `linkman` varchar(30) NOT NULL COMMENT '联系人',
  `mobile` varchar(30) NOT NULL COMMENT '联系电话',
  `address` varchar(150) NOT NULL COMMENT '联系地址',
  `addtime` int(11) unsigned NOT NULL COMMENT '添加时间',
  `updatetime` int(11) unsigned NOT NULL COMMENT '更新时间',
  `userid` int(10) unsigned NOT NULL COMMENT '添加用户',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

#
# Data for table "stock_set"
#

INSERT INTO `stock_set` VALUES (1,1,2,'',0,0,'','','',1505296294,0,1),(2,1,2,'',0,1,'','','',1505296319,0,1),(3,1,2,'',0,2,'','','',1505296345,0,1),(4,1,2,'',0,3,'','','',1505296371,0,1),(5,1,2,'',0,4,'','','',1505296391,0,1),(6,1,2,'',0,6,'','','',1505296419,0,1),(7,1,1,'东莞市华宸电子科技有限公司',0,0,'王洁  ','0769-82322658 　','广东省东莞市常平镇还珠沥教育路38号创伟科技 　',1505296490,0,1),(8,1,1,'福建中海创自动化科技有限公司 　',0,0,'吴丽腾','0591-83846839 ','福州市工业路洪山科技园6号楼2层 　',1505296550,0,1),(9,1,1,'佛山市奇创自动化设备有限公司 　',0,0,'陶春燕','0757-83322642 　','佛山市禅城区文华北路杨堂新村49号3楼 　',1505296613,0,1),(10,1,1,'广州众邦业电气技术有限公司 　',0,0,'倪国兵','18928753090 　','广州市荔湾区花蕾路10号1501 　',1505298017,0,1),(11,1,1,'合肥福元自动化控制有限公司 　',0,0,'赵敏　','0551-66100910 ','合肥市蜀山区长江西路304号鑫鹏大厦802室 　',1505298058,0,1),(12,1,1,'东莞市友盛电子科技有限公司 　',0,0,'付小姐','0755-27944992 　','东莞市南城区胜和红山路红山大厦一层2号铺 　',1505298108,0,1);

#
# Structure for table "stock_storage"
#

DROP TABLE IF EXISTS `stock_storage`;
CREATE TABLE `stock_storage` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `shop_id` int(5) unsigned NOT NULL COMMENT '门店编号',
  `orderid` varchar(50) NOT NULL COMMENT '订单编号',
  `pid` int(10) unsigned NOT NULL COMMENT '产品名称',
  `buying_price` decimal(10,2) NOT NULL COMMENT '采购价格',
  `amount` int(10) unsigned NOT NULL COMMENT '采购数量',
  `addtime` int(11) unsigned NOT NULL COMMENT '采购时间',
  `userid` int(11) unsigned NOT NULL COMMENT '操作用户',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "stock_storage"
#


#
# Structure for table "system"
#

DROP TABLE IF EXISTS `system`;
CREATE TABLE `system` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `wx_appid` varchar(50) NOT NULL COMMENT '微信APPID',
  `wx_appsecret` varchar(50) NOT NULL COMMENT '微信APPSECRET',
  `extime` int(11) unsigned NOT NULL COMMENT '过期时间',
  `userid` int(11) unsigned NOT NULL COMMENT '用户编号',
  `title` varchar(50) NOT NULL COMMENT '配置标题',
  `keyword` varchar(255) NOT NULL COMMENT '关键字',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `logo` varchar(255) NOT NULL,
  `copyright` text NOT NULL,
  `beian` varchar(200) NOT NULL,
  `tongji` text NOT NULL,
  `filesize` char(20) NOT NULL,
  `filetype` varchar(100) NOT NULL,
  `addtime` int(11) unsigned NOT NULL COMMENT '添加时间',
  `updatetime` int(11) unsigned NOT NULL COMMENT '更新时间',
  `accesstoken` varchar(255) NOT NULL COMMENT '微信accesstoken',
  `uptype` int(5) NOT NULL COMMENT '上传类型',
  `upak` char(50) NOT NULL COMMENT '七牛ak',
  `upsk` char(50) NOT NULL COMMENT '七牛sk',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='系统配置';

#
# Data for table "system"
#

INSERT INTO `system` VALUES (1,'','',1501556360,1,'素材火CRM管理系统','挂医网','微信挂号渠道','20170619/9a13e3eaa4df871df57810f0796aca1c.jpg','333','444','555','66','77',1501039176,1501039176,'RM4KtolbiKSmyDNI3EF6s7X3H2ikPB62MpaMJyDnbXgH6HDuTm9jdyuCWAZnVQ9VIN7qJe1M9THyFYjIheS7fUsQW0EDih-QgefhEdOHrMSr-Mat1tE_qQr0WuSjVHQ1KRFdAHAGNB',2,'','');

#
# Structure for table "upload"
#

DROP TABLE IF EXISTS `upload`;
CREATE TABLE `upload` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) unsigned NOT NULL COMMENT '操作用户',
  `addtime` int(11) unsigned NOT NULL COMMENT '添加时间',
  `filename` varchar(200) NOT NULL COMMENT '文件名',
  `controller` varchar(20) NOT NULL COMMENT '控制器名',
  `action` varchar(20) NOT NULL COMMENT '操作名',
  `app` varchar(20) NOT NULL COMMENT '项目名称',
  `filetype` char(20) NOT NULL COMMENT '文件类型',
  `filesize` char(20) NOT NULL COMMENT '文件大小',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "upload"
#

INSERT INTO `upload` VALUES (1,0,1501824970,'20170804/95e93ac9a6c8d6a5f10159a700f1a47c.jpg','Upload','input','member','',''),(2,0,1501824980,'20170804/6ba414a049a667799dcc21e7467afaf2.jpg','Upload','input','member','','');

#
# Structure for table "user"
#

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(50) NOT NULL,
  `password` char(32) NOT NULL,
  `realname` varchar(50) NOT NULL,
  `photo` varchar(300) NOT NULL,
  `gender` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `birthday` varchar(10) NOT NULL DEFAULT '0',
  `remark` text NOT NULL,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `delete_time` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "user"
#

INSERT INTO `user` VALUES (1,1,'admin','dfedac50808042795122ff31746c03f2','超管','',1,'1998-01-29','<p>asdff</p><p><br></p>',1496804765,1496824126,NULL);

#
# Structure for table "wx_user"
#

DROP TABLE IF EXISTS `wx_user`;
CREATE TABLE `wx_user` (
  `wxid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '微信编号',
  `openid` varchar(200) DEFAULT NULL COMMENT 'OPENID',
  `nickname` varchar(100) DEFAULT NULL COMMENT '昵称',
  `sex` int(5) unsigned DEFAULT NULL COMMENT '性别',
  `province` varchar(30) DEFAULT NULL COMMENT '省',
  `city` varchar(30) DEFAULT NULL COMMENT '市',
  `country` varchar(50) DEFAULT NULL COMMENT '国家',
  `headimgurl` varchar(255) DEFAULT NULL COMMENT '头像',
  `subscribe_time` int(11) unsigned DEFAULT NULL COMMENT '关注时间',
  `subscribe` int(5) DEFAULT NULL COMMENT '是否关注',
  `addtime` int(11) NOT NULL COMMENT '录入时间',
  `name` varchar(100) DEFAULT NULL COMMENT '姓名',
  `mobile` varchar(30) DEFAULT NULL COMMENT '电话',
  `u_province` varchar(30) DEFAULT NULL COMMENT '省',
  `u_city` varchar(30) DEFAULT NULL COMMENT '城市',
  `u_area` varchar(30) DEFAULT NULL COMMENT '区',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `updatetime` int(11) unsigned DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`wxid`),
  UNIQUE KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信关注用户表';

#
# Data for table "wx_user"
#

