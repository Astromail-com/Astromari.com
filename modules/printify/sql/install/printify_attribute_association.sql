CREATE TABLE IF NOT EXISTS `PREFIX_printify_attribute` (
  `id_attribute_printify` INT(11) NOT NULL,
  `id_attribute` INT(11) NOT NULL,
  PRIMARY KEY (`id_attribute_printify`, `id_attribute`)
) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;
