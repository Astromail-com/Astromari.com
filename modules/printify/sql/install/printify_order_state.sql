CREATE TABLE IF NOT EXISTS `PREFIX_printify_order_state` (
            `id` VARCHAR(255),
			`id_order_state` int(6) NOT NULL,
			  PRIMARY KEY(`id`, `id_order_state`)
		) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;
