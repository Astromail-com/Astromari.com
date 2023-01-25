CREATE TABLE IF NOT EXISTS `PREFIX_printify_product` (
  `id_printify_product` VARCHAR(255) NOT NULL,
  `id_product` INT(11) NOT NULL,
  `printify_print_provider_id` INT(11) NOT NULL,
  `printify_blueprint_id` INT(11) NOT NULL,
  PRIMARY KEY (`id_printify_product`, `id_product`)
) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;
