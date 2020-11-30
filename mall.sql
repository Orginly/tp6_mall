/*
 Navicat Premium Data Transfer

 Source Server         : mysql
 Source Server Type    : MySQL
 Source Server Version : 80019
 Source Host           : localhost:3306
 Source Schema         : mall

 Target Server Type    : MySQL
 Target Server Version : 80019
 File Encoding         : 65001

 Date: 30/11/2020 20:30:15
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for mall_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `mall_admin_user`;
CREATE TABLE `mall_admin_user`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户名，因为之后需要通过用户名查询用户表所以给个索引',
  `password` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '密码',
  `status` tinyint UNSIGNED NOT NULL DEFAULT 1 COMMENT '0为禁用1为启用2为待审核 99删除',
  `create_time` int UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `last_time` int UNSIGNED NOT NULL DEFAULT 0 COMMENT '最后登录时间',
  `last_ip` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `operation_user` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '操作人',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mall_admin_user
-- ----------------------------
INSERT INTO `mall_admin_user` VALUES (1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, 1606212427, 0, 1606738615, '127.0.0.1', '');

-- ----------------------------
-- Table structure for mall_category
-- ----------------------------
DROP TABLE IF EXISTS `mall_category`;
CREATE TABLE `mall_category`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '分类名称',
  `pid` int NOT NULL DEFAULT 0 COMMENT '父级分类名称',
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '图标',
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '路径 1，2，5',
  `create_time` int NOT NULL COMMENT '创建时间',
  `update_time` int NOT NULL DEFAULT 0 COMMENT '更新时间',
  `operate_user` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '更新人',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '分类',
  `listorder` int NOT NULL DEFAULT 50 COMMENT '排序',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 40 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mall_category
-- ----------------------------
INSERT INTO `mall_category` VALUES (1, '手机类', 0, '', '', 1606386748, 1606386748, '', 1, 50);
INSERT INTO `mall_category` VALUES (2, '小米', 1, '', '', 1606387013, 1606387013, '', 1, 50);
INSERT INTO `mall_category` VALUES (3, '平板', 0, '', '', 1606387248, 1606387248, '', 1, 50);
INSERT INTO `mall_category` VALUES (4, '衣服', 0, '', '', 1606387399, 1606387399, '', 1, 65);
INSERT INTO `mall_category` VALUES (5, '冰箱', 0, '', '', 1606387413, 1606387413, '', 99, 61);
INSERT INTO `mall_category` VALUES (6, '空调', 0, '', '', 1606387527, 1606387527, '', 1, 63);
INSERT INTO `mall_category` VALUES (7, '小米平板2', 3, '', '', 1606388648, 1606388648, '', 1, 50);
INSERT INTO `mall_category` VALUES (8, '小米10', 2, '', '', 1606388666, 1606388666, '', 1, 50);
INSERT INTO `mall_category` VALUES (10, '上身', 4, '', '', 1606538460, 1606538460, '', 1, 50);
INSERT INTO `mall_category` VALUES (11, '下身', 4, '', '', 1606538472, 1606538472, '', 1, 50);
INSERT INTO `mall_category` VALUES (12, '华为', 3, '', '', 1606538486, 1606538486, '', 1, 50);
INSERT INTO `mall_category` VALUES (13, '华为手机', 1, '', '', 1606538502, 1606538502, '', 1, 50);
INSERT INTO `mall_category` VALUES (14, 'VIVO', 1, '', '', 1606538512, 1606538512, '', 1, 50);
INSERT INTO `mall_category` VALUES (15, 'OPPO', 1, '', '', 1606538518, 1606538518, '', 1, 50);
INSERT INTO `mall_category` VALUES (16, '三星', 3, '', '', 1606538537, 1606538537, '', 1, 50);
INSERT INTO `mall_category` VALUES (17, '阿尔法', 2, '', '', 1606540481, 1606540481, '', 1, 50);
INSERT INTO `mall_category` VALUES (18, '小米11', 2, '', '', 1606540723, 1606540723, '', 1, 50);
INSERT INTO `mall_category` VALUES (19, '小米12', 2, '', '', 1606540745, 1606540745, '', 1, 50);
INSERT INTO `mall_category` VALUES (20, '华为Mate50', 13, '', '', 1606540775, 1606540775, '', 1, 50);
INSERT INTO `mall_category` VALUES (21, 'VIVO X50', 14, '', '', 1606540788, 1606540788, '', 1, 50);
INSERT INTO `mall_category` VALUES (22, 'OPPO X50', 15, '', '', 1606540794, 1606540794, '', 1, 50);
INSERT INTO `mall_category` VALUES (23, '华为MateX', 12, '', '', 1606540815, 1606540815, '', 1, 50);
INSERT INTO `mall_category` VALUES (24, '三星foldX', 16, '', '', 1606540827, 1606540827, '', 1, 50);
INSERT INTO `mall_category` VALUES (25, '紧身', 10, '', '', 1606540841, 1606540841, '', 1, 50);
INSERT INTO `mall_category` VALUES (26, '西裤', 11, '', '', 1606540846, 1606540846, '', 1, 50);
INSERT INTO `mall_category` VALUES (27, '电脑', 0, '', '', 1606540990, 1606540990, '', 1, 50);
INSERT INTO `mall_category` VALUES (28, '笔记本', 27, '', '', 1606541005, 1606541005, '', 1, 50);
INSERT INTO `mall_category` VALUES (29, '游戏本', 27, '', '', 1606541013, 1606541013, '', 1, 50);
INSERT INTO `mall_category` VALUES (34, '中央空调', 6, '', '', 1606541245, 1606541245, '', 1, 50);
INSERT INTO `mall_category` VALUES (35, '家用空调', 6, '', '', 1606541253, 1606541253, '', 1, 50);
INSERT INTO `mall_category` VALUES (36, '蓝色', 7, '', '', 1606541288, 1606541288, '', 1, 50);
INSERT INTO `mall_category` VALUES (37, '大功率', 34, '', '', 1606541295, 1606541295, '', 1, 50);
INSERT INTO `mall_category` VALUES (38, '节能环保', 35, '', '', 1606541304, 1606541304, '', 1, 50);
INSERT INTO `mall_category` VALUES (39, '锐龙6600', 28, '', '', 1606541317, 1606541317, '', 1, 50);
INSERT INTO `mall_category` VALUES (40, '3080', 29, '', '', 1606541335, 1606541335, '', 1, 50);

-- ----------------------------
-- Table structure for mall_goods
-- ----------------------------
DROP TABLE IF EXISTS `mall_goods`;
CREATE TABLE `mall_goods`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '标题',
  `category_id` int NOT NULL COMMENT '商品分类',
  `category_path_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '栏目id path 三级分类的完整路径',
  `promotion_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '商品促销语',
  `goods_unit` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '商品单位',
  `keywords` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '关键词',
  `sub_title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '副标题',
  `stock` int NOT NULL DEFAULT 0 COMMENT '库存',
  `price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '现价',
  `cost_price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '原价',
  `sku_id` int NOT NULL DEFAULT 0 COMMENT '商品默认的sku_id',
  `is_show_stock` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否显示库存',
  `production_time` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '生产日期',
  `goods_specs_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '商品规划1统一规格2多规格',
  `big_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '大图',
  `recommend_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '商品推荐图',
  `carousel_image` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '商品详情页轮播图',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '商品详情',
  `is_index_recommend` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否首页推荐大图商品',
  `goods_specs_data` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '所有规格属性存放的JSON',
  `create_time` int NOT NULL DEFAULT 0,
  `update_time` int NOT NULL DEFAULT 0,
  `operation_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `listorder` int NOT NULL DEFAULT 50,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mall_goods
-- ----------------------------
INSERT INTO `mall_goods` VALUES (6, '羽绒服', 25, '4,10,25', '羽绒服', '件', '羽绒服', '羽绒服', 1200, 99.00, 299.00, 31, 1, '2020-11-28', 2, '/storage/image/upload/20201128\\02021fff0057303161621755ce0501c0.jpg', '/storage/image/upload/20201129\\8f4407ebec473c0b90ebdd2864949ae8.jpg', '/storage/image/upload/20201128\\bba6fb230272a580e5fd2dab5fbc92c9.jpg', '<p><img src=\"/storage/image/upload/20201128\\10cf89ce1838a19902c6c91b234d0284.PNG\" alt=\"undefined\"></p><p>详情</p>', 0, '', 1606573214, 1606573214, '', 1, 50);
INSERT INTO `mall_goods` VALUES (7, '小米10', 8, '1,2,8', '小米10', '台', '小米10', '小米10', 10000, 2999.00, 3999.00, 37, 1, '2020-11-28', 2, '/storage/image/upload/20201128\\17a22d63fccb4782.jpg', '/storage/image/upload/20201129\\17a22d63fccb4782.jpg', '/storage/image/upload/20201128\\e79fca43c37806ccda7c4a0137a9aa4e.jpg', '<p>2000小米102000小米102000小米102000小米10</p>', 0, '', 1606573502, 1606573502, '', 1, 50);
INSERT INTO `mall_goods` VALUES (8, ' 颜域长款毛领羽绒服女2020年新款冬装时尚抽绳收腰加厚白鸭绒外套', 25, '4,10,25', ' 颜域长款毛领羽绒服女2020年新款冬装时尚抽绳收腰加厚白鸭绒外套', '件', '衣服', ' 颜域长款毛领羽绒服女2020年新款冬装时尚抽绳收腰加厚白鸭绒外套', 1196, 199.00, 299.00, 42, 1, '2020-11-29', 2, '/storage/image/upload/20201129\\969209bcd8922c4c7f880db952438526.jpg', '/storage/image/upload/20201129\\2f69e70f7e3ce20a4e3db527d66c1810.jpg', '/storage/image/upload/20201129\\2f69e70f7e3ce20a4e3db527d66c1810.jpg,/storage/image/upload/20201129\\a5e23d5295b67a097b71a14142fdbbfb.jpg,/storage/image/upload/20201129\\8f4407ebec473c0b90ebdd2864949ae8.jpg', '<p>&nbsp;颜域长款毛领羽绒服女2020年新款冬装时尚抽绳收腰加厚白鸭绒外套 颜域长款毛领羽绒服女2020年新款冬装时尚抽绳收腰加厚白鸭绒外套 颜域长款毛领羽绒服女2020年新款冬装时尚抽绳收腰加厚白鸭绒外套</p>', 1, '', 1606621884, 1606621884, '', 1, 50);

-- ----------------------------
-- Table structure for mall_goods_sku
-- ----------------------------
DROP TABLE IF EXISTS `mall_goods_sku`;
CREATE TABLE `mall_goods_sku`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `goods_id` int NOT NULL COMMENT '商品id',
  `specs_value_ids` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '每行规划的属性id',
  `price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '现价',
  `cost_price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '原价',
  `stock` int NOT NULL DEFAULT 0 COMMENT '库存',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `create_time` int NOT NULL DEFAULT 0,
  `update_time` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 45 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mall_goods_sku
-- ----------------------------
INSERT INTO `mall_goods_sku` VALUES (31, 6, '1,5', 99.00, 299.00, 214, 1, 1606573214, 1606573214);
INSERT INTO `mall_goods_sku` VALUES (32, 6, '1,6', 99.00, 299.00, 200, 1, 1606573214, 1606573214);
INSERT INTO `mall_goods_sku` VALUES (33, 6, '2,5', 99.00, 299.00, 219, 1, 1606573214, 1606573214);
INSERT INTO `mall_goods_sku` VALUES (34, 6, '2,6', 99.00, 299.00, 200, 1, 1606573214, 1606573214);
INSERT INTO `mall_goods_sku` VALUES (35, 6, '3,5', 99.00, 299.00, 200, 1, 1606573214, 1606573214);
INSERT INTO `mall_goods_sku` VALUES (36, 6, '3,6', 99.00, 299.00, 200, 1, 1606573214, 1606573214);
INSERT INTO `mall_goods_sku` VALUES (37, 7, '1,12', 2999.00, 3999.00, 2000, 1, 1606573502, 1606573502);
INSERT INTO `mall_goods_sku` VALUES (38, 7, '2,12', 2999.00, 3999.00, 2000, 1, 1606573502, 1606573502);
INSERT INTO `mall_goods_sku` VALUES (39, 7, '3,12', 2999.00, 3999.00, 2000, 1, 1606573502, 1606573502);
INSERT INTO `mall_goods_sku` VALUES (40, 7, '13,12', 2999.00, 3999.00, 2000, 1, 1606573502, 1606573502);
INSERT INTO `mall_goods_sku` VALUES (41, 7, '14,12', 2999.00, 3999.00, 2000, 1, 1606573502, 1606573502);
INSERT INTO `mall_goods_sku` VALUES (42, 8, '3,4', 199.00, 299.00, 311, 1, 1606621884, 1606621884);
INSERT INTO `mall_goods_sku` VALUES (43, 8, '3,5', 199.00, 299.00, 299, 1, 1606621884, 1606621884);
INSERT INTO `mall_goods_sku` VALUES (44, 8, '13,4', 199.00, 299.00, 299, 1, 1606621884, 1606621884);
INSERT INTO `mall_goods_sku` VALUES (45, 8, '13,5', 199.00, 299.00, 299, 1, 1606621884, 1606621884);

-- ----------------------------
-- Table structure for mall_order
-- ----------------------------
DROP TABLE IF EXISTS `mall_order`;
CREATE TABLE `mall_order`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT ' ',
  `order_id` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '订单id',
  `total_price` decimal(10, 2) NOT NULL COMMENT '订单价格',
  `address_id` int NOT NULL COMMENT '地址表的id',
  `user_id` int NOT NULL COMMENT '用户id',
  `create_time` int NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int NOT NULL DEFAULT 0 COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '业务状态',
  `operation_user` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '操作人',
  `pay_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '支付方式',
  `pay_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '支付状态',
  `pay_time` int NOT NULL DEFAULT 0 COMMENT '支付时间',
  `message` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `logistics` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '物流',
  `logistics_order` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '物流单号',
  `end_time` int NOT NULL DEFAULT 0 COMMENT '订单完成时间',
  `close_time` int NOT NULL DEFAULT 0 COMMENT '订单关闭时间',
  `consignment_time` int NOT NULL DEFAULT 0 COMMENT '发货时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mall_order
-- ----------------------------
INSERT INTO `mall_order` VALUES (43, '1333301255758753792', 397.00, 1, 1, 1606718765, 1606718765, 1, '', 0, 0, 0, '', '', '', 0, 0, 0);

-- ----------------------------
-- Table structure for mall_order_goods
-- ----------------------------
DROP TABLE IF EXISTS `mall_order_goods`;
CREATE TABLE `mall_order_goods`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '订单id',
  `sku` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'sku文案',
  `sku_id` int NOT NULL COMMENT '商品SkuId',
  `num` int NOT NULL COMMENT '购买数量',
  `price` decimal(10, 2) NOT NULL COMMENT '价格',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '商品标题',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '图片',
  `create_time` int NOT NULL DEFAULT 0,
  `update_time` int NOT NULL DEFAULT 0,
  `operation_user` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mall_order_goods
-- ----------------------------
INSERT INTO `mall_order_goods` VALUES (43, '1333301255758753792', '颜色:粉色  尺码:M', 33, 1, 99.00, '羽绒服', 'http://shop.io/storage/image/upload/20201129\\8f4407ebec473c0b90ebdd2864949ae8.jpg', 1606658597, 1606718765, '');
INSERT INTO `mall_order_goods` VALUES (44, '1333301255758753792', '颜色:黑色  尺码:M', 31, 1, 99.00, '羽绒服', 'http://shop.io/storage/image/upload/20201129\\8f4407ebec473c0b90ebdd2864949ae8.jpg', 1606658595, 1606718765, '');
INSERT INTO `mall_order_goods` VALUES (45, '1333301255758753792', '颜色:绿色  尺码:S', 42, 1, 199.00, ' 颜域长款毛领羽绒服女2020年新款冬装时尚抽绳收腰加厚白鸭绒外套', 'http://shop.io/storage/image/upload/20201129\\2f69e70f7e3ce20a4e3db527d66c1810.jpg', 1606654416, 1606718765, '');

-- ----------------------------
-- Table structure for mall_specs_value
-- ----------------------------
DROP TABLE IF EXISTS `mall_specs_value`;
CREATE TABLE `mall_specs_value`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `specs_id` int NOT NULL COMMENT '规格id',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '规格属性名',
  `create_time` int NOT NULL DEFAULT 0,
  `update_time` int NOT NULL DEFAULT 0,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mall_specs_value
-- ----------------------------
INSERT INTO `mall_specs_value` VALUES (1, 1, '黑色', 0, 0, '', 1);
INSERT INTO `mall_specs_value` VALUES (2, 1, '粉色', 0, 0, '', 1);
INSERT INTO `mall_specs_value` VALUES (3, 1, '绿色', 0, 0, '', 1);
INSERT INTO `mall_specs_value` VALUES (4, 2, 'S', 0, 0, '', 1);
INSERT INTO `mall_specs_value` VALUES (5, 2, 'M', 0, 0, '', 1);
INSERT INTO `mall_specs_value` VALUES (6, 2, 'L', 0, 0, '', 1);
INSERT INTO `mall_specs_value` VALUES (7, 2, 'XL', 0, 0, '', 1);
INSERT INTO `mall_specs_value` VALUES (8, 3, '4G', 0, 0, '', 1);
INSERT INTO `mall_specs_value` VALUES (9, 3, '8G', 0, 0, '', 1);
INSERT INTO `mall_specs_value` VALUES (10, 4, '6寸', 0, 0, '', 1);
INSERT INTO `mall_specs_value` VALUES (11, 4, '8寸', 0, 0, '', 1);
INSERT INTO `mall_specs_value` VALUES (12, 5, 'puls', 0, 0, '', 1);
INSERT INTO `mall_specs_value` VALUES (13, 1, '黄色', 1606557941, 1606557941, '', 1);
INSERT INTO `mall_specs_value` VALUES (14, 1, '灰色', 1606558007, 1606558007, '', 1);

-- ----------------------------
-- Table structure for mall_user
-- ----------------------------
DROP TABLE IF EXISTS `mall_user`;
CREATE TABLE `mall_user`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户名',
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '手机号',
  `password` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '密码',
  `login_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '默认0 手机号登录 1密码登录',
  `session_type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '会话保存天数 1为3天 2为7天 3为30天',
  `sex` tinyint(1) NOT NULL DEFAULT 0 COMMENT '性别1男2女',
  `create_time` int NOT NULL COMMENT '创建时间',
  `update_time` int NOT NULL DEFAULT 0 COMMENT '更新时间',
  `operate_user` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '操作人',
  `status` tinyint(1) NOT NULL COMMENT '账号状态',
  `last_time` int UNSIGNED NOT NULL DEFAULT 0 COMMENT '最后登录时间',
  `last_ip` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '最后登录的ip',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `username`(`username`) USING BTREE,
  INDEX `phone`(`phone`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mall_user
-- ----------------------------
INSERT INTO `mall_user` VALUES (1, 'Mo', '18169630262', '', 0, 1, 2, 1606360982, 1606651719, '', 1, 1606651719, '127.0.0.1');
INSERT INTO `mall_user` VALUES (2, 'Mo-1136', '15278911136', '', 0, 1, 2, 1606378898, 1606378930, '', 1, 1606378930, '127.0.0.1');

SET FOREIGN_KEY_CHECKS = 1;
