-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 08 月 06 日 15:57
-- 服务器版本: 5.5.38
-- PHP 版本: 5.4.29

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `demo_358`
--

-- --------------------------------------------------------

--
-- 表的结构 `article`
--

CREATE TABLE IF NOT EXISTS `article` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `column`
--

CREATE TABLE IF NOT EXISTS `column` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='栏目表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `customer_track`
--

CREATE TABLE IF NOT EXISTS `customer_track` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(10) unsigned NOT NULL COMMENT '客户ID',
  `shop_id` int(10) unsigned NOT NULL COMMENT '门店ID',
  `userid` int(10) unsigned NOT NULL COMMENT '跟踪人员',
  `addtime` int(11) unsigned NOT NULL COMMENT '跟踪时间',
  `linkman` varchar(50) NOT NULL COMMENT '对接人员',
  `type` int(5) unsigned NOT NULL COMMENT '对接方式',
  `remark` text NOT NULL COMMENT '对接记录',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) unsigned NOT NULL,
  `app` char(20) NOT NULL,
  `controller` char(20) NOT NULL,
  `action` char(20) NOT NULL,
  `addtime` int(11) unsigned NOT NULL COMMENT '操作时间',
  `data` varchar(200) NOT NULL COMMENT '参数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `member`
--

CREATE TABLE IF NOT EXISTS `member` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `member`
--

INSERT INTO `member` (`uid`, `shop_id`, `pid`, `realname`, `username`, `mobile`, `password`, `gender`, `birthday`, `photo`, `addtime`, `lasttime`, `ip`, `remark`, `status`, `is_admin`, `openid`, `role_id`, `type`) VALUES
(1, 1, 0, '', 'admin', '', '11629b1be5b6d07a80c52fe8e983d994', 0, 0, '', 0, 1502006135, '', '', 0, 0, '', 4, 3);

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `orders_back`
--

CREATE TABLE IF NOT EXISTS `orders_back` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `shop_id` int(5) NOT NULL COMMENT '门店编号',
  `orderid` int(10) unsigned NOT NULL COMMENT '订单编号',
  `userid` int(5) unsigned NOT NULL COMMENT '操作用户',
  `datetime` int(11) unsigned NOT NULL COMMENT '操作时间',
  `remark` text NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `orders_back`
--

INSERT INTO `orders_back` (`id`, `shop_id`, `orderid`, `userid`, `datetime`, `remark`) VALUES
(1, 1, 1024, 1, 1499914874, '深度发杀到发多少发到付');

-- --------------------------------------------------------

--
-- 表的结构 `orders_data`
--

CREATE TABLE IF NOT EXISTS `orders_data` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单数据' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `role`
--

CREATE TABLE IF NOT EXISTS `role` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `role`
--

