CREATE TABLE IF NOT EXISTS `PREFIX_printify_log` (
  `id_printify_log` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(20),
  `id_object` VARCHAR(40) DEFAULT NULL,
  `status` VARCHAR(20),
  `message` VARCHAR(1000),
  `date` DATETIME NOT NULL,
  PRIMARY KEY (`id_printify_log`)
) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;
