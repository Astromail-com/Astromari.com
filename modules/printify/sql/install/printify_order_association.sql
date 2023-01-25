CREATE TABLE IF NOT EXISTS `PREFIX_printify_order` (
  `reference` VARCHAR(255) NOT NULL,
  `id_printify_order` VARCHAR(255) NOT NULL,
  `created_at` DATETIME,
  `customer` VARCHAR(255) NOT NULL,
  `total_paid` VARCHAR(255) NOT NULL,
  `status` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`reference`, `id_printify_order`)
) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;
