-- Maple.xia 2017-01-06
DROP TABLE IF EXISTS `yf_products`;
CREATE TABLE `yf_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `size` tinyint(4) DEFAULT 0 COMMENT  '尺寸',
  `category` smallint (6) DEFAULT 0 COMMENT  '分类',
  `type` smallint (6)  DEFAULT 0 COMMENT  '类型',
  `code` varchar(100) NOT NULL DEFAULT '' COMMENT '编号',
  `price_cn` int(11) DEFAULT 0 COMMENT 'cny',
  `price_kr` int(11) DEFAULT 0 COMMENT 'kry',
  `manufacturer` varchar(200) DEFAULT '' COMMENT '厂商',
  `origin` varchar(100) DEFAULT '' COMMENT '产地',
  `desc` varchar(300) DEFAULT '' COMMENT '描述',
  `image` varchar(255) DEFAULT '' COMMENT '图片url',
  `status` tinyint(4) DEFAULT 1 COMMENT '状态 -1:禁用 1:激活',
  `create_time` int(11) DEFAULT 0 COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='产品表';

DROP TABLE IF EXISTS `yf_product_img`;
CREATE TABLE `yf_product_img` (
  `product_id` int(11) NOT NULL DEFAULT 0 COMMENT '产品id',
  `image` varchar(20) NOT NULL DEFAULT '' COMMENT '详情图片'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品详情表';

DROP TABLE IF EXISTS `yf_rbac_user`;
CREATE TABLE `yf_rbac_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(20) NOT NULL DEFAULT '' COMMENT '账号',
  `password` char(32) NOT NULL DEFAULT 0 COMMENT  '密码',
  `nickname` varchar(40) NOT NULL DEFAULT '' COMMENT '昵称',
  `email` varchar(40) DEFAULT '' COMMENT '电子邮箱',
  `mobile` char(11) DEFAULT '' COMMENT '手机',
  `status` tinyint(4) DEFAULT 1 COMMENT '状态 -1:禁用 1:激活',
  `last_login_time` int(11) DEFAULT 0 COMMENT '最后登录时间',
  `last_login_ip` varchar(30) DEFAULT '' COMMENT '最后登录ip',
  `login_count` int(11) DEFAULT 0 COMMENT '登录次数',
  `session_id` char(32) DEFAULT '' COMMENT '会话id',
  `create_time` int(11) DEFAULT 0 COMMENT '创建时间',
  `notes` varchar(255) DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='用户表';