CREATE TABLE IF NOT EXISTS `PREFIX_printify_product_attribute` (
  `id_product_attribute_printify` INT(11) NOT NULL,
  `id_product_attribute` INT(11) NOT NULL,
  `id_product` INT(11) NOT NULL,
  PRIMARY KEY (`id_product_attribute_printify`, `id_product_attribute`)
) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;
