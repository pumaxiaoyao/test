CREATE TABLE `gmusers` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`account`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`password`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`regtime`  decimal(10,0) NOT NULL ,
`lastlogintime`  decimal(10,0) NOT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=5
ROW_FORMAT=DYNAMIC
;