INSERT INTO `role` (`id`, `shop_id`, `name`, `remark`, `auth`, `sort`, `create_time`, `update_time`, `delete_time`, `type`) VALUES
(1, 0, '超级管理员', '', '["system","system-list","system-log","system-attachment","system-attachment-auth-delete","user","user-list","user-list-auth-edit","user-list-auth-delete","user-role","content","content-list","content-list-auth-add","content-list-auth-edit","content-list-auth-delete","content-article","content-article-auth-add","content-article-auth-edit","content-article-auth-delete","content-page","weixin","weixin-list","weixin-list-auth-edit","weixin-list-auth-delete"]', 0, 1496804891, 1497590177, NULL, 0),
(2, 0, '普通用户', '', '["system","system-list","system-log","system-attachment","system-attachment-auth-delete","user","user-list","user-list-auth-edit","user-list-auth-delete","user-role","content","content-list","content-list-auth-add","content-list-auth-edit","content-list-auth-delete","content-article","content-article-auth-add","content-article-auth-edit","content-article-auth-delete","content-page","weixin","weixin-list","weixin-list-auth-edit","weixin-list-auth-delete"]', 0, 1496806722, 1497590185, NULL, 0),
(3, 1, '普通用户', '', '["index","customer","customer-list","customer-list-auth-add","customer-list-auth-edit","customer-track","customer-track-auth-add","customer-track-auth-edit","customer-visit","customer-visit-auth-add","customer-visit-auth-edit","customer-search"]', 0, 1497590564, 1499225026, NULL, 1),
(4, 1, '管理员用户', '', '["index","sales","sales-add","sales-list","sales-list-auth-add","sales-list-auth-edit","sales-list-auth-delete","sales-returnorder","sales-unsubscribe","customer","customer-list","customer-list-auth-all","customer-list-auth-add","customer-list-auth-edit","customer-list-auth-delete","customer-track","customer-track-auth-add","customer-track-auth-edit","customer-track-auth-delete","customer-visit","customer-visit-auth-add","customer-visit-auth-edit","customer-visit-auth-delete","customer-search","stock","stock-orders","stock-storage","stock-storage-auth-add","stock-inventory","stock-product","stock-setting","finance","finance-audit","finance-auditok","finance-report","user","user-list","user-list-auth-add","user-list-auth-edit","user-list-auth-delete","user-role","user-role-auth-add","user-role-auth-edit","user-role-auth-delete","shop","shop-list"]', 0, 1497946934, 1499997593, NULL, 1),
(7, 0, '默认用户组别', '', '["index","user","user-list","user-list-auth-add","user-list-auth-edit","user-list-auth-delete","user-role","user-role-auth-add","user-role-auth-edit","user-role-auth-delete","systems","systems-list"]', 0, 1498110242, 1498110254, NULL, 1),
(8, 2, '管理', '', '["index","sales","sales-add","sales-list","sales-list-auth-add","sales-list-auth-edit","sales-list-auth-delete","sales-returnorder","customer","customer-list","customer-list-auth-all","customer-list-auth-add","customer-list-auth-edit","customer-list-auth-delete","customer-track","customer-track-auth-add","customer-track-auth-edit","customer-track-auth-delete","customer-visit","customer-visit-auth-add","customer-visit-auth-edit","customer-visit-auth-delete","customer-search","stock","stock-orders","stock-storage","stock-storage-auth-add","stock-inventory","stock-product","stock-setting","finance","finance-audit","user","user-list","user-list-auth-add","user-list-auth-edit","user-list-auth-delete","user-role","user-role-auth-add","user-role-auth-edit","user-role-auth-delete","shop","shop-list"]', 0, 1498274307, 1501642020, NULL, 1),
(9, 2, '普通员工', '', '["index","customer","customer-list","customer-list-auth-add","customer-list-auth-edit","customer-track","customer-track-auth-add","customer-track-auth-edit","customer-search"]', 0, 1498274612, 1498274612, NULL, 1),
(10, 3, '管理', '', '["index","customer","customer-list","customer-list-auth-add","customer-list-auth-edit","customer-list-auth-delete","customer-track","customer-track-auth-add","customer-track-auth-edit","customer-track-auth-delete","customer-search","user","user-list","user-list-auth-add","user-list-auth-edit","user-list-auth-delete","user-role","user-role-auth-add","user-role-auth-edit","user-role-auth-delete","shop","shop-list"]', 0, 1498274307, 1498282581, NULL, 1),
(11, 1, '业务主管', '', '["index","customer","customer-list","customer-list-auth-all","customer-list-auth-add","customer-list-auth-edit","customer-track","customer-track-auth-add","customer-track-auth-edit","customer-visit","customer-visit-auth-add","customer-visit-auth-edit","customer-search"]', 0, 1499225826, 1499225826, NULL, 1);

-- --------------------------------------------------------

--
-- 表的结构 `shop`
--

CREATE TABLE IF NOT EXISTS `shop` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `shop`
--

