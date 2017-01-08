-- Maple.xia 2017-01-06
CREATE TABLE `yf_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `size` tinyint(4) DEFAULT 0 COMMENT  '尺寸',
  `code` varchar(100) NOT NULL DEFAULT '' COMMENT '编号',
  `price_cn` int(11) DEFAULT 0 COMMENT 'cny',
  `price_kr` int(11) DEFAULT 0 COMMENT 'kry',
  `manufacturer` varchar(200) DEFAULT '' COMMENT '厂商',
  `origin` varchar(100) DEFAULT '' COMMENT '产地',
  `desc` varchar(300) DEFAULT '' COMMENT '描述',
  `image` varchar(255) DEFAULT '' COMMENT '图片url',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='产品表';