INSERT INTO `shop` (`shop_id`, `name`, `mobile`, `logo`, `map_lat`, `map_lng`, `province`, `city`, `area`, `address`, `remark`, `addtime`, `userid`) VALUES
(1, '福州宝仕尼网络科技有限公司', '0591-88023652', '/uploads/20170622/53ffcecf9163fce7309ecee59aa372ec.png', '26.137283', '119.313896', '福建省', '福州市', '晋安区', '索高广场1#20190o9898', '&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 1501827206, 1),
(2, '宝仕尼南通', '13773836017', '', '', '', '江苏省', '南通市', '', '', '', 1501515126, 16),
(3, '上海宝仕尼', '', '', '', '', '', '', '', '', '', 111, 18);

-- --------------------------------------------------------

--
-- 表的结构 `slide`
--

CREATE TABLE IF NOT EXISTS `slide` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL COMMENT '幻灯标题',
  `image` varchar(255) NOT NULL COMMENT '幻灯图片',
  `url` varchar(255) NOT NULL COMMENT '链接',
  `type` varchar(20) NOT NULL COMMENT '分类',
  `extime` int(11) unsigned NOT NULL COMMENT '过期时间',
  `addtime` int(11) unsigned NOT NULL COMMENT '添加时间',
  `userid` int(11) unsigned NOT NULL COMMENT '添加用户',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `stock_inventory`
--

CREATE TABLE IF NOT EXISTS `stock_inventory` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(5) unsigned NOT NULL COMMENT '门店编号',
  `userid` int(5) unsigned NOT NULL COMMENT '盘点人',
  `addtime` int(11) unsigned NOT NULL COMMENT '盘点日期',
  `remark` varchar(255) NOT NULL COMMENT '盘点备注',
  `jiandu` int(5) unsigned NOT NULL COMMENT '监督用户',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `stock_inventory`
--

INSERT INTO `stock_inventory` (`id`, `shop_id`, `userid`, `addtime`, `remark`, `jiandu`) VALUES
(1, 1, 1, 1501689600, '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `stock_inventory_data`
--

CREATE TABLE IF NOT EXISTS `stock_inventory_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(5) unsigned NOT NULL COMMENT '门店编号',
  `iid` int(5) unsigned NOT NULL COMMENT '盘点ID',
  `pid` int(10) unsigned NOT NULL COMMENT '产品ID',
  `old_amount` int(10) unsigned NOT NULL COMMENT '盘点前数量',
  `new_amount` int(10) unsigned NOT NULL COMMENT '盘点后数量',
  `addtime` int(11) unsigned NOT NULL COMMENT '时间',
  `remark` varchar(200) NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `stock_product`
--

CREATE TABLE IF NOT EXISTS `stock_product` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `stock_set`
--

CREATE TABLE IF NOT EXISTS `stock_set` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `stock_storage`
--

CREATE TABLE IF NOT EXISTS `stock_storage` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `shop_id` int(5) unsigned NOT NULL COMMENT '门店编号',
  `orderid` varchar(50) NOT NULL COMMENT '订单编号',
  `pid` int(10) unsigned NOT NULL COMMENT '产品名称',
  `buying_price` decimal(10,2) NOT NULL COMMENT '采购价格',
  `amount` int(10) unsigned NOT NULL COMMENT '采购数量',
  `addtime` int(11) unsigned NOT NULL COMMENT '采购时间',
  `userid` int(11) unsigned NOT NULL COMMENT '操作用户',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `system`
--

CREATE TABLE IF NOT EXISTS `system` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='系统配置' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `system`
--

INSERT INTO `system` (`id`, `wx_appid`, `wx_appsecret`, `extime`, `userid`, `title`, `keyword`, `description`, `logo`, `copyright`, `beian`, `tongji`, `filesize`, `filetype`, `addtime`, `updatetime`, `accesstoken`, `uptype`, `upak`, `upsk`) VALUES
(1, '', '', 1501556360, 1, '素材火CRM管理系统', '挂医网', '微信挂号渠道', '20170619/9a13e3eaa4df871df57810f0796aca1c.jpg', '333', '444', '555', '66', '77', 1501039176, 1501039176, 'RM4KtolbiKSmyDNI3EF6s7X3H2ikPB62MpaMJyDnbXgH6HDuTm9jdyuCWAZnVQ9VIN7qJe1M9THyFYjIheS7fUsQW0EDih-QgefhEdOHrMSr-Mat1tE_qQr0WuSjVHQ1KRFdAHAGNB', 2, '', '');

-- --------------------------------------------------------

--
-- 表的结构 `upload`
--

CREATE TABLE IF NOT EXISTS `upload` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `upload`
--

INSERT INTO `upload` (`id`, `userid`, `addtime`, `filename`, `controller`, `action`, `app`, `filetype`, `filesize`) VALUES
(1, 0, 1501824970, '20170804/95e93ac9a6c8d6a5f10159a700f1a47c.jpg', 'Upload', 'input', 'member', '', ''),
(2, 0, 1501824980, '20170804/6ba414a049a667799dcc21e7467afaf2.jpg', 'Upload', 'input', 'member', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `role_id`, `username`, `password`, `realname`, `photo`, `gender`, `birthday`, `remark`, `create_time`, `update_time`, `delete_time`) VALUES
(1, 1, 'admin', 'dfedac50808042795122ff31746c03f2', '超管', '', 1, '1998-01-29', '<p>asdff</p><p><br></p>', 1496804765, 1496824126, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `wx_user`
--

CREATE TABLE IF NOT EXISTS `wx_user` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信关注用户表' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
