<?php
/**
 * @author    ELEGANTAL <info@elegantal.com>
 * @copyright (c) 2023, ELEGANTAL <www.elegantal.com>
 * @license   Proprietary License - It is forbidden to resell or redistribute copies of the module or modified copies of the module.
 */

/**
 * This is an object model class used to manage import rules
 */
class ElegantalEasyImportClass extends ElegantalEasyImportObjectModel
{
    public $tableName = 'elegantaleasyimport';
    public static $definition = array(
        'table' => 'elegantaleasyimport',
        'primary' => 'id_elegantaleasyimport',
        'multishop' => true,
        'fields' => array(
            'name' => array('type' => self::TYPE_STRING, 'size' => 255, 'validate' => 'isString', 'required' => true),
            'entity' => array('type' => self::TYPE_STRING, 'size' => 25, 'validate' => 'isString', 'required' => true),
            'supplier_id' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'map' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'map_default_values' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'csv_header' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'header_row' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'import_type' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
            'csv_file' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'csv_path' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'csv_url' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'csv_url_username' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'csv_url_password' => array('type' => self::TYPE_STRING, 'validate' => 'isString'), // Can hold Authorization Bearer token
            'csv_url_method' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'csv_url_post_params' => array('type' => self::TYPE_HTML, 'validate' => 'isString'),
            'ftp_host' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'ftp_port' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'ftp_username' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'ftp_password' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'ftp_file' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'is_cron' => array('type' => self::TYPE_BOOL, 'validate' => 'isUnsignedInt'),
            'cron_csv_file_size' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'cron_csv_file_md5' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'product_limit_per_request' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'product_range_to_import' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'email_to_send_notification' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'find_products_by' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'create_new_products' => array('type' => self::TYPE_BOOL, 'validate' => 'isUnsignedInt'),
            'update_existing_products' => array('type' => self::TYPE_BOOL, 'validate' => 'isUnsignedInt'),
            'update_products_on_all_shops' => array('type' => self::TYPE_BOOL, 'validate' => 'isUnsignedInt'),
            'force_id_product' => array('type' => self::TYPE_BOOL, 'validate' => 'isUnsignedInt'),
            'price_modifier' => array('type' => self::TYPE_STRING),
            'product_reference_modifier' => array('type' => self::TYPE_STRING),
            'min_price_amount' => array('type' => self::TYPE_FLOAT, 'validate' => 'isFloat'),
            'multiple_value_separator' => array('type' => self::TYPE_STRING),
            'multiple_subcategory_separator' => array('type' => self::TYPE_STRING),
            'is_associate_all_subcategories' => array('type' => self::TYPE_BOOL, 'validate' => 'isUnsignedInt'),
            'is_first_parent_root_for_categories' => array('type' => self::TYPE_BOOL, 'validate' => 'isUnsignedInt'),
            'decimal_char' => array('type' => self::TYPE_STRING),
            'shipping_package_size_unit' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'shipping_package_weight_unit' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'base_url_images' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'delete_old_combinations' => array('type' => self::TYPE_BOOL, 'validate' => 'isUnsignedInt'),
            'enable_new_products_by_default' => array('type' => self::TYPE_BOOL, 'validate' => 'isUnsignedInt'),
            'skip_if_no_stock' => array('type' => self::TYPE_BOOL, 'validate' => 'isUnsignedInt'),
            'enable_if_have_stock' => array('type' => self::TYPE_BOOL, 'validate' => 'isUnsignedInt'),
            'disable_if_no_stock' => array('type' => self::TYPE_BOOL, 'validate' => 'isUnsignedInt'),
            'disable_if_no_image' => array('type' => self::TYPE_BOOL, 'validate' => 'isUnsignedInt'),
            'enable_all_products_found_in_csv' => array('type' => self::TYPE_BOOL, 'validate' => 'isUnsignedInt'),
            'disable_all_products_not_found_in_csv' => array('type' => self::TYPE_BOOL, 'validate' => 'isUnsignedInt'),
            'deny_orders_when_no_stock_for_products_not_found_in_file' => array('type' => self::TYPE_BOOL, 'validate' => 'isUnsignedInt'),
            'delete_stock_for_products_not_found_in_csv' => array('type' => self::TYPE_BOOL, 'validate' => 'isUnsignedInt'),
            'is_utf8_encode' => array('type' => self::TYPE_BOOL, 'validate' => 'isUnsignedInt'),
            'active' => array('type' => self::TYPE_BOOL, 'validate' => 'isUnsignedInt'),
        ),
    );

    /**
     * History Object for current import process
     * @var object
     */
    protected $currentHistory = null;

    /**
     * id_reference from file for current product being imported
     * @var string
     */
    protected $current_id_reference = null;

    /**
     * Variables to cache data
     * @var array
     */
    protected $categories = array();
    protected $manufacturers = array();
    protected $suppliers = array();
    protected $carriers = array();
    protected $column_value_dictionary = array();
    protected $category_map_keys = array();
    protected $id_lang_default = 1;
    protected $id_all_langs = array();
    protected $id_other_langs = array();

    /**
     * Import Types
     * @var int
     */
    public static $IMPORT_TYPE_UPLOAD = 1;
    public static $IMPORT_TYPE_PATH = 2;
    public static $IMPORT_TYPE_URL = 3;
    public static $IMPORT_TYPE_FTP = 4;
    public static $IMPORT_TYPE_SFTP = 5;

    /**
     * List of allowed file types for import
     * @var array
     */
    public static $allowed_file_types = array('csv', 'xls', 'xlsx', 'xml', 'json', 'txt', 'ods', 'rss'); // zip,gz can be added

    /**
     * List of allowed mime types for import
     * @var array
     */
    public static $allowed_mime_types = array(
        'text/xml',
        'text/html',
        'application/xml',
        'text/csv',
        'text/plain',
        'application/octet-stream',
        'application/vnd.ms-excel',
        'application/vnd.ms-office',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.oasis.opendocument.spreadsheet',
        'application/json',
        'message/news',
        // 'application/zip',
        // 'application/gzip',
        // 'application/x-gzip',
    );

    public function __construct($id = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id, $id_lang, $id_shop);

        $this->context = Context::getContext();

        if (!$this->id) {
            $this->header_row = 1;
            $this->is_first_parent_root_for_categories = 1;
        }

        if (method_exists('Shop', 'addTableAssociation')) {
            Shop::addTableAssociation($this->tableName, array('type' => 'shop'));
        }

        $this->id_lang_default = (int) Configuration::get('PS_LANG_DEFAULT');
        $this->id_all_langs[] = $this->id_lang_default;
        $languages = Language::getLanguages(true, false, true);
        foreach ($languages as $id_lang) {
            if ($id_lang != $this->id_lang_default) {
                $this->id_all_langs[] = $id_lang;
                $this->id_other_langs[] = $id_lang;
            }
        }

        $this->defaultMapProducts = ElegantalEasyImportMap::getDefaultMapProducts();
        $this->defaultMapCombinations = ElegantalEasyImportMap::getDefaultMapCombinations();
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Reads CSV file and saves each row into database in bulk insert query
     * @return int
     * @throws Exception
     */
    public function saveCsvRows()
    {
        $id_shop = $this->context->shop->id;
        $context_shop = Shop::getContext();

        // Delete old csv rows if exists
        $sql = "DELETE FROM `" . _DB_PREFIX_ . "elegantaleasyimport_data` WHERE `id_elegantaleasyimport` = " . (int) $this->id;
        Db::getInstance()->execute($sql);

        // We do not need to do anything because both create_new_products and update_existing_products are disabled
        if (!$this->create_new_products && !$this->update_existing_products) {
            return 0;
        }

        $file = ElegantalEasyImportTools::getRealPath($this->csv_file);
        if (!$file || !is_file($file) || !is_readable($file) || !filesize($file)) {
            throw new Exception('File not found or it is empty: ' . $file);
        }

        $delimiter = ElegantalEasyImportCsv::identifyCsvDelimiter($file);

        $handle = fopen($file, 'r');
        if (!$handle) {
            throw new Exception('Cannot open file: ' . $file);
        }

        $map = $this->getMap();
        $map_default_values = $this->getMapDefaultValues();

        $ranges_to_import = array();
        if ($this->product_range_to_import) {
            $product_ranges = explode(";", $this->product_range_to_import);
            foreach ($product_ranges as $product_range) {
                $ranges = explode("-", $product_range);
                if (isset($ranges[0]) && isset($ranges[1]) && $ranges[1] >= $ranges[0]) {
                    $ranges_to_import[] = array('from' => $ranges[0], 'to' => $ranges[1]);
                }
            }
        }

        $settings = $this->getModuleSettings();
        $id_reference_column = $this->getReferenceColumn();
        $history = ElegantalEasyImportHistory::createNew($this->id);
        $combination_references = array(); // Used later to delete stock if combination does not exist in csv
        $skip_product_from_update_if_id_exists_in = explode(',', preg_replace("/[^0-9,]/", "", $settings['skip_product_from_update_if_id_exists_in']));
        $skip_product_from_update_if_reference_has_sign = explode(',', $settings['skip_product_from_update_if_reference_has_sign']);

        $row_count = 0;
        $insert_count = 0;
        $current_row = 0;
        while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
            $row_count++;
            if ($this->header_row > 0 && $this->header_row >= $row_count) {
                continue;
            }
            // Check if non-empty row. Remove spaces & tabs and utf-8 BOM and then check length of line
            $line_str = preg_replace("/[\s\t\"]+/", "", implode('', $data));
            $line_str = str_replace("\xEF\xBB\xBF", "", $line_str);
            if (Tools::strlen($line_str) <= 0) {
                continue;
            }

            if ($this->is_utf8_encode) {
                $data = array_map(array('ElegantalEasyImportTools', 'encodeUtf8'), $data);
            }

            $id_reference = "";
            if ($map['id_reference'] >= 0 && isset($data[$map['id_reference']])) {
                $id_reference = trim($data[$map['id_reference']]);
                $id_reference = trim($id_reference, "'");
                $id_reference = trim($id_reference, '"');
                // Add prefix to reference
                if ($this->find_products_by == 'reference' && $id_reference && strpos($this->product_reference_modifier, 'REFERENCE') !== false) {
                    $id_reference = str_replace("REFERENCE", $id_reference, $this->product_reference_modifier);
                }
                $data[$map['id_reference']] = $id_reference;
            }

            $current_row++;

            if ($ranges_to_import) {
                $exist_in_range = false;
                foreach ($ranges_to_import as $range) {
                    if ($current_row >= $range['from'] && $current_row <= $range['to']) {
                        $exist_in_range = true;
                        break;
                    }
                }
                if (!$exist_in_range) {
                    continue;
                }
            }

            // Skip this product if its ID exists in this array
            if ($this->find_products_by == 'id' && $settings['skip_product_from_update_if_id_exists_in'] && $id_reference && in_array($id_reference, $skip_product_from_update_if_id_exists_in)) {
                continue;
            }
            // Skip this product if the reference contains specified symbol
            // skip_product_from_update_if_reference_has_sign setting accepts multiple values separated by comma
            // We check if any symbols exist in $id_reference using str_replace method
            if ($this->find_products_by == 'reference' && $settings['skip_product_from_update_if_reference_has_sign'] && $id_reference && str_replace($skip_product_from_update_if_reference_has_sign, '', $id_reference) != $id_reference) {
                continue;
            }

            // Keep combination reference in array. It is used later to delete stock if combination does not exist in csv
            $combination_reference = "";
            if ($this->entity == 'combination') {
                $combination_reference = (isset($data[$map['combination_reference']]) && $data[$map['combination_reference']]) ? trim($data[$map['combination_reference']]) : trim($map_default_values['combination_reference']);
                if ($combination_reference) {
                    // Skip this combination if the combination reference contains specified symbol
                    if ($settings['skip_product_from_update_if_reference_has_sign'] && $combination_reference && str_replace($skip_product_from_update_if_reference_has_sign, '', $combination_reference) != $combination_reference) {
                        continue;
                    }
                    $combination_references[] = $combination_reference;
                }
            }

            // If "create_new_products" is disabled, make sure this product exists
            // If "update_existing_products" is disabled, make sure this product does not exists
            if (!$this->create_new_products || !$this->update_existing_products || ($this->create_new_products && $this->skip_if_no_stock)) {
                $quantity = (isset($data[$map['quantity']]) && $data[$map['quantity']]) ? trim($data[$map['quantity']]) : trim($map_default_values['quantity']);
                if ($this->entity == 'product') {
                    $product_exists = false;
                    if ($id_reference) {
                        $sql = "SELECT DISTINCT p.`id_product` FROM `" . _DB_PREFIX_ . "product` p ";
                        if ($this->find_products_by == 'supplier_reference' || $this->supplier_id) {
                            $sql .= "INNER JOIN `" . _DB_PREFIX_ . "product_supplier` ps ON (ps.`id_product` = p.`id_product` AND ps.`id_product_attribute` = 0) ";
                        }
                        $sql .= "WHERE " . pSQL($id_reference_column) . " = '" . pSQL($id_reference) . "' ";
                        if ($this->supplier_id) {
                            $sql .= "AND ps.`id_supplier` = " . (int) $this->supplier_id . " ";
                        }
                        $product_exists = Db::getInstance()->getValue($sql);
                    }
                    if ((!$this->create_new_products && !$product_exists) ||
                        (!$this->update_existing_products && $product_exists) ||
                        ($this->create_new_products && $this->skip_if_no_stock && !$product_exists && !$quantity)
                    ) {
                        continue;
                    }
                } elseif ($this->entity == 'combination') {
                    $combination_exists = false;
                    $combination_id = (isset($data[$map['combination_id']]) && $data[$map['combination_id']]) ? trim($data[$map['combination_id']]) : trim($map_default_values['combination_id']);
                    $combination_ean = (isset($data[$map['combination_ean']]) && $data[$map['combination_ean']]) ? trim($data[$map['combination_ean']]) : trim($map_default_values['combination_ean']);
                    $combination_supplier_reference = (isset($data[$map['supplier_reference']]) && $data[$map['supplier_reference']]) ? trim($data[$map['supplier_reference']]) : trim($map_default_values['supplier_reference']);
                    if ($combination_id) {
                        $sql = "SELECT DISTINCT pa.`id_product_attribute` FROM `" . _DB_PREFIX_ . "product_attribute` pa ";
                        if ($this->supplier_id) {
                            $sql .= "INNER JOIN `" . _DB_PREFIX_ . "product_supplier` ps ON (ps.`id_product` = pa.`id_product` AND ps.`id_product_attribute` = pa.`id_product_attribute`) ";
                        }
                        $sql .= "WHERE pa.`id_product_attribute` = " . (int) $combination_id . " ";
                        if ($this->supplier_id) {
                            $sql .= "AND ps.`id_supplier` = " . (int) $this->supplier_id . " ";
                        }
                        $combination_exists = (int) Db::getInstance()->getValue($sql);
                    }
                    if (!$combination_exists && $combination_reference) {
                        $sql = "SELECT DISTINCT pa.`id_product_attribute` FROM `" . _DB_PREFIX_ . "product_attribute` pa ";
                        if ($this->supplier_id) {
                            $sql .= "INNER JOIN `" . _DB_PREFIX_ . "product_supplier` ps ON (ps.`id_product` = pa.`id_product` AND ps.`id_product_attribute` = pa.`id_product_attribute`) ";
                        }
                        $sql .= "WHERE pa.`reference` = '" . pSQL($combination_reference) . "' ";
                        if ($this->supplier_id) {
                            $sql .= "AND ps.`id_supplier` = " . (int) $this->supplier_id . " ";
                        }
                        $combination_exists = (int) Db::getInstance()->getValue($sql);
                    }
                    if (!$combination_exists && $combination_ean) {
                        $sql = "SELECT DISTINCT pa.`id_product_attribute` FROM `" . _DB_PREFIX_ . "product_attribute` pa ";
                        if ($this->supplier_id) {
                            $sql .= "INNER JOIN `" . _DB_PREFIX_ . "product_supplier` ps ON (ps.`id_product` = pa.`id_product` AND ps.`id_product_attribute` = pa.`id_product_attribute`) ";
                        }
                        $sql .= "WHERE pa.`ean13` = '" . pSQL($combination_ean) . "' ";
                        if ($this->supplier_id) {
                            $sql .= "AND ps.`id_supplier` = " . (int) $this->supplier_id . " ";
                        }
                        $combination_exists = (int) Db::getInstance()->getValue($sql);
                    }
                    if (!$combination_exists && $combination_supplier_reference) {
                        $sql = "SELECT DISTINCT pa.`id_product_attribute` FROM `" . _DB_PREFIX_ . "product_attribute` pa ";
                        if ($this->supplier_id) {
                            $sql .= "INNER JOIN `" . _DB_PREFIX_ . "product_supplier` ps ON (ps.`id_product` = pa.`id_product` AND ps.`id_product_attribute` = pa.`id_product_attribute`) ";
                        }
                        $sql .= "WHERE pa.`supplier_reference` = '" . pSQL($combination_supplier_reference) . "' ";
                        if ($this->supplier_id) {
                            $sql .= "AND ps.`id_supplier` = " . (int) $this->supplier_id . " ";
                        }
                        $combination_exists = (int) Db::getInstance()->getValue($sql);
                    }
                    if ((!$this->create_new_products && !$combination_exists) ||
                        (!$this->update_existing_products && $combination_exists && !$this->delete_old_combinations) ||
                        ($this->create_new_products && $this->skip_if_no_stock && !$combination_exists && !$quantity)
                    ) {
                        continue;
                    }
                }
            }

            $sql = "INSERT INTO `" . _DB_PREFIX_ . "elegantaleasyimport_data` (`id_elegantaleasyimport`, `id_reference`, `csv_row`)
                VALUES(" . (int) $this->id . ", '" . pSQL($id_reference) . "', '" . pSQL(ElegantalEasyImportTools::serialize($data)) . "'); " . PHP_EOL;
            if (Db::getInstance()->execute($sql) == false) {
                throw new Exception(Db::getInstance()->getMsgError() . ' SQL: ' . $sql);
            }
            $insert_count++;

            // We need to update the history here because it may not reach to the end due to timeout or database error
            $history->total_number_of_products = $insert_count;
            $history->date_ended = date('Y-m-d H:i:s');
            $history->update();
        }
        fclose($handle);

        if ($insert_count < 1) {
            return 0;
        }

        $shop_ids = array();
        if ($this->update_products_on_all_shops) {
            $shop_groups = Shop::getTree();
            foreach ($shop_groups as $shop_group) {
                foreach ($shop_group['shops'] as $shop) {
                    $shop_ids[] = $shop['id_shop'];
                }
            }
        }
        if (empty($shop_ids)) {
            $shop_ids = array($id_shop);
        }

        // Enable products found in csv
        if ($this->enable_all_products_found_in_csv) {
            $sql = "UPDATE `" . _DB_PREFIX_ . "product_shop` psh
                INNER JOIN `" . _DB_PREFIX_ . "product` p ON (psh.`id_product` = p.`id_product`) ";
            if ($this->find_products_by == 'supplier_reference' || $this->supplier_id) {
                $sql .= "INNER JOIN `" . _DB_PREFIX_ . "product_supplier` ps ON (ps.`id_product` = p.`id_product` AND ps.`id_product_attribute` = 0) ";
            }
            $sql .= "SET psh.`active` = 1
                WHERE " . pSQL($id_reference_column) . " IN (SELECT c.`id_reference` FROM `" . _DB_PREFIX_ . "elegantaleasyimport_data` c WHERE c.`id_elegantaleasyimport` = " . (int) $this->id . ") ";
            if (!$this->update_products_on_all_shops) {
                $sql .= "AND psh.`id_shop` = " . (int) $id_shop . " ";
            }
            if ($this->supplier_id) {
                $sql .= "AND ps.`id_supplier` = " . (int) $this->supplier_id . " ";
            }
            if ($settings['skip_product_from_update_if_id_exists_in'] && $skip_product_from_update_if_id_exists_in && is_array($skip_product_from_update_if_id_exists_in)) {
                $sql .= "AND p.`id_product` NOT IN (" . implode(", ", array_map("intval", $skip_product_from_update_if_id_exists_in)) . ") ";
            }
            if ($settings['skip_product_from_update_if_reference_has_sign']) {
                foreach ($skip_product_from_update_if_reference_has_sign as $sign) {
                    $sql .= "AND p.`reference` NOT LIKE '%" . pSQL($sign) . "%' ";
                }
            }
            if (Db::getInstance()->execute($sql) == false) {
                throw new Exception(Db::getInstance()->getMsgError() . ' SQL: ' . $sql);
            }
        }

        // Disable products not found in csv.
        // This works only if "Update existing products" is enabled. Otherwise it may disable many products even if they exist in file.
        // This works only if "Product range to import" is not used. Otherwise it may disable many products even if they exist in file.
        if ($this->disable_all_products_not_found_in_csv && $this->update_existing_products && !$this->product_range_to_import) {
            $sql = "UPDATE `" . _DB_PREFIX_ . "product_shop` psh
                INNER JOIN `" . _DB_PREFIX_ . "product` p ON (psh.`id_product` = p.`id_product`) ";
            if ($this->find_products_by == 'supplier_reference' || $this->supplier_id) {
                $sql .= "INNER JOIN `" . _DB_PREFIX_ . "product_supplier` ps ON (ps.`id_product` = p.`id_product` AND ps.`id_product_attribute` = 0) ";
            }
            $sql .= "SET psh.`active` = 0
                WHERE " . pSQL($id_reference_column) . " NOT IN (SELECT c.`id_reference` FROM `" . _DB_PREFIX_ . "elegantaleasyimport_data` c WHERE c.`id_elegantaleasyimport` = " . (int) $this->id . ") ";
            if (!$this->update_products_on_all_shops) {
                $sql .= "AND psh.`id_shop` = " . (int) $id_shop . " ";
            }
            if ($this->supplier_id) {
                $sql .= "AND ps.`id_supplier` = " . (int) $this->supplier_id . " ";
            }
            $product_ids_to_exclude = explode(',', preg_replace("/[^0-9,]/", "", $settings['product_ids_to_exclude_from_deactivation']));
            if ($product_ids_to_exclude && is_array($product_ids_to_exclude)) {
                $sql .= "AND p.`id_product` NOT IN (" . implode(", ", array_map("intval", $product_ids_to_exclude)) . ")";
            }
            if ($settings['skip_product_from_update_if_id_exists_in'] && $skip_product_from_update_if_id_exists_in && is_array($skip_product_from_update_if_id_exists_in)) {
                $sql .= "AND p.`id_product` NOT IN (" . implode(", ", array_map("intval", $skip_product_from_update_if_id_exists_in)) . ") ";
            }
            if ($settings['skip_product_from_update_if_reference_has_sign']) {
                foreach ($skip_product_from_update_if_reference_has_sign as $sign) {
                    $sql .= "AND p.`reference` NOT LIKE '%" . pSQL($sign) . "%' ";
                }
            }
            if (Db::getInstance()->execute($sql) == false) {
                throw new Exception(Db::getInstance()->getMsgError() . ' SQL: ' . $sql);
            }
        }

        // Deny orders when out of stock for products not found in import file.
        // This works only if "Update existing products" is enabled. Otherwise it may deny many products even if they exist in file.
        // This works only if "Product range to import" is not used. Otherwise it may deny many products even if they exist in file.
        if ($this->deny_orders_when_no_stock_for_products_not_found_in_file && $this->update_existing_products && !$this->product_range_to_import) {
            $sql = "UPDATE `" . _DB_PREFIX_ . "stock_available` sa
                INNER JOIN `" . _DB_PREFIX_ . "product` p ON (sa.`id_product` = p.`id_product`) ";
            if ($this->find_products_by == 'supplier_reference' || $this->supplier_id) {
                $sql .= "INNER JOIN `" . _DB_PREFIX_ . "product_supplier` ps ON (ps.`id_product` = p.`id_product` AND ps.`id_product_attribute` = 0) ";
            }
            $sql .= "SET sa.`out_of_stock` = 0
                WHERE " . pSQL($id_reference_column) . " NOT IN (SELECT c.`id_reference` FROM `" . _DB_PREFIX_ . "elegantaleasyimport_data` c WHERE c.`id_elegantaleasyimport` = " . (int) $this->id . ") ";
            if (!$this->update_products_on_all_shops) {
                $sql .= "AND sa.`id_shop` = " . (int) $id_shop . " ";
            }
            if ($this->supplier_id) {
                $sql .= "AND ps.`id_supplier` = " . (int) $this->supplier_id . " ";
            }
            $product_ids_to_exclude = explode(',', preg_replace("/[^0-9,]/", "", $settings['product_ids_to_exclude_from_deactivation']));
            if ($product_ids_to_exclude && is_array($product_ids_to_exclude)) {
                $sql .= "AND p.`id_product` NOT IN (" . implode(", ", array_map("intval", $product_ids_to_exclude)) . ")";
            }
            if ($settings['skip_product_from_update_if_id_exists_in'] && $skip_product_from_update_if_id_exists_in && is_array($skip_product_from_update_if_id_exists_in)) {
                $sql .= "AND p.`id_product` NOT IN (" . implode(", ", array_map("intval", $skip_product_from_update_if_id_exists_in)) . ") ";
            }
            if ($settings['skip_product_from_update_if_reference_has_sign']) {
                foreach ($skip_product_from_update_if_reference_has_sign as $sign) {
                    $sql .= "AND p.`reference` NOT LIKE '%" . pSQL($sign) . "%' ";
                }
            }
            if (Db::getInstance()->execute($sql) == false) {
                throw new Exception(Db::getInstance()->getMsgError() . ' SQL: ' . $sql);
            }
        }

        // Delete stock for products/combinations not found in csv.
        // This works only if "Update existing products" is enabled. Otherwise it may disable many products even if they exist in file.
        // This works only if "Product range to import" is not used. Otherwise it may delete stock for many products even if they exist in file.
        if ($this->delete_stock_for_products_not_found_in_csv && $this->update_existing_products && !$this->product_range_to_import) {
            if ($map['id_reference'] >= 0) {
                $sql = "SELECT DISTINCT psh.`id_product` FROM `" . _DB_PREFIX_ . "product_shop` psh
                    INNER JOIN `" . _DB_PREFIX_ . "product` p ON (psh.`id_product` = p.`id_product`) ";
                if ($this->find_products_by == 'supplier_reference' || $this->supplier_id) {
                    $sql .= "INNER JOIN `" . _DB_PREFIX_ . "product_supplier` ps ON (ps.`id_product` = p.`id_product` AND ps.`id_product_attribute` = 0) ";
                }
                $sql .= "WHERE " . pSQL($id_reference_column) . " NOT IN (SELECT c.`id_reference` FROM `" . _DB_PREFIX_ . "elegantaleasyimport_data` c WHERE c.`id_elegantaleasyimport` = " . (int) $this->id . ") ";
                if (!$this->update_products_on_all_shops) {
                    $sql .= "AND psh.`id_shop` = " . (int) $id_shop . " ";
                }
                if ($this->supplier_id) {
                    $sql .= "AND ps.`id_supplier` = " . (int) $this->supplier_id . " ";
                }
                if ($settings['skip_product_from_update_if_id_exists_in'] && $skip_product_from_update_if_id_exists_in && is_array($skip_product_from_update_if_id_exists_in)) {
                    $sql .= "AND p.`id_product` NOT IN (" . implode(", ", array_map("intval", $skip_product_from_update_if_id_exists_in)) . ") ";
                }
                if ($settings['skip_product_from_update_if_reference_has_sign']) {
                    foreach ($skip_product_from_update_if_reference_has_sign as $sign) {
                        $sql .= "AND p.`reference` NOT LIKE '%" . pSQL($sign) . "%' ";
                    }
                }
                $rows = Db::getInstance()->executeS($sql);
                if ($rows && is_array($rows)) {
                    Shop::setContext(Shop::CONTEXT_SHOP, $id_shop);
                    foreach ($rows as $row) {
                        $product = new Product($row['id_product']);
                        if (!Validate::isLoadedObject($product)) {
                            continue;
                        }
                        $combinations = $product->getAttributeCombinations($this->context->language->id);
                        if ($combinations && is_array($combinations)) {
                            foreach ($combinations as $combination) {
                                // Skip this combination if the combination reference contains specified symbol
                                if ($settings['skip_product_from_update_if_reference_has_sign'] && $combination['reference'] && str_replace($skip_product_from_update_if_reference_has_sign, '', $combination['reference']) != $combination['reference']) {
                                    continue;
                                }
                                foreach ($shop_ids as $sh_id) {
                                    StockAvailable::setQuantity($row['id_product'], $combination['id_product_attribute'], 0, $sh_id);
                                }
                            }
                        } else {
                            foreach ($shop_ids as $sh_id) {
                                StockAvailable::setQuantity($row['id_product'], null, 0, $sh_id);
                            }
                        }
                    }
                    Shop::setContext($context_shop, $id_shop);
                }
            }
            if ($this->entity == 'combination' && !$this->delete_old_combinations && $map['combination_reference'] >= 0 && $combination_references) {
                $sql = "SELECT pa.`id_product`, pa.`id_product_attribute` FROM `" . _DB_PREFIX_ . "product_attribute` pa ";
                if ($this->supplier_id) {
                    $sql .= "INNER JOIN `" . _DB_PREFIX_ . "product_supplier` ps ON (ps.`id_product` = pa.`id_product` AND ps.`id_product_attribute` = pa.`id_product_attribute`) ";
                }
                $sql .= "WHERE pa.`reference` NOT IN (";
                foreach ($combination_references as $key => $c_ref) {
                    $sql .= $key > 0 ? "," : "";
                    $sql .= "'" . pSQL($c_ref) . "'";
                }
                $sql .= ") ";
                if ($this->supplier_id) {
                    $sql .= "AND ps.`id_supplier` = " . (int) $this->supplier_id . " ";
                }
                if ($settings['skip_product_from_update_if_id_exists_in'] && $skip_product_from_update_if_id_exists_in && is_array($skip_product_from_update_if_id_exists_in)) {
                    $sql .= "AND pa.`id_product` NOT IN (" . implode(", ", array_map("intval", $skip_product_from_update_if_id_exists_in)) . ") ";
                }
                if ($settings['skip_product_from_update_if_reference_has_sign']) {
                    foreach ($skip_product_from_update_if_reference_has_sign as $sign) {
                        $sql .= "AND pa.`reference` NOT LIKE '%" . pSQL($sign) . "%' ";
                    }
                }
                $sql .= "GROUP BY pa.`id_product`, pa.`id_product_attribute` ";
                $rows = Db::getInstance()->executeS($sql);
                if ($rows && is_array($rows)) {
                    Shop::setContext(Shop::CONTEXT_SHOP, $id_shop);
                    foreach ($rows as $row) {
                        foreach ($shop_ids as $sh_id) {
                            StockAvailable::setQuantity($row['id_product'], $row['id_product_attribute'], 0, $sh_id);
                        }
                    }
                    Shop::setContext($context_shop, $id_shop);
                }
            }
        }

        // Delete old combinations
        if ($this->entity == 'combination' && $this->delete_old_combinations) {
            $sql = "DELETE pac FROM `" . _DB_PREFIX_ . "product_attribute_combination` pac
                INNER JOIN `" . _DB_PREFIX_ . "product_attribute` pa ON pac.`id_product_attribute` = pa.`id_product_attribute`
                INNER JOIN `" . _DB_PREFIX_ . "product` p ON pa.`id_product` = p.`id_product` ";
            if ($this->find_products_by == 'supplier_reference') {
                $sql .= "INNER JOIN `" . _DB_PREFIX_ . "product_supplier` ps ON (ps.`id_product` = pa.`id_product` AND ps.`id_product_attribute` = pa.`id_product_attribute`) ";
            }
            $sql .= "INNER JOIN `" . _DB_PREFIX_ . "elegantaleasyimport_data` ec ON " . pSQL($id_reference_column) . " = ec.`id_reference`
                WHERE ec.`id_elegantaleasyimport` = " . (int) $this->id . " ";
            if ($settings['skip_product_from_update_if_id_exists_in'] && $skip_product_from_update_if_id_exists_in && is_array($skip_product_from_update_if_id_exists_in)) {
                $sql .= "AND p.`id_product` NOT IN (" . implode(", ", array_map("intval", $skip_product_from_update_if_id_exists_in)) . ") ";
            }
            if ($settings['skip_product_from_update_if_reference_has_sign']) {
                foreach ($skip_product_from_update_if_reference_has_sign as $sign) {
                    $sql .= "AND p.`reference` NOT LIKE '%" . pSQL($sign) . "%' ";
                    $sql .= "AND pa.`reference` NOT LIKE '%" . pSQL($sign) . "%' ";
                }
            }
            $sql .= "; ";

            $sql .= "DELETE pai FROM `" . _DB_PREFIX_ . "product_attribute_image` pai
                INNER JOIN `" . _DB_PREFIX_ . "product_attribute` pa ON pai.`id_product_attribute` = pa.`id_product_attribute`
                INNER JOIN `" . _DB_PREFIX_ . "product` p ON pa.`id_product` = p.`id_product` ";
            if ($this->find_products_by == 'supplier_reference') {
                $sql .= "INNER JOIN `" . _DB_PREFIX_ . "product_supplier` ps ON (ps.`id_product` = pa.`id_product` AND ps.`id_product_attribute` = pa.`id_product_attribute`) ";
            }
            $sql .= "INNER JOIN `" . _DB_PREFIX_ . "elegantaleasyimport_data` ec ON " . pSQL($id_reference_column) . " = ec.`id_reference`
                WHERE ec.`id_elegantaleasyimport` = " . (int) $this->id . " ";
            if ($settings['skip_product_from_update_if_id_exists_in'] && $skip_product_from_update_if_id_exists_in && is_array($skip_product_from_update_if_id_exists_in)) {
                $sql .= "AND p.`id_product` NOT IN (" . implode(", ", array_map("intval", $skip_product_from_update_if_id_exists_in)) . ") ";
            }
            if ($settings['skip_product_from_update_if_reference_has_sign']) {
                foreach ($skip_product_from_update_if_reference_has_sign as $sign) {
                    $sql .= "AND p.`reference` NOT LIKE '%" . pSQL($sign) . "%' ";
                    $sql .= "AND pa.`reference` NOT LIKE '%" . pSQL($sign) . "%' ";
                }
            }
            $sql .= "; ";

            $sql .= "DELETE sa FROM `" . _DB_PREFIX_ . "stock_available` sa
                INNER JOIN `" . _DB_PREFIX_ . "product_attribute` pa ON sa.`id_product_attribute` = pa.`id_product_attribute`
                INNER JOIN `" . _DB_PREFIX_ . "product` p ON sa.`id_product` = p.`id_product` ";
            if ($this->find_products_by == 'supplier_reference') {
                $sql .= "INNER JOIN `" . _DB_PREFIX_ . "product_supplier` ps ON (ps.`id_product` = pa.`id_product` AND ps.`id_product_attribute` = pa.`id_product_attribute`) ";
            }
            $sql .= "INNER JOIN `" . _DB_PREFIX_ . "elegantaleasyimport_data` ec ON " . pSQL($id_reference_column) . " = ec.`id_reference`
                WHERE sa.`id_product_attribute` != 0 AND ec.`id_elegantaleasyimport` = " . (int) $this->id . " ";
            if ($settings['skip_product_from_update_if_id_exists_in'] && $skip_product_from_update_if_id_exists_in && is_array($skip_product_from_update_if_id_exists_in)) {
                $sql .= "AND p.`id_product` NOT IN (" . implode(", ", array_map("intval", $skip_product_from_update_if_id_exists_in)) . ") ";
            }
            if ($settings['skip_product_from_update_if_reference_has_sign']) {
                foreach ($skip_product_from_update_if_reference_has_sign as $sign) {
                    $sql .= "AND p.`reference` NOT LIKE '%" . pSQL($sign) . "%' ";
                    $sql .= "AND pa.`reference` NOT LIKE '%" . pSQL($sign) . "%' ";
                }
            }
            $sql .= "; ";

            $sql .= "DELETE pas FROM `" . _DB_PREFIX_ . "product_attribute_shop` pas
                INNER JOIN `" . _DB_PREFIX_ . "product_attribute` pa ON pas.`id_product_attribute` = pa.`id_product_attribute`
                INNER JOIN `" . _DB_PREFIX_ . "product` p ON pas.`id_product` = p.`id_product` ";
            if ($this->find_products_by == 'supplier_reference') {
                $sql .= "INNER JOIN `" . _DB_PREFIX_ . "product_supplier` ps ON (ps.`id_product` = pa.`id_product` AND ps.`id_product_attribute` = pa.`id_product_attribute`) ";
            }
            $sql .= "INNER JOIN `" . _DB_PREFIX_ . "elegantaleasyimport_data` ec ON " . pSQL($id_reference_column) . " = ec.`id_reference`
                WHERE ec.`id_elegantaleasyimport` = " . (int) $this->id . " ";
            if ($settings['skip_product_from_update_if_id_exists_in'] && $skip_product_from_update_if_id_exists_in && is_array($skip_product_from_update_if_id_exists_in)) {
                $sql .= "AND p.`id_product` NOT IN (" . implode(", ", array_map("intval", $skip_product_from_update_if_id_exists_in)) . ") ";
            }
            if ($settings['skip_product_from_update_if_reference_has_sign']) {
                foreach ($skip_product_from_update_if_reference_has_sign as $sign) {
                    $sql .= "AND p.`reference` NOT LIKE '%" . pSQL($sign) . "%' ";
                    $sql .= "AND pa.`reference` NOT LIKE '%" . pSQL($sign) . "%' ";
                }
            }
            $sql .= "; ";

            $sql .= "DELETE pa FROM `" . _DB_PREFIX_ . "product_attribute` pa
                INNER JOIN `" . _DB_PREFIX_ . "product` p ON pa.`id_product` = p.`id_product` ";
            if ($this->find_products_by == 'supplier_reference') {
                $sql .= "INNER JOIN `" . _DB_PREFIX_ . "product_supplier` ps ON (ps.`id_product` = pa.`id_product` AND ps.`id_product_attribute` = pa.`id_product_attribute`) ";
            }
            $sql .= "INNER JOIN `" . _DB_PREFIX_ . "elegantaleasyimport_data` ec ON " . pSQL($id_reference_column) . " = ec.`id_reference`
                WHERE ec.`id_elegantaleasyimport` = " . (int) $this->id . " ";
            if ($settings['skip_product_from_update_if_id_exists_in'] && $skip_product_from_update_if_id_exists_in && is_array($skip_product_from_update_if_id_exists_in)) {
                $sql .= "AND p.`id_product` NOT IN (" . implode(", ", array_map("intval", $skip_product_from_update_if_id_exists_in)) . ") ";
            }
            if ($settings['skip_product_from_update_if_reference_has_sign']) {
                foreach ($skip_product_from_update_if_reference_has_sign as $sign) {
                    $sql .= "AND p.`reference` NOT LIKE '%" . pSQL($sign) . "%' ";
                    $sql .= "AND pa.`reference` NOT LIKE '%" . pSQL($sign) . "%' ";
                }
            }
            $sql .= "; ";

            $sql .= "DELETE sp FROM `" . _DB_PREFIX_ . "specific_price` sp
                INNER JOIN `" . _DB_PREFIX_ . "product_attribute` pa ON sp.`id_product_attribute` = pa.`id_product_attribute`
                INNER JOIN `" . _DB_PREFIX_ . "product` p ON sp.`id_product` = p.`id_product` ";
            if ($this->find_products_by == 'supplier_reference') {
                $sql .= "INNER JOIN `" . _DB_PREFIX_ . "product_supplier` ps ON (ps.`id_product` = pa.`id_product` AND ps.`id_product_attribute` = pa.`id_product_attribute`) ";
            }
            $sql .= "INNER JOIN `" . _DB_PREFIX_ . "elegantaleasyimport_data` ec ON " . pSQL($id_reference_column) . " = ec.`id_reference`
                WHERE sp.`id_product_attribute` != 0 AND ec.`id_elegantaleasyimport` = " . (int) $this->id . " ";
            if ($settings['skip_product_from_update_if_id_exists_in'] && $skip_product_from_update_if_id_exists_in && is_array($skip_product_from_update_if_id_exists_in)) {
                $sql .= "AND p.`id_product` NOT IN (" . implode(", ", array_map("intval", $skip_product_from_update_if_id_exists_in)) . ") ";
            }
            if ($settings['skip_product_from_update_if_reference_has_sign']) {
                foreach ($skip_product_from_update_if_reference_has_sign as $sign) {
                    $sql .= "AND p.`reference` NOT LIKE '%" . pSQL($sign) . "%' ";
                    $sql .= "AND pa.`reference` NOT LIKE '%" . pSQL($sign) . "%' ";
                }
            }
            $sql .= "; ";

            $sql .= "UPDATE `" . _DB_PREFIX_ . "product_shop` SET `cache_default_attribute` = 0 WHERE `cache_default_attribute` IS NOT NULL AND `cache_default_attribute` != 0 AND `cache_default_attribute` NOT IN (SELECT DISTINCT `id_product_attribute` FROM `" . _DB_PREFIX_ . "product_attribute`); ";
            $sql .= "UPDATE `" . _DB_PREFIX_ . "product` SET `cache_default_attribute` = 0 WHERE `cache_default_attribute` IS NOT NULL AND `cache_default_attribute` != 0 AND `cache_default_attribute` NOT IN (SELECT DISTINCT `id_product_attribute` FROM `" . _DB_PREFIX_ . "product_attribute`); ";

            Db::getInstance()->execute($sql);
        }

        return $insert_count;
    }

    public function import($limit)
    {
        // This currentHistory is used in other functions below
        $this->currentHistory = $this->getLastHistory();

        $settings = $this->getModuleSettings();
        if (isset($settings['is_allow_hook_exec_after_product_save']) && !$settings['is_allow_hook_exec_after_product_save'] && !defined('PS_INSTALLATION_IN_PROGRESS')) {
            define('PS_INSTALLATION_IN_PROGRESS', true);
        }

        if ($this->entity == 'product') {
            $this->importProducts($limit);
        } elseif ($this->entity == 'combination') {
            $this->importCombinations($limit);
        } else {
            throw new Exception('Unknown import entity.');
        }

        $this->currentHistory->date_ended = date('Y-m-d H:i:s');
        $this->currentHistory->update();

        // Action to call at the end of the import process if the import was by CRON and all rows were processed
        if ($this->is_cron && $this->currentHistory->total_number_of_products == $this->currentHistory->number_of_products_processed) {
            $this->actionAfterImport();
        }

        $result = array(
            'processed' => $this->currentHistory->number_of_products_processed,
            'created' => $this->currentHistory->number_of_products_created,
            'updated' => $this->currentHistory->number_of_products_updated,
            'deleted' => $this->currentHistory->number_of_products_deleted,
            'errors' => $this->currentHistory->getErrorsCount(),
        );

        return $result;
    }

    public function importProducts($limit)
    {
        $map = $this->getMap();
        $map_default_values = $this->getMapDefaultValues();
        $category_map_keys = $this->getCategoryMapKeys($map);
        $file = ElegantalEasyImportTools::getRealPath($this->csv_file);
        $csv_header = ElegantalEasyImportCsv::getCsvHeaderRow($file, $this->header_row, $this->is_utf8_encode);
        $id_shop_context = $this->context->shop->id;
        $context_shop = Shop::getContext();
        $settings = $this->getModuleSettings();
        $rootCategory = Category::getRootCategory();
        $multiple_value_separator = $this->multiple_value_separator;
        $multiple_subcategory_separator = $this->multiple_subcategory_separator;
        $update_products_on_all_shops = $this->update_products_on_all_shops && Shop::isFeatureActive();
        $category_mapping = ElegantalEasyImportCategoryMap::getCategoryMappingByRule($this->id);
        $ps_weight_unit = Configuration::get('PS_WEIGHT_UNIT');
        $ps_dimension_unit = Configuration::get('PS_DIMENSION_UNIT');
        $skip_product_from_update_if_reference_has_sign = explode(',', $settings['skip_product_from_update_if_reference_has_sign']);

        $shop_ids = array();
        if ($update_products_on_all_shops) {
            $shop_groups = Shop::getTree();
            foreach ($shop_groups as $shop_group) {
                foreach ($shop_group['shops'] as $shop) {
                    $shop_ids[] = $shop['id_shop'];
                }
            }
        }
        if (empty($shop_ids)) {
            $shop_ids = array($id_shop_context);
        }

        $csvRows = ElegantalEasyImportData::model()->findAll(array(
            'condition' => array(
                'id_elegantaleasyimport' => $this->id,
            ),
            'limit' => $limit,
        ));

        foreach ($csvRows as $csvRow) {
            $csvRowModel = new ElegantalEasyImportData($csvRow['id_elegantaleasyimport_data']);
            if (!Validate::isLoadedObject($csvRowModel)) {
                continue;
            }

            $line = ElegantalEasyImportTools::unserialize($csvRowModel->csv_row);

            // We don't need this row in database anymore
            $csvRowModel->delete();

            $this->currentHistory->number_of_products_processed++;

            // We need this update because the current row is already deleted and number_of_products_processed should be saved.
            // It may fail to save by the end of importing this row.
            $this->currentHistory->update();

            $id_reference_index = $map['id_reference'];
            $id_reference = "";
            if (isset($line[$id_reference_index])) {
                $id_reference = trim($line[$id_reference_index]);
            }
            $this->current_id_reference = $id_reference;

            // If shop is given in import file, use it for the context
            $shop_map = (isset($line[$map['shop']]) && $line[$map['shop']]) ? $line[$map['shop']] : $map_default_values['shop'];
            $id_shop_map = $this->getShopIdByName($shop_map);
            if ($id_shop_map) {
                $id_shop = $id_shop_map;
                $shop_ids = array($id_shop);
                Shop::setContext(Shop::CONTEXT_SHOP, $id_shop);
            } else {
                $id_shop = $this->context->shop->id;
            }

            // Check with category mapping
            if ($category_mapping) {
                // Prepare file categories for checking
                $categories_to_check = array();
                $current_category_to_check = "";
                foreach ($category_map_keys as $categories_attr) {
                    if ($map[$categories_attr] >= 0 && isset($line[$map[$categories_attr]]) && $line[$map[$categories_attr]]) {
                        if ($multiple_subcategory_separator) {
                            $category_names = explode($multiple_value_separator, $line[$map[$categories_attr]]);
                            foreach ($category_names as $category_name) {
                                $categories_to_check[] = $category_name;
                            }
                        } else {
                            $current_category_to_check .= $current_category_to_check ? $multiple_value_separator : "";
                            $current_category_to_check .= $line[$map[$categories_attr]];
                            $categories_to_check[] = $current_category_to_check;
                        }
                    }
                }
                // Check if file categories are allowed/disallowed
                if ($categories_to_check) {
                    if (isset($category_mapping['categories_disallowed']) && $category_mapping['categories_disallowed']) {
                        $categories_disallowed_found = false;
                        foreach ($categories_to_check as $category_to_check) {
                            if (in_array($category_to_check, $category_mapping['categories_disallowed'])) {
                                $categories_disallowed_found = true;
                                break;
                            }
                        }
                        if ($categories_disallowed_found) {
                            $this->addError("Disallowed category found.");
                            continue;
                        }
                    }
                    if (isset($category_mapping['categories_allowed']) && $category_mapping['categories_allowed']) {
                        $categories_allowed_found = false;
                        foreach ($categories_to_check as $category_to_check) {
                            if (in_array($category_to_check, $category_mapping['categories_allowed'])) {
                                $categories_allowed_found = true;
                                break;
                            }
                        }
                        if (!$categories_allowed_found) {
                            $this->addError("Allowed category not found.");
                            continue;
                        }
                    }
                }
                // Check if file manufacturers are allowed/disallowed
                if ($map['manufacturer'] >= 0 && isset($line[$map['manufacturer']]) && $line[$map['manufacturer']]) {
                    if (isset($category_mapping['manufacturers_disallowed']) && $category_mapping['manufacturers_disallowed'] && in_array($line[$map['manufacturer']], $category_mapping['manufacturers_disallowed'])) {
                        $this->addError("Disallowed brand found.");
                        continue;
                    }
                    if (isset($category_mapping['manufacturers_allowed']) && $category_mapping['manufacturers_allowed'] && !in_array($line[$map['manufacturer']], $category_mapping['manufacturers_allowed'])) {
                        $this->addError("Allowed brand not found.");
                        continue;
                    }
                }
                // Replace categories if there is category mapping
                if (isset($category_mapping['categories_map']) && $category_mapping['categories_map']) {
                    $category_map_keys[] = 'default_category';
                    $current_category_to_check = "";
                    foreach ($category_map_keys as $categories_attr) {
                        if ($map[$categories_attr] >= 0 && isset($line[$map[$categories_attr]]) && $line[$map[$categories_attr]]) {
                            if ($multiple_subcategory_separator) {
                                $category_names = explode($multiple_value_separator, $line[$map[$categories_attr]]);
                                foreach ($category_names as $key => $category_name) {
                                    $category_map_found = false;
                                    $extracted_subcategories = "";
                                    do {
                                        foreach ($category_mapping['categories_map'] as $categories_map) {
                                            if ($categories_map['csv_category'] == $category_name && $categories_map['shop_category_id']) {
                                                if ($category_map_found) {
                                                    $category_names[$key] .= $multiple_value_separator . $categories_map['shop_category_id'];
                                                } else {
                                                    $category_map_found = true;
                                                    $category_names[$key] = $categories_map['shop_category_id'] . ($extracted_subcategories ? $multiple_subcategory_separator . $extracted_subcategories : "");
                                                }
                                            }
                                        }
                                        if (!$category_map_found) {
                                            $subcategories = explode($multiple_subcategory_separator, $category_name);
                                            $extracted_subcategories = array_pop($subcategories) . ($extracted_subcategories ? $multiple_subcategory_separator . $extracted_subcategories : "");
                                            $category_name = implode($multiple_subcategory_separator, $subcategories);
                                        }
                                    } while (!$category_map_found && $category_name);
                                }
                                $line[$map[$categories_attr]] = implode($multiple_value_separator, $category_names);
                            } else {
                                $current_category_to_check .= $current_category_to_check ? $multiple_value_separator : "";
                                $line_category = $line[$map[$categories_attr]];

                                $category_map_found = false;
                                $extracted_subcategories = "";
                                do {
                                    foreach ($category_mapping['categories_map'] as $categories_map) {
                                        if ($categories_map['csv_category'] == $current_category_to_check . $line_category && $categories_map['shop_category_id']) {
                                            if ($category_map_found) {
                                                $line[$map[$categories_attr]] .= $multiple_value_separator . $categories_map['shop_category_id'];
                                            } else {
                                                $category_map_found = true;
                                                $line[$map[$categories_attr]] = $categories_map['shop_category_id'];
                                            }
                                        }
                                    }
                                    if (!$category_map_found) {
                                        $subcategories = explode($multiple_value_separator, $line[$map[$categories_attr]]);
                                        $extracted_subcategories = array_pop($subcategories) . ($extracted_subcategories ? $multiple_value_separator . $extracted_subcategories : "");
                                        $line[$map[$categories_attr]] = implode($multiple_value_separator, $subcategories);
                                    }
                                } while (!$category_map_found && $line[$map[$categories_attr]]);
                                $line[$map[$categories_attr]] .= (($line[$map[$categories_attr]] && $extracted_subcategories) ? $multiple_value_separator : "") . $extracted_subcategories;
                                $current_category_to_check .= $line_category;
                            }
                        }
                    }
                }
            }

            $id_reference_column = $this->getReferenceColumn();

            $products_rows = array();
            if ($id_reference) {
                $sql = "SELECT DISTINCT p.`id_product` FROM `" . _DB_PREFIX_ . "product` p ";
                if ($this->find_products_by == 'supplier_reference' || $this->supplier_id) {
                    $sql .= "INNER JOIN `" . _DB_PREFIX_ . "product_supplier` ps ON (ps.`id_product` = p.`id_product` AND ps.`id_product_attribute` = 0) ";
                }
                $sql .= "WHERE " . pSQL($id_reference_column) . " = '" . pSQL($id_reference) . "' ";
                if ($this->supplier_id) {
                    $sql .= "AND ps.`id_supplier` = " . (int) $this->supplier_id . " ";
                }
                $products_rows = Db::getInstance()->executeS($sql);
            }

            if (empty($products_rows) || !is_array($products_rows)) {
                $products_rows = array(
                    array('id_product' => null),
                );
            }

            foreach ($products_rows as $product_row) {
                try {
                    $product = null;
                    $id_product_attribute = 0;
                    $product_categories_ids = array();

                    if ($product_row && isset($product_row['id_product']) && $product_row['id_product'] > 0) {
                        $id_shop_for_product = $id_shop;
                        if ($update_products_on_all_shops) {
                            if (isset($product_row['id_shop_default']) && $product_row['id_shop_default'] != $id_shop) {
                                $id_shop_for_product = $product_row['id_shop_default'];
                            }
                        } elseif ($this->find_products_by != 'id') {
                            // Check if product exists in context shop
                            $sql = "SELECT `id_product` FROM `" . _DB_PREFIX_ . "product_shop` WHERE `id_product` = " . (int) $product_row['id_product'] . " AND `id_shop` = " . (int) $id_shop;
                            $product_exists_in_current_shop = (int) Db::getInstance()->getValue($sql);
                            if (!$product_exists_in_current_shop) {
                                continue;
                            }
                        }
                        $product = new Product($product_row['id_product'], false, null, $id_shop_for_product);
                    }
                    if ($product_row && isset($product_row['id_product_attribute']) && $product_row['id_product_attribute'] > 0) {
                        $id_product_attribute = (int) $product_row['id_product_attribute'];
                    }

                    if (Validate::isLoadedObject($product)) {
                        if ($settings['skip_product_from_update_if_id_exists_in']) {
                            $skip_product_from_update_if_id_exists_in = explode(',', preg_replace("/[^0-9,]/", "", $settings['skip_product_from_update_if_id_exists_in']));
                            if ($skip_product_from_update_if_id_exists_in && is_array($skip_product_from_update_if_id_exists_in) && in_array($product->id, $skip_product_from_update_if_id_exists_in)) {
                                continue;
                            }
                        }
                        if ($settings['skip_product_from_update_if_reference_has_sign'] && $product->reference && str_replace($skip_product_from_update_if_reference_has_sign, '', $product->reference) != $product->reference) {
                            continue;
                        }
                        if ($this->update_existing_products) {
                            $delete_product = ($map['delete_product'] >= 0 && isset($line[$map['delete_product']]) && $line[$map['delete_product']]) ? $line[$map['delete_product']] : $map_default_values['delete_product'];
                            if ($delete_product && $this->isCsvValueTrue($delete_product)) {
                                if ($product->delete() && $settings['employee_id_for_events_log']) {
                                    PrestaShopLogger::addLog('Product deletion', 1, null, 'Product', $product->id, true, (int) $settings['employee_id_for_events_log']);
                                }
                                $this->currentHistory->number_of_products_deleted++;
                                continue;
                            }
                            // Load additional properties to the product
                            $product->quantity = StockAvailable::getQuantityAvailableByProduct($product->id, $id_product_attribute);
                            $product->tax_rate = $product->getTaxesRate(new Address());
                            $product->unit_price = ($product->unit_price_ratio != 0) ? ($product->price / $product->unit_price_ratio) : 0;
                            $product->out_of_stock = StockAvailable::outOfStock($product->id);
                            $product->depends_on_stock = (int) StockAvailable::dependsOnStock($product->id);
                        } else {
                            $product = null;
                            $this->addError("Updating product not allowed.");
                        }
                    } else {
                        if (!$this->create_new_products) {
                            continue;
                        }
                        if ($this->create_new_products && (($map['name_' . $this->id_lang_default] >= 0 && isset($line[$map['name_' . $this->id_lang_default]]) && trim($line[$map['name_' . $this->id_lang_default]])) || (trim($map_default_values['name_' . $this->id_lang_default]))) && ($id_reference_index < 0 || $id_reference)) {
                            // New product must have name and reference must be either skipped or must have value, because empty reference is not allowed for new products
                            $product = new Product();
                            // Don't allow new product if price is less than MIN PRICE
                            if ($this->min_price_amount > 0) {
                                $price_tax_excluded = ($map['price_tax_excluded'] >= 0 && isset($line[$map['price_tax_excluded']]) && $line[$map['price_tax_excluded']]) ? $line[$map['price_tax_excluded']] : $map_default_values['price_tax_excluded'];
                                $price_tax_included = ($map['price_tax_included'] >= 0 && isset($line[$map['price_tax_included']]) && $line[$map['price_tax_included']]) ? $line[$map['price_tax_included']] : $map_default_values['price_tax_included'];
                                $discounted_price = ($map['discounted_price'] >= 0 && isset($line[$map['discounted_price']]) && $line[$map['discounted_price']]) ? $line[$map['discounted_price']] : $map_default_values['discounted_price'];
                                if (($price_tax_excluded > 0 && $price_tax_excluded < $this->min_price_amount) ||
                                    ($price_tax_included > 0 && $price_tax_included < $this->min_price_amount) ||
                                    ($discounted_price > 0 && $discounted_price < $this->min_price_amount)
                                ) {
                                    $product = null;
                                    $this->addError("Creating product not allowed because of Min Price Amount.");
                                }
                            }
                        } else {
                            $product = null;
                            if (($map['name_' . $this->id_lang_default] < 0 || $line[$map['name_' . $this->id_lang_default]] == "") && empty($map_default_values['name_' . $this->id_lang_default])) {
                                $this->addError("Name is required for new product.");
                            } elseif ($id_reference_index >= 0 && empty($id_reference)) {
                                $this->addError("Reference cannot be empty for new product.");
                            } else {
                                $this->addError("New product could not be created.");
                            }
                        }
                    }

                    if (!$product) {
                        continue;
                    }

                    foreach ($map as $attr => $index) {
                        // Skip if neither mapped nor provided default value
                        if ($index < 0 && $map_default_values[$attr] === "") {
                            continue;
                        }

                        $value = isset($line[$index]) ? $line[$index] : "";
                        $value_default = isset($map_default_values[$attr]) ? $map_default_values[$attr] : "";
                        $value = ($value === "") ? trim($value_default) : trim($value);
                        $value = $this->getDictionaryValue($attr, $value, $line, $csv_header);

                        switch ($attr) {
                            case 'reference':
                                if ($value && Validate::isReference($value)) {
                                    $product->reference = $value;
                                }
                                break;
                            case (preg_match("/^name_([\d]+)$/", $attr, $match) ? true : false):
                                if ($value) {
                                    $value = Tools::substr(preg_replace("/[<>;=#{}]*/", "", $value), 0, 128);
                                    if (!Validate::isCatalogName($value) && !$this->is_utf8_encode) {
                                        $value = ElegantalEasyImportTools::encodeUtf8($value);
                                    }
                                    $product->name[$match[1]] = $value;
                                }
                                break;
                            case 'enabled':
                                $product->active = $this->isCsvValueFalse($value) ? 0 : 1;
                                break;
                            case 'ean':
                                // Change EAN based on Quantity. This was requested by one customer.
                                if (Tools::substr($value, 0, 4) == "[QTY") {
                                    $value = str_replace(' ', '', $value);
                                    $value = str_replace('#', '9999999', $value);
                                    if (preg_match("/^\[QTY([0-9\;\-\=]+)\]$/", $value, $ean_formulas)) {
                                        $ean_formulas = explode(";", $ean_formulas[1]);
                                        foreach ($ean_formulas as $ean_formula) {
                                            if ($ean_formula && preg_match("/^([0-9]+)-([0-9]+)=([0-9]+)$/", $ean_formula, $ean_formula_parts)) {
                                                $qty_tmp = (isset($line[$map['quantity']])) ? $line[$map['quantity']] : $map_default_values['quantity'];
                                                $qty_tmp = $this->getDictionaryValue('quantity', $qty_tmp, $line, $csv_header);
                                                if ($qty_tmp >= $ean_formula_parts[1] && $qty_tmp <= $ean_formula_parts[2]) {
                                                    $value = $ean_formula_parts[3];
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                    if (Tools::substr($value, 0, 4) == "[QTY") {
                                        $value = "";
                                    }
                                }
                                if ($value && Validate::isEan13($value)) {
                                    $product->ean13 = $value;
                                } else {
                                    $product->ean13 = "";
                                    if ($value) {
                                        $this->addError('EAN is not valid: ' . $value, $product);
                                    }
                                }
                                break;
                            case 'upc_barcode':
                                $product->upc = ($value && Validate::isUpc($value)) ? $value : "";
                                break;
                            case 'isbn':
                                $value = str_replace(',', '.', $value);
                                $value = preg_replace('/[^0-9-]/', '', $value);
                                $product->isbn = $value ? Tools::substr($value, 0, 32) : "";
                                break;
                            case 'mpn':
                                $product->mpn = $value ? Tools::substr($value, 0, 40) : "";
                                break;
                            case (preg_match("/^meta_title_([\d]+)$/", $attr, $match) ? true : false):
                                $value = preg_replace('/[<>={}]*/', '', $value);
                                $product->meta_title[$match[1]] = Tools::substr($value, 0, 128);
                                break;
                            case (preg_match("/^meta_description_([\d]+)$/", $attr, $match) ? true : false):
                                $value = strip_tags($value);
                                $value = htmlentities($value);
                                $value = preg_replace('/[<>={}]*/', '', $value);
                                $product->meta_description[$match[1]] = Tools::substr($value, 0, 255);
                                break;
                            case (preg_match("/^meta_keywords_([\d]+)$/", $attr, $match) ? true : false):
                                $value = strip_tags($value);
                                $value = htmlentities($value);
                                $value = preg_replace('/[<>={}]*/', '', $value);
                                $product->meta_keywords[$match[1]] = Tools::substr($value, 0, 255);
                                break;
                            case (preg_match("/^friendly_url_([\d]+)$/", $attr, $match) ? true : false):
                                if ($value) {
                                    $product->link_rewrite[$match[1]] = Tools::link_rewrite(Tools::substr($value, 0, 128));
                                }
                                break;
                            case (preg_match("/^short_description_([\d]+)$/", $attr, $match) ? true : false):
                                $value = ElegantalEasyImportTools::cleanDescription($value);
                                if ($product->validateField('description_short', $value, $match[1]) !== true) {
                                    $short_desc_limit = (int) Configuration::get('PS_PRODUCT_SHORT_DESC_LIMIT');
                                    if ($short_desc_limit <= 0) {
                                        $short_desc_limit = 800;
                                    }
                                    $value = str_ireplace(array("<br />", "<br>", "<br/>"), PHP_EOL, $value);
                                    $value = strip_tags($value);
                                    $value = Tools::substr($value, 0, $short_desc_limit);
                                }
                                if ($map_default_values['short_description_' . $match[1]] == 'strip_tags') {
                                    $value = strip_tags($value);
                                }
                                $product->description_short[$match[1]] = $value;
                                break;
                            case (preg_match("/^long_description_([\d]+)$/", $attr, $match) ? true : false):
                                $value = ElegantalEasyImportTools::cleanDescription($value);
                                // If the value is URL, wrap it inside iframe
                                if ($value && Validate::isAbsoluteUrl($value)) {
                                    $value = '<iframe src="' . $value . '" style="border:0;overflow:visible;width:100%;height:100%;"></iframe>';
                                }
                                if ($map_default_values['long_description_' . $match[1]] == 'strip_tags') {
                                    $value = strip_tags($value);
                                }
                                $product->description[$match[1]] = $value;
                                break;
                            case 'wholesale_price':
                                $currency = (isset($line[$map['price_currency']]) && $line[$map['price_currency']]) ? $line[$map['price_currency']] : $map_default_values['price_currency'];
                                $currency = $this->getDictionaryValue('price_currency', $currency, $line, $csv_header);
                                $product->wholesale_price = (float) $this->extractPriceInDefaultCurrency($value, $currency);
                                if ($map_default_values['wholesale_price'] && preg_match("/\[FORMULA:([\s\+\.\;\*\/\-\d]+)\]/", $map_default_values['wholesale_price'], $match)) {
                                    $product->wholesale_price = ElegantalEasyImportTools::getModifiedPriceByFormula($product->wholesale_price, $match[1]);
                                }
                                break;
                            case 'tax_rules_group':
                                // If there is no tax rule group, set tax rule group from default. This is not needed, as it is possible to set default value now
                                if (($index >= 0 && !$value) || ($index < 0 && !$value_default && $value_default !== "")) {
                                    // $product->id_tax_rules_group = (int) Product::getIdTaxRulesGroupMostUsed();
                                    $product->id_tax_rules_group = 0;
                                } elseif ($value) {
                                    $id_tax_rules_group = (int) Db::getInstance()->getValue("SELECT `id_tax_rules_group` FROM `" . _DB_PREFIX_ . "tax_rules_group` WHERE `name` = '" . pSQL($value) . "' AND `deleted` = 0");
                                    if (!$id_tax_rules_group && Validate::isInt($value)) {
                                        $taxRulesGroup = new TaxRulesGroup($value);
                                        if (Validate::isLoadedObject($taxRulesGroup) && !$taxRulesGroup->deleted) {
                                            $id_tax_rules_group = (int) $value;
                                        }
                                    }
                                    if ($id_tax_rules_group) {
                                        $product->id_tax_rules_group = $id_tax_rules_group;
                                    }
                                }
                                break;
                            case 'price_tax_excluded':
                                $currency = (isset($line[$map['price_currency']]) && $line[$map['price_currency']]) ? $line[$map['price_currency']] : $map_default_values['price_currency'];
                                $currency = $this->getDictionaryValue('price_currency', $currency, $line, $csv_header);
                                $price_value = (float) $this->extractPriceInDefaultCurrency($value, $currency);
                                if ($price_value >= $this->min_price_amount) {
                                    $product->price = ElegantalEasyImportTools::getModifiedPriceByFormula($price_value, $this->price_modifier);
                                }
                                break;
                            case 'price_tax_included':
                                $currency = (isset($line[$map['price_currency']]) && $line[$map['price_currency']]) ? $line[$map['price_currency']] : $map_default_values['price_currency'];
                                $currency = $this->getDictionaryValue('price_currency', $currency, $line, $csv_header);
                                $price_value = (float) $this->extractPriceInDefaultCurrency($value, $currency);
                                if ($price_value >= $this->min_price_amount) {
                                    $product->price = ElegantalEasyImportTools::getModifiedPriceByFormula($price_value, $this->price_modifier);
                                    // Check if Tax Rule Group exists
                                    $taxRulesGroup = new TaxRulesGroup($product->id_tax_rules_group);
                                    if (!Validate::isLoadedObject($taxRulesGroup) || $taxRulesGroup->deleted) {
                                        $product->id_tax_rules_group = 0;
                                    }
                                    // If a tax is already included in price, withdraw it from price
                                    $tax_rate = $product->tax_rate;
                                    if ($product->id_tax_rules_group) {
                                        $address = Address::initialize();
                                        $tax_manager = TaxManagerFactory::getManager($address, $product->id_tax_rules_group);
                                        $tax_calculator = $tax_manager->getTaxCalculator();
                                        $tax_rate = $tax_calculator->getTotalRate();
                                    }
                                    if ($tax_rate) {
                                        $product->price = (float) number_format($product->price / (1 + $tax_rate / 100), 6, '.', '');
                                    }
                                }
                                break;
                            case 'unit_price':
                                $currency = (isset($line[$map['price_currency']]) && $line[$map['price_currency']]) ? $line[$map['price_currency']] : $map_default_values['price_currency'];
                                $currency = $this->getDictionaryValue('price_currency', $currency, $line, $csv_header);
                                $price_value = (float) $this->extractPriceInDefaultCurrency($value, $currency);
                                if ($price_value >= $this->min_price_amount) {
                                    $product->unit_price = $price_value;
                                }
                                break;
                            case 'unity':
                                $product->unity = $value;
                                break;
                            case 'ecotax':
                                $product->ecotax = Configuration::get('PS_USE_ECOTAX') ? (float) $this->extractPriceInDefaultCurrency($value) : 0;
                                break;
                            case 'advanced_stock_management':
                                $product->advanced_stock_management = $this->isCsvValueTrue($value) ? 1 : 0;
                                break;
                            case 'depends_on_stock':
                                $value = $this->isCsvValueTrue($value) ? 1 : 0;
                                if (!$product->advanced_stock_management) {
                                    $value = 0;
                                }
                                $product->depends_on_stock = $value;
                                break;
                            case 'quantity':
                                if ($value !== "") {
                                    $value = str_replace([" ", ">", "<", "="], "", $value);
                                    if (strpos($value, ",") !== false && strpos($value, ".") !== false) {
                                        $value = str_replace(",", "", $value);
                                    }
                                    $value = $settings['product_quantity_data_type'] == 'float' ? (float) $value : (int) $value;
                                    $value = $value < 0 ? 0 : $value;
                                    $product->quantity = $value;
                                }
                                break;
                            case 'minimal_quantity':
                                if ($value && $value >= 1) {
                                    $product->minimal_quantity = (int) $value;
                                } elseif (($index >= 0 && !$value) || ($index < 0 && !$value_default && $value_default !== "")) {
                                    $product->minimal_quantity = 1;
                                }
                                break;
                            case 'low_stock_level':
                                $product->low_stock_threshold = (int) $value;
                                break;
                            case 'email_alert_on_low_stock':
                                $product->low_stock_alert = $this->isCsvValueTrue($value) ? 1 : 0;
                                break;
                            case 'action_when_out_of_stock':
                                $value = (int) $value;
                                $product->out_of_stock = ($value === 1 || $value === 0) ? $value : 2;
                                break;
                            case (preg_match("/^text_when_in_stock_([\d]+)$/", $attr, $match) ? true : false):
                                $product->available_now[$match[1]] = Tools::substr(preg_replace("/[<>;=#{}]*/", "", $value), 0, 255);
                                break;
                            case (preg_match("/^text_when_backordering_([\d]+)$/", $attr, $match) ? true : false):
                                $product->available_later[$match[1]] = Tools::substr(preg_replace("/[<>;=#{}]*/", "", $value), 0, 255);
                                break;
                            case 'availability_date':
                                if ($value && strtotime($value)) {
                                    $product->available_date = date('Y-m-d', strtotime($value));
                                } else {
                                    $product->available_date = null;
                                }
                                break;
                            case "categories_" . $this->id_lang_default:
                            case (preg_match("/^category_([\d]+)_" . $this->id_lang_default . "$/", $attr, $match) ? true : false):
                                // Build multilang categories array
                                $cat_lang_arr = array();
                                if (preg_match("/^([a-z_]+)_([\d]+)_?([\d]+)?$/", $attr, $matches)) {
                                    foreach ($this->id_all_langs as $id_lang) {
                                        $attr_tmp = $matches[1] . '_' . ((isset($matches[3]) && $matches[3]) ? $matches[2] . '_' . $id_lang : $id_lang);
                                        $val = "";
                                        if (isset($line[$map[$attr_tmp]]) && $line[$map[$attr_tmp]]) {
                                            $val = $line[$map[$attr_tmp]];
                                        }
                                        if (isset($map_default_values[$attr_tmp]) && $map_default_values[$attr_tmp]) {
                                            $val .= $val ? $multiple_value_separator : "";
                                            $val .= $map_default_values[$attr_tmp];
                                        }
                                        if ($val) {
                                            $categoryNames = explode($multiple_value_separator, $val);
                                            $categoryNames = array_map('trim', $categoryNames);
                                            foreach ($categoryNames as $key1 => $categoryName) {
                                                if ($multiple_subcategory_separator) {
                                                    $categories_arr = explode($multiple_subcategory_separator, $categoryName);
                                                    $categories_arr = array_map('trim', $categories_arr);
                                                    $count_categories_arr = count($categories_arr);
                                                    if ($count_categories_arr > 1) {
                                                        foreach ($categories_arr as $key2 => $category_name) {
                                                            $cat_lang_arr[$key1 . '_' . $key2][$id_lang] = $category_name;
                                                        }
                                                    } else {
                                                        $cat_lang_arr[$key1][$id_lang] = $categoryName;
                                                    }
                                                } else {
                                                    $cat_lang_arr[$key1][$id_lang] = $categoryName;
                                                }
                                            }
                                        }
                                    }
                                }

                                if (isset($line[$index]) && $line[$index] && $value_default) {
                                    $value .= $value ? $multiple_value_separator : "";
                                    $value .= $value_default;
                                }
                                if ($value) {
                                    $categoryNames = explode($multiple_value_separator, $value);
                                    $categoryNames = array_map('trim', $categoryNames);
                                    foreach ($categoryNames as $key1 => $categoryName) {
                                        // If multiple_subcategory_separator is set, it means each category is path of categories
                                        if ($multiple_subcategory_separator) {
                                            $categories_arr = explode($multiple_subcategory_separator, $categoryName);
                                            $categories_arr = array_map('trim', $categories_arr);
                                            $count_categories_arr = count($categories_arr);
                                            if ($count_categories_arr > 1) {
                                                $id_parent_category2 = $rootCategory->id;
                                                foreach ($categories_arr as $key2 => $category_name) {
                                                    $category_names_lang = isset($cat_lang_arr[$key1 . '_' . $key2]) ? $cat_lang_arr[$key1 . '_' . $key2] : $category_name;
                                                    $categoryId = $this->getCategoryIdByName($category_names_lang, $id_parent_category2);
                                                    if ($categoryId) {
                                                        $id_parent_category2 = $categoryId;
                                                        if (!in_array($categoryId, $product_categories_ids)) {
                                                            // Assign this cat if enabled by settings OR assign only the last cat
                                                            if ($this->is_associate_all_subcategories || ($count_categories_arr == ($key2 + 1))) {
                                                                $product_categories_ids[] = $categoryId;
                                                            }
                                                        }
                                                    }
                                                }
                                            } else {
                                                $category_names_lang = isset($cat_lang_arr[$key1]) ? $cat_lang_arr[$key1] : $categoryName;
                                                $categoryId = $this->getCategoryIdByName($category_names_lang, $rootCategory->id);
                                                if ($categoryId && !in_array($categoryId, $product_categories_ids)) {
                                                    $product_categories_ids[] = $categoryId;
                                                }
                                            }
                                        } else {
                                            $id_parent_category = end($product_categories_ids);
                                            if (!$id_parent_category) {
                                                $id_parent_category = $this->is_first_parent_root_for_categories ? $rootCategory->id : null;
                                            }
                                            $category_names_lang = isset($cat_lang_arr[$key1]) ? $cat_lang_arr[$key1] : $categoryName;
                                            $categoryId = $this->getCategoryIdByName($category_names_lang, $id_parent_category);
                                            if ($categoryId && !in_array($categoryId, $product_categories_ids)) {
                                                $product_categories_ids[] = $categoryId;
                                            }
                                        }
                                    }
                                }
                                break;
                            case 'default_category':
                                if ($value) {
                                    // In case value is array, get the last element as default category
                                    $value_arr = explode($multiple_value_separator, $value);
                                    $value_arr = array_map('trim', $value_arr);
                                    if (is_array($value_arr) && count($value_arr) > 1) {
                                        $value = end($value_arr);
                                    }

                                    $value_arr2 = array();
                                    if ($multiple_subcategory_separator) {
                                        // Here $value is already last item of $value_arr
                                        $value_arr2 = explode($multiple_subcategory_separator, $value);
                                        $value_arr2 = array_map('trim', $value_arr2);
                                        $value = end($value_arr2);
                                    }

                                    // Need to find parent category of default category:
                                    $id_parent_category = null;

                                    // If default category column contains multiple categories:
                                    if ((is_array($value_arr) && count($value_arr) > 1) || $multiple_subcategory_separator) {
                                        // There is more than 1 category in array, so the first one must be under Home
                                        if ($this->is_first_parent_root_for_categories) {
                                            $id_parent_category = $rootCategory->id;
                                        }
                                        // If multiple_subcategory_separator is set, it means each category is path of categories
                                        if ($multiple_subcategory_separator) {
                                            if (is_array($value_arr2) && count($value_arr2) > 1) {
                                                foreach ($value_arr2 as $key => $value_name) {
                                                    if (!$value_name) {
                                                        continue;
                                                    }
                                                    if ($value_name == $value) {
                                                        break;
                                                    }
                                                    $categoryId = $this->getCategoryIdByName($value_name, $id_parent_category);
                                                    if (!$categoryId) {
                                                        continue;
                                                    }
                                                    $id_parent_category = $categoryId;
                                                }
                                            }
                                        } else {
                                            foreach ($value_arr as $key => $categoryName) {
                                                if (!$categoryName) {
                                                    continue;
                                                }
                                                if ($categoryName == $value) {
                                                    break;
                                                }
                                                $categoryId = $this->getCategoryIdByName($categoryName, $id_parent_category);
                                                if (!$categoryId) {
                                                    continue;
                                                }
                                                $id_parent_category = $categoryId;
                                            }
                                        }
                                    } elseif (isset($line[$map['categories_' . $this->id_lang_default]]) && $line[$map['categories_' . $this->id_lang_default]]) {
                                        // If default category column contains only one category and there is 'categories':
                                        $categoryNames = explode($multiple_value_separator, $line[$map['categories_' . $this->id_lang_default]]);
                                        $categoryNames = array_map('trim', $categoryNames);

                                        $default_category_exists_in_categories = false;

                                        // If there is only one category, parent id should be null. Otherwise first parent will be Home.
                                        $id_parent_category = null;
                                        if (count($categoryNames) > 1 && $this->is_first_parent_root_for_categories) {
                                            $id_parent_category = $rootCategory->id;
                                        }

                                        foreach ($categoryNames as $key => $categoryName) {
                                            if (!$categoryName) {
                                                continue;
                                            }
                                            if ($categoryName == $value) {
                                                $default_category_exists_in_categories = true;
                                                break;
                                            }

                                            // If multiple_subcategory_separator is set, it means each category is path of categories
                                            if ($multiple_subcategory_separator) {
                                                $categories_arr = explode($multiple_subcategory_separator, $categoryName);
                                                $categories_arr = array_map('trim', $categories_arr);
                                                $id_parent_category = $rootCategory->id;
                                                if (count($categories_arr) > 1) {
                                                    foreach ($categories_arr as $category_name) {
                                                        if (!$category_name) {
                                                            continue;
                                                        }
                                                        if ($category_name == $value) {
                                                            $default_category_exists_in_categories = true;
                                                            break 2;
                                                        }
                                                        $categoryId = $this->getCategoryIdByName($category_name, $id_parent_category);
                                                        if ($categoryId) {
                                                            $id_parent_category = $categoryId;
                                                        }
                                                    }
                                                }
                                            } else {
                                                $categoryId = $this->getCategoryIdByName($categoryName, $id_parent_category);
                                                if (!$categoryId) {
                                                    continue;
                                                }
                                                $id_parent_category = $categoryId;
                                            }
                                        }

                                        if (!$default_category_exists_in_categories) {
                                            $id_parent_category = $rootCategory->id;
                                        }
                                    }

                                    // If new product, it will be used later, that's why it is not inside if statement
                                    $product->id_category_default = $this->getCategoryIdByName($value, $id_parent_category);
                                }
                                break;
                            case 'manufacturer':
                                if ($value) {
                                    $product->id_manufacturer = $this->getManufacturerIdByName($value);
                                } else {
                                    $product->id_manufacturer = null;
                                }
                                break;
                            case 'package_width':
                            case 'package_height':
                            case 'package_depth':
                                if ($value && preg_match("/^([0-9.]*)x([0-9.]*)x([0-9.]*)$/i", $value, $matches)) {
                                    $product->width = ElegantalEasyImportTools::getConvertedDimension($matches[1], $this->shipping_package_size_unit, $ps_dimension_unit);
                                    $product->height = ElegantalEasyImportTools::getConvertedDimension($matches[2], $this->shipping_package_size_unit, $ps_dimension_unit);
                                    $product->depth = ElegantalEasyImportTools::getConvertedDimension($matches[3], $this->shipping_package_size_unit, $ps_dimension_unit);
                                } else {
                                    $package_attr = str_replace('package_', '', $attr);
                                    $product->{$package_attr} = ElegantalEasyImportTools::getConvertedDimension($value, $this->shipping_package_size_unit, $ps_dimension_unit);
                                }
                                break;
                            case 'package_weight':
                                $value = str_replace(",", ".", $value);
                                $product->weight = ElegantalEasyImportTools::getConvertedWeight($value, $this->shipping_package_weight_unit, $ps_weight_unit);
                                break;
                            case 'additional_shipping_cost':
                                $product->additional_shipping_cost = (float) $this->extractPriceInDefaultCurrency($value);
                                break;
                            case 'delivery_time':
                                $value = (int) $value;
                                $product->additional_delivery_times = ($value === 0 || $value === 2) ? $value : 1;
                                break;
                            case (preg_match("/^delivery_in_stock_([\d]+)$/", $attr, $match) ? true : false):
                                $product->delivery_in_stock[$match[1]] = Tools::substr($value, 0, 255);
                                break;
                            case (preg_match("/^delivery_out_stock_([\d]+)$/", $attr, $match) ? true : false):
                                $product->delivery_out_stock[$match[1]] = Tools::substr($value, 0, 255);
                                break;
                            case 'available_for_order':
                                $product->available_for_order = $this->isCsvValueFalse($value) ? 0 : 1;
                                if ($product->available_for_order) {
                                    $product->show_price = 1;
                                }
                                break;
                            case 'show_price':
                                if (!$product->available_for_order) {
                                    $product->show_price = $this->isCsvValueFalse($value) ? 0 : 1;
                                }
                                break;
                            case 'on_sale':
                                $product->on_sale = $this->isCsvValueTrue($value) ? 1 : 0;
                                break;
                            case 'online_only':
                                $product->online_only = $this->isCsvValueTrue($value) ? 1 : 0;
                                break;
                            case 'condition':
                                $value = Tools::strtolower($value);
                                if ($value && in_array($value, array('new', 'used', 'refurbished'))) {
                                    $product->condition = $value;
                                } else {
                                    $product->condition = 'new';
                                }
                                break;
                            case 'display_condition':
                                $product->show_condition = $this->isCsvValueTrue($value) ? 1 : 0;
                                break;
                            case 'is_virtual_product':
                                $product->is_virtual = $this->isCsvValueTrue($value) ? 1 : 0;
                                break;
                            case 'customizable':
                                $product->customizable = $this->isCsvValueTrue($value) ? 1 : 0;
                                break;
                            case 'uploadable_files':
                                $product->uploadable_files = (int) $value;
                                break;
                            case 'text_fields':
                                $product->text_fields = (int) $value;
                                break;
                            case 'visibility':
                                $value = $value ? Tools::strtolower($value) : $value;
                                switch ($value) {
                                    case 'everywhere':
                                    case 'both':
                                        $product->visibility = 'both';
                                        break;
                                    case 'catalog only':
                                    case 'catalog':
                                        $product->visibility = 'catalog';
                                        break;
                                    case 'search only':
                                    case 'search':
                                        $product->visibility = 'search';
                                        break;
                                    case 'nowhere':
                                    case 'none':
                                        $product->visibility = 'none';
                                        break;
                                    default:
                                        $product->visibility = 'both';
                                        break;
                                }
                                break;
                            case 'date_created':
                                if (strtotime($value)) {
                                    $product->date_add = date("Y-m-d H:i:s", strtotime($value));
                                }
                                break;
                            case 'redirect_type_when_offline':
                                $value = Tools::strtolower($value);
                                $product->redirect_type = in_array($value, array('301-category', '302-category', '301-product', '302-product', '404')) ? $value : '404';
                                break;
                            case 'redirect_target_category_id':
                                $product->id_type_redirected = (int) $value;
                                break;
                            default:
                                break;
                        }
                    }

                    // Make update on all shops
                    if ($update_products_on_all_shops && Shop::getContext() != Shop::CONTEXT_ALL) {
                        Shop::setContext(Shop::CONTEXT_ALL);
                    }

                    if ($map['enabled'] < 0) {
                        if ($this->enable_if_have_stock && $product->quantity >= 1) {
                            $product->active = 1;
                        } elseif ($this->disable_if_no_stock && $product->quantity <= 0) {
                            $product->active = 0;
                        } elseif (!$product->id && $this->enable_new_products_by_default) {
                            $product->active = 1;
                        } elseif (!$product->id && !$this->enable_new_products_by_default) {
                            $product->active = 0;
                        }
                    }

                    if ($this->find_products_by == 'reference' && isset($id_reference) && empty($product->reference)) {
                        $product->reference = preg_replace('/[<>;={}]*/', '', $id_reference);
                    }
                    if ($this->find_products_by == 'ean' && isset($id_reference) && empty($product->ean13) && Validate::isEan13($id_reference)) {
                        $product->ean13 = $id_reference;
                    }
                    if ($this->find_products_by == 'mpn' && isset($id_reference) && empty($product->mpn)) {
                        $product->mpn = $id_reference;
                    }

                    foreach ($this->id_all_langs as $id_lang) {
                        if (empty($product->name[$id_lang])) {
                            $product->name[$id_lang] = $product->name[$this->id_lang_default];
                        }
                        if (empty($product->link_rewrite[$id_lang])) {
                            $product->link_rewrite[$id_lang] = Tools::link_rewrite(str_replace("\xc2\xa0", "-", Tools::substr($product->name[$id_lang], 0, 128)));
                        }
                        // This is needed for Greek language
                        $product->link_rewrite[$id_lang] = preg_replace("/σ-/", "ς-", $product->link_rewrite[$id_lang]);
                        $product->link_rewrite[$id_lang] = preg_replace("/σ$/", "ς", $product->link_rewrite[$id_lang]);
                    }

                    // If product has no default category, select it from the last category in categories tree
                    if (!empty($product_categories_ids) && ($map['default_category'] < 0 || !isset($line[$map['default_category']]) || !$line[$map['default_category']]) && !$map_default_values['default_category']) {
                        $product->id_category_default = end($product_categories_ids);
                    }

                    // If product has no default category, add it to Home category
                    if (!$product->id_category_default) {
                        $product->id_category_default = $rootCategory->id;
                    }

                    $product->customizable = ($product->uploadable_files > 0 || $product->text_fields > 0) ? 1 : $product->customizable;

                    if ($product->id) {
                        if (!$product->update()) {
                            throw new Exception(Db::getInstance()->getMsgError());
                        }

                        // number_of_products_updated can get higher than number_of_products_processed because several products may have the same reference
                        $this->currentHistory->number_of_products_updated++;

                        if (_PS_VERSION_ < '1.7' && Shop::isFeatureActive()) {
                            // This is needed to update shop fields. This is not needed in PS 1.7. Probably a bug in PS 1.6.
                            $product->setFieldsToUpdate($product->getFieldsShop());
                            $product->update();
                        }
                        if ($settings['employee_id_for_events_log']) {
                            PrestaShopLogger::addLog('Product modification', 1, null, 'Product', $product->id, true, (int) $settings['employee_id_for_events_log']);
                        }
                    } else {
                        if ($this->force_id_product && $this->find_products_by == 'id' && Validate::isInt($id_reference) && $id_reference > 0) {
                            $product->id = (int) $id_reference;
                            $product->force_id = true;
                        }
                        if (!$product->add()) {
                            throw new Exception(Db::getInstance()->getMsgError());
                        }

                        $this->currentHistory->number_of_products_created++;

                        // If date_created is set in mapping, make update for it
                        $date_created = (isset($line[$map['date_created']]) && $line[$map['date_created']]) ? $line[$map['date_created']] : $map_default_values['date_created'];
                        if ($date_created && strtotime($date_created)) {
                            $product->date_add = date("Y-m-d H:i:s", strtotime($date_created));
                            $product->update();
                        }

                        if ($this->supplier_id && ($map['supplier'] < 0 || !isset($line[$map['supplier']]) || !$line[$map['supplier']]) && !$map_default_values['supplier']) {
                            $supplier_references = null;
                            $supplier_prices = null;
                            if (isset($line[$map['supplier_reference']]) && $line[$map['supplier_reference']]) {
                                $supplier_references = $line[$map['supplier_reference']];
                                if ($map_default_values['supplier_reference']) {
                                    $supplier_references .= $multiple_value_separator . $map_default_values['supplier_reference'];
                                }
                            } elseif ($map_default_values['supplier_reference']) {
                                $supplier_references = $map_default_values['supplier_reference'];
                            }
                            if (isset($line[$map['supplier_price']]) && $line[$map['supplier_price']]) {
                                $supplier_prices = $line[$map['supplier_price']];
                                if ($map_default_values['supplier_price']) {
                                    $supplier_prices .= $multiple_value_separator . $map_default_values['supplier_price'];
                                }
                            } elseif ($map_default_values['supplier_price']) {
                                $supplier_prices = $map_default_values['supplier_price'];
                            }
                            $this->createProductSuppliers($product, $this->supplier_id, $supplier_references, $supplier_prices, $multiple_value_separator);
                        }
                        if (in_array($product->visibility, array('both', 'search')) && Configuration::get('PS_SEARCH_INDEXATION')) {
                            Search::indexation(false, $product->id);
                        }
                        if ($settings['employee_id_for_events_log']) {
                            PrestaShopLogger::addLog('Product addition', 1, null, 'Product', $product->id, true, (int) $settings['employee_id_for_events_log']);
                        }
                    }

                    // Continue processing the rest of columns in mapping that require $product->id
                    foreach ($map as $attr => $index) {
                        // Skip if neither mapped nor provided default value
                        if ($index < 0 && $map_default_values[$attr] === "") {
                            continue;
                        }

                        $value = isset($line[$index]) ? $line[$index] : "";
                        $value_default = isset($map_default_values[$attr]) ? $map_default_values[$attr] : "";
                        $value = ($value === "") ? trim($value_default) : trim($value);
                        $value = $this->getDictionaryValue($attr, $value, $line, $csv_header);

                        switch ($attr) {
                            case 'delete_existing_discount':
                                if ($value && $this->isCsvValueTrue($value)) {
                                    Db::getInstance()->execute("DELETE FROM `" . _DB_PREFIX_ . "specific_price` WHERE `id_product` = " . (int) $product->id . " AND (`id_shop` = 0 OR `id_shop` IN (" . implode(", ", array_map("intval", $shop_ids)) . "))");
                                }
                                break;
                            case 'discount_amount':
                            case 'discount_percent':
                                $is_percentage = (strpos($value, '%') !== false || $attr == 'discount_percent') ? true : false;
                                $discount_from = '0000-00-00 00:00:00';
                                $discount_to = '0000-00-00 00:00:00';
                                $is_discount_tax_included = 1;
                                $discount_base_price = (isset($line[$map['discount_base_price']]) && $line[$map['discount_base_price']] !== "") ? $line[$map['discount_base_price']] : $map_default_values['discount_base_price'];
                                $discount_starting_unit = (isset($line[$map['discount_starting_unit']]) && $line[$map['discount_starting_unit']]) ? $line[$map['discount_starting_unit']] : $map_default_values['discount_starting_unit'];
                                $discount_customer_group = (isset($line[$map['discount_customer_group']]) && $line[$map['discount_customer_group']]) ? $line[$map['discount_customer_group']] : $map_default_values['discount_customer_group'];
                                $discount_customer_id = (isset($line[$map['discount_customer_id']]) && $line[$map['discount_customer_id']] !== "") ? $line[$map['discount_customer_id']] : $map_default_values['discount_customer_id'];
                                $discount_country = (isset($line[$map['discount_country']]) && $line[$map['discount_country']]) ? $line[$map['discount_country']] : $map_default_values['discount_country'];
                                $discount_currency = (isset($line[$map['discount_currency']]) && $line[$map['discount_currency']]) ? $line[$map['discount_currency']] : $map_default_values['discount_currency'];
                                if (isset($line[$map['discount_from']]) && $line[$map['discount_from']]) {
                                    $discount_from = date('Y-m-d H:i:s', strtotime($line[$map['discount_from']]));
                                } elseif ($map_default_values['discount_from']) {
                                    $discount_from = date('Y-m-d H:i:s', strtotime($map_default_values['discount_from']));
                                }
                                if (isset($line[$map['discount_to']]) && $line[$map['discount_to']]) {
                                    $discount_to = date('Y-m-d H:i:s', strtotime($line[$map['discount_to']]));
                                } elseif ($map_default_values['discount_to']) {
                                    $discount_to = date('Y-m-d H:i:s', strtotime($map_default_values['discount_to']));
                                }
                                if (isset($line[$map['discount_tax_included']]) && $line[$map['discount_tax_included']] !== "") {
                                    $is_discount_tax_included = $this->isCsvValueFalse($line[$map['discount_tax_included']]) ? 0 : 1;
                                } elseif ($map_default_values['discount_tax_included'] !== "") {
                                    $is_discount_tax_included = $this->isCsvValueFalse($map_default_values['discount_tax_included']) ? 0 : 1;
                                }
                                $value = $is_percentage ? $value : (float) $this->extractPriceInDefaultCurrency($value);
                                $this->createProductSpecificPrice($product->id, $value, $is_percentage, $is_discount_tax_included, $discount_from, $discount_to, $discount_base_price, $discount_starting_unit, $discount_customer_group, $discount_customer_id, $discount_country, $discount_currency, 0, $shop_ids);
                                break;
                            case 'discounted_price':
                                $discounted_price = (float) $this->extractPriceInDefaultCurrency($value);
                                if (!$discounted_price) {
                                    break;
                                }
                                $is_discount_tax_included = 1;
                                if (isset($line[$map['discount_tax_included']]) && $line[$map['discount_tax_included']] !== "") {
                                    $is_discount_tax_included = $this->isCsvValueFalse($line[$map['discount_tax_included']]) ? 0 : 1;
                                } elseif ($map_default_values['discount_tax_included'] !== "") {
                                    $is_discount_tax_included = $this->isCsvValueFalse($map_default_values['discount_tax_included']) ? 0 : 1;
                                }
                                if ($is_discount_tax_included) {
                                    // Check if Tax Rule Group exists
                                    $taxRulesGroup = new TaxRulesGroup($product->id_tax_rules_group);
                                    if (!Validate::isLoadedObject($taxRulesGroup) || $taxRulesGroup->deleted) {
                                        $product->id_tax_rules_group = null;
                                    }
                                    // If a tax is already included in price, withdraw it from price
                                    $tax_rate = $product->tax_rate;
                                    if ($product->id_tax_rules_group) {
                                        $address = Address::initialize();
                                        $tax_manager = TaxManagerFactory::getManager($address, $product->id_tax_rules_group);
                                        $tax_calculator = $tax_manager->getTaxCalculator();
                                        $tax_rate = $tax_calculator->getTotalRate();
                                    }
                                    if ($tax_rate) {
                                        $discounted_price = (float) number_format($discounted_price / (1 + $tax_rate / 100), 6, '.', '');
                                    }
                                }
                                $discount_base_price = (isset($line[$map['discount_base_price']]) && $line[$map['discount_base_price']] !== "") ? $line[$map['discount_base_price']] : $map_default_values['discount_base_price'];
                                $discount_starting_unit = (isset($line[$map['discount_starting_unit']]) && $line[$map['discount_starting_unit']]) ? $line[$map['discount_starting_unit']] : $map_default_values['discount_starting_unit'];
                                $discount_customer_group = (isset($line[$map['discount_customer_group']]) && $line[$map['discount_customer_group']]) ? $line[$map['discount_customer_group']] : $map_default_values['discount_customer_group'];
                                $discount_customer_id = (isset($line[$map['discount_customer_id']]) && $line[$map['discount_customer_id']] !== "") ? $line[$map['discount_customer_id']] : $map_default_values['discount_customer_id'];
                                $discount_country = (isset($line[$map['discount_country']]) && $line[$map['discount_country']]) ? $line[$map['discount_country']] : $map_default_values['discount_country'];
                                $discount_currency = (isset($line[$map['discount_currency']]) && $line[$map['discount_currency']]) ? $line[$map['discount_currency']] : $map_default_values['discount_currency'];
                                $discount_from = '0000-00-00 00:00:00';
                                $discount_to = '0000-00-00 00:00:00';
                                if (isset($line[$map['discount_from']]) && $line[$map['discount_from']]) {
                                    $discount_from = date('Y-m-d H:i:s', strtotime($line[$map['discount_from']]));
                                } elseif ($map_default_values['discount_from']) {
                                    $discount_from = date('Y-m-d H:i:s', strtotime($map_default_values['discount_from']));
                                }
                                if (isset($line[$map['discount_to']]) && $line[$map['discount_to']]) {
                                    $discount_to = date('Y-m-d H:i:s', strtotime($line[$map['discount_to']]));
                                } elseif ($map_default_values['discount_to']) {
                                    $discount_to = date('Y-m-d H:i:s', strtotime($map_default_values['discount_to']));
                                }

                                if ((isset($line[$map['price_tax_excluded']]) || isset($line[$map['price_tax_included']]) || $map_default_values['price_tax_excluded'] || $map_default_values['price_tax_included']) &&
                                    (!isset($line[$map['discount_amount']]) && !isset($line[$map['discount_percent']]) && !$map_default_values['discount_amount'] && !$map_default_values['discount_percent']) &&
                                    $product->price > $discounted_price
                                ) {
                                    // Discount amount
                                    $discount_amount = round($product->price - $discounted_price, 6);
                                    $this->createProductSpecificPrice($product->id, $discount_amount, false, false, $discount_from, $discount_to, $discount_base_price, $discount_starting_unit, $discount_customer_group, $discount_customer_id, $discount_country, $discount_currency, 0, $shop_ids);
                                } elseif ((!isset($line[$map['price_tax_excluded']]) && !isset($line[$map['price_tax_included']]) && !$map_default_values['price_tax_excluded'] && !$map_default_values['price_tax_included']) &&
                                    (isset($line[$map['discount_amount']]) && $discounted_price > $line[$map['discount_amount']]) || ($map_default_values['discount_amount'] && $discounted_price > $map_default_values['discount_amount'])
                                ) {
                                    // Product price
                                    $discount_amount = isset($line[$map['discount_amount']]) ? $line[$map['discount_amount']] : $map_default_values['discount_amount'];
                                    $discount_amount = (float) $this->extractPriceInDefaultCurrency($discount_amount);
                                    $product->price = round($discounted_price + $discount_amount, 6);
                                    $product->update();
                                } elseif ((!isset($line[$map['price_tax_excluded']]) && !isset($line[$map['price_tax_included']]) && !$map_default_values['price_tax_excluded'] && !$map_default_values['price_tax_included']) &&
                                    (isset($line[$map['discount_percent']]) || $map_default_values['discount_percent'])
                                ) {
                                    // Product price
                                    $discount_percent = isset($line[$map['discount_percent']]) ? $line[$map['discount_percent']] : $map_default_values['discount_percent'];
                                    if (preg_match('/([0-9]+\.{0,1}[0-9]*)/', $discount_percent, $match)) {
                                        $discount_percent = $match[0];
                                    }
                                    if ($discount_percent > 0 && $discount_percent < 1) {
                                        $discount_percent = $discount_percent * 100;
                                    }
                                    $product->price = round($discounted_price / (1 - $discount_percent / 100), 6);
                                    $product->update();
                                }
                                break;
                            case 'discount_base_price':
                                if ($value !== "" && !isset($line[$map['discount_amount']]) && $map_default_values['discount_amount'] === "" && !isset($line[$map['discount_percent']]) && $map_default_values['discount_percent'] === "") {
                                    $discount_from = '0000-00-00 00:00:00';
                                    $discount_to = '0000-00-00 00:00:00';
                                    $discount_base_price = (isset($line[$map['discount_base_price']]) && $line[$map['discount_base_price']] !== "") ? $line[$map['discount_base_price']] : $map_default_values['discount_base_price'];
                                    $discount_starting_unit = (isset($line[$map['discount_starting_unit']]) && $line[$map['discount_starting_unit']]) ? $line[$map['discount_starting_unit']] : $map_default_values['discount_starting_unit'];
                                    $discount_customer_group = (isset($line[$map['discount_customer_group']]) && $line[$map['discount_customer_group']]) ? $line[$map['discount_customer_group']] : $map_default_values['discount_customer_group'];
                                    $discount_customer_id = (isset($line[$map['discount_customer_id']]) && $line[$map['discount_customer_id']] !== "") ? $line[$map['discount_customer_id']] : $map_default_values['discount_customer_id'];
                                    $discount_country = (isset($line[$map['discount_country']]) && $line[$map['discount_country']]) ? $line[$map['discount_country']] : $map_default_values['discount_country'];
                                    $discount_currency = (isset($line[$map['discount_currency']]) && $line[$map['discount_currency']]) ? $line[$map['discount_currency']] : $map_default_values['discount_currency'];
                                    if (isset($line[$map['discount_from']]) && $line[$map['discount_from']]) {
                                        $discount_from = date('Y-m-d H:i:s', strtotime($line[$map['discount_from']]));
                                    } elseif ($map_default_values['discount_from']) {
                                        $discount_from = date('Y-m-d H:i:s', strtotime($map_default_values['discount_from']));
                                    }
                                    if (isset($line[$map['discount_to']]) && $line[$map['discount_to']]) {
                                        $discount_to = date('Y-m-d H:i:s', strtotime($line[$map['discount_to']]));
                                    } elseif ($map_default_values['discount_to']) {
                                        $discount_to = date('Y-m-d H:i:s', strtotime($map_default_values['discount_to']));
                                    }
                                    $this->createProductSpecificPrice($product->id, null, 0, 0, $discount_from, $discount_to, $discount_base_price, $discount_starting_unit, $discount_customer_group, $discount_customer_id, $discount_country, $discount_currency, 0, $shop_ids);
                                }
                                break;
                            case 'depends_on_stock':
                                StockAvailable::setProductDependsOnStock($product->id, $product->depends_on_stock);
                                break;
                            case 'warehouse_id':
                                if ($value && $product->advanced_stock_management) {
                                    if (Warehouse::exists($value)) {
                                        $product->warehouse = (int) $value;
                                        $query = new DbQuery();
                                        $query->select('id_warehouse_product_location');
                                        $query->from('warehouse_product_location');
                                        $query->where("id_product = " . (int) $product->id . " AND id_product_attribute = " . (int) $id_product_attribute . " AND id_warehouse = " . (int) $product->warehouse);
                                        $warehouse_product_location = (int) Db::getInstance()->getValue($query);
                                        if ($warehouse_product_location) {
                                            $wpl = new WarehouseProductLocation($warehouse_product_location);
                                            $wpl->location = (isset($line[$map['location_in_warehouse']]) && $line[$map['location_in_warehouse']]) ? $line[$map['location_in_warehouse']] : $map_default_values['location_in_warehouse'];
                                            $wpl->update();
                                        } else {
                                            $wpl = new WarehouseProductLocation();
                                            $wpl->id_product = $product->id;
                                            $wpl->id_product_attribute = $id_product_attribute;
                                            $wpl->id_warehouse = (int) $product->warehouse;
                                            $wpl->location = (isset($line[$map['location_in_warehouse']]) && $line[$map['location_in_warehouse']]) ? $line[$map['location_in_warehouse']] : $map_default_values['location_in_warehouse'];
                                            $wpl->add();
                                        }
                                        StockAvailable::synchronize($product->id);
                                    } else {
                                        $this->addError('Warehouse does not exist with ID ' . $value . '.', $product);
                                    }
                                }
                                break;
                            case 'quantity':
                                if ($value !== "") {
                                    if ($product->advanced_stock_management && $product->depends_on_stock) {
                                        if (empty($product->warehouse)) {
                                            $query = new DbQuery();
                                            $query->select('id_warehouse');
                                            $query->from('warehouse_product_location');
                                            $query->where('id_product = ' . (int) $product->id . ' AND id_product_attribute = ' . (int) $id_product_attribute);
                                            $product->warehouse = (int) Db::getInstance()->getValue($query);
                                        }
                                        if ($product->warehouse) {
                                            $stock_manager = StockManagerFactory::getManager();
                                            $price = str_replace(',', '.', $product->wholesale_price);
                                            if ($price == 0) {
                                                $price = 0.000001;
                                            }
                                            $price = round((float) $price, 6);
                                            $warehouse = new Warehouse($product->warehouse);
                                            if ($stock_manager->addProduct($product->id, $id_product_attribute, $warehouse, $product->quantity, 1, $price, true)) {
                                                StockAvailable::synchronize($product->id);
                                            }
                                        } else {
                                            $this->addError('Warehouse is missing.', $product);
                                        }
                                    } else {
                                        $tmp_context_shop = Shop::getContext();
                                        Shop::setContext(Shop::CONTEXT_SHOP, $id_shop);
                                        foreach ($shop_ids as $sh_id) {
                                            StockAvailable::setQuantity($product->id, $id_product_attribute, $product->quantity, $sh_id);
                                        }
                                        // Check if product has combination. If yes, update combination qty.
                                        // Do we really need to update combination stock from product import??? Stock should be updated by combination import!!!
                                        // This is needed to trigger StockAvailable->postSave to upgrade total_quantity_available after
                                        /*
                                        if ($id_product_attribute == 0) {
                                        $combinations = $product->getAttributeCombinations($this->context->language->id);
                                        if ($combinations && is_array($combinations) && is_array($combinations[0]) && isset($combinations[0]['id_product_attribute']) && $this->find_products_by == 'reference' && $id_reference) {
                                        // Check if there is combination with the same reference
                                        // If exists, use it as id_product_attribute
                                        // Otherwise just update first combination to trigger StockAvailable->postSave
                                        $row = Db::getInstance()->getRow("SELECT * FROM `" . _DB_PREFIX_ . "product_attribute` WHERE `reference` = '" . pSQL($id_reference) . "'");
                                        if ($row && isset($row['id_product']) && isset($row['id_product_attribute']) && $row['id_product'] == $product->id) {
                                        $id_product_attribute_tmp = $row['id_product_attribute'];
                                        } else {
                                        $id_product_attribute_tmp = $combinations[0]['id_product_attribute'];
                                        // $product->quantity = $combinations[0]['quantity']; why is this needed?
                                        }
                                        foreach ($shop_ids as $sh_id) {
                                        StockAvailable::setQuantity($product->id, $id_product_attribute_tmp, $product->quantity, $sh_id);
                                        }
                                        }
                                        }
                                         */
                                        Shop::setContext($tmp_context_shop, $id_shop);
                                    }
                                }
                                break;
                            case 'stock_location':
                                if (method_exists('StockAvailable', 'setLocation')) {
                                    $value = Tools::substr($value, 0, 64);
                                    call_user_func(array('StockAvailable', 'setLocation'), $product->id, $value, $id_shop, $id_product_attribute);
                                }
                                break;
                            case 'action_when_out_of_stock':
                                $tmp_context_shop = Shop::getContext();
                                Shop::setContext(Shop::CONTEXT_SHOP, $id_shop);
                                foreach ($shop_ids as $sh_id) {
                                    StockAvailable::setProductOutOfStock($product->id, $product->out_of_stock, $sh_id, $id_product_attribute);
                                }
                                Shop::setContext($tmp_context_shop, $id_shop);
                                break;
                            case 'delete_existing_images':
                                if ($value && $this->isCsvValueTrue($value)) {
                                    $product->deleteImages();
                                    Db::getInstance()->execute("DELETE FROM " . _DB_PREFIX_ . "image_shop WHERE id_image NOT IN (SELECT id_image FROM " . _DB_PREFIX_ . "image)");
                                }
                                break;
                            case 'product_images':
                            case 'default_image':
                            case (preg_match("/^image_[\d]+$/", $attr) ? true : false):
                                if (isset($line[$index]) && $line[$index] && $value_default && $attr != 'default_image') {
                                    $value .= $value ? $multiple_value_separator : "";
                                    $value .= $value_default;
                                }
                                if ($value) {
                                    $default_image = "";
                                    $captions = array();
                                    if ($attr == 'product_images') {
                                        foreach ($this->id_all_langs as $id_lang) {
                                            $captions[$id_lang] = (isset($line[$map['captions_' . $id_lang]]) && $line[$map['captions_' . $id_lang]]) ? array_map('trim', explode($multiple_value_separator, $line[$map['captions_' . $id_lang]])) : array_map('trim', explode($multiple_value_separator, $map_default_values['captions_' . $id_lang]));
                                        }
                                    } elseif ($attr == 'default_image') {
                                        $default_images = explode($multiple_value_separator, $value);
                                        if ($default_images && is_array($default_images)) {
                                            if (count($default_images) > 1) {
                                                if (Tools::strtoupper($map_default_values['default_image']) == "LAST") {
                                                    $default_image = end($default_images);
                                                } elseif (Validate::isInt($map_default_values['default_image']) && isset($default_images[$map_default_values['default_image'] - 1])) {
                                                    $default_image = $default_images[$map_default_values['default_image'] - 1];
                                                } else {
                                                    $default_image = $default_images[0];
                                                    if (isset($line[$index]) && $line[$index] && $value_default) {
                                                        $value .= $value ? $multiple_value_separator : "";
                                                        $value .= $value_default;
                                                    }
                                                }
                                            } else {
                                                $default_image = $default_images[0];
                                            }
                                        }
                                    }
                                    $convert_to = (isset($line[$map['convert_image_to']]) && $line[$map['convert_image_to']]) ? $line[$map['convert_image_to']] : $map_default_values['convert_image_to'];
                                    $this->createProductImages($product, $value, $default_image, $multiple_value_separator, $captions, $convert_to);
                                }
                                break;
                            case 'delete_existing_features':
                                if ($value && $this->isCsvValueTrue($value)) {
                                    $product->deleteFeatures();
                                }
                                break;
                            case "features_" . $this->id_lang_default:
                                if (isset($line[$index]) && $line[$index] && $value_default) {
                                    $value .= $value ? $multiple_value_separator : "";
                                    $value .= $value_default;
                                }
                                if ($value) {
                                    $features = array($this->id_lang_default => explode($multiple_value_separator, $value));
                                    foreach ($this->id_other_langs as $id_lang) {
                                        if (isset($line[$map['features_' . $id_lang]]) && $line[$map['features_' . $id_lang]]) {
                                            $value = $line[$map['features_' . $id_lang]];
                                            if ($map_default_values['features_' . $id_lang]) {
                                                $value .= $value ? $multiple_value_separator : "";
                                                $value .= $map_default_values['features_' . $id_lang];
                                            }
                                            $features[$id_lang] = explode($multiple_value_separator, $value);
                                        } elseif ($map_default_values['features_' . $id_lang]) {
                                            $features[$id_lang] = explode($multiple_value_separator, $map_default_values['features_' . $id_lang]);
                                        }
                                    }
                                    $this->createProductFeatures($product->id, $features);
                                }
                                break;
                            case (preg_match("/^feature_([\d]+)_" . $this->id_lang_default . "$/", $attr, $match) ? true : false):
                                if ($value && $index >= 0 && isset($csv_header[$index]) && $csv_header[$index]) {
                                    $feature_values = explode($multiple_value_separator, $value);
                                    $value = "";
                                    foreach ($feature_values as $fv) {
                                        $value .= $value ? $multiple_value_separator : "";
                                        $value .= $csv_header[$index] . ':"' . htmlspecialchars($fv) . '"';
                                    }
                                    if ($value_default) {
                                        $value .= $value ? $multiple_value_separator : "";
                                        $value .= $value_default;
                                    }
                                }
                                if ($value) {
                                    $features = array($this->id_lang_default => explode($multiple_value_separator, $value));
                                    foreach ($this->id_other_langs as $id_lang) {
                                        if (isset($line[$map['feature_' . $match[1] . '_' . $id_lang]]) && $line[$map['feature_' . $match[1] . '_' . $id_lang]]) {
                                            $value = $line[$map['feature_' . $match[1] . '_' . $id_lang]];
                                            $feature_values = explode($multiple_value_separator, $value);
                                            $value = "";
                                            foreach ($feature_values as $fv) {
                                                $value .= $value ? $multiple_value_separator : "";
                                                $value .= $csv_header[$map['feature_' . $match[1] . '_' . $id_lang]] . ':"' . htmlspecialchars($fv) . '"';
                                            }
                                            if ($map_default_values['feature_' . $match[1] . '_' . $id_lang]) {
                                                $value .= $value ? $multiple_value_separator : "";
                                                $value .= $map_default_values['feature_' . $match[1] . '_' . $id_lang];
                                            }
                                            $features[$id_lang] = explode($multiple_value_separator, $value);
                                        } elseif ($map_default_values['feature_' . $match[1] . '_' . $id_lang]) {
                                            $features[$id_lang] = explode($multiple_value_separator, $map_default_values['feature_' . $match[1] . '_' . $id_lang]);
                                        }
                                    }
                                    $this->createProductFeatures($product->id, $features);
                                }
                                break;
                            case (preg_match("/^tags_([\d]+)$/", $attr, $match) ? true : false):
                                if (isset($line[$index]) && $line[$index] && $value_default) {
                                    $value .= $value ? $multiple_value_separator : "";
                                    $value .= $value_default;
                                }
                                if ($value) {
                                    $this->createProductTags($product, $value, $multiple_value_separator, $match[1]);
                                }
                                break;
                            case 'accessories':
                                if (isset($line[$index]) && $line[$index] && $value_default) {
                                    $value .= $value ? $multiple_value_separator : "";
                                    $value .= $value_default;
                                }
                                if ($value) {
                                    $this->createProductAccessories($product, $value, $multiple_value_separator);
                                }
                                break;
                            case 'delete_existing_attachments':
                                if ($value && $this->isCsvValueTrue($value)) {
                                    $attachments = Attachment::getAttachments($this->id_lang_default, $product->id);
                                    if ($attachments && is_array($attachments)) {
                                        foreach ($attachments as $attachment) {
                                            $is_attached_to_other_product = false;
                                            $sql = "SELECT `id_product` FROM `" . _DB_PREFIX_ . "product_attachment` WHERE `id_attachment` = " . (int) $attachment['id_attachment'];
                                            $attachment_products = Db::getInstance()->executeS($sql);
                                            if ($attachment_products && is_array($attachment_products)) {
                                                foreach ($attachment_products as $attachment_product) {
                                                    if ($attachment_product['id_product'] != $product->id) {
                                                        $is_attached_to_other_product = true;
                                                        break;
                                                    }
                                                }
                                            }
                                            if (!$is_attached_to_other_product) {
                                                $attachmentObj = new Attachment((int) $attachment['id_attachment']);
                                                if (!Validate::isLoadedObject($attachmentObj) || !$attachmentObj->delete()) {
                                                    $this->addError('Failed to delete attachment ID: ' . $attachment['id_attachment'], $product);
                                                }
                                            }
                                        }
                                        Attachment::deleteProductAttachments($product->id);
                                    }
                                }
                                break;
                            case 'attachments':
                                if (isset($line[$index]) && $line[$index] && $value_default) {
                                    $value .= $value ? $multiple_value_separator : "";
                                    $value .= $value_default;
                                }
                                if ($value) {
                                    $attachment_names = array();
                                    $attachment_descriptions = array();
                                    foreach ($this->id_all_langs as $id_lang) {
                                        $attachment_names[$id_lang] = (isset($line[$map['attachment_names_' . $id_lang]]) && $line[$map['attachment_names_' . $id_lang]]) ? $line[$map['attachment_names_' . $id_lang]] : $map_default_values['attachment_names_' . $id_lang];
                                        $attachment_names[$id_lang] = array_map('trim', explode($multiple_value_separator, $this->getDictionaryValue('attachment_names', $attachment_names[$id_lang], $line, $csv_header)));
                                        $attachment_descriptions[$id_lang] = (isset($line[$map['attachment_descriptions_' . $id_lang]]) && $line[$map['attachment_descriptions_' . $id_lang]]) ? $line[$map['attachment_descriptions_' . $id_lang]] : $map_default_values['attachment_descriptions_' . $id_lang];
                                        $attachment_descriptions[$id_lang] = array_map('trim', explode($multiple_value_separator, $this->getDictionaryValue('attachment_descriptions', $attachment_descriptions[$id_lang], $line, $csv_header)));
                                    }
                                    $this->createProductAttachments($product, $value, $attachment_names, $attachment_descriptions, $multiple_value_separator);
                                }
                                break;
                            case 'carriers':
                                if (isset($line[$index]) && $line[$index] && $value_default) {
                                    $value .= $value ? $multiple_value_separator : "";
                                    $value .= $value_default;
                                }
                                if ($value !== "") {
                                    $this->createProductCarriers($product, $value, $multiple_value_separator);
                                }
                                break;
                            case 'supplier':
                                if (isset($line[$index]) && $line[$index] && $value_default) {
                                    $value .= $value ? $multiple_value_separator : "";
                                    $value .= $value_default;
                                }
                                if ($value) {
                                    $supplier_references = null;
                                    $supplier_prices = null;
                                    if (isset($line[$map['supplier_reference']]) && $line[$map['supplier_reference']]) {
                                        $supplier_references = $line[$map['supplier_reference']];
                                        if ($map_default_values['supplier_reference']) {
                                            $supplier_references .= $multiple_value_separator . $map_default_values['supplier_reference'];
                                        }
                                    } elseif ($map_default_values['supplier_reference']) {
                                        $supplier_references = $map_default_values['supplier_reference'];
                                    }
                                    if (isset($line[$map['supplier_price']]) && $line[$map['supplier_price']]) {
                                        $supplier_prices = $line[$map['supplier_price']];
                                        if ($map_default_values['supplier_price']) {
                                            $supplier_prices .= $multiple_value_separator . $map_default_values['supplier_price'];
                                        }
                                    } elseif ($map_default_values['supplier_price']) {
                                        $supplier_prices = $map_default_values['supplier_price'];
                                    }
                                    $this->createProductSuppliers($product, $value, $supplier_references, $supplier_prices, $multiple_value_separator);
                                }
                                break;
                            case 'delete_existing_customize_fields':
                                if ($value && $this->isCsvValueTrue($value)) {
                                    $sql = "DELETE `" . _DB_PREFIX_ . "customization_field`, `" . _DB_PREFIX_ . "customization_field_lang`
                                        FROM `" . _DB_PREFIX_ . "customization_field`
                                        INNER JOIN `" . _DB_PREFIX_ . "customization_field_lang` ON `" . _DB_PREFIX_ . "customization_field`.`id_customization_field` = `" . _DB_PREFIX_ . "customization_field_lang`.`id_customization_field`
                                        WHERE `" . _DB_PREFIX_ . "customization_field`.`id_product` = " . (int) $product->id;
                                    if (Db::getInstance()->execute($sql)) {
                                        Configuration::updateGlobalValue('PS_CUSTOMIZATION_FEATURE_ACTIVE', Customization::isCurrentlyUsed());
                                    }
                                }
                                break;
                            case 'uploadable_files':
                                if ($value) {
                                    $uploadable_files_labels = (isset($line[$map['uploadable_files_labels']]) && $line[$map['uploadable_files_labels']]) ? $line[$map['uploadable_files_labels']] : $map_default_values['uploadable_files_labels'];
                                    $text_fields_labels = (isset($line[$map['text_fields_labels']]) && $line[$map['text_fields_labels']]) ? $line[$map['text_fields_labels']] : $map_default_values['text_fields_labels'];
                                    $this->createProductCustomizableFields($product, $uploadable_files_labels, $text_fields_labels, $multiple_value_separator);
                                }
                                break;
                            case 'text_fields':
                                $uploadable_files = (isset($line[$map['uploadable_files']]) && $line[$map['uploadable_files']]) ? $line[$map['uploadable_files']] : $map_default_values['uploadable_files'];
                                if ($value && !$uploadable_files) {
                                    $text_fields_labels = (isset($line[$map['text_fields_labels']]) && $line[$map['text_fields_labels']]) ? $line[$map['text_fields_labels']] : $map_default_values['text_fields_labels'];
                                    $this->createProductCustomizableFields($product, "", $text_fields_labels, $multiple_value_separator);
                                }
                                break;
                            case 'fsproductvideo_url':
                                if (isset($line[$index]) && $line[$index] && $value_default) {
                                    $value .= $value ? $multiple_value_separator : "";
                                    $value .= $value_default;
                                }
                                $this->createFsProductVideoUrls($product, $value, $multiple_value_separator);
                                break;
                            case 'additionalproductsorder_ids':
                                if (isset($line[$index]) && $line[$index] && $value_default) {
                                    $value .= $value ? $multiple_value_separator : "";
                                    $value .= $value_default;
                                }
                                $this->createAdditionalproductsorderRelation($product, $value, $multiple_value_separator);
                                break;
                            case 'jmarketplace_seller_id':
                                $this->createJmarketplaceSellerRelation($product->id, $value);
                                break;
                            case 'productaffiliate_external_shop_url':
                                if (isset($line[$map['productaffiliate_button_text']]) || isset($map_default_values['productaffiliate_button_text'])) {
                                    $productaffiliate_button_text = isset($line[$map['productaffiliate_button_text']]) ? $line[$map['productaffiliate_button_text']] : $map_default_values['productaffiliate_button_text'];
                                    $this->createProductaffiliateRelation($product->id, $this->id_lang_default, $value, $productaffiliate_button_text);
                                }
                                break;
                            case 'iqitadditionaltabs_description':
                            case (preg_match("/^iqitadditionaltabs_description_([\d]+)$/", $attr, $match) ? true : false):
                                $iqit_count = isset($match[1]) ? (int) $match[1] : 1;
                                $iqit_suffix = isset($match[1]) ? '_' . $match[1] : "";
                                if (isset($line[$map['iqitadditionaltabs_title' . $iqit_suffix]]) || isset($map_default_values['iqitadditionaltabs_title' . $iqit_suffix])) {
                                    $iqitadditionaltabs_title = isset($line[$map['iqitadditionaltabs_title' . $iqit_suffix]]) ? $line[$map['iqitadditionaltabs_title' . $iqit_suffix]] : $map_default_values['iqitadditionaltabs_title' . $iqit_suffix];
                                    $this->createIqitadditionaltabsRelation($product->id, $iqitadditionaltabs_title, $value, $this->id_lang_default, $shop_ids, $iqit_count);
                                }
                                break;
                            case 'ecm_cmlid_xml':
                                if ($value) {
                                    $this->createEcmCmlidRelation($product->id, $value);
                                }
                                break;
                            case (preg_match("/^acf_([a-zA-Z0-9_]+)_([\d]+)$/", $attr, $match) ? true : false):
                                // id_lang is always added to the key in order to be able to extract id_lang from code
                                $this->createAdvancedcustomfieldsValue($product->id, $match[1], $value, $match[2]);
                                break;
                            case (preg_match("/^totcustomfields_([a-zA-Z0-9_]+)_([\d]+)$/", $attr, $match) ? true : false):
                                // id_lang is always added to the key in order to be able to extract id_lang from code
                                $this->createTotcustomfieldsValue($product->id, $match[1], $value, $match[2]);
                                break;
                            case 'pproperties_quantity_step':
                                $this->createPpropertiesRelation($product->id, null, $value, false, $shop_ids);
                                break;
                            case 'pproperties_minimal_quantity':
                                $this->createPpropertiesRelation($product->id, null, false, $value, $shop_ids);
                                break;
                            case 'bms_advancedstock_warehouse':
                                $bms_advancedstock_physical_quantity = (isset($line[$map['bms_advancedstock_physical_quantity']]) && $line[$map['bms_advancedstock_physical_quantity']] !== "") ? $line[$map['bms_advancedstock_physical_quantity']] : $map_default_values['bms_advancedstock_physical_quantity'];
                                $bms_advancedstock_available_quantity = (isset($line[$map['bms_advancedstock_available_quantity']]) && $line[$map['bms_advancedstock_available_quantity']] !== "") ? $line[$map['bms_advancedstock_available_quantity']] : $map_default_values['bms_advancedstock_available_quantity'];
                                $bms_advancedstock_reserved_quantity = (isset($line[$map['bms_advancedstock_reserved_quantity']]) && $line[$map['bms_advancedstock_reserved_quantity']] !== "") ? $line[$map['bms_advancedstock_reserved_quantity']] : $map_default_values['bms_advancedstock_reserved_quantity'];
                                $bms_advanced_stock_shelf_location = (isset($line[$map['bms_advanced_stock_shelf_location']]) && $line[$map['bms_advanced_stock_shelf_location']]) ? $line[$map['bms_advanced_stock_shelf_location']] : $map_default_values['bms_advanced_stock_shelf_location'];
                                $this->createBmsAdvancedstockRelation($product->id, 0, $value, $bms_advancedstock_physical_quantity, $bms_advancedstock_available_quantity, $bms_advancedstock_reserved_quantity, $bms_advanced_stock_shelf_location, $shop_ids);
                                break;
                            case 'wk_measurement_allowed':
                                $wk_measurement_type = (isset($line[$map['wk_measurement_type']]) && $line[$map['wk_measurement_type']]) ? $line[$map['wk_measurement_type']] : $map_default_values['wk_measurement_type'];
                                $wk_measurement_value = (isset($line[$map['wk_measurement_value']]) && $line[$map['wk_measurement_value']]) ? $line[$map['wk_measurement_value']] : $map_default_values['wk_measurement_value'];
                                $wk_measurement_unit = (isset($line[$map['wk_measurement_unit']]) && $line[$map['wk_measurement_unit']] !== "") ? $line[$map['wk_measurement_unit']] : $map_default_values['wk_measurement_unit'];
                                $wk_measurement_units_for_customer = (isset($line[$map['wk_measurement_units_for_customer']]) && $line[$map['wk_measurement_units_for_customer']]) ? $line[$map['wk_measurement_units_for_customer']] : $map_default_values['wk_measurement_units_for_customer'];
                                $this->createWkgrocerymanagementRelation($product->id, $value, $wk_measurement_type, $wk_measurement_value, $wk_measurement_unit, $wk_measurement_units_for_customer, $multiple_value_separator, $shop_ids);
                                break;
                            case 'msrp_price_tax_excl':
                                $this->createMsrpRelation($product->id, 0, $product->id_tax_rules_group, $value, false, $shop_ids);
                                break;
                            case 'msrp_price_tax_incl':
                                $this->createMsrpRelation($product->id, 0, $product->id_tax_rules_group, $value, true, $shop_ids);
                                break;
                            default:
                                break;
                        }
                    }

                    if ($product->advanced_stock_management == 0 && StockAvailable::dependsOnStock($product->id) == 1) {
                        StockAvailable::setProductDependsOnStock($product->id, 0);
                    }
                    if (!empty($product_categories_ids)) {
                        $product->updateCategories($product_categories_ids);
                    }
                    if ($product->id_category_default) {
                        $category_exists = Db::getInstance()->getRow("SELECT * FROM `" . _DB_PREFIX_ . "category_product` WHERE `id_category` = " . (int) $product->id_category_default . " AND `id_product` = " . (int) $product->id, false);
                        if (!$category_exists) {
                            $product->addToCategories($product->id_category_default);
                        }
                    }
                    // Disable product if it has no image
                    if ($this->disable_if_no_image) {
                        if (empty(Image::getImages($this->id_lang_default, $product->id))) {
                            $product->active = 0;
                            $product->update();
                        }
                    }

                    // Process 3rd party module integration
                    // Module: areapacks
                    if (isset($map['areapacks_label']) && isset($map['areapacks_type']) && isset($map['areapacks_area'])) {
                        $areapacks_label = (isset($line[$map['areapacks_label']]) && $line[$map['areapacks_label']]) ? $line[$map['areapacks_label']] : $map_default_values['areapacks_label'];
                        $areapacks_type = (isset($line[$map['areapacks_type']]) && $line[$map['areapacks_type']]) ? $line[$map['areapacks_type']] : $map_default_values['areapacks_type'];
                        $areapacks_area = (isset($line[$map['areapacks_area']]) && $line[$map['areapacks_area']] !== "") ? $line[$map['areapacks_area']] : $map_default_values['areapacks_area'];
                        if ($areapacks_label || $areapacks_type || $areapacks_area !== "") {
                            $this->createAreapacksRelation($product->id, 0, $areapacks_label, $areapacks_type, $areapacks_area);
                        }
                    }

                    // Set context shop back to its original value
                    Shop::setContext($context_shop, $id_shop_context);
                } catch (Exception $e) {
                    $this->addError('Exception: ' . $e->getMessage());
                    if ($settings['is_debug_mode']) {
                        $this->currentHistory->date_ended = date('Y-m-d H:i:s');
                        $this->currentHistory->update();
                        throw new Exception($e->getMessage());
                    }
                }
            }
            // We need this update because it may fail to update at the end, if timeout error happens.
            $this->currentHistory->date_ended = date('Y-m-d H:i:s');
            $this->currentHistory->update();
        }
        return true;
    }

    public function importCombinations($limit)
    {
        $map = $this->getMap();
        $map_default_values = $this->getMapDefaultValues();
        $file = ElegantalEasyImportTools::getRealPath($this->csv_file);
        $csv_header = ElegantalEasyImportCsv::getCsvHeaderRow($file, $this->header_row, $this->is_utf8_encode);
        $id_shop_context = $this->context->shop->id;
        $context_shop = Shop::getContext();
        $settings = $this->getModuleSettings();
        $update_products_on_all_shops = $this->update_products_on_all_shops && Shop::isFeatureActive();
        $multiple_value_separator = $this->multiple_value_separator;
        $skip_product_from_update_if_reference_has_sign = explode(',', $settings['skip_product_from_update_if_reference_has_sign']);
        $attribute_class = (_PS_VERSION_ >= '8.0.0') ? 'ProductAttribute' : 'Attribute';

        $shop_ids = array();
        if ($update_products_on_all_shops) {
            $shop_groups = Shop::getTree();
            foreach ($shop_groups as $shop_group) {
                foreach ($shop_group['shops'] as $shop) {
                    $shop_ids[] = $shop['id_shop'];
                }
            }
        }
        if (empty($shop_ids)) {
            $shop_ids = array($id_shop_context);
        }

        $groups = array();
        $attributes_groups = AttributeGroup::getAttributesGroups($this->id_lang_default);
        foreach ($attributes_groups as $group) {
            $groups[Tools::strtolower($group['name'])] = (int) $group['id_attribute_group'];
        }

        $attributes = array();
        foreach ($attribute_class::getAttributes($this->id_lang_default) as $attribute) {
            $attributes[Tools::strtolower($attribute['attribute_group']) . '_' . Tools::strtolower($attribute['name'])] = (int) $attribute['id_attribute'];
        }

        $csvRows = ElegantalEasyImportData::model()->findAll(array(
            'condition' => array(
                'id_elegantaleasyimport' => $this->id,
            ),
            'limit' => $limit,
        ));

        foreach ($csvRows as $csvRow) {
            $csvRowModel = new ElegantalEasyImportData($csvRow['id_elegantaleasyimport_data']);
            if (!Validate::isLoadedObject($csvRowModel)) {
                continue;
            }

            $line = ElegantalEasyImportTools::unserialize($csvRowModel->csv_row);

            // We don't need this row in database anymore
            $csvRowModel->delete();

            $this->currentHistory->number_of_products_processed++;

            // We need this update because the current row is already deleted and number_of_products_processed should be saved.
            // It may fail to save by the end of importing this row.
            $this->currentHistory->update();

            $id_reference_index = $map['id_reference'];
            $id_reference = "";
            if (isset($line[$id_reference_index])) {
                $id_reference = trim($line[$id_reference_index]);
            }
            $this->current_id_reference = $id_reference;

            // If shop is given in import file, use it for the context
            $shop_map = (isset($line[$map['shop']]) && $line[$map['shop']]) ? $line[$map['shop']] : $map_default_values['shop'];
            $id_shop_map = $this->getShopIdByName($shop_map);
            if ($id_shop_map) {
                $id_shop = $id_shop_map;
                $shop_ids = array($id_shop);
                Shop::setContext(Shop::CONTEXT_SHOP, $id_shop);
            } else {
                $id_shop = $this->context->shop->id;
            }

            $id_reference_column = $this->getReferenceColumn();

            $combination_id = (isset($line[$map['combination_id']]) && $line[$map['combination_id']]) ? trim($line[$map['combination_id']]) : trim($map_default_values['combination_id']);
            $combination_reference = (isset($line[$map['combination_reference']]) && $line[$map['combination_reference']]) ? trim($line[$map['combination_reference']]) : trim($map_default_values['combination_reference']);
            $combination_ean = (isset($line[$map['combination_ean']]) && $line[$map['combination_ean']]) ? trim($line[$map['combination_ean']]) : trim($map_default_values['combination_ean']);
            $combination_supplier_reference = (isset($line[$map['supplier_reference']]) && $line[$map['supplier_reference']]) ? trim($line[$map['supplier_reference']]) : trim($map_default_values['supplier_reference']);

            $products_rows = array();
            if ($id_reference) {
                $sql = "SELECT DISTINCT p.`id_product` FROM `" . _DB_PREFIX_ . "product` p ";
                if ($this->find_products_by == 'supplier_reference' || $this->supplier_id) {
                    $sql .= "INNER JOIN `" . _DB_PREFIX_ . "product_supplier` ps ON (ps.`id_product` = p.`id_product` AND ps.`id_product_attribute` = 0) ";
                }
                $sql .= "WHERE " . pSQL($id_reference_column) . " = '" . pSQL($id_reference) . "' ";
                if ($this->supplier_id) {
                    $sql .= "AND ps.`id_supplier` = " . (int) $this->supplier_id . " ";
                }
                $products_rows = Db::getInstance()->executeS($sql);
            }
            if (empty($products_rows)) { // Find product by Combination
                if ($combination_id) {
                    $sql = "SELECT pa.`id_product`, pa.`id_product_attribute` FROM `" . _DB_PREFIX_ . "product_attribute` pa ";
                    if ($this->supplier_id) {
                        $sql .= "INNER JOIN `" . _DB_PREFIX_ . "product_supplier` ps ON (ps.`id_product` = pa.`id_product` AND ps.`id_product_attribute` = pa.`id_product_attribute`) ";
                    }
                    $sql .= "WHERE pa.`id_product_attribute` = " . (int) $combination_id . " ";
                    if ($this->supplier_id) {
                        $sql .= "AND ps.`id_supplier` = " . (int) $this->supplier_id . " ";
                    }
                    $sql .= "GROUP BY pa.`id_product`, pa.`id_product_attribute`";
                    $products_rows = Db::getInstance()->executeS($sql);
                }
                if (empty($products_rows) && $combination_reference) {
                    $sql = "SELECT pa.`id_product`, pa.`id_product_attribute` FROM `" . _DB_PREFIX_ . "product_attribute` pa ";
                    if ($this->supplier_id) {
                        $sql .= "INNER JOIN `" . _DB_PREFIX_ . "product_supplier` ps ON (ps.`id_product` = pa.`id_product` AND ps.`id_product_attribute` = pa.`id_product_attribute`) ";
                    }
                    $sql .= "WHERE pa.`reference` = '" . pSQL($combination_reference) . "' ";
                    if ($this->supplier_id) {
                        $sql .= "AND ps.`id_supplier` = " . (int) $this->supplier_id . " ";
                    }
                    $sql .= "GROUP BY pa.`id_product`, pa.`id_product_attribute`";
                    $products_rows = Db::getInstance()->executeS($sql);
                }
                if (empty($products_rows) && $combination_ean) {
                    $sql = "SELECT pa.`id_product`, pa.`id_product_attribute` FROM `" . _DB_PREFIX_ . "product_attribute` pa ";
                    if ($this->supplier_id) {
                        $sql .= "INNER JOIN `" . _DB_PREFIX_ . "product_supplier` ps ON (ps.`id_product` = pa.`id_product` AND ps.`id_product_attribute` = pa.`id_product_attribute`) ";
                    }
                    $sql .= "WHERE pa.`ean13` = '" . pSQL($combination_ean) . "' ";
                    if ($this->supplier_id) {
                        $sql .= "AND ps.`id_supplier` = " . (int) $this->supplier_id . " ";
                    }
                    $sql .= "GROUP BY pa.`id_product`, pa.`id_product_attribute`";
                    $products_rows = Db::getInstance()->executeS($sql);
                }
                if (empty($products_rows) && $combination_supplier_reference) {
                    $sql = "SELECT pa.`id_product`, pa.`id_product_attribute` FROM `" . _DB_PREFIX_ . "product_attribute` pa ";
                    if ($this->supplier_id) {
                        $sql .= "INNER JOIN `" . _DB_PREFIX_ . "product_supplier` ps ON (ps.`id_product` = pa.`id_product` AND ps.`id_product_attribute` = pa.`id_product_attribute`) ";
                    }
                    $sql .= "WHERE pa.`supplier_reference` = '" . pSQL($combination_supplier_reference) . "' ";
                    if ($this->supplier_id) {
                        $sql .= "AND ps.`id_supplier` = " . (int) $this->supplier_id . " ";
                    }
                    $sql .= "GROUP BY pa.`id_product`, pa.`id_product_attribute`";
                    $products_rows = Db::getInstance()->executeS($sql);
                }
            }

            if (empty($products_rows)) {
                // $this->addError("Product not found.");
                continue;
            }

            foreach ($products_rows as $product_row) {
                try {
                    $product = null;
                    $id_product_attribute = 0;
                    if ($product_row && isset($product_row['id_product']) && $product_row['id_product'] > 0) {
                        $id_shop_for_product = $id_shop_context;
                        if ($update_products_on_all_shops) {
                            if (isset($product_row['id_shop_default']) && $product_row['id_shop_default'] != $id_shop_context) {
                                $id_shop_for_product = $product_row['id_shop_default'];
                            }
                        } elseif ($this->find_products_by != 'id') {
                            // Check if product exists in context shop
                            $sql = "SELECT `id_product` FROM `" . _DB_PREFIX_ . "product_shop` WHERE `id_product` = " . (int) $product_row['id_product'] . " AND `id_shop` = " . (int) $id_shop_context;
                            $product_exists_in_current_shop = (int) Db::getInstance()->getValue($sql);
                            if (!$product_exists_in_current_shop) {
                                continue;
                            }
                        }
                        $product = new Product($product_row['id_product'], false, $this->id_lang_default, $id_shop_for_product);
                    }
                    if ($product_row && isset($product_row['id_product_attribute']) && $product_row['id_product_attribute'] > 0) {
                        $id_product_attribute = (int) $product_row['id_product_attribute'];
                    }

                    if (!Validate::isLoadedObject($product)) {
                        $this->addError("Product could not be loaded.");
                        continue;
                    }

                    if ($settings['skip_product_from_update_if_id_exists_in']) {
                        $skip_product_from_update_if_id_exists_in = explode(',', preg_replace("/[^0-9,]/", "", $settings['skip_product_from_update_if_id_exists_in']));
                        if ($skip_product_from_update_if_id_exists_in && is_array($skip_product_from_update_if_id_exists_in) && in_array($product->id, $skip_product_from_update_if_id_exists_in)) {
                            continue;
                        }
                    }
                    if ($settings['skip_product_from_update_if_reference_has_sign'] && $product->reference && str_replace($skip_product_from_update_if_reference_has_sign, '', $product->reference) != $product->reference) {
                        continue;
                    }

                    $product->depends_on_stock = (int) StockAvailable::dependsOnStock($product->id);

                    // Prepare attributes and values per language
                    $csv_attribute_groups = array();
                    $csv_attribute_values = array();
                    $attribute_names = array();
                    $attribute_values = array();
                    foreach ($this->id_all_langs as $id_lang) {
                        if (isset($line[$map['attribute_names_' . $id_lang]]) && $line[$map['attribute_names_' . $id_lang]]) {
                            $attribute_names[$id_lang] = $line[$map['attribute_names_' . $id_lang]];
                        }
                        if ($map_default_values['attribute_names_' . $id_lang]) {
                            if (!isset($attribute_names[$id_lang])) {
                                $attribute_names[$id_lang] = "";
                            }
                            $attribute_names[$id_lang] .= (isset($attribute_names[$id_lang]) && $attribute_names[$id_lang]) ? $multiple_value_separator : "";
                            $attribute_names[$id_lang] .= $map_default_values['attribute_names_' . $id_lang];
                        }
                        if (isset($line[$map['attribute_values_' . $id_lang]]) && $line[$map['attribute_values_' . $id_lang]]) {
                            $attribute_values[$id_lang] = $line[$map['attribute_values_' . $id_lang]];
                        }
                        if ($map_default_values['attribute_values_' . $id_lang]) {
                            if (!isset($attribute_values[$id_lang])) {
                                $attribute_values[$id_lang] = "";
                            }
                            $attribute_values[$id_lang] .= (isset($attribute_values[$id_lang]) && $attribute_values[$id_lang]) ? $multiple_value_separator : "";
                            $attribute_values[$id_lang] .= $map_default_values['attribute_values_' . $id_lang];
                        }
                    }
                    foreach ($map as $attr => $index) {
                        // Skip if neither mapped nor provided default value
                        if ($index < 0 && $map_default_values[$attr] === "") {
                            continue;
                        }
                        switch ($attr) {
                            case (preg_match("/^attribute_([\d]+)_([\d]+)$/", $attr, $match) ? true : false):
                                $id_lang = $match[2];
                                if ($index >= 0 && isset($line[$index]) && $line[$index] && isset($csv_header[$index]) && $csv_header[$index]) {
                                    if (!isset($attribute_names[$id_lang])) {
                                        $attribute_names[$id_lang] = "";
                                    }
                                    if (!isset($attribute_values[$id_lang])) {
                                        $attribute_values[$id_lang] = "";
                                    }
                                    $attribute_names[$id_lang] .= (isset($attribute_names[$id_lang]) && $attribute_names[$id_lang]) ? $multiple_value_separator : "";
                                    $attribute_names[$id_lang] .= str_replace(":", "∶", trim($csv_header[$index])) . ':select';
                                    $attribute_values[$id_lang] .= (isset($attribute_values[$id_lang]) && $attribute_values[$id_lang]) ? $multiple_value_separator : "";
                                    $attribute_values[$id_lang] .= str_replace(":", "∶", trim($line[$index]));
                                }
                                if (isset($map_default_values[$attr]) && $map_default_values[$attr]) {
                                    $attribute_name_default = explode(':', $map_default_values[$attr]);
                                    if (isset($attribute_name_default[0]) && $attribute_name_default[0] && isset($attribute_name_default[1]) && $attribute_name_default[1]) {
                                        if (!isset($attribute_names[$id_lang])) {
                                            $attribute_names[$id_lang] = "";
                                        }
                                        if (!isset($attribute_values[$id_lang])) {
                                            $attribute_values[$id_lang] = "";
                                        }
                                        $attribute_names[$id_lang] .= (isset($attribute_names[$id_lang]) && $attribute_names[$id_lang]) ? $multiple_value_separator : "";
                                        $attribute_names[$id_lang] .= $attribute_name_default[0] . ':select';
                                        $attribute_values[$id_lang] .= (isset($attribute_values[$id_lang]) && $attribute_values[$id_lang]) ? $multiple_value_separator : "";
                                        $attribute_values[$id_lang] .= $attribute_name_default[1];
                                    }
                                }

                                break;
                            default:
                                break;
                        }
                    }
                    if ($attribute_names) {
                        foreach ($attribute_names as $id_lang => $attr_names) {
                            $attribute_names[$id_lang] = explode($multiple_value_separator, $attr_names);
                            foreach ($attribute_names[$id_lang] as $key => $attr_group_line) {
                                $attr_group_parts = explode(':', $attr_group_line);
                                $attribute_names[$id_lang][$key] = array('name' => "", 'public_name' => "", 'type' => "", 'position' => "");
                                if (is_array($attr_group_parts) && count($attr_group_parts) == 4) {
                                    $attribute_names[$id_lang][$key]['name'] = trim($attr_group_parts[0]);
                                    $attribute_names[$id_lang][$key]['public_name'] = trim($attr_group_parts[1]);
                                    $attribute_names[$id_lang][$key]['type'] = Tools::strtolower(trim($attr_group_parts[2]));
                                    $attribute_names[$id_lang][$key]['position'] = (int) $attr_group_parts[3];
                                } else {
                                    $attribute_names[$id_lang][$key]['name'] = trim($attr_group_parts[0]);
                                    $attribute_names[$id_lang][$key]['public_name'] = $attribute_names[$id_lang][$key]['name'];
                                    $attribute_names[$id_lang][$key]['type'] = isset($attr_group_parts[1]) ? Tools::strtolower(trim($attr_group_parts[1])) : 'select';
                                    $attribute_names[$id_lang][$key]['position'] = isset($attr_group_parts[2]) ? (int) $attr_group_parts[2] : false;
                                }
                            }
                        }
                        if (is_array($attribute_names[$this->id_lang_default]) && count($attribute_names[$this->id_lang_default]) > 0) {
                            foreach ($attribute_names[$this->id_lang_default] as $key => $attr_group_parts) {
                                $csv_attribute_groups[$key]['group'] = $attr_group_parts['name'];
                                if (isset($groups[Tools::strtolower($attr_group_parts['name'])])) {
                                    $csv_attribute_groups[$key]['id'] = $groups[Tools::strtolower($attr_group_parts['name'])];
                                } else {
                                    $attributeGroup = new AttributeGroup();
                                    $attributeGroup->is_color_group = ($attr_group_parts['type'] == 'color') ? 1 : 0;
                                    $attributeGroup->group_type = in_array($attr_group_parts['type'], array('select', 'color', 'radio')) ? $attr_group_parts['type'] : 'select';
                                    $attributeGroup->name[$this->id_lang_default] = $this->getDictionaryValue('attribute_name', $attr_group_parts['name'], $line, $csv_header);
                                    $attributeGroup->public_name[$this->id_lang_default] = $this->getDictionaryValue('attribute_name', $attr_group_parts['public_name'], $line, $csv_header);
                                    foreach ($this->id_other_langs as $id_lang) {
                                        if (isset($attribute_names[$id_lang][$key]['name']) && $attribute_names[$id_lang][$key]['name']) {
                                            $attributeGroup->name[$id_lang] = $attribute_names[$id_lang][$key]['name'];
                                        } else {
                                            $attributeGroup->name[$id_lang] = $attributeGroup->name[$this->id_lang_default];
                                        }
                                        if (isset($attribute_names[$id_lang][$key]['public_name']) && $attribute_names[$id_lang][$key]['public_name']) {
                                            $attributeGroup->public_name[$id_lang] = $attribute_names[$id_lang][$key]['public_name'];
                                        } else {
                                            $attributeGroup->public_name[$id_lang] = $attributeGroup->public_name[$this->id_lang_default];
                                        }
                                    }
                                    $attributeGroup->position = (!$attr_group_parts['position']) ? AttributeGroup::getHigherPosition() + 1 : $attr_group_parts['position'];
                                    $attributeGroup->add();
                                    $attributeGroup->associateTo($shop_ids);
                                    $groups[Tools::strtolower($attr_group_parts['name'])] = $attributeGroup->id;
                                    $csv_attribute_groups[$key]['id'] = $attributeGroup->id;
                                    AttributeGroup::cleanPositions();
                                }
                            }
                        }
                    }
                    if ($attribute_values) {
                        foreach ($attribute_values as $id_lang => $attr_values) {
                            $attribute_values[$id_lang] = explode($multiple_value_separator, $attr_values);
                            foreach ($attribute_values[$id_lang] as $key => $attr_value_line) {
                                $attr_value_parts = explode(':', $attr_value_line);
                                $attribute_values[$id_lang][$key] = array('value' => $attr_value_parts[0], 'position' => (isset($attr_value_parts[1]) ? (int) $attr_value_parts[1] : false));
                            }
                        }
                        if (is_array($attribute_values[$this->id_lang_default]) && count($attribute_values[$this->id_lang_default]) > 0) {
                            foreach ($attribute_values[$this->id_lang_default] as $key => $attr_value_parts) {
                                if (!isset($csv_attribute_groups[$key])) {
                                    continue;
                                }
                                $attribute_group = Tools::strtolower($csv_attribute_groups[$key]['group']);
                                $attr_value = str_replace('\n', '', str_replace('\r', '', trim($attr_value_parts['value'])));
                                $attr_position = $attr_value_parts['position'];
                                if (empty($attr_value)) {
                                    continue;
                                }
                                if (isset($attributes[$attribute_group . '_' . Tools::strtolower($attr_value)])) {
                                    $csv_attribute_values[$key] = $attributes[$attribute_group . '_' . Tools::strtolower($attr_value)];
                                } else {
                                    $attributeGroupTmp = new AttributeGroup($csv_attribute_groups[$key]['id']);
                                    if (Validate::isLoadedObject($attributeGroupTmp)) {
                                        $attributeObj = new $attribute_class();
                                        $attributeObj->id_attribute_group = (int) $csv_attribute_groups[$key]['id'];
                                        $attributeObj->name[$this->id_lang_default] = $this->getDictionaryValue('attribute_value', $attr_value, $line, $csv_header);
                                        foreach ($this->id_other_langs as $id_lang) {
                                            if (isset($attribute_values[$id_lang][$key]['value']) && $attribute_values[$id_lang][$key]['value']) {
                                                $attributeObj->name[$id_lang] = $attribute_values[$id_lang][$key]['value'];
                                            } else {
                                                $attributeObj->name[$id_lang] = $attributeObj->name[$this->id_lang_default];
                                            }
                                        }
                                        $attributeObj->position = (!$attr_position && isset($groups[$attribute_group])) ? $attribute_class::getHigherPosition($groups[$attribute_group]) + 1 : $attr_position;
                                        if ($attributeGroupTmp->group_type == 'color') {
                                            $attributeObj->color = (isset($line[$map['color_hex_value']]) && $line[$map['color_hex_value']]) ? $this->getDictionaryValue('color_hex_value', $line[$map['color_hex_value']], $line, $csv_header) : $map_default_values['color_hex_value'];
                                            if (Tools::strlen($attributeObj->color) == 6 && Tools::substr($attributeObj->color, 0, 1) != '#') {
                                                $attributeObj->color = '#' . $attributeObj->color;
                                            }
                                        }
                                        $attributeObj->add();
                                        $attributeObj->associateTo($shop_ids);
                                        $attributes[$attribute_group . '_' . Tools::strtolower($attr_value)] = $attributeObj->id;
                                        $csv_attribute_values[$key] = $attributeObj->id;
                                        // After insertion, we clean attribute position and group attribute position
                                        $attributeObj->cleanPositions((int) $attributeObj->id_attribute_group, false);
                                        AttributeGroup::cleanPositions();
                                        // If there is texture for color attribute, move the image to img/co folder
                                        $texture = (isset($line[$map['color_texture']]) && $line[$map['color_texture']]) ? $line[$map['color_texture']] : $map_default_values['color_texture'];
                                        if ($attributeGroupTmp->group_type == 'color' && $texture) {
                                            try {
                                                if ($this->base_url_images && !ElegantalEasyImportTools::isValidUrl($texture)) {
                                                    if (strpos($this->base_url_images, '%s') !== false) {
                                                        $texture = str_replace('%s', $texture, $this->base_url_images);
                                                    } elseif (!ElegantalEasyImportTools::isValidUrl($texture)) {
                                                        $texture = $this->base_url_images . $texture;
                                                    }
                                                }
                                                ElegantalEasyImportTools::downloadFileFromUrl($texture, _PS_COL_IMG_DIR_ . $attributeObj->id . '.jpg');
                                            } catch (Exception $e) {
                                                $this->addError('Failed to download texture: ' . $texture . ' ' . $e->getMessage(), $product);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    $combination_data = array(
                        'combination_id' => '',
                        'combination_reference' => '',
                        'combination_ean' => '',
                        'quantity' => null,
                        'minimal_quantity' => 1,
                        'stock_location' => '',
                        'low_stock_threshold' => null,
                        'low_stock_alert' => 0,
                        'wholesale_price' => 0,
                        'combination_price' => null,
                        'impact_on_price' => 0,
                        'impact_on_weight' => 0,
                        'impact_on_unit_price' => 0,
                        'images' => null,
                        'supplier_reference' => '',
                        'supplier_price' => 0,
                        'upc' => '',
                        'isbn' => '',
                        'mpn' => '',
                        'ecotax' => 0,
                        'default' => null,
                        'available_date' => null,
                    );

                    if (!$id_product_attribute) {
                        if ($combination_id) {
                            $id_product_attribute = (int) Db::getInstance()->getValue("SELECT `id_product_attribute` FROM `" . _DB_PREFIX_ . "product_attribute` WHERE `id_product_attribute` = " . (int) $combination_id);
                        }
                        if (!$id_product_attribute && $combination_reference) {
                            $id_product_attribute = (int) Db::getInstance()->getValue("SELECT `id_product_attribute` FROM `" . _DB_PREFIX_ . "product_attribute` WHERE `reference` = '" . pSQL($combination_reference) . "' AND `id_product` = " . (int) $product->id);
                        }
                        if (!$id_product_attribute && $combination_ean) {
                            $id_product_attribute = (int) Db::getInstance()->getValue("SELECT `id_product_attribute` FROM `" . _DB_PREFIX_ . "product_attribute` WHERE `ean13` = '" . pSQL($combination_ean) . "' AND `id_product` = " . (int) $product->id);
                        }
                        if (!$id_product_attribute && $combination_supplier_reference) {
                            $id_product_attribute = (int) Db::getInstance()->getValue("SELECT `id_product_attribute` FROM `" . _DB_PREFIX_ . "product_attribute` WHERE `supplier_reference` = '" . pSQL($combination_supplier_reference) . "' AND `id_product` = " . (int) $product->id);
                        }
                    }

                    // If combination does not exist, check if combination with the same attributes exists
                    if (!$id_product_attribute && count($csv_attribute_values) > 0) {
                        $id_product_attribute = (int) $product->productAttributeExists($csv_attribute_values, false, null, true, true);
                    }

                    // Check if creating or updating combination allowed
                    if (($id_product_attribute && !$this->update_existing_products) || (!$id_product_attribute && !$this->create_new_products)) {
                        continue;
                    }

                    if ($id_product_attribute) {
                        $existingCombination = new Combination($id_product_attribute);

                        // Skip this combination if the combination reference contains specified symbol
                        if ($settings['skip_product_from_update_if_reference_has_sign'] && $existingCombination->reference && str_replace($skip_product_from_update_if_reference_has_sign, '', $existingCombination->reference) != $existingCombination->reference) {
                            continue;
                        }

                        $combination_data = array(
                            'combination_reference' => $existingCombination->reference,
                            'combination_ean' => $existingCombination->ean13,
                            'quantity' => StockAvailable::getQuantityAvailableByProduct($product->id, $id_product_attribute),
                            'minimal_quantity' => $existingCombination->minimal_quantity,
                            'stock_location' => '',
                            'low_stock_threshold' => $existingCombination->low_stock_threshold,
                            'low_stock_alert' => $existingCombination->low_stock_alert,
                            'wholesale_price' => $existingCombination->wholesale_price,
                            'combination_price' => null,
                            'impact_on_price' => $existingCombination->price,
                            'impact_on_weight' => $existingCombination->weight,
                            'impact_on_unit_price' => $existingCombination->unit_price_impact,
                            'images' => null,
                            'supplier_reference' => $existingCombination->supplier_reference,
                            'supplier_price' => null,
                            'upc' => $existingCombination->upc,
                            'isbn' => $existingCombination->isbn,
                            'mpn' => (property_exists($existingCombination, 'mpn')) ? $existingCombination->mpn : "",
                            'ecotax' => $existingCombination->ecotax,
                            'default' => $existingCombination->default_on,
                            'available_date' => $existingCombination->available_date,
                        );
                    }

                    foreach ($map as $attr => $index) {
                        // Skip if neither mapped nor provided default value
                        if ($index < 0 && $map_default_values[$attr] === "") {
                            continue;
                        }

                        $value = isset($line[$index]) ? $line[$index] : "";
                        $value_default = isset($map_default_values[$attr]) ? $map_default_values[$attr] : "";
                        $value = ($value === "") ? trim($value_default) : trim($value);
                        $value = $this->getDictionaryValue($attr, $value, $line, $csv_header);

                        switch ($attr) {
                            case 'combination_reference':
                                $combination_data['combination_reference'] = $value;
                                break;
                            case 'combination_price':
                                if ($value) {
                                    $currency = (isset($line[$map['price_currency']]) && $line[$map['price_currency']]) ? $line[$map['price_currency']] : $map_default_values['price_currency'];
                                    $currency = $this->getDictionaryValue('price_currency', $currency, $line, $csv_header);
                                    $value = (float) $this->extractPriceInDefaultCurrency($value, $currency);
                                    $value = ElegantalEasyImportTools::getModifiedPriceByFormula($value, $this->price_modifier);
                                    $combination_data['impact_on_price'] = round(($value - $product->price), 6);
                                }
                                break;
                            case 'wholesale_price':
                                $currency = (isset($line[$map['price_currency']]) && $line[$map['price_currency']]) ? $line[$map['price_currency']] : $map_default_values['price_currency'];
                                $currency = $this->getDictionaryValue('price_currency', $currency, $line, $csv_header);
                                $combination_data['wholesale_price'] = (float) $this->extractPriceInDefaultCurrency($value, $currency);
                                if ($map_default_values['wholesale_price'] && preg_match("/\[FORMULA:([\s\+\.\;\*\/\-\d]+)\]/", $map_default_values['wholesale_price'], $match)) {
                                    $combination_data['wholesale_price'] = ElegantalEasyImportTools::getModifiedPriceByFormula($combination_data['wholesale_price'], $match[1]);
                                }
                                break;
                            case 'impact_on_price':
                                $currency = (isset($line[$map['price_currency']]) && $line[$map['price_currency']]) ? $line[$map['price_currency']] : $map_default_values['price_currency'];
                                $currency = $this->getDictionaryValue('price_currency', $currency, $line, $csv_header);
                                $combination_data['impact_on_price'] = ElegantalEasyImportTools::getModifiedPriceByFormula((float) $this->extractPriceInDefaultCurrency($value, $currency), $this->price_modifier);
                                break;
                            case 'impact_on_weight':
                                $combination_data['impact_on_weight'] = (float) str_replace(',', '.', $value);
                                break;
                            case 'impact_on_unit_price':
                                $currency = (isset($line[$map['price_currency']]) && $line[$map['price_currency']]) ? $line[$map['price_currency']] : $map_default_values['price_currency'];
                                $currency = $this->getDictionaryValue('price_currency', $currency, $line, $csv_header);
                                $combination_data['impact_on_unit_price'] = (float) $this->extractPriceInDefaultCurrency($value, $currency);
                                break;
                            case 'advanced_stock_management':
                                $product->advanced_stock_management = $this->isCsvValueTrue($value) ? 1 : 0;
                                $product->update();
                                break;
                            case 'depends_on_stock':
                                $value = $this->isCsvValueTrue($value) ? 1 : 0;
                                if (!$product->advanced_stock_management) {
                                    $value = 0;
                                }
                                $product->depends_on_stock = $value;
                                StockAvailable::setProductDependsOnStock($product->id, $product->depends_on_stock);
                                break;
                            case 'quantity':
                                if ($value !== "") {
                                    $value = str_replace(" ", "", $value);
                                    if (strpos($value, ",") !== false && strpos($value, ".") !== false) {
                                        $value = str_replace(",", "", $value);
                                    }
                                    $value = $settings['product_quantity_data_type'] == 'float' ? (float) $value : (int) $value;
                                    $value = $value < 0 ? 0 : $value;
                                    $combination_data['quantity'] = $value;
                                }
                                break;
                            case 'minimal_quantity':
                                $combination_data['minimal_quantity'] = ($value >= 1) ? (int) $value : 1;
                                break;
                            case 'stock_location':
                                $value = Tools::substr($value, 0, 64);
                                $combination_data['stock_location'] = $value;
                                break;
                            case 'low_stock_level':
                                $combination_data['low_stock_threshold'] = (int) $value;
                                break;
                            case 'email_alert_on_low_stock':
                                $combination_data['low_stock_alert'] = $this->isCsvValueTrue($value) ? 1 : 0;
                                break;
                            case 'ecotax':
                                $combination_data['ecotax'] = Configuration::get('PS_USE_ECOTAX') ? (float) str_replace(',', '.', $value) : 0;
                                break;
                            case 'delete_existing_images':
                                if ($value && $this->isCsvValueTrue($value) && $id_product_attribute) {
                                    // Delete combinations images completely if they are not used by other combinations, otherwise just un-assign them from this combination.
                                    $sql = "SELECT * FROM `" . _DB_PREFIX_ . "product_attribute_image`
                                        WHERE `id_product_attribute`=" . (int) $id_product_attribute . " AND `id_image` NOT IN (SELECT `id_image` FROM `" . _DB_PREFIX_ . "product_attribute_image` WHERE `id_product_attribute` != " . (int) $id_product_attribute . ")";
                                    $product_attribute_images = Db::getInstance()->executeS($sql);
                                    if ($product_attribute_images && is_array($product_attribute_images)) {
                                        foreach ($product_attribute_images as $product_attribute_image) {
                                            $image = new Image($product_attribute_image['id_image']);
                                            if (Validate::isLoadedObject($image)) {
                                                $image->delete();
                                            }
                                        }
                                    }
                                    Db::getInstance()->execute("DELETE FROM `" . _DB_PREFIX_ . "product_attribute_image` WHERE `id_product_attribute`=" . (int) $id_product_attribute);
                                }
                                break;
                            case 'images':
                            case 'default_image':
                            case (preg_match("/^image_[\d]+$/", $attr) ? true : false):
                                if (isset($line[$index]) && $line[$index] && $value_default && $attr != 'default_image') {
                                    $value .= $value ? $multiple_value_separator : "";
                                    $value .= $value_default;
                                }
                                if ($value) {
                                    $default_image = "";
                                    $captions = array();
                                    if ($attr == 'images') {
                                        foreach ($this->id_all_langs as $id_lang) {
                                            $captions[$id_lang] = (isset($line[$map['captions_' . $id_lang]]) && $line[$map['captions_' . $id_lang]]) ? array_map('trim', explode($multiple_value_separator, $line[$map['captions_' . $id_lang]])) : array_map('trim', explode($multiple_value_separator, $map_default_values['captions_' . $id_lang]));
                                        }
                                    } elseif ($attr == 'default_image') {
                                        $default_images = explode($multiple_value_separator, $value);
                                        if ($default_images && is_array($default_images)) {
                                            if (count($default_images) > 1) {
                                                if (Tools::strtoupper($map_default_values['default_image']) == "LAST") {
                                                    $default_image = end($default_images);
                                                } elseif (Validate::isInt($map_default_values['default_image']) && isset($default_images[$map_default_values['default_image'] - 1])) {
                                                    $default_image = $default_images[$map_default_values['default_image'] - 1];
                                                } else {
                                                    $default_image = $default_images[0];
                                                    if (isset($line[$index]) && $line[$index] && $value_default) {
                                                        $value .= $value ? $multiple_value_separator : "";
                                                        $value .= $value_default;
                                                    }
                                                }
                                            } else {
                                                $default_image = $default_images[0];
                                            }
                                        }
                                    }
                                    $convert_to = (isset($line[$map['convert_image_to']]) && $line[$map['convert_image_to']]) ? $line[$map['convert_image_to']] : $map_default_values['convert_image_to'];
                                    $combination_image_ids = $this->createProductImages($product, $value, $default_image, $multiple_value_separator, $captions, $convert_to);
                                    if ($combination_image_ids && is_array($combination_image_ids)) {
                                        if ($combination_data['images']) {
                                            foreach ($combination_image_ids as $img_id) {
                                                if (!in_array($img_id, $combination_data['images'])) {
                                                    $combination_data['images'][] = $img_id;
                                                }
                                            }
                                        } else {
                                            $combination_data['images'] = $combination_image_ids;
                                        }
                                    }
                                }
                                break;
                            case 'combination_ean':
                                if ($value && Validate::isEan13($value)) {
                                    $combination_data['combination_ean'] = $value;
                                } else {
                                    $combination_data['combination_ean'] = "";
                                    if ($value) {
                                        $this->addError('EAN is not valid: ' . $value, $product);
                                    }
                                }
                                break;
                            case 'default':
                                $combination_data['default'] = $this->isCsvValueTrue($value) ? 1 : 0;
                                break;
                            case 'upc':
                                $combination_data['upc'] = ($value && Validate::isUpc($value)) ? $value : "";
                                break;
                            case 'isbn':
                                $combination_data['isbn'] = ($value && Validate::isIsbn($value)) ? $value : "";
                                break;
                            case 'mpn':
                                $combination_data['mpn'] = $value ? Tools::substr($value, 0, 40) : "";
                                break;
                            case 'supplier_reference':
                                $combination_data['supplier_reference'] = $value;
                                break;
                            case 'supplier_price':
                                $currency = (isset($line[$map['price_currency']]) && $line[$map['price_currency']]) ? $line[$map['price_currency']] : $map_default_values['price_currency'];
                                $currency = $this->getDictionaryValue('price_currency', $currency, $line, $csv_header);
                                $combination_data['supplier_price'] = (float) $this->extractPriceInDefaultCurrency($value, $currency);
                                break;
                            case 'available_date':
                                if ($value && strtotime($value)) {
                                    $combination_data['available_date'] = date('Y-m-d', strtotime($value));
                                } else {
                                    $combination_data['available_date'] = null;
                                }
                                break;
                            default:
                                break;
                        }
                    }

                    if ($combination_data['default']) {
                        $product->deleteDefaultAttributes();
                    }

                    // To call product->update() one time at the end
                    $product_update = false;

                    // If product price is 0, use combination price for product
                    // This is disabled because some people make product price = 0 on purpose
                    // If this is really needed, make a new setting to enable this behavior
                    /*
                    if ($product->price <= 0 && $combination_data['impact_on_price'] > 0) {
                    $product->price = $combination_data['impact_on_price'];
                    $combination_data['impact_on_price'] = 0;
                    $product_update = true;
                    }*/

                    if ($id_product_attribute) {
                        $product->updateAttribute($id_product_attribute, $combination_data['wholesale_price'], $combination_data['impact_on_price'], $combination_data['impact_on_weight'], $combination_data['impact_on_unit_price'], $combination_data['ecotax'], $combination_data['images'], $combination_data['combination_reference'], $combination_data['combination_ean'], $combination_data['default'], null, $combination_data['upc'], $combination_data['minimal_quantity'], $combination_data['available_date'], true, $shop_ids, $combination_data['isbn'], $combination_data['low_stock_threshold'], $combination_data['low_stock_alert'], $combination_data['mpn']);
                        // number_of_products_updated can get higher than number_of_products_processed because several products may have the same reference
                        $this->currentHistory->number_of_products_updated++;
                    } elseif (count($csv_attribute_values) > 0) {
                        $id_product_attribute = $product->addCombinationEntity($combination_data['wholesale_price'], $combination_data['impact_on_price'], $combination_data['impact_on_weight'], 0, $combination_data['ecotax'], $combination_data['quantity'], $combination_data['images'], $combination_data['combination_reference'], 0, $combination_data['combination_ean'], $combination_data['default'], null, $combination_data['upc'], $combination_data['minimal_quantity'], $shop_ids, $combination_data['available_date'], $combination_data['isbn'], $combination_data['low_stock_threshold'], $combination_data['low_stock_alert'], $combination_data['mpn']);
                        $this->currentHistory->number_of_products_created++;
                    }

                    if ($id_product_attribute && $combination_data['supplier_reference']) {
                        $supplier_price = $combination_data['supplier_price'] > 0 ? $combination_data['supplier_price'] : null;
                        $product->addSupplierReference($product->id_supplier, $id_product_attribute, $combination_data['supplier_reference'], $supplier_price);
                    }
                    if ($id_product_attribute && isset($combination_data['stock_location']) && method_exists('StockAvailable', 'setLocation')) {
                        $tmp_context_shop = Shop::getContext();
                        Shop::setContext(Shop::CONTEXT_SHOP, $id_shop);
                        foreach ($shop_ids as $sh_id) {
                            call_user_func(array('StockAvailable', 'setLocation'), $product->id, $combination_data['stock_location'], $sh_id, $id_product_attribute);
                        }
                        Shop::setContext($tmp_context_shop, $id_shop);
                    }

                    // Add attributes to the combination
                    if ($id_product_attribute && count($csv_attribute_values) > 0) {
                        Db::getInstance()->execute("DELETE FROM `" . _DB_PREFIX_ . "product_attribute_combination` WHERE `id_product_attribute` = " . (int) $id_product_attribute);
                        foreach ($csv_attribute_values as $csv_attribute_value_id) {
                            Db::getInstance()->execute("INSERT IGNORE INTO `" . _DB_PREFIX_ . "product_attribute_combination` (`id_attribute`, `id_product_attribute`)
                                VALUES (" . (int) $csv_attribute_value_id . "," . (int) $id_product_attribute . ")", false);
                        }
                    }

                    // Check and make sure default combination is set
                    $product->checkDefaultAttributes();
                    if (!$product->cache_default_attribute) {
                        Product::updateDefaultAttribute($product->id);
                    }

                    $combination_warehouse = (isset($line[$map['warehouse_id']]) && $line[$map['warehouse_id']]) ? $line[$map['warehouse_id']] : $map_default_values['warehouse_id'];
                    if ($combination_warehouse && $product->advanced_stock_management && $id_product_attribute) {
                        if (Warehouse::exists($combination_warehouse)) {
                            $query = new DbQuery();
                            $query->select('id_warehouse_product_location');
                            $query->from('warehouse_product_location');
                            $query->where("id_product = " . (int) $product->id . " AND id_product_attribute = " . (int) $id_product_attribute . " AND id_warehouse = " . (int) $combination_warehouse);
                            $warehouse_product_location = (int) Db::getInstance()->getValue($query);
                            if ($warehouse_product_location) {
                                $wpl = new WarehouseProductLocation($warehouse_product_location);
                                $wpl->location = (isset($line[$map['location_in_warehouse']]) && $line[$map['location_in_warehouse']]) ? $line[$map['location_in_warehouse']] : $map_default_values['location_in_warehouse'];
                                $wpl->update();
                            } else {
                                $wpl = new WarehouseProductLocation();
                                $wpl->id_product = $product->id;
                                $wpl->id_product_attribute = $id_product_attribute;
                                $wpl->id_warehouse = (int) $combination_warehouse;
                                $wpl->location = (isset($line[$map['location_in_warehouse']]) && $line[$map['location_in_warehouse']]) ? $line[$map['location_in_warehouse']] : $map_default_values['location_in_warehouse'];
                                $wpl->add();
                            }
                            StockAvailable::synchronize($product->id);
                        } else {
                            $this->addError('Warehouse does not exist with ID: ' . $combination_warehouse, $product);
                        }
                    }

                    if ($id_product_attribute && !is_null($combination_data['quantity'])) {
                        if ($product->advanced_stock_management && $product->depends_on_stock) {
                            if (empty($combination_warehouse)) {
                                $query = new DbQuery();
                                $query->select('id_warehouse');
                                $query->from('warehouse_product_location');
                                $query->where('id_product = ' . (int) $product->id . ' AND id_product_attribute = ' . (int) $id_product_attribute);
                                $combination_warehouse = (int) Db::getInstance()->getValue($query);
                            }
                            if ($combination_warehouse) {
                                $stock_manager = StockManagerFactory::getManager();
                                $price = str_replace(',', '.', $product->wholesale_price);
                                if ($price == 0) {
                                    $price = 0.000001;
                                }
                                $price = round((float) $price, 6);
                                $warehouse = new Warehouse($combination_warehouse);
                                if ($stock_manager->addProduct($product->id, $id_product_attribute, $warehouse, $combination_data['quantity'], 1, $price, true)) {
                                    StockAvailable::synchronize($product->id);
                                }
                            } else {
                                $this->addError('Warehouse is missing.', $product);
                            }
                        } else {
                            $tmp_context_shop = Shop::getContext();
                            Shop::setContext(Shop::CONTEXT_SHOP, $id_shop);
                            foreach ($shop_ids as $sh_id) {
                                StockAvailable::setQuantity($product->id, $id_product_attribute, $combination_data['quantity'], $sh_id);
                            }
                            Shop::setContext($tmp_context_shop, $id_shop);
                        }
                    }

                    if ($product->advanced_stock_management == 0 && StockAvailable::dependsOnStock($product->id) == 1) {
                        StockAvailable::setProductDependsOnStock($product->id, 0);
                    }

                    // Enable this product if it has at least one stock from its combinations or disable it if it has no any stock
                    if ($this->enable_if_have_stock || $this->disable_if_no_stock) {
                        $product_stock = StockAvailable::getQuantityAvailableByProduct($product->id);
                        if ($this->enable_if_have_stock && $product_stock) {
                            $product->active = 1;
                            $product_update = true;
                        } elseif ($this->disable_if_no_stock && !$product_stock) {
                            $product->active = 0;
                            $product_update = true;
                        }
                    }

                    // Disable product if it has no image
                    if ($this->disable_if_no_image) {
                        if (empty(Image::getImages($this->id_lang_default, $product->id))) {
                            $product->active = 0;
                            $product_update = true;
                        }
                    }

                    if ($product_update) {
                        $product->update();
                    }

                    // Create specific price for combination
                    $discount_amount = (isset($line[$map['discount_amount']]) && $line[$map['discount_amount']]) ? $line[$map['discount_amount']] : $map_default_values['discount_amount'];
                    $discount_percent = (isset($line[$map['discount_percent']]) && $line[$map['discount_percent']]) ? $line[$map['discount_percent']] : $map_default_values['discount_percent'];
                    $discount_base_price = (isset($line[$map['discount_base_price']]) && $line[$map['discount_base_price']] !== "") ? $line[$map['discount_base_price']] : $map_default_values['discount_base_price'];
                    $delete_existing_discount = (isset($line[$map['delete_existing_discount']]) && $line[$map['delete_existing_discount']]) ? $line[$map['delete_existing_discount']] : $map_default_values['delete_existing_discount'];
                    if ($id_product_attribute && $delete_existing_discount && $this->isCsvValueTrue($delete_existing_discount)) {
                        Db::getInstance()->execute("DELETE FROM `" . _DB_PREFIX_ . "specific_price` WHERE `id_product` = " . (int) $product->id . " AND `id_product_attribute` = " . (int) $id_product_attribute . " AND (`id_shop` = 0 OR `id_shop` IN (" . implode(", ", array_map("intval", $shop_ids)) . "))");
                    }
                    if ($id_product_attribute && ($discount_percent || $discount_amount || $discount_base_price !== "")) {
                        $discount = 0;
                        $is_percentage = false;
                        if ($discount_percent) {
                            $discount = $discount_percent;
                            $is_percentage = true;
                        } elseif ($discount_amount) {
                            $discount = (float) $this->extractPriceInDefaultCurrency($discount_amount);
                            if (strpos($discount, '%') !== false) {
                                $is_percentage = true;
                            }
                        }
                        $discount_from = '0000-00-00 00:00:00';
                        $discount_to = '0000-00-00 00:00:00';
                        $is_discount_tax_included = 1;
                        $discount_starting_unit = (isset($line[$map['discount_starting_unit']]) && $line[$map['discount_starting_unit']]) ? $line[$map['discount_starting_unit']] : $map_default_values['discount_starting_unit'];
                        $discount_customer_group = (isset($line[$map['discount_customer_group']]) && $line[$map['discount_customer_group']]) ? $line[$map['discount_customer_group']] : $map_default_values['discount_customer_group'];
                        $discount_customer_id = (isset($line[$map['discount_customer_id']]) && $line[$map['discount_customer_id']] !== "") ? $line[$map['discount_customer_id']] : $map_default_values['discount_customer_id'];
                        $discount_country = (isset($line[$map['discount_country']]) && $line[$map['discount_country']]) ? $line[$map['discount_country']] : $map_default_values['discount_country'];
                        $discount_currency = (isset($line[$map['discount_currency']]) && $line[$map['discount_currency']]) ? $line[$map['discount_currency']] : $map_default_values['discount_currency'];
                        if (isset($line[$map['discount_from']]) && $line[$map['discount_from']]) {
                            $discount_from = date('Y-m-d H:i:s', strtotime($line[$map['discount_from']]));
                        } elseif ($map_default_values['discount_from']) {
                            $discount_from = date('Y-m-d H:i:s', strtotime($map_default_values['discount_from']));
                        }
                        if (isset($line[$map['discount_to']]) && $line[$map['discount_to']]) {
                            $discount_to = date('Y-m-d H:i:s', strtotime($line[$map['discount_to']]));
                        } elseif ($map_default_values['discount_to']) {
                            $discount_to = date('Y-m-d H:i:s', strtotime($map_default_values['discount_to']));
                        }
                        if (isset($line[$map['discount_tax_included']]) && $line[$map['discount_tax_included']] !== "") {
                            $is_discount_tax_included = $this->isCsvValueFalse($line[$map['discount_tax_included']]) ? 0 : 1;
                        } elseif ($map_default_values['discount_tax_included'] !== "") {
                            $is_discount_tax_included = $this->isCsvValueFalse($map_default_values['discount_tax_included']) ? 0 : 1;
                        }
                        $this->createProductSpecificPrice($product->id, $discount, $is_percentage, $is_discount_tax_included, $discount_from, $discount_to, $discount_base_price, $discount_starting_unit, $discount_customer_group, $discount_customer_id, $discount_country, $discount_currency, $id_product_attribute, $shop_ids);
                    }

                    if ($id_product_attribute && isset($map['ecm_cmlid_xml']) && ($map['ecm_cmlid_xml'] >= 0 || $map_default_values['ecm_cmlid_xml'] != "")) {
                        $ecm_cmlid_xml = (isset($line[$map['ecm_cmlid_xml']]) && $line[$map['ecm_cmlid_xml']]) ? $line[$map['ecm_cmlid_xml']] : $map_default_values['ecm_cmlid_xml'];
                        $this->createEcmCmlidRelation($product->id, $ecm_cmlid_xml, $id_product_attribute);
                    }
                    if ($id_product_attribute && ((isset($map['pproperties_quantity_step']) && ($map['pproperties_quantity_step'] >= 0 || $map_default_values['pproperties_quantity_step'] != "")) || (isset($map['pproperties_minimal_quantity']) && ($map['pproperties_minimal_quantity'] >= 0 || $map_default_values['pproperties_minimal_quantity'] != "")))) {
                        $pp_quantity_step = ($map['pproperties_quantity_step'] >= 0 && isset($line[$map['pproperties_quantity_step']])) ? $line[$map['pproperties_quantity_step']] : $map_default_values['pproperties_quantity_step'];
                        $pp_minimal_quantity = ($map['pproperties_minimal_quantity'] >= 0 && isset($line[$map['pproperties_minimal_quantity']])) ? $line[$map['pproperties_minimal_quantity']] : $map_default_values['pproperties_minimal_quantity'];
                        $this->createPpropertiesRelation($product->id, $id_product_attribute, $pp_quantity_step, $pp_minimal_quantity, $shop_ids);
                    }
                    if ($id_product_attribute && isset($map['bms_advancedstock_warehouse']) && ($map['bms_advancedstock_warehouse'] >= 0 || $map_default_values['bms_advancedstock_warehouse'] != "")) {
                        $bms_advancedstock_warehouse = (isset($line[$map['bms_advancedstock_warehouse']]) && $line[$map['bms_advancedstock_warehouse']]) ? $line[$map['bms_advancedstock_warehouse']] : $map_default_values['bms_advancedstock_warehouse'];
                        $bms_advancedstock_physical_quantity = (isset($line[$map['bms_advancedstock_physical_quantity']]) && $line[$map['bms_advancedstock_physical_quantity']] !== "") ? $line[$map['bms_advancedstock_physical_quantity']] : $map_default_values['bms_advancedstock_physical_quantity'];
                        $bms_advancedstock_available_quantity = (isset($line[$map['bms_advancedstock_available_quantity']]) && $line[$map['bms_advancedstock_available_quantity']] !== "") ? $line[$map['bms_advancedstock_available_quantity']] : $map_default_values['bms_advancedstock_available_quantity'];
                        $bms_advancedstock_reserved_quantity = (isset($line[$map['bms_advancedstock_reserved_quantity']]) && $line[$map['bms_advancedstock_reserved_quantity']] !== "") ? $line[$map['bms_advancedstock_reserved_quantity']] : $map_default_values['bms_advancedstock_reserved_quantity'];
                        $bms_advanced_stock_shelf_location = (isset($line[$map['bms_advanced_stock_shelf_location']]) && $line[$map['bms_advanced_stock_shelf_location']]) ? $line[$map['bms_advanced_stock_shelf_location']] : $map_default_values['bms_advanced_stock_shelf_location'];
                        $this->createBmsAdvancedstockRelation($product->id, $id_product_attribute, $bms_advancedstock_warehouse, $bms_advancedstock_physical_quantity, $bms_advancedstock_available_quantity, $bms_advancedstock_reserved_quantity, $bms_advanced_stock_shelf_location, $shop_ids);
                    }
                    if ($id_product_attribute && isset($map['msrp_price_tax_excl']) && ($map['msrp_price_tax_excl'] >= 0 || $map_default_values['msrp_price_tax_excl'] != "")) {
                        $msrp_price_tax_excl = ($map['msrp_price_tax_excl'] >= 0 && isset($line[$map['msrp_price_tax_excl']])) ? $line[$map['msrp_price_tax_excl']] : $map_default_values['msrp_price_tax_excl'];
                        $this->createMsrpRelation($product->id, $id_product_attribute, $product->id_tax_rules_group, $msrp_price_tax_excl, false, $shop_ids);
                    }
                    if ($id_product_attribute && isset($map['msrp_price_tax_incl']) && ($map['msrp_price_tax_incl'] >= 0 || $map_default_values['msrp_price_tax_incl'] != "")) {
                        $msrp_price_tax_incl = ($map['msrp_price_tax_incl'] >= 0 && isset($line[$map['msrp_price_tax_incl']])) ? $line[$map['msrp_price_tax_incl']] : $map_default_values['msrp_price_tax_incl'];
                        $this->createMsrpRelation($product->id, $id_product_attribute, $product->id_tax_rules_group, $msrp_price_tax_incl, true, $shop_ids);
                    }
                    if ($id_product_attribute) {
                        $areapacks_label = (isset($line[$map['areapacks_label']]) && $line[$map['areapacks_label']]) ? $line[$map['areapacks_label']] : $map_default_values['areapacks_label'];
                        $areapacks_type = (isset($line[$map['areapacks_type']]) && $line[$map['areapacks_type']]) ? $line[$map['areapacks_type']] : $map_default_values['areapacks_type'];
                        $areapacks_area = (isset($line[$map['areapacks_area']]) && $line[$map['areapacks_area']] !== "") ? $line[$map['areapacks_area']] : $map_default_values['areapacks_area'];
                        if ($areapacks_label || $areapacks_type || $areapacks_area !== "") {
                            $this->createAreapacksRelation($product->id, $id_product_attribute, $areapacks_label, $areapacks_type, $areapacks_area);
                        }
                    }

                    // Set context shop back to its original value
                    Shop::setContext($context_shop, $id_shop_context);
                } catch (Exception $e) {
                    $this->addError('Exception: ' . $e->getMessage() . ' ' . $combination_reference);
                    if ($settings['is_debug_mode']) {
                        $this->currentHistory->date_ended = date('Y-m-d H:i:s');
                        $this->currentHistory->update();
                        throw new Exception($e->getMessage());
                    }
                }
            }
            // We need this update because it may fail to update at the end, if timeout error happens.
            $this->currentHistory->date_ended = date('Y-m-d H:i:s');
            $this->currentHistory->update();
        }
        return true;
    }

    /**
     * Action called after finishing import
     */
    protected function actionAfterImport()
    {
        // Send email notification after CRON has finished importing
        $email = $this->email_to_send_notification;
        if (!$email || (!Validate::isEmail($email) && !Validate::isAbsoluteUrl($email))) {
            return;
        }
        try {
            if (Validate::isEmail($email)) {
                $error_log = "";
                $errors = ElegantalEasyImportError::model()->findAll(array(
                    'condition' => array(
                        'id_elegantaleasyimport_history' => $this->currentHistory->id,
                    ),
                    'order' => 'id_elegantaleasyimport_error DESC',
                    'limit' => 50,
                ));
                if ($errors) {
                    foreach ($errors as $error) {
                        $error_log .= $error_log ? PHP_EOL : "";
                        $error_log .= $error['error'] . '  Product: ' . $error['product_id_reference'];
                    }
                }

                $subject = 'CRON has finished importing for the rule "' . $this->name . '"';
                $error_log = $error_log ? "Error Log: " . PHP_EOL . PHP_EOL . $error_log . PHP_EOL : "";
                $is_html = in_array(Configuration::get('PS_MAIL_TYPE'), array(Mail::TYPE_BOTH, Mail::TYPE_HTML));
                if ($is_html && $error_log) {
                    $error_log = nl2br($error_log . PHP_EOL);
                }
                $template_vars = array(
                    '{rule_name}' => $this->name,
                    '{error_log}' => $error_log,
                    '{history_date_started}' => date('d-m-Y H:i:s', strtotime($this->currentHistory->date_started)),
                    '{history_date_ended}' => date('d-m-Y H:i:s', strtotime($this->currentHistory->date_ended)),
                    '{total_number_of_products}' => $this->currentHistory->total_number_of_products,
                    '{number_of_products_processed}' => $this->currentHistory->number_of_products_processed,
                    '{number_of_products_created}' => $this->currentHistory->number_of_products_created,
                    '{number_of_products_updated}' => $this->currentHistory->number_of_products_updated,
                    '{number_of_products_deleted_txt}' => $this->currentHistory->number_of_products_deleted ? $this->l('Number of products deleted') . ': ' : "",
                    '{number_of_products_deleted_num}' => $this->currentHistory->number_of_products_deleted ? $this->currentHistory->number_of_products_deleted : "",
                );
                $template_path = dirname(__FILE__) . '/mails/';
                Mail::Send($this->context->language->id, 'import_finished', $subject, $template_vars, $email, null, null, "Easy Import Module", null, null, $template_path);
            } elseif (Validate::isAbsoluteUrl($email)) {
                Tools::file_get_contents($email, false, null, 200);
            }
        } catch (Exception $e) {
            // Do nothing
        }
    }

    public function addError($error_text, $product = null)
    {
        if (!$this->currentHistory) {
            $this->currentHistory = $this->getLastHistory();
        }
        $error = new ElegantalEasyImportError();
        $error->id_elegantaleasyimport_history = $this->currentHistory->id;
        $error->product_id_reference = $this->current_id_reference . (($product && !empty($product->id) && $this->find_products_by != 'id') ? ' ID: ' . $product->id : "");
        $error->error = $error_text;
        $error->date_created = date('Y-m-d H:i:s');
        if (!$error->add()) {
            throw new Exception(Db::getInstance()->getMsgError());
        }
    }

    public function getLastHistory()
    {
        $historyObj = null;
        $history = ElegantalEasyImportHistory::model()->find(array(
            'condition' => array(
                'id_elegantaleasyimport' => $this->id,
            ),
            'order' => 'id_elegantaleasyimport_history DESC',
        ));
        if ($history) {
            $historyObj = new ElegantalEasyImportHistory($history['id_elegantaleasyimport_history']);
        }
        if (!Validate::isLoadedObject($historyObj)) {
            $historyObj = ElegantalEasyImportHistory::createNew($this->id);
        }
        return $historyObj;
    }

    protected function isCsvValueTrue($value)
    {
        $value_lower = Tools::strtolower($value);
        if ($value == 1 || $value_lower == 'yes' || $value_lower == 'true') {
            return true;
        }
        return false;
    }

    protected function isCsvValueFalse($value)
    {
        $value_lower = Tools::strtolower($value);
        if (empty($value) || $value == ' ' || $value == '-' || $value_lower == 'no' || $value_lower == 'false') {
            return true;
        }
        return false;
    }

    protected function extractPriceInDefaultCurrency($price, $currency_sign = null)
    {
        if ($currency_sign) {
            $price .= $currency_sign;
        }

        if ($this->decimal_char == ',') {
            $amount = preg_replace("/[^0-9,]/", "", $price);
            $amount = preg_replace("/,/", ".", $amount);
        } else {
            $amount = preg_replace("/[^0-9.]/", "", $price);
        }

        $currencySigns = array();
        $currencies = Currency::getCurrencies();
        foreach ($currencies as $currency) {
            $currencySigns[Tools::strtoupper($currency['name'])] = $currency['id_currency'];
            $currencySigns[Tools::strtoupper($currency['iso_code'])] = $currency['id_currency'];
            $currencySigns[Tools::strtoupper($currency['sign'])] = $currency['id_currency'];
        }

        $pattern = "/(?:";
        $count = 0;
        foreach ($currencySigns as $currencySign => $id_currency) {
            $pattern .= ($count == 0) ? '' : '|';
            $pattern .= (Tools::strlen($currencySign) > 1) ? $currencySign : '[' . $currencySign . ']';
            $count++;
        }
        $pattern .= ")\s*/iu";

        if (preg_match($pattern, $price, $match) && isset($match[0]) && Tools::strlen(trim($match[0])) > 0) {
            $defaultCurrency = Currency::getDefaultCurrency();
            $priceCurrency = Currency::getCurrencyInstance($currencySigns[Tools::strtoupper(trim($match[0]))]);
            if (Tools::strtoupper($priceCurrency->iso_code) != Tools::strtoupper($defaultCurrency->iso_code)) {
                $amount = Tools::convertPriceFull($amount, $priceCurrency, $defaultCurrency);
            }
        }

        return round($amount, 6);
    }

    protected function getDictionaryValue($attr, $value, $csv_row = [], $header_row = [])
    {
        // Build column value dictionary, that is used to replace value when column xyz = val then xyz = val2
        if (empty($this->column_value_dictionary)) {
            $settings = $this->getModuleSettings();
            $column_value_dictionary = $settings['text_column_value_dictionary'];
            if ($column_value_dictionary) {
                $column_value_dictionary = preg_split("/\\r\\n|\\r|\\n/", $column_value_dictionary);
                if ($column_value_dictionary && is_array($column_value_dictionary)) {
                    $current_key = null;
                    foreach ($column_value_dictionary as $dict) {
                        $dict = trim($dict);
                        if (empty($dict)) {
                            continue;
                        }
                        if (preg_match("/^\[([a-zA-Z0-9_\s]+)\]$/i", $dict, $dict_matches)) {
                            $current_key = str_replace(" ", "_", Tools::strtolower($dict_matches[1]));
                        } else {
                            $key_value = explode('=>', $dict);
                            if (isset($key_value[0]) && isset($key_value[1]) && $current_key && !isset($this->column_value_dictionary[$current_key][$key_value[0]])) {
                                $key_value[0] = Tools::strtolower(trim($key_value[0]));
                                $this->column_value_dictionary[$current_key][$key_value[0]] = trim($key_value[1]);
                            }
                        }
                    }
                }
            }
        }

        // Combine fields if the value contains field names in this format: [%Name%] - [%Price%] etc.
        if ($csv_row && $header_row && preg_match_all("/\[\%([a-zA-Z0-9\s\_\-\'\"\p{L}]+)\%\]/u", $value, $header_matches)) {
            foreach ($header_matches[0] as $key => $match) {
                if (isset($header_matches[1][$key])) {
                    $header_key = array_search($header_matches[1][$key], $header_row);
                    if ($header_key !== false) {
                        $value = str_replace($match, $csv_row[$header_key], $value);
                    }
                }
            }
        }

        // Replace value with dictionary value
        $value_l = Tools::strtolower($value);
        if (isset($this->column_value_dictionary[$attr][$value_l]) && array_key_exists($value_l, $this->column_value_dictionary[$attr])) {
            $value = $this->column_value_dictionary[$attr][$value_l];
        }

        return $value;
    }

    public function getReferenceColumn()
    {
        $column = "p.`reference`";
        if ($this->find_products_by == 'id') {
            $column = "p.`id_product`";
        } elseif ($this->find_products_by == 'ean') {
            $column = "p.`ean13`";
        } elseif ($this->find_products_by == 'supplier_reference') {
            $column = "ps.`product_supplier_reference`";
        } elseif ($this->find_products_by == 'mpn') {
            $column = "p.`mpn`";
        }
        return $column;
    }

    public function getCsvHeader()
    {
        $file = ElegantalEasyImportTools::getRealPath($this->csv_file);
        return ElegantalEasyImportCsv::getCsvHeaderRow($file, $this->header_row, $this->is_utf8_encode);
    }

    public function getMap()
    {
        $map = ElegantalEasyImportTools::unserialize($this->map);
        $map_default = $this->entity == 'combination' ? $this->defaultMapCombinations : $this->defaultMapProducts;
        $map = array_merge($map_default, $map);

        try {
            // Check and compare old csv_header with new csv_header and update map if csv_header is changed.
            // The new map and new csv_header are not saved because we need to keep original configuration.
            if ($this->csv_header && $this->header_row > 0 && $this->map) {
                $csv_header_old = ElegantalEasyImportTools::unserialize($this->csv_header);
                $csv_header_new = $this->getCsvHeader();
                if ($csv_header_old && $csv_header_new) {
                    foreach ($map as $attr => $index) {
                        if ($index >= 0 && isset($csv_header_old[$index])) {
                            if (isset($csv_header_new[$index]) && $csv_header_old[$index] == $csv_header_new[$index]) {
                                continue; // Old header and new header matched for this map
                            }
                            $new_index = array_search($csv_header_old[$index], $csv_header_new);
                            if ($new_index !== false && $new_index >= 0) {
                                $map[$attr] = $new_index;
                            } else {
                                $map[$attr] = '-1'; // Remove mapping, because header not found.
                            }
                        }
                    }
                }
            }
        } catch (Exception $e) {
            // nothing
        }

        return $map;
    }

    public function getMapDefaultValues()
    {
        $map_default_values = ElegantalEasyImportTools::unserialize($this->map_default_values);
        $map_default = $this->entity == 'combination' ? $this->defaultMapCombinations : $this->defaultMapProducts;
        $map_default_values_empty = array();
        foreach ($map_default as $key => $value) {
            $map_default_values_empty[$key] = "";
        }
        $map_default_values = array_merge($map_default_values_empty, $map_default_values);
        return $map_default_values;
    }

    public function getCategoryMapKeys($map = null)
    {
        if (empty($this->category_map_keys)) {
            if (!$map) {
                $map = $this->getMap();
            }
            $this->category_map_keys = array('categories_' . $this->id_lang_default);
            foreach ($map as $attr => $index) {
                if (preg_match("/^category_([\d]+)_" . $this->id_lang_default . "$/", $attr)) {
                    $this->category_map_keys[] = $attr;
                }
            }
        }
        return $this->category_map_keys;
    }

    protected function getShopIdByName($value)
    {
        if (empty($value)) {
            return null;
        }
        if (Validate::isInt($value) && Shop::getShop($value)) {
            $id_shop = (int) $value;
        } else {
            $id_shop = Shop::getIdByName($value);
        }
        return $id_shop;
    }

    /**
     * Finds category by name, if not found creates new one and returns ID
     * @param array|string $name
     * @param int $id_parent_category
     * @return int
     */
    protected function getCategoryIdByName($names_lang, $id_parent_category = null)
    {
        if (!is_array($names_lang)) {
            $names_lang = array($this->id_lang_default => $names_lang);
        }
        if (!isset($names_lang[$this->id_lang_default])) {
            $names_lang[$this->id_lang_default] = reset($names_lang);
        }

        $name = $names_lang[$this->id_lang_default];

        $id_shop = $this->context->shop->id;
        $id_category = null;
        $name = html_entity_decode($name);
        $name = Tools::substr(preg_replace("/[<>;=#{}]*/", "", $name), 0, 128);
        $name = trim($name);
        if (empty($name)) {
            return null;
        }

        $original_name = $name;
        $name = $this->getDictionaryValue('category', $name);

        $original_name_l = Tools::strtolower($original_name);
        if (isset($this->column_value_dictionary['category'][$original_name_l]) && array_key_exists($original_name_l, $this->column_value_dictionary['category']) && empty($name)) {
            throw new Exception("Products of category " . $original_name . " are skipped.");
        }
        if (empty($name)) {
            return null;
        }

        $rootCategory = Category::getRootCategory();

        if ($name == $rootCategory->name && (!$id_parent_category || $id_parent_category == $rootCategory->id)) {
            return $rootCategory->id;
        }

        if (empty($this->categories)) {
            $sql = "SELECT c.`id_category`, cl.`name`, c.`id_parent`
                FROM `" . _DB_PREFIX_ . "category` c
                INNER JOIN `" . _DB_PREFIX_ . "category_shop` csh ON (csh.`id_category` = c.`id_category` AND csh.`id_shop` = " . (int) $id_shop . ")
                LEFT JOIN `" . _DB_PREFIX_ . "category_lang` cl ON c.`id_category` = cl.`id_category` AND cl.id_shop = " . (int) $id_shop . "
                GROUP BY c.`id_category`
                ORDER BY c.`level_depth` ASC, csh.`position` ASC";
            $this->categories = Db::getInstance()->executeS($sql);
        }

        // If ID is given instead of name
        if (Validate::isInt($name)) {
            foreach ($this->categories as $category) {
                if ($category['id_category'] == $name) {
                    $id_category = $category['id_category'];
                    break;
                }
            }
            return $id_category;
        }

        if (!is_null($id_parent_category) && $id_parent_category >= 0) {
            foreach ($this->categories as $category) {
                if (Tools::strtolower($category['name']) == Tools::strtolower($name) && $category['id_parent'] == $id_parent_category) {
                    $id_category = $category['id_category'];
                    break;
                }
            }
        } else {
            foreach ($this->categories as $category) {
                if (Tools::strtolower($category['name']) == Tools::strtolower($name)) {
                    $id_category = $category['id_category'];
                    break;
                }
            }
        }

        if (!$id_category) {
            if (!$id_parent_category) {
                $id_parent_category = $rootCategory->id;
            }
            $categoryObj = new Category();
            $categoryObj->id_parent = $id_parent_category;
            $categoryObj->name = array();
            $categoryObj->link_rewrite = array();
            foreach ($this->id_all_langs as $id_lang) {
                $categoryObj->name[$id_lang] = (isset($names_lang[$id_lang]) && $names_lang[$id_lang]) ? html_entity_decode($names_lang[$id_lang]) : $name;
                $categoryObj->link_rewrite[$id_lang] = Tools::link_rewrite(Tools::substr($categoryObj->name[$id_lang], 0, 128));
            }
            $categoryObj->doNotRegenerateNTree = false;
            if ($categoryObj->add()) {
                $id_category = $categoryObj->id;
                $this->categories[] = array('id_category' => $id_category, 'name' => $name, 'id_parent' => $categoryObj->id_parent);
                // Category::regenerateEntireNtree(); doNotRegenerateNTree = false does this job.
            }
        }

        return $id_category;
    }

    /**
     * Finds manufacturer by name, if not found creates new one and returns ID
     * @param string $name
     * @return int
     */
    protected function getManufacturerIdByName($name)
    {
        $id_manufacturer = null;

        if (empty($name)) {
            return null;
        }
        if (preg_match("/^([\d\s]+\|)(.+)/", $name, $match)) {
            // If brand is given in format as 85|Brand, remove ID part
            $name = $match[2];
        }

        if (empty($this->manufacturers)) {
            $this->manufacturers = Manufacturer::getManufacturers(false, $this->id_lang_default, false, false, false, true);
        }

        foreach ($this->manufacturers as $m) {
            if ((Validate::isInt($name) && $m['id_manufacturer'] == $name) || Tools::strtolower($m['name']) == Tools::strtolower($name)) {
                $id_manufacturer = $m['id_manufacturer'];
                break;
            }
        }

        if (!$id_manufacturer) {
            $manufacturer = new Manufacturer();
            $manufacturer->name = $name;
            $manufacturer->active = 1;
            if ($manufacturer->add()) {
                $id_manufacturer = $manufacturer->id;
                $this->manufacturers[] = array('id_manufacturer' => $id_manufacturer, 'name' => $name);
            }
        }

        return $id_manufacturer;
    }

    /**
     * Finds supplier by name, if not found creates new one and returns ID
     * @param string $name
     * @return int
     */
    protected function getSupplierIdByName($name)
    {
        $id_supplier = null;

        if (empty($name)) {
            return null;
        }

        if (empty($this->suppliers)) {
            $this->suppliers = Supplier::getSuppliers(false, $this->id_lang_default, false, false, false, true);
        }

        foreach ($this->suppliers as $s) {
            if ((Validate::isInt($name) && $s['id_supplier'] == $name) || Tools::strtolower($s['name']) == Tools::strtolower($name)) {
                $id_supplier = $s['id_supplier'];
                break;
            }
        }

        if (!$id_supplier) {
            $supplier = new Supplier();
            $supplier->name = $name;
            $supplier->active = 1;
            if ($supplier->add()) {
                $id_supplier = $supplier->id;
                $this->suppliers[] = array('id_supplier' => $id_supplier, 'name' => $name);
            }
        }

        return $id_supplier;
    }

    protected function createProductSuppliers($product, $value, $supplier_references, $supplier_prices, $multiple_value_separator)
    {
        $id_default_supplier = false;
        $default_supplier_reference = "";
        $suppliers = explode($multiple_value_separator, $value);
        $suppliers = array_unique($suppliers);
        $suppliers = array_map('trim', $suppliers);
        if ($supplier_references) {
            $supplier_references = array_unique(explode($multiple_value_separator, $supplier_references));
            $supplier_references = array_map('trim', $supplier_references);
        }
        if ($supplier_prices) {
            $supplier_prices = array_unique(explode($multiple_value_separator, $supplier_prices));
            $supplier_prices = array_map('trim', $supplier_prices);
        }

        $product_suppliers = ProductSupplier::getSupplierCollection($product->id);

        foreach ($suppliers as $key => $supplier_name) {
            $id_supplier = $this->getSupplierIdByName($supplier_name);
            if (!$id_supplier) {
                continue;
            }

            // Get first supplier as default supplier. Will be used if product has no default supplier.
            if (!$id_default_supplier) {
                $id_default_supplier = $id_supplier;
            }

            // Check if supplier is already associated
            $already_accociated = false;
            foreach ($product_suppliers as $product_supplier) {
                if ($product_supplier->id_supplier == $id_supplier) {
                    $already_accociated = true;
                    if (isset($supplier_references[$key]) && $supplier_references[$key]) {
                        $product_supplier->product_supplier_reference = pSQL($supplier_references[$key]);
                    }
                    if (isset($supplier_prices[$key]) && $supplier_prices[$key]) {
                        $product_supplier->product_supplier_price_te = (float) $this->extractPriceInDefaultCurrency($supplier_prices[$key]);
                    }
                    if ($product_supplier->id_supplier == $id_default_supplier) {
                        $default_supplier_reference = $product_supplier->product_supplier_reference;
                    }
                    $product_supplier->update();
                    break;
                }
            }
            if (!$already_accociated) {
                $productSupplier = new ProductSupplier();
                $productSupplier->id_product = $product->id;
                $productSupplier->id_product_attribute = 0;
                $productSupplier->id_supplier = $id_supplier;
                if (isset($supplier_references[$key]) && $supplier_references[$key]) {
                    $productSupplier->product_supplier_reference = pSQL($supplier_references[$key]);
                }
                if (isset($supplier_prices[$key]) && $supplier_prices[$key]) {
                    $productSupplier->product_supplier_price_te = (float) $this->extractPriceInDefaultCurrency($supplier_prices[$key]);
                }
                if ($this->context->currency->id) {
                    $productSupplier->id_currency = (int) $this->context->currency->id;
                } else {
                    $productSupplier->id_currency = (int) Configuration::get('PS_CURRENCY_DEFAULT');
                }
                if ($productSupplier->id_supplier == $id_default_supplier) {
                    $default_supplier_reference = $productSupplier->product_supplier_reference;
                }
                $productSupplier->save();

                $attributes = $product->getAttributesResume($this->context->language->id);
                if ($attributes && is_array($attributes)) {
                    foreach ($attributes as $attribute) {
                        if ((int) $attribute['id_product_attribute'] > 0) {
                            $productSupplier = new ProductSupplier();
                            $productSupplier->id_product = $product->id;
                            $productSupplier->id_product_attribute = (int) $attribute['id_product_attribute'];
                            $productSupplier->id_supplier = $id_supplier;
                            $productSupplier->save();
                        }
                    }
                }
            }
        }
        if (!$product->id_supplier && $id_default_supplier) {
            $product->id_supplier = $id_default_supplier;
            $product->supplier_reference = $default_supplier_reference;
            $product->update();
        }
    }

    protected function createProductSpecificPrice($id_product, $discount_amount, $is_percentage, $discount_tax_included = 1, $discount_from = '0000-00-00 00:00:00', $discount_to = '0000-00-00 00:00:00', $discount_base_price = "", $discount_starting_unit = 1, $discount_customer_group = "", $discount_customer_id = 0, $discount_country = "", $discount_currency = "", $id_product_attribute = 0, $shop_ids = null)
    {
        if (preg_match('/([0-9]+\.{0,1}[0-9]*)/', $discount_amount, $match)) {
            $discount_amount = $match[0];
        }
        $discount_amount = (float) $discount_amount;
        if ($is_percentage && $discount_amount > 0 && $discount_amount < 1) {
            $discount_amount = $discount_amount * 100;
        }
        if ($discount_base_price === "" && (!$discount_amount || empty($discount_amount) || $discount_amount === 0 || $discount_amount === 0.00)) {
            return;
        }

        $discount_starting_unit = (int) $discount_starting_unit;
        if ($discount_starting_unit < 1) {
            $discount_starting_unit = 1;
        }

        if ($discount_customer_group && !Validate::isInt($discount_customer_group)) {
            $group = Group::searchByName($discount_customer_group);
            if ($group && $group['id_group']) {
                $discount_customer_group = $group['id_group'];
            }
        }
        if ($discount_customer_id) {
            $customer = new Customer($discount_customer_id);
            if (!$customer || !Validate::isLoadedObject($customer)) {
                $discount_customer_id = 0;
            }
        }
        if ($discount_country && !Validate::isInt($discount_country)) {
            $country_id = Country::getIdByName(null, $discount_country);
            if ($country_id) {
                $discount_country = $country_id;
            } else {
                $discount_country = Country::getByIso($discount_country);
            }
        }
        if ($discount_currency && !Validate::isInt($discount_currency)) {
            $discount_currency = Currency::getIdByIsoCode($discount_currency);
        }
        if ($discount_base_price !== "" && !is_null($discount_base_price)) {
            $discount_base_price = (float) $this->extractPriceInDefaultCurrency($discount_base_price);
        } else {
            $discount_base_price = '-1';
        }

        foreach ($shop_ids as $id_shop) {
            // "Delete discount that was created by this module only" feature was implemented in elegantalautopricepack module with dates 2017-01-01 01:01:01 and 2071-01-01 01:01:01
            // It is not needed here so far but may be needed in future.
            $id_specific_price = SpecificPrice::exists((int) $id_product, (int) $id_product_attribute, $id_shop, (int) $discount_customer_group, (int) $discount_country, (int) $discount_currency, (int) $discount_customer_id, $discount_starting_unit, $discount_from, $discount_to, false);
            $specificPrice = new SpecificPrice($id_specific_price);
            $specificPrice->id_product = (int) $id_product;
            $specificPrice->id_product_attribute = (int) $id_product_attribute;
            $specificPrice->id_shop = $id_shop;
            $specificPrice->id_currency = (int) $discount_currency;
            $specificPrice->id_country = (int) $discount_country;
            $specificPrice->id_group = (int) $discount_customer_group;
            $specificPrice->id_customer = (int) $discount_customer_id;
            $specificPrice->from_quantity = $discount_starting_unit;
            $specificPrice->price = $discount_base_price;
            $specificPrice->from = $discount_from;
            $specificPrice->to = $discount_to;
            $specificPrice->reduction = (float) ($is_percentage ? round((($discount_amount) / 100), 8) : round($discount_amount, 8));
            $specificPrice->reduction_tax = $discount_tax_included;
            $specificPrice->reduction_type = $is_percentage ? 'percentage' : 'amount';
            if (!$specificPrice->save()) {
                throw new Exception("Discount is invalid: " . Db::getInstance()->getMsgError());
            }
        }
    }

    protected function createProductImages($product, $csv_images, $default_image, $multiple_value_separator, $captions, $convert_to)
    {
        $base_url_images = $this->base_url_images;

        // Base URL may contain username and password in this format: @@username:password@@
        $username = null;
        $password = null;
        if (preg_match("/^@@([\w\W]+):([\w\W]+)@@/", $base_url_images, $match)) {
            $username = $match[1];
            $password = $match[2];
            $base_url_images = str_replace($match[0], "", $base_url_images);
        }

        if ($multiple_value_separator == '/') {
            $multiple_value_separator = ',';
        }

        // Get images from csv column into array
        $csv_images = array_map('trim', explode($multiple_value_separator, $csv_images));

        $image_ids = array();

        if ($csv_images && is_array($csv_images) && count($csv_images) > 0) {
            $images_hashes = array();

            // Prepare image hash array
            $images = Image::getImages($this->context->language->id, $product->id);
            foreach ($images as $product_image) {
                $imageObj = new Image($product_image['id_image']);
                if (Validate::isLoadedObject($imageObj)) {
                    $image_file = _PS_PROD_IMG_DIR_ . $imageObj->getExistingImgPath() . '.' . $imageObj->image_format;
                    if (is_file($image_file)) {
                        $hash = md5_file($image_file);
                        $images_hashes[$hash] = $imageObj->id;
                    }
                }
            }

            foreach ($csv_images as $key => $file) {
                $url = $file;
                // If number is given, take existing image of the product by this position
                if (Validate::isInt($url) && $this->entity == 'combination') {
                    foreach ($images as $img) {
                        if (isset($img['id_image']) && isset($img['position']) && $img['position'] == $url) {
                            $image_ids[] = $img['id_image'];
                        }
                    }
                    continue;
                }
                if ($base_url_images) {
                    if (strpos($base_url_images, '%s') !== false) {
                        $url = str_replace('%s', $file, $base_url_images);
                    } elseif (!ElegantalEasyImportTools::isValidUrl($url)) {
                        $url = $base_url_images . $file;
                    }
                }

                $image = new Image();
                $image->id_product = $product->id;
                $image->position = Image::getHighestPosition($product->id) + 1;
                $image->cover = false; // We adjust cover at the end because it is giving "Duplicate entry for key id_product_cover" error
                $id_cover_image = null;

                foreach ($this->id_all_langs as $id_lang) {
                    if ($captions && isset($captions[$id_lang][$key]) && $captions[$id_lang][$key]) {
                        $image->legend[$id_lang] = Tools::substr(preg_replace("/[<>;=#{}]*/", "", $captions[$id_lang][$key]), 0, 128);
                    }
                }

                $image_add = $image->add();
                if (!$image_add) {
                    Db::getInstance()->execute("DELETE FROM " . _DB_PREFIX_ . "image_shop WHERE id_image NOT IN (SELECT id_image FROM " . _DB_PREFIX_ . "image)");
                    $image_add = $image->add();
                }
                if ($image_add) {
                    if ($file == $default_image) {
                        $id_cover_image = $image->id;
                    }
                    if (ElegantalEasyImportTools::copyImg($product->id, $image, $url, $username, $password, $convert_to)) {
                        // Delete image if it is duplicate
                        $hash = md5_file(_PS_PROD_IMG_DIR_ . $image->getExistingImgPath() . '.' . $image->image_format);
                        if (isset($images_hashes[$hash])) {
                            // Get id of existing image
                            $image_ids[] = $images_hashes[$hash];
                            // If current image was set as cover, update cover image ID with existing image's ID
                            if ($id_cover_image == $image->id) {
                                $id_cover_image = $images_hashes[$hash];
                            }
                            // Delete new image because it is duplicate
                            $image->delete();
                            $image_dir = dirname(_PS_PROD_IMG_DIR_ . $image->getExistingImgPath() . '.' . $image->image_format);
                            ElegantalEasyImportTools::deleteFolderIfEmpty($image_dir);
                        } else {
                            $images_hashes[$hash] = $image->id;
                            $image_ids[] = $image->id;
                        }
                        // Update cover image
                        if ($id_cover_image) {
                            Db::getInstance()->execute("UPDATE `" . _DB_PREFIX_ . "image` SET `cover` = NULL WHERE `id_product` = " . (int) $product->id);
                            Db::getInstance()->execute("UPDATE `" . _DB_PREFIX_ . "image_shop` SET `cover` = NULL WHERE `id_product` = " . (int) $product->id);
                            Db::getInstance()->execute("UPDATE `" . _DB_PREFIX_ . "image` SET `cover` = 1 WHERE `id_product` = " . (int) $product->id . " AND `id_image` = " . (int) $id_cover_image);
                            Db::getInstance()->execute("UPDATE `" . _DB_PREFIX_ . "image_shop` SET `cover` = 1 WHERE `id_product` = " . (int) $product->id . " AND `id_image` = " . (int) $id_cover_image);
                        }
                    } else {
                        $image->delete();
                        $image_dir = dirname(_PS_PROD_IMG_DIR_ . $image->getExistingImgPath() . '.' . $image->image_format);
                        ElegantalEasyImportTools::deleteFolderIfEmpty($image_dir);
                        $this->addError('Image not found: ' . $url, $product);
                    }
                } else {
                    $this->addError('Failed to create image object. ' . Db::getInstance()->getMsgError(), $product);
                }
            }
        }

        // Fix cover on ps_image table
        $has_cover = Db::getInstance()->getRow("SELECT * FROM `" . _DB_PREFIX_ . "image` WHERE `id_product` = " . (int) $product->id . " AND `cover`= 1");
        if (!$has_cover) {
            $first_image = Db::getInstance()->getRow("SELECT * FROM `" . _DB_PREFIX_ . "image` WHERE `id_product` = " . (int) $product->id . " ORDER BY `id_image` ASC");
            if ($first_image && $first_image['id_image']) {
                Db::getInstance()->execute("UPDATE `" . _DB_PREFIX_ . "image` SET `cover` = 1 WHERE `id_product` = " . (int) $product->id . " AND `id_image` = " . (int) $first_image['id_image']);
            }
        }
        // Fix cover on ps_image_shop table
        $shop_groups = Shop::getTree();
        foreach ($shop_groups as $shop_group) {
            foreach ($shop_group['shops'] as $shop) {
                $has_cover = Db::getInstance()->getRow("SELECT * FROM `" . _DB_PREFIX_ . "image_shop` WHERE `id_product` = " . (int) $product->id . " AND `id_shop` = " . (int) $shop['id_shop'] . " AND `cover`= 1");
                if (!$has_cover) {
                    $first_image = Db::getInstance()->getRow("SELECT * FROM `" . _DB_PREFIX_ . "image_shop` WHERE `id_product` = " . (int) $product->id . " AND `id_shop` = " . (int) $shop['id_shop'] . " ORDER BY `id_image` ASC");
                    if ($first_image && $first_image['id_image']) {
                        Db::getInstance()->execute("UPDATE `" . _DB_PREFIX_ . "image_shop` SET `cover` = 1 WHERE `id_product` = " . (int) $product->id . " AND `id_shop` = " . (int) $shop['id_shop'] . " AND `id_image` = " . (int) $first_image['id_image']);
                    }
                }
            }
        }

        return $image_ids;
    }

    protected function createProductFeatures($id_product, $features)
    {
        if (!$id_product || !$features || !isset($features[$this->id_lang_default]) || !$features[$this->id_lang_default]) {
            return;
        }
        // Prepare features array
        $features_arr_lang = array();
        foreach ($features as $id_lang => $features_arr) {
            foreach ($features_arr as $feature) {
                if (empty($feature)) {
                    continue;
                }
                // $feature_parts = explode(':', $feature);
                // We cannot use explode here because feature value may contain : as well
                $feature_parts = str_getcsv($feature, ":", '"');
                $feature_name = isset($feature_parts[0]) ? trim($feature_parts[0]) : "";
                $feature_value = isset($feature_parts[1]) ? trim($feature_parts[1]) : "";
                $position = isset($feature_parts[2]) ? (int) $feature_parts[2] - 1 : false;
                $is_custom = isset($feature_parts[3]) ? (bool) $feature_parts[3] : false;

                $feature_name = html_entity_decode($feature_name);
                $feature_name = str_replace('=', '-', $feature_name);
                $feature_name = str_replace(array('=', '[', ']', '<', '>', '{', '}'), '', $feature_name);

                $feature_value = html_entity_decode($feature_value);
                $feature_value = str_replace('=', '-', $feature_value);
                $feature_value = str_replace(array('=', '[', ']', '<', '>', '{', '}'), '', $feature_value);

                $feature_name = $this->getDictionaryValue('feature_name', $feature_name);
                $feature_value = $this->getDictionaryValue('feature_value', $feature_value);

                if (empty($feature_name) || (empty($feature_value) && $feature_value !== '0')) {
                    continue;
                }

                $feature_name_size = isset(Feature::$definition['fields']['name']['size']) ? (int) Feature::$definition['fields']['name']['size'] : 12;
                $feature_value_size = isset(FeatureValue::$definition['fields']['value']['size']) ? (int) FeatureValue::$definition['fields']['value']['size'] : 255;

                $features_arr_lang[$id_lang][] = array(
                    'feature_name' => Tools::substr($feature_name, 0, $feature_name_size),
                    'feature_value' => Tools::substr($feature_value, 0, $feature_value_size),
                    'position' => $position,
                    'is_custom' => $is_custom,
                );
            }
        }
        // Create features and values
        foreach ($features_arr_lang[$this->id_lang_default] as $key => $feature) {
            $id_feature = null;
            $id_feature_value = null;
            // $id_feature = (int) Feature::addFeatureImport($feature_name, $position);
            // We cannot use this function because it does not save translations
            $feature_exists = Db::getInstance()->getRow("SELECT `id_feature` FROM " . _DB_PREFIX_ . "feature_lang WHERE `name` = '" . pSQL($feature['feature_name']) . "' AND `id_lang` = " . (int) $this->id_lang_default . " GROUP BY `id_feature`");
            if (empty($feature_exists)) {
                // Feature does not exist, so create it.
                $featureObj = new Feature();
                $featureObj->name[$this->id_lang_default] = $feature['feature_name'];
                foreach ($this->id_other_langs as $id_lang) {
                    if (isset($features_arr_lang[$id_lang][$key]['feature_name']) && $features_arr_lang[$id_lang][$key]['feature_name']) {
                        $featureObj->name[$id_lang] = $features_arr_lang[$id_lang][$key]['feature_name'];
                    } else {
                        $featureObj->name[$id_lang] = $feature['feature_name'];
                    }
                }
                $featureObj->position = $position ? (int) $position : Feature::getHigherPosition() + 1;
                $featureObj->add();
                $id_feature = (int) $featureObj->id;
            } elseif (isset($feature_exists['id_feature']) && $feature_exists['id_feature']) {
                $featureObj = new Feature((int) $feature_exists['id_feature']);
                if (Validate::isLoadedObject($featureObj)) {
                    if (is_numeric($position)) {
                        $featureObj->position = (int) $position;
                        $featureObj->update();
                    }
                    $id_feature = (int) $featureObj->id;
                }
            }
            if (!$id_feature) {
                continue;
            }
            // $id_feature_value = (int) FeatureValue::addFeatureValueImport($id_feature, $feature_value, $id_product, $id_lang, $is_custom);
            // We cannot use this function because it does not save translations
            $id_feature_value = Db::getInstance()->getValue("
				SELECT fp.`id_feature_value`
				FROM " . _DB_PREFIX_ . "feature_product fp
				INNER JOIN " . _DB_PREFIX_ . "feature_value fv USING (`id_feature_value`)
				WHERE fp.`id_feature` = " . (int) $id_feature . "
				AND fv.`custom` = " . (int) $is_custom . "
				AND fp.`id_product` = " . (int) $id_product);

            if ($is_custom && $id_feature_value && $this->id_lang_default) {
                Db::getInstance()->execute("
				UPDATE " . _DB_PREFIX_ . "feature_value_lang
				SET `value` = '" . pSQL($feature['feature_value']) . "'
				WHERE `id_feature_value` = " . (int) $id_feature_value . "
				AND `value` != '" . pSQL($feature['feature_value']) . "'
				AND `id_lang` = " . (int) $this->id_lang_default);
            }
            if (!$is_custom) {
                $id_feature_value = Db::getInstance()->getValue("
                    SELECT fv.`id_feature_value`
                    FROM " . _DB_PREFIX_ . "feature_value fv
                    LEFT JOIN " . _DB_PREFIX_ . "feature_value_lang fvl ON (fvl.`id_feature_value` = fv.`id_feature_value` AND fvl.`id_lang` = " . (int) $this->id_lang_default . ")
                    WHERE `value` = '" . pSQL($feature['feature_value']) . "'
                    AND fv.`id_feature` = " . (int) $id_feature . "
                    AND fv.`custom` = 0
                    GROUP BY fv.`id_feature_value`");
            }
            if (!$id_feature_value) {
                $feature_value = new FeatureValue();
                $feature_value->id_feature = (int) $id_feature;
                $feature_value->custom = (bool) $is_custom;
                $feature_value->value[$this->id_lang_default] = $feature['feature_value'];
                foreach ($this->id_other_langs as $id_lang) {
                    if (isset($features_arr_lang[$id_lang][$key]['feature_value'])) {
                        $feature_value->value[$id_lang] = $features_arr_lang[$id_lang][$key]['feature_value'];
                    } else {
                        $feature_value->value[$id_lang] = $feature['feature_value'];
                    }
                }
                $feature_value->add();
                $id_feature_value = (int) $feature_value->id;
            }
            if (!$id_feature) {
                continue;
            }
            Product::addFeatureProductImport($id_product, $id_feature, $id_feature_value);
        }
        Feature::cleanPositions();
    }

    protected function createProductTags($product, $value, $multiple_value_separator, $id_lang)
    {
        if (empty($value)) {
            return;
        }
        $tags = explode($multiple_value_separator, $value);
        $value = implode(',', $tags);
        if (Validate::isTagsList($value)) {
            // Delete old tags. Similar function to Tag::deleteTagsForProduct but need to add id_lang
            $tagsRemoved = Db::getInstance()->executeS("SELECT id_tag FROM " . _DB_PREFIX_ . "product_tag WHERE id_product = " . (int) $product->id . " AND id_lang = " . (int) $id_lang);
            Db::getInstance()->delete("product_tag", "id_product = " . (int) $product->id . " AND id_lang = " . (int) $id_lang);
            Db::getInstance()->delete("tag", "NOT EXISTS (SELECT 1 FROM " . _DB_PREFIX_ . "product_tag WHERE " . _DB_PREFIX_ . "product_tag.id_tag = " . _DB_PREFIX_ . "tag.id_tag)");
            $tagList = array();
            foreach ($tagsRemoved as $tagRemoved) {
                $tagList[] = $tagRemoved['id_tag'];
            }
            if ($tagList != array()) {
                Tag::updateTagCount($tagList);
            }
            // Add tags to the product
            Tag::addTags($id_lang, $product->id, $value, ',');
        } else {
            $this->addError('Tags list is not valid.', $product);
        }
    }

    protected function createProductAccessories($product, $value, $multiple_value_separator)
    {
        if (!$product->id || !$value) {
            return;
        }

        // Delete old accessories
        $product->deleteAccessories();

        $accessory_product_ids = array();

        // Create new accessories
        $accessories = explode($multiple_value_separator, $value);
        $accessories = array_map('trim', $accessories);
        $accessories = array_unique($accessories);
        foreach ($accessories as $id_accessory_product) {
            if (empty($id_accessory_product)) {
                continue;
            }
            if ($this->find_products_by == 'reference' || !Validate::isInt($id_accessory_product)) {
                // Find product id by reference
                $sql = "SELECT * FROM `" . _DB_PREFIX_ . "product` WHERE `reference` = '" . pSQL($id_accessory_product) . "'";
                $row = Db::getInstance()->getRow($sql);
                if ($row && isset($row['id_product']) && $row['id_product']) {
                    $id_accessory_product = $row['id_product'];
                }
            }
            $accessory_product_ids[] = $id_accessory_product;
        }
        $product->changeAccessories($accessory_product_ids);
    }

    protected function createProductAttachments($product, $attachments_str, $attachment_names, $attachment_descriptions, $multiple_value_separator)
    {
        $attachments = array_map('trim', explode($multiple_value_separator, $attachments_str));
        if (!$attachments || !is_array($attachments) || count($attachments) < 1) {
            return;
        }

        foreach ($attachments as $key => $attachment_file) {
            if (Validate::isInt($attachment_file)) {
                $attachment = new Attachment($attachment_file);
                if (Validate::isLoadedObject($attachment)) {
                    $attachment->attachProduct($product->id);
                    $product->cache_has_attachments = 1;
                }
                continue;
            }

            $tmp_file = null;
            $filename = basename($attachment_file);
            $extension = Tools::strrpos($filename, '.') !== false ? '.' . Tools::substr($filename, Tools::strrpos($filename, '.') + 1, 5) : "";
            $filename = Validate::isGenericName($filename) ? $filename : Tools::passwdGen(8) . $extension;

            // Download attachment to tmp file
            if (ElegantalEasyImportTools::isValidUrl($attachment_file)) {
                try {
                    $tmp_file = ElegantalEasyImportTools::downloadFileFromUrl($attachment_file);
                    $parced_url = parse_url($attachment_file);
                    if (ElegantalEasyImportTools::isValidUrl($attachment_file) && isset($parced_url['host']) && Tools::strtolower($parced_url['host']) == 'drive.google.com' && isset($parced_url['path']) && preg_match("/^(\/file\/d\/)(.+?(?=\/))/", $parced_url['path'], $path_match)) {
                        $filename = basename($tmp_file);
                    }
                    $attachment_file = $tmp_file;
                } catch (Exception $e) {
                    $this->addError('Failed to download attachment: ' . $attachment_file . ' ' . $e->getMessage(), $product);
                    @unlink($tmp_file);
                    continue;
                }
            } elseif (Tools::substr($attachment_file, 0, 1) != '/') {
                $attachment_file = _PS_ROOT_DIR_ . '/' . $attachment_file;
            }

            if (!is_file($attachment_file)) {
                $this->addError('Attachment file is not found: ' . $attachment_file, $product);
                @unlink($tmp_file);
                continue;
            }

            $filesize = filesize($attachment_file);
            if (!$filesize) {
                $this->addError('Attachment file is empty: ' . $attachment_file, $product);
                @unlink($tmp_file);
                continue;
            }
            if ($filesize > (Configuration::get('PS_ATTACHMENT_MAXIMUM_SIZE') * 1024 * 1024)) {
                $this->addError('Attachment file size is too large (' . ElegantalEasyImportTools::displaySize($filesize) . '). Max allowed size is ' . ElegantalEasyImportTools::displaySize(Configuration::get('PS_ATTACHMENT_MAXIMUM_SIZE') * 1024 * 1024) . '. ' . $filename, $product);
                @unlink($tmp_file);
                continue;
            }

            // If there is a file with the same name and size, use it instead of creating a new attachment
            $sql = "SELECT `id_attachment` FROM `" . _DB_PREFIX_ . "attachment` WHERE `file_name` = '" . pSQL($filename) . "' AND `file_size` = '" . pSQL($filesize) . "'";
            $id_attachment = Db::getInstance()->getValue($sql);
            $attachment = new Attachment($id_attachment);

            if ($id_attachment > 0 && Validate::isLoadedObject($attachment)) {
                $attachment->attachProduct($product->id);
                $product->cache_has_attachments = 1;
            } else {
                $uniqid = null;
                do {
                    $uniqid = sha1(microtime());
                } while (file_exists(_PS_DOWNLOAD_DIR_ . $uniqid));
                if (!copy($attachment_file, _PS_DOWNLOAD_DIR_ . $uniqid)) {
                    $this->addError('Failed to copy attachment: ' . $attachment_file, $product);
                    @unlink($tmp_file);
                    continue;
                }

                $attachment = new Attachment();
                foreach ($this->id_all_langs as $id_lang) {
                    $attachment->name[$id_lang] = ($attachment_names && isset($attachment_names[$id_lang][$key]) && $attachment_names[$id_lang][$key]) ? $attachment_names[$id_lang][$key] : Tools::substr($filename, 0, 32);
                    $attachment->description[$id_lang] = ($attachment_descriptions && isset($attachment_descriptions[$id_lang][$key]) && $attachment_descriptions[$id_lang][$key]) ? $attachment_descriptions[$id_lang][$key] : "";
                }
                $attachment->file = $uniqid;
                $attachment->mime = ElegantalEasyImportTools::getMimeType($attachment_file);
                $attachment->file_name = $filename;
                $attachment->add();
                $attachment->attachProduct($product->id);
                $product->cache_has_attachments = 1;
            }
            @unlink($tmp_file);
        }
    }

    protected function createProductCarriers($product, $value, $multiple_value_separator)
    {
        $carriers = explode($multiple_value_separator, $value);
        $carriers = array_unique($carriers);
        $carriers = array_map('trim', $carriers);
        if (!$carriers || !is_array($carriers)) {
            return;
        }
        $carriers_ids = array();
        foreach ($carriers as $carrier) {
            if (empty($carrier)) {
                continue;
            }
            if (empty($this->carriers)) {
                $this->carriers = Carrier::getCarriers($this->id_lang_default, false, false, false, null, Carrier::ALL_CARRIERS);
            }
            foreach ($this->carriers as $c) {
                if ((Validate::isInt($carrier) && $carrier == $c['id_reference']) || Tools::strtolower($c['name']) == Tools::strtolower($carrier)) {
                    $carriers_ids[] = $c['id_reference'];
                    break;
                }
            }
        }
        $product->setCarriers($carriers_ids);
    }

    protected function createProductCustomizableFields($product, $uploadable_files_labels, $text_fields_labels, $multiple_value_separator)
    {
        $current_customization = $product->getCustomizationFieldIds();
        $files_count = 0;
        $text_count = 0;
        if (is_array($current_customization)) {
            foreach ($current_customization as $field) {
                if ($field['type'] == 1) {
                    $text_count++;
                } else {
                    $files_count++;
                }
            }
        }
        // Create only new fields
        $files_count = (int) $product->uploadable_files - $files_count;
        $text_count = (int) $product->text_fields - $text_count;
        if ($files_count > 0 || $text_count > 0) {
            $shop_ids = Shop::getContextListShopID();
            if ($files_count > 0) {
                $uploadable_files_labels = explode($multiple_value_separator, $uploadable_files_labels);
                $uploadable_files_labels = array_map('trim', $uploadable_files_labels);
                for ($i = 0; $i < $files_count; $i++) {
                    $sql = "INSERT INTO `" . _DB_PREFIX_ . "customization_field` (`id_product`, `type`, `required`)
                        VALUES (" . (int) $product->id . ", " . (int) Product::CUSTOMIZE_FILE . ", 0)";
                    if (Db::getInstance()->execute($sql) && ($id_customization_field = (int) Db::getInstance()->Insert_ID())) {
                        $sql = "INSERT INTO `" . _DB_PREFIX_ . "customization_field_lang` (`id_customization_field`, `id_lang`, `id_shop`, `name`)
                                VALUES ";
                        $values = "";
                        $label = isset($uploadable_files_labels[$i]) ? $uploadable_files_labels[$i] : "";
                        foreach ($this->id_all_langs as $id_lang) {
                            foreach ($shop_ids as $id_shop) {
                                $values .= $values ? ", " : "";
                                $values .= "(" . (int) $id_customization_field . ", " . (int) $id_lang . ", " . (int) $id_shop . ", '" . pSQL($label) . "')";
                            }
                        }
                        $sql .= $values;
                        Db::getInstance()->execute($sql);
                    }
                }
            }
            if ($text_count > 0) {
                $text_fields_labels = explode($multiple_value_separator, $text_fields_labels);
                $text_fields_labels = array_map('trim', $text_fields_labels);
                for ($i = 0; $i < $text_count; $i++) {
                    $sql = "INSERT INTO `" . _DB_PREFIX_ . "customization_field` (`id_product`, `type`, `required`)
                        VALUES (" . (int) $product->id . ", " . (int) Product::CUSTOMIZE_TEXTFIELD . ", 0)";
                    if (Db::getInstance()->execute($sql) && ($id_customization_field = (int) Db::getInstance()->Insert_ID())) {
                        $sql = "INSERT INTO `" . _DB_PREFIX_ . "customization_field_lang` (`id_customization_field`, `id_lang`, `id_shop`, `name`)
                                VALUES ";
                        $values = "";
                        $label = isset($text_fields_labels[$i]) ? $text_fields_labels[$i] : "";
                        foreach ($this->id_all_langs as $id_lang) {
                            foreach ($shop_ids as $id_shop) {
                                $values .= $values ? ", " : "";
                                $values .= "(" . (int) $id_customization_field . ", " . (int) $id_lang . ", " . (int) $id_shop . ", '" . pSQL($label) . "')";
                            }
                        }
                        $sql .= $values;
                        Db::getInstance()->execute($sql);
                    }
                }
            }
            Configuration::updateGlobalValue('PS_CUSTOMIZATION_FEATURE_ACTIVE', '1');
        }
    }

    protected function createFsProductVideoUrls($product, $urls, $multiple_value_separator)
    {
        if (!$product->id || !ElegantalEasyImportTools::isModuleInstalled('fsproductvideo')) {
            return;
        }
        $urls = explode($multiple_value_separator, $urls);
        if (Shop::getContext() == Shop::CONTEXT_ALL) {
            $shops = array(array('id_shop' => $this->context->shop->id));
        } else {
            $shops = Shop::getShops();
        }

        // Delete old lang records
        $sql = "DELETE l FROM `" . _DB_PREFIX_ . "fsproductvideo_lang` l
            INNER JOIN `" . _DB_PREFIX_ . "fsproductvideo` f ON f.`id_fsproductvideo` = l.`id_fsproductvideo`
            WHERE f.`id_product` = " . (int) $product->id;
        Db::getInstance()->execute($sql);

        // Delete old records
        $sql = "DELETE FROM `" . _DB_PREFIX_ . "fsproductvideo` WHERE `id_product` = " . (int) $product->id;
        Db::getInstance()->execute($sql);

        // Create new record
        $ids = array();
        foreach ($urls as $pos => $url) {
            $url = (Tools::substr($url, 0, 7) != "http://" && Tools::substr($url, 0, 8) != "https://") ? "http://" . $url : $url;
            if (ElegantalEasyImportTools::isValidUrl($url)) {
                // Get thumbnail image as fsproductvideo module's controller
                $thumbnail = $this->fsSaveThumbnailImage($url, $product->id);
                foreach ($shops as $shop) {
                    $sql = "INSERT INTO `" . _DB_PREFIX_ . "fsproductvideo` (`id_shop`, `id_product`, `active`, `position`, `thumbnail`, `date_add`, `date_upd`)
                        VALUES (" . (int) $shop['id_shop'] . ", " . (int) $product->id . ", 1, " . (int) ($pos + 1) . ", '" . pSQL($thumbnail) . "', '" . pSQL(date('Y-m-d H:i:s')) . "', '" . pSQL(date('Y-m-d H:i:s')) . "')";
                    if (Db::getInstance()->execute($sql)) {
                        $ids[DB::getInstance()->Insert_ID()] = $url;
                    }
                }
            }
        }
        if (!empty($ids) && is_array($ids)) {
            foreach ($ids as $id => $url) {
                foreach ($this->id_all_langs as $id_lang) {
                    $sql = "INSERT INTO `" . _DB_PREFIX_ . "fsproductvideo_lang` (`id_fsproductvideo`, `id_lang`, `url`, `title`)
                        VALUES(" . (int) $id . ", " . (int) $id_lang . ", '" . pSQL($url) . "', '" . pSQL($product->name) . "')";
                    Db::getInstance()->execute($sql);
                }
            }
        }
    }

    protected function fsSaveThumbnailImage($fspv_video_url, $fspv_id_product)
    {
        $fsproductvideo = Module::getInstanceByName('fsproductvideo');

        $imageName = '';
        if ($fsproductvideo && $fspv_video_url && $fspv_id_product) {
            $image_url = '';
            $youtube_matches = array();
            $exp = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|';
            $exp .= '(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';
            preg_match($exp, trim($fspv_video_url), $youtube_matches);
            if (isset($youtube_matches[1]) && $youtube_matches[1]) {
                $videoType = 'youtube';
                $videoId = $youtube_matches[1];
                $image_url = 'http://img.youtube.com/vi/' . $videoId . '/sddefault.jpg';
                $image_curl_handle = curl_init($image_url);
                curl_setopt($image_curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_exec($image_curl_handle);
                $image_curl_response_http_code = curl_getinfo($image_curl_handle, CURLINFO_HTTP_CODE);
                if ($image_curl_response_http_code == 404) {
                    $image_url = 'http://img.youtube.com/vi/' . $videoId . '/hqdefault.jpg';
                }
            }
            $vimeo_matches = array();
            $exp = '/https?:\/\/(?:www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|';
            $exp .= 'groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|)(\d+)(?:$|\/|\?)/';
            preg_match($exp, trim($fspv_video_url), $vimeo_matches);
            if (isset($vimeo_matches[3]) && $vimeo_matches[3]) {
                $videoType = 'vimeo';
                $videoId = $vimeo_matches[3];
                $vimeo = json_decode(Tools::file_get_contents('http://vimeo.com/api/v2/video/' . $videoId . '.json', false, null, 20), true);
                $image_url = $vimeo[0]['thumbnail_large'];
            }
            if ($videoType) {
                $file_attachment = array();
                $file_attachment['content'] = Tools::file_get_contents($image_url, false, null, 20);
                $ext = Tools::strtolower(strrchr(basename($image_url), '.'));
                $file_attachment['name'] = $fspv_id_product . '_' . $videoId . $ext;
                $same_file_counter = 1;
                while (file_exists(dirname(call_user_func(array($fsproductvideo, 'getModuleFile'))) . '/thumbnail/' . $file_attachment['name'])) {
                    $file_attachment['name'] = $fspv_id_product . '_' . $videoId . '-';
                    $file_attachment['name'] .= $same_file_counter . $ext;
                    $same_file_counter++;
                }
                $class = 'FsProductVideoImage';
                $image = new $class($file_attachment);
                $image->setResizeOptions(640, 480, 'crop');
                $image->saveImage(dirname(call_user_func(array($fsproductvideo, 'getModuleFile'))) . '/thumbnail/' . $file_attachment['name']);
                $imageName = $file_attachment['name'];
            }
        }
        return $imageName;
    }

    protected function createAdditionalproductsorderRelation($product, $value, $multiple_value_separator)
    {
        if (!$product->id || !ElegantalEasyImportTools::isModuleInstalled('additionalproductsorder')) {
            return;
        }
        // Delete old records
        $sql = "DELETE FROM `" . _DB_PREFIX_ . "lineven_apo` WHERE `product_cart_id` = " . (int) $product->id;
        Db::getInstance()->execute($sql);

        $id_shop = $this->context->shop->id;
        $id_shop_group = $this->context->shop->id_shop_group;

        $ids = explode($multiple_value_separator, $value);
        $ids = array_map('trim', $ids);
        $ids = array_unique($ids);
        foreach ($ids as $id) {
            if (empty($id)) {
                continue;
            }
            if ($this->find_products_by == 'reference' || !Validate::isInt($id)) {
                // Find product id by reference
                $sql = "SELECT * FROM `" . _DB_PREFIX_ . "product` WHERE `reference` = '" . pSQL($id) . "'";
                $row = Db::getInstance()->getRow($sql);
                if ($row && isset($row['id_product']) && $row['id_product']) {
                    $id = $row['id_product'];
                }
            }
            $sql = "INSERT INTO `" . _DB_PREFIX_ . "lineven_apo` (`id_shop_group`, `id_shop`, `name`, `short_description`, `comments`, `category_id`, `product_cart_id`, `product_id`, `minimum_amount`, `maximum_amount`, `is_active_groups`, `order_display`)
                VALUES (" . (int) $id_shop_group . ", " . (int) $id_shop . ", 'a:1:{i:1;s:0:\"\";}', 'a:1:{i:1;s:0:\"\";}', '', NULL, " . (int) $product->id . ", " . (int) $id . ", 0, 0, 0, 1)";
            Db::getInstance()->execute($sql);
        }
    }

    protected function createJmarketplaceSellerRelation($id_product, $value)
    {
        if (!$id_product || !ElegantalEasyImportTools::isModuleInstalled('jmarketplace')) {
            return;
        }
        $sql = "DELETE FROM `" . _DB_PREFIX_ . "seller_product` WHERE `id_seller_product` = " . (int) $value . " AND `id_product` = " . (int) $id_product;
        Db::getInstance()->execute($sql);
        if ($id_product && $value && Validate::isInt($value)) {
            $sql = "INSERT INTO `" . _DB_PREFIX_ . "seller_product` (`id_seller_product`, `id_product`) VALUES (" . (int) $value . ", " . (int) $id_product . ")";
            Db::getInstance()->execute($sql);
        }
    }

    protected function createProductaffiliateRelation($product_id, $lang_id, $productaffiliate_external_shop_url, $productaffiliate_button_text)
    {
        if (!$product_id || !$lang_id || !ElegantalEasyImportTools::isModuleInstalled('productaffiliate')) {
            return;
        }
        if (!empty($productaffiliate_button_text) && !empty($productaffiliate_external_shop_url)) {
            $sql = "INSERT INTO `" . _DB_PREFIX_ . "affiliated_product` (`id_product`,`id_language`,`text`,`href`)
                VALUES (" . (int) $product_id . "," . (int) $lang_id . ",'" . pSQL($productaffiliate_button_text) . "','" . pSQL($productaffiliate_external_shop_url) . "')
                ON DUPLICATE KEY UPDATE `text`='" . pSQL($productaffiliate_button_text) . "', `href`='" . pSQL($productaffiliate_external_shop_url) . "'";
            $result = Db::getInstance()->execute($sql);
            if ($result) {
                Configuration::updateValue('AFFP_ID_LANGUAGE', $lang_id);
            }
        } else {
            $sql = "DELETE FROM `" . _DB_PREFIX_ . "affiliated_product` WHERE `id_product`=" . (int) $product_id . " AND `id_language`=" . (int) $lang_id;
            $result = Db::getInstance()->execute($sql);
        }
    }

    protected function createIqitadditionaltabsRelation($id_product, $title, $description, $lang_id, $shop_ids, $iqit_count)
    {
        if (!$id_product || !ElegantalEasyImportTools::isModuleInstalled('iqitadditionaltabs')) {
            return;
        }
        if (empty($shop_ids)) {
            $shop_ids = array($this->context->shop->id);
        }

        $offset = ($iqit_count > 0) ? $iqit_count - 1 : 0;
        $sql = "SELECT `id_iqitadditionaltab` FROM `" . _DB_PREFIX_ . "iqitadditionaltab` WHERE `id_product` = " . (int) $id_product . " ORDER BY `position`, `id_iqitadditionaltab` LIMIT 1 OFFSET " . (int) $offset;
        $id_iqitadditionaltab = Db::getInstance()->executeS($sql);
        $id_iqitadditionaltab = isset($id_iqitadditionaltab[0]['id_iqitadditionaltab']) ? $id_iqitadditionaltab[0]['id_iqitadditionaltab'] : null;

        if ($id_iqitadditionaltab) {
            $sql = "SELECT `id_iqitadditionaltab` FROM `" . _DB_PREFIX_ . "iqitadditionaltab_lang` WHERE `id_iqitadditionaltab` = " . (int) $id_iqitadditionaltab . " AND `id_lang` = " . (int) $lang_id;
            $id_iqitadditionaltab = Db::getInstance()->getValue($sql);
            if ($id_iqitadditionaltab) {
                $sql = "UPDATE `" . _DB_PREFIX_ . "iqitadditionaltab_lang`
                    SET `title` = '" . pSQL($title) . "', `description` = '" . pSQL($description, true) . "'
                    WHERE `id_iqitadditionaltab` = " . (int) $id_iqitadditionaltab . " AND `id_lang` = " . (int) $lang_id;
            } else {
                $sql = "INSERT INTO `" . _DB_PREFIX_ . "iqitadditionaltab_lang` (`id_iqitadditionaltab`, `id_lang`, `title`, `description`)
                    VALUES (" . (int) $id_iqitadditionaltab . ", " . (int) $lang_id . ", '" . pSQL($title) . "', '" . pSQL($description, true) . "')
                    WHERE `id_iqitadditionaltab` = " . (int) $id_iqitadditionaltab . " AND `id_lang` = " . (int) $lang_id;
            }
            Db::getInstance()->execute($sql);
        } else {
            $sql = "INSERT INTO `" . _DB_PREFIX_ . "iqitadditionaltab` (`id_product`, `position`, `active`)
                VALUES (" . (int) $id_product . ", 0, 1)";
            if (Db::getInstance()->execute($sql) && ($id_iqitadditionaltab = (int) Db::getInstance()->Insert_ID())) {
                foreach ($this->id_all_langs as $id_lang) {
                    $title_lang = ($lang_id == $id_lang) ? $title : "";
                    $desc_lang = ($lang_id == $id_lang) ? $description : "";
                    $sql = "INSERT INTO `" . _DB_PREFIX_ . "iqitadditionaltab_lang` (`id_iqitadditionaltab`, `id_lang`, `title`, `description`)
                        VALUES (" . (int) $id_iqitadditionaltab . ", " . (int) $id_lang . ", '" . pSQL($title_lang) . "', '" . pSQL($desc_lang, true) . "')";
                    Db::getInstance()->execute($sql);
                }
                foreach ($shop_ids as $shop_id) {
                    $sql = "INSERT INTO `" . _DB_PREFIX_ . "iqitadditionaltab_shop` (`id_iqitadditionaltab`, `id_shop`)
                        VALUES (" . (int) $id_iqitadditionaltab . ", " . (int) $shop_id . ")";
                    Db::getInstance()->execute($sql);
                }
            }
        }
    }

    protected function createEcmCmlidRelation($id_product, $value, $id_product_attribute = null)
    {
        if (!$id_product || !ElegantalEasyImportTools::isModuleInstalled('ecm_cmlid')) {
            return;
        }
        $check_xml = Db::getInstance()->ExecuteS("SHOW COLUMNS FROM `" . _DB_PREFIX_ . "product` WHERE `Field` = 'xml'");
        if (!empty($check_xml) && $id_product && $value) {
            if ($id_product_attribute) {
                Db::getInstance()->update('product_attribute', array('xml' => $value), 'id_product = ' . (int) $id_product . ' AND id_product_attribute = ' . (int) $id_product_attribute);
                Db::getInstance()->update('product_attribute_shop', array('xml' => $value), 'id_product_attribute = ' . (int) $id_product_attribute);
            } else {
                Db::getInstance()->update('product', array('xml' => $value), 'id_product = ' . (int) $id_product);
                Db::getInstance()->update('product_shop', array('xml' => $value), 'id_product = ' . (int) $id_product);
            }
        }
    }

    protected function createAdvancedcustomfieldsValue($product_id, $acf_technical_name, $value, $id_lang)
    {
        if (!$product_id || !$acf_technical_name || !ElegantalEasyImportTools::isModuleInstalled('advancedcustomfields')) {
            return;
        }
        $sql = "SELECT * FROM `" . _DB_PREFIX_ . "advanced_custom_fields` WHERE `location` = 'product' AND `technical_name` = '" . pSQL($acf_technical_name) . "'";
        $acf = Db::getInstance()->getRow($sql);
        if (!$acf || !isset($acf['id_custom_field'])) {
            return;
        }
        $value_main = $acf['translatable'] ? "" : $value;
        $value_lang = $acf['translatable'] ? $value : "";
        $id_custom_field_content = null;
        $sql = "SELECT * FROM `" . _DB_PREFIX_ . "advanced_custom_fields_content` WHERE `id_custom_field` = " . (int) $acf['id_custom_field'] . " AND `resource_id` = " . (int) $product_id;
        $acfc = Db::getInstance()->getRow($sql);
        if ($acfc && isset($acfc['id_custom_field_content']) && $acfc['id_custom_field_content']) {
            $id_custom_field_content = (int) $acfc['id_custom_field_content'];
        } else {
            $sql = "INSERT INTO `" . _DB_PREFIX_ . "advanced_custom_fields_content` (`id_store`, `id_custom_field`, `resource_id`, `value`)
                VALUES (" . (int) $this->context->shop->id . ", " . (int) $acf['id_custom_field'] . ", " . (int) $product_id . ", '" . pSQL($value_main) . "')";
            if (Db::getInstance()->execute($sql)) {
                $id_custom_field_content = (int) Db::getInstance()->Insert_ID();
            }
        }
        if ($id_custom_field_content) {
            $sql = "SELECT * FROM `" . _DB_PREFIX_ . "advanced_custom_fields_content_lang` WHERE `id_custom_field_content` = " . (int) $id_custom_field_content . " AND `id_lang` = " . (int) $id_lang;
            $acfcl = Db::getInstance()->getRow($sql);
            if ($acfcl) {
                $sql = "UPDATE `" . _DB_PREFIX_ . "advanced_custom_fields_content_lang` SET `lang_value` = '" . pSQL($value_lang) . "' WHERE `id_custom_field_content` = " . (int) $id_custom_field_content . " AND `id_lang` = " . (int) $id_lang;
            } else {
                $sql = "INSERT INTO `" . _DB_PREFIX_ . "advanced_custom_fields_content_lang` (`id_custom_field_content`, `id_lang`, `lang_value`) VALUES (" . (int) $id_custom_field_content . ", " . (int) $id_lang . ", '" . pSQL($value_lang) . "')";
            }
            Db::getInstance()->execute($sql);
        }
    }

    protected function createTotcustomfieldsValue($product_id, $code, $value, $id_lang)
    {
        if (!$product_id || !$code || !ElegantalEasyImportTools::isModuleInstalled('totcustomfields')) {
            return;
        }
        $totcustomfield = Db::getInstance()->getRow("SELECT * FROM `" . _DB_PREFIX_ . "totcustomfields_input` t WHERE t.`code_object` = 'product' AND t.`code` = '" . pSQL($code) . "'");
        if (!$totcustomfield) {
            return;
        }
        if ($totcustomfield['is_translatable']) {
            $exists = Db::getInstance()->getRow("SELECT * FROM `" . _DB_PREFIX_ . "totcustomfields_input_" . pSQL($totcustomfield['code_input_type']) . "_value` WHERE `id_input` = " . (int) $totcustomfield['id_input'] . " AND `id_object` = " . (int) $product_id . " AND `id_lang` = " . (int) $id_lang);
            if ($exists) {
                $sql = "UPDATE `" . _DB_PREFIX_ . "totcustomfields_input_" . pSQL($totcustomfield['code_input_type']) . "_value`
                    SET `id_input` = " . (int) $totcustomfield['id_input'] . ", `id_object` = " . (int) $product_id . ", `id_lang` = " . (int) $id_lang . ", `value` = '" . pSQL($value) . "'
                    WHERE `id_input_value` = " . (int) $exists['id_input_value'];
            } else {
                $sql = "INSERT INTO `" . _DB_PREFIX_ . "totcustomfields_input_" . pSQL($totcustomfield['code_input_type']) . "_value` (`id_input`, `id_object`, `id_lang`, `value`)
                    VALUES (" . (int) $totcustomfield['id_input'] . ", " . (int) $product_id . ", " . (int) $id_lang . ", '" . pSQL($value) . "')";
            }
            Db::getInstance()->execute($sql);
        } else {
            // Delete existing
            $sql = "DELETE FROM `" . _DB_PREFIX_ . "totcustomfields_input_" . pSQL($totcustomfield['code_input_type']) . "_value` WHERE `id_input` = " . (int) $totcustomfield['id_input'] . " AND `id_object` = " . (int) $product_id;
            Db::getInstance()->execute($sql);
            // Insert new
            $sql = "INSERT INTO `" . _DB_PREFIX_ . "totcustomfields_input_" . pSQL($totcustomfield['code_input_type']) . "_value` (`id_input`, `id_object`, `value`)  VALUES (" . (int) $totcustomfield['id_input'] . ", " . (int) $product_id . ", '" . pSQL($value) . "')";
            Db::getInstance()->execute($sql);
        }
    }

    protected function createPpropertiesRelation($id_product, $id_product_attribute, $quantity_step, $minimal_quantity, $shop_ids)
    {
        if (!$id_product || !ElegantalEasyImportTools::isModuleInstalled('pproperties')) {
            return;
        }
        if (empty($shop_ids)) {
            $shop_ids = array($this->context->shop->id);
        }
        $data = array();
        if ($quantity_step !== false) {
            $data['quantity_step'] = $quantity_step;
        }
        if ($minimal_quantity !== false) {
            $data['minimal_quantity_fractional'] = $minimal_quantity;
        }
        foreach ($shop_ids as $key => $shop_id) {
            if ($id_product_attribute) {
                if ($key === 0) {
                    Db::getInstance()->update('product_attribute', $data, "`id_product` = " . (int) $id_product . " AND `id_product_attribute` = " . (int) $id_product_attribute);
                }
                Db::getInstance()->update('product_attribute_shop', $data, "`id_product` = " . (int) $id_product . " AND `id_product_attribute` = " . (int) $id_product_attribute . " AND `id_shop` = " . (int) $shop_id);
            } else {
                if ($key === 0) {
                    Db::getInstance()->update('product', $data, "`id_product` = " . (int) $id_product);
                }
                Db::getInstance()->update('product_shop', $data, "`id_product` = " . (int) $id_product . " AND `id_shop` = " . (int) $shop_id);
            }
        }
    }

    protected function createBmsAdvancedstockRelation($id_product, $id_product_attribute, $warehouse, $physical_quantity, $available_quantity, $reserved_quantity, $stock_shelf_location, $shop_ids)
    {
        if (!$id_product || !$warehouse || !ElegantalEasyImportTools::isModuleInstalled('advancedstock')) {
            return;
        }
        if (empty($shop_ids)) {
            $shop_ids = array($this->context->shop->id);
        }

        $physical_quantity = $physical_quantity < 0 ? 0 : $physical_quantity;
        $available_quantity = $available_quantity < 0 ? 0 : $available_quantity;
        $reserved_quantity = $reserved_quantity < 0 ? 0 : $reserved_quantity;

        $warehouse_id = 0;
        $sql = "SELECT DISTINCT w.`w_id` FROM `" . _DB_PREFIX_ . "bms_advancedstock_warehouse` w
            INNER JOIN `" . _DB_PREFIX_ . "bms_advancedstock_warehouse_shop` ws ON ws.`ws_warehouse_id` = w.`w_id`
            WHERE w.`w_name` = '" . pSQL($warehouse) . "' AND ws.`ws_shop_id` IN (" . implode(", ", array_map("intval", $shop_ids)) . ")";
        $w_id = (int) Db::getInstance()->getValue($sql);
        if ($w_id) {
            $warehouse_id = (int) $w_id;
        } elseif (!$w_id && Validate::isInt($warehouse)) {
            $warehouse_id = (int) $warehouse;
        } else {
            return;
        }

        $sql = "SELECT * FROM `" . _DB_PREFIX_ . "bms_advancedstock_warehouse_product` wp
            WHERE wp.`wi_warehouse_id` = " . (int) $warehouse_id . " AND wp.`wi_product_id` = " . (int) $id_product . " AND wp.`wi_attribute_id` = " . (int) $id_product_attribute;
        $wp = Db::getInstance()->getRow($sql);
        if ($wp) {
            if (!$stock_shelf_location) {
                $stock_shelf_location = $wp['wi_shelf_location'];
            }
            $sql = "UPDATE `" . _DB_PREFIX_ . "bms_advancedstock_warehouse_product` SET `wi_physical_quantity` = " . (int) $physical_quantity . ", `wi_available_quantity` = " . (int) $available_quantity . ", `wi_reserved_quantity` = " . (int) $reserved_quantity . ", wi_shelf_location = '" . pSQL($stock_shelf_location) . "' WHERE `wi_id` = " . (int) $wp['wi_id'];
            Db::getInstance()->execute($sql);
        } else {
            $sql = "INSERT INTO `" . _DB_PREFIX_ . "bms_advancedstock_warehouse_product` (`wi_warehouse_id`, `wi_product_id`, `wi_attribute_id`, `wi_physical_quantity`, `wi_available_quantity`, `wi_reserved_quantity`, `wi_shelf_location`)
                VALUES (" . (int) $warehouse_id . ", " . (int) $id_product . ", " . (int) $id_product_attribute . ", " . (int) $physical_quantity . ", " . (int) $available_quantity . ", " . (int) $reserved_quantity . ", '" . pSQL($stock_shelf_location) . "')";
            Db::getInstance()->execute($sql);
        }
    }

    protected function createWkgrocerymanagementRelation($id_product, $wk_measurement_allowed, $wk_measurement_type, $wk_measurement_value, $wk_measurement_unit, $wk_measurement_units_for_customer, $multiple_value_separator, $shop_ids)
    {
        if (!$id_product || !ElegantalEasyImportTools::isModuleInstalled('wkgrocerymanagement') || !$wk_measurement_value) {
            return;
        }
        if (!$this->isCsvValueTrue($wk_measurement_allowed)) {
            foreach ($shop_ids as $shop_id) {
                $sql = "DELETE FROM `" . _DB_PREFIX_ . "wk_grocery_products` WHERE `id_ps_product` = " . (int) $id_product . " AND `id_ps_shop` = " . (int) $shop_id;
                Db::getInstance()->execute($sql);
            }
            return;
        }

        $measurement_types = array();
        $wk_measurement_type = Tools::strtolower($wk_measurement_type);
        if (method_exists('WkGroceryModuleDb', 'predefinedMeasurementTypes')) {
            $wk_types = call_user_func(array('WkGroceryModuleDb', 'predefinedMeasurementTypes'));
            foreach ($wk_types as $wk_type) {
                $measurement_types[$wk_type['id']] = Tools::strtolower($wk_type['name']);
            }
        } else {
            $measurement_types = array(1 => 'weight', 2 => 'length', 3 => 'area', 4 => 'volume');
        }
        if (!in_array($wk_measurement_type, $measurement_types)) {
            return;
        }
        $wk_measurement_type = array_search($wk_measurement_type, $measurement_types);
        if (!$wk_measurement_type) {
            return;
        }

        $measurement_units = array();
        $wk_measurement_unit = Tools::strtolower($wk_measurement_unit);
        // Only position is needed because position is saved as measurement_unit
        $sql = "SELECT u.`position`, ul.`measurement_units` FROM `" . _DB_PREFIX_ . "wk_grocery_measurement_units` u
            INNER JOIN `" . _DB_PREFIX_ . "wk_grocery_measurement_units_lang` ul ON ul.`id` = u.`id`
            WHERE u.`measurement_type` = " . (int) $wk_measurement_type . "
            GROUP BY u.`position`, ul.`measurement_units`";
        $wk_measurement_units = Db::getInstance()->executeS($sql);
        foreach ($wk_measurement_units as $wk_mu) {
            $measurement_units[Tools::strtolower($wk_mu['measurement_units'])] = $wk_mu['position'];
        }
        $wk_measurement_unit = isset($measurement_units[$wk_measurement_unit]) ? $measurement_units[$wk_measurement_unit] : false;
        if (!$wk_measurement_unit && $wk_measurement_unit !== 0 && $wk_measurement_unit !== '0') {
            return;
        }

        $measurement_units_for_customer = array();
        $wk_measurement_units_for_customer = explode($multiple_value_separator, $wk_measurement_units_for_customer);
        foreach ($wk_measurement_units_for_customer as $wk_muc) {
            $wk_muc = isset($measurement_units[$wk_muc]) ? $measurement_units[$wk_muc] : false;
            if ($wk_muc || $wk_muc === 0 || $wk_muc === '0') {
                $measurement_units_for_customer[] = $wk_muc;
            }
        }
        if (!in_array($wk_measurement_unit, $measurement_units_for_customer)) {
            $measurement_units_for_customer[] = $wk_measurement_unit;
        }
        $measurement_units_for_customer = serialize($measurement_units_for_customer);

        foreach ($shop_ids as $shop_id) {
            $sql = "SELECT `id_grocery_product` FROM `" . _DB_PREFIX_ . "wk_grocery_products`
                WHERE `id_ps_product` = " . (int) $id_product . " AND `id_ps_shop` = " . (int) $shop_id;
            $id_grocery_product = Db::getInstance()->getValue($sql);
            if ($id_grocery_product) {
                $sql = "UPDATE `" . _DB_PREFIX_ . "wk_grocery_products`
                    SET `measurement_type` = " . (int) $wk_measurement_type . ", `measurement_unit` = " . (int) $wk_measurement_unit . ", `measurement_initial_value` = " . (float) $wk_measurement_value . ", `selected_measurement_units` = '" . pSQL($measurement_units_for_customer) . "', `is_grocery` = 1
                    WHERE `id_grocery_product` = " . (int) $id_grocery_product;
            } else {
                $sql = "INSERT INTO `" . _DB_PREFIX_ . "wk_grocery_products` (`id_ps_product`, `id_ps_shop`, `measurement_type`, `measurement_unit`, `measurement_initial_value`, `selected_measurement_units`, `is_grocery`)
                    VALUES (" . (int) $id_product . ", " . (int) $shop_id . ", " . (int) $wk_measurement_type . ", " . (int) $wk_measurement_unit . ", " . (float) $wk_measurement_value . ", '" . pSQL($measurement_units_for_customer) . "', 1)";
            }
            Db::getInstance()->execute($sql);
        }
    }

    protected function createMsrpRelation($id_product, $id_product_attribute, $id_tax_rules_group, $tex, $tax_included, $shop_ids)
    {
        if (!$id_product || !ElegantalEasyImportTools::isModuleInstalled('msrp')) {
            return;
        }

        $tex = (float) $this->extractPriceInDefaultCurrency($tex);

        // Check if Tax Rule Group exists
        if ($tax_included) {
            $tax_rate = 0;
            if ($id_tax_rules_group) {
                $taxRulesGroup = new TaxRulesGroup($id_tax_rules_group);
                if (!Validate::isLoadedObject($taxRulesGroup) || $taxRulesGroup->deleted) {
                    $id_tax_rules_group = 0;
                }
            }
            if ($id_tax_rules_group) {
                $address = Address::initialize();
                $tax_manager = TaxManagerFactory::getManager($address, $id_tax_rules_group);
                $tax_calculator = $tax_manager->getTaxCalculator();
                $tax_rate = $tax_calculator->getTotalRate();
            }
            if ($tax_rate) {
                $tex = (float) number_format($tex / (1 + $tax_rate / 100), 2, '.', '');
            }
        }

        foreach ($shop_ids as $shop_id) {
            if ($id_product_attribute) {
                $sql = "SELECT `id_msrp_combination` FROM `" . _DB_PREFIX_ . "msrp_combination`
                    WHERE `id_product` = " . (int) $id_product . " AND `id_combination` = " . (int) $id_product_attribute . " AND `id_shop` = " . (int) $shop_id;
                $id_msrp_combination = Db::getInstance()->getValue($sql);
                if ($id_msrp_combination) {
                    $sql = "UPDATE `" . _DB_PREFIX_ . "msrp_combination` SET `tex` = " . (float) $tex . " WHERE `id_msrp_combination` = " . (int) $id_msrp_combination;
                } else {
                    $sql = "INSERT INTO `" . _DB_PREFIX_ . "msrp_combination` (`id_product`, `id_combination`, `id_shop`, `tex`, `tin`) VALUES (" . (int) $id_product . ", " . (int) $id_product_attribute . ", " . (int) $shop_id . ", " . (float) $tex . ", 0)";
                }
            } else {
                $sql = "SELECT `id_msrp_product` FROM `" . _DB_PREFIX_ . "msrp_product`
                    WHERE `id_product` = " . (int) $id_product . " AND `id_shop` = " . (int) $shop_id;
                $id_msrp_product = Db::getInstance()->getValue($sql);
                if ($id_msrp_product) {
                    $sql = "UPDATE `" . _DB_PREFIX_ . "msrp_product` SET `tex` = " . (float) $tex . " WHERE `id_msrp_product` = " . (int) $id_msrp_product;
                } else {
                    $sql = "INSERT INTO `" . _DB_PREFIX_ . "msrp_product` (`id_product`, `id_shop`, `tex`, `tin`) VALUES (" . (int) $id_product . ", " . (int) $shop_id . ", " . (float) $tex . ", 0)";
                }
            }
            Db::getInstance()->execute($sql);
        }
    }

    protected function createAreapacksRelation($id_product, $id_product_attribute, $areapacks_label, $areapacks_type, $areapacks_area)
    {
        if (!$id_product || !ElegantalEasyImportTools::isModuleInstalled('areapacks')) {
            return;
        }

        $id_areapacks = Db::getInstance()->getValue("SELECT `id_areapacks` FROM `" . _DB_PREFIX_ . "areapacks` WHERE `id_product` = " . (int) $id_product);
        if ($id_areapacks && ($areapacks_label || $areapacks_type || $areapacks_area !== "")) {
            $sql = "UPDATE `" . _DB_PREFIX_ . "areapacks` SET ";
            if ($areapacks_area !== "") {
                $sql .= "`item_area` = " . (float) $areapacks_area . ", ";
            }
            if ($areapacks_label) {
                $sql .= "`item_label` = '" . pSQL($areapacks_label) . "', ";
            }
            if ($areapacks_type) {
                $sql .= "`pak_type` = " . (int) $areapacks_type . ", ";
            }
            $sql = rtrim($sql, ", ") . " WHERE `id_areapacks` = " . (int) $id_areapacks;
            Db::getInstance()->execute($sql);
        } elseif (!$id_areapacks && $areapacks_label && $areapacks_type && $areapacks_area !== "") {
            $sql = "INSERT INTO `" . _DB_PREFIX_ . "areapacks` (`id_product`, `item_label`, `pak_type`, `item_area`) VALUES (" . (int) $id_product . ", '" . pSQL($areapacks_label) . "', " . (int) $areapacks_type . ", " . (float) $areapacks_area . ")";
            Db::getInstance()->execute($sql);
        }

        if ($id_product_attribute && $areapacks_area !== "") {
            Db::getInstance()->execute("DELETE FROM `" . _DB_PREFIX_ . "areapacks_combination` WHERE `id_product` = " . (int) $id_product . " AND `id_combination` = " . (int) $id_product_attribute);
            Db::getInstance()->execute("INSERT INTO `" . _DB_PREFIX_ . "areapacks_combination` (`id_product`, `id_combination`, `item_area`) VALUES (" . (int) $id_product . ", " . (int) $id_product_attribute . ", " . (float) $areapacks_area . ")");
        }
    }

    /**
     * Downloads import file according to selected method
     * @return boolean
     * @throws Exception
     */
    public function downloadImportFile()
    {
        $error = null;

        // Get old file name so that we can delete it after downloading new file
        $old_file = $this->csv_file;

        // Generate name for new file
        $this->csv_file = ElegantalEasyImportTools::generateTmpFilename('csv');

        $remote_file_extension = null;
        try {
            switch ($this->import_type) {
                case self::$IMPORT_TYPE_UPLOAD:
                    $remote_file_extension = $this->downloadFileUploaded();
                    break;
                case self::$IMPORT_TYPE_URL:
                    $remote_file_extension = $this->downloadFileFromUrl();
                    break;
                case self::$IMPORT_TYPE_PATH:
                    $remote_file_extension = $this->downloadFileFromPath();
                    break;
                case self::$IMPORT_TYPE_FTP:
                    $remote_file_extension = $this->downloadFileFromFtp();
                    break;
                case self::$IMPORT_TYPE_SFTP:
                    $remote_file_extension = $this->downloadFileFromSftp();
                    break;
                default:
                    throw new Exception('Import Method is not valid.');
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        // If model has old file, delete it
        if ($old_file && !$error) {
            ElegantalEasyImportTools::deleteTmpFile($old_file);
        }

        if ($error) {
            throw new Exception($error);
        }

        $local_file = ElegantalEasyImportTools::getRealPath($this->csv_file);

        if ($this->is_cron) {
            $this->cron_csv_file_size = filesize($local_file);
            $this->cron_csv_file_md5 = md5_file($local_file);
        }

        $this->convertFileToCsv($local_file, $remote_file_extension);

        if ($this->id) {
            $this->update();
        }

        return true;
    }

    protected function downloadFileUploaded()
    {
        if (!isset($_FILES['csv_file_upload']) || empty($_FILES['csv_file_upload']["tmp_name"]) || !is_uploaded_file($_FILES['csv_file_upload']['tmp_name'])) {
            throw new Exception('File is not uploaded.');
        }

        // Validate file type
        $extension = Tools::strtolower(pathinfo($_FILES['csv_file_upload']['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, self::$allowed_file_types)) {
            throw new Exception(sprintf($this->l('File type %s is not allowed.'), $extension) . ' ' . $this->l('Supported file formats:') . ' ' . implode(', ', self::$allowed_file_types));
        }

        // Validate mime type
        $mime = ElegantalEasyImportTools::getMimeType($_FILES['csv_file_upload']["tmp_name"], $extension);
        if (!in_array($mime, self::$allowed_mime_types)) {
            throw new Exception($this->l('This type of file is not allowed.') . ' Mime Type: ' . $mime);
        }

        $local_file = ElegantalEasyImportTools::createPath($this->csv_file);

        if (!move_uploaded_file($_FILES['csv_file_upload']["tmp_name"], $local_file)) {
            throw new Exception('There was an error uploading your file. Please try again.');
        }

        return $extension;
    }

    protected function downloadFileFromUrl()
    {
        if (!$this->csv_url || !ElegantalEasyImportTools::isValidUrl($this->csv_url)) {
            throw new Exception($this->l('Wrong URL') . ': ' . $this->csv_url);
        }

        $local_file = ElegantalEasyImportTools::createPath($this->csv_file);

        ElegantalEasyImportTools::downloadFileFromUrl($this->csv_url, $local_file, $this->csv_url_username, $this->csv_url_password, $this->csv_url_method, $this->csv_url_post_params);

        // Get file size
        $file_size = filesize($local_file);
        if (!$file_size) {
            @unlink($local_file);
            throw new Exception($this->l('File not found or it is empty.') . ' ' . $this->csv_url);
        }

        $extension = Tools::strtolower(pathinfo($this->csv_url, PATHINFO_EXTENSION));

        // Validate mime type
        $mime = ElegantalEasyImportTools::getMimeType($local_file, $extension);
        if (!in_array($mime, self::$allowed_mime_types)) {
            @unlink($local_file);
            throw new Exception($this->l('This type of file is not allowed.') . ' Mime Type: ' . $mime);
        }

        // Validate file type
        if (!in_array($extension, self::$allowed_file_types)) {
            switch ($mime) {
                case 'text/xml':
                case 'text/html':
                case 'application/xml':
                    $extension = 'xml';
                    break;
                case 'text/csv':
                case 'text/plain':
                case 'application/octet-stream':
                case 'message/news':
                    $extension = 'csv';
                    break;
                case 'application/vnd.ms-excel':
                case 'application/vnd.ms-office':
                    $extension = 'xls';
                    break;
                case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                    $extension = 'xlsx';
                    break;
                case 'application/vnd.oasis.opendocument.spreadsheet':
                    $extension = 'ods';
                    break;
                case 'application/json':
                    $extension = 'json';
                    break;
                default:
                    break;
            }
            if (!in_array($extension, self::$allowed_file_types)) {
                @unlink($local_file);
                throw new Exception(sprintf($this->l('File type %s is not allowed.'), $extension) . ' ' . $this->l('Supported file formats:') . ' ' . implode(', ', self::$allowed_file_types));
            }
        }

        return $extension;
    }

    protected function downloadFileFromPath()
    {
        $csv_path = $this->csv_path;
        if (Tools::substr($csv_path, 0, 1) != '/') {
            $csv_path = realpath(_PS_ROOT_DIR_ . '/' . $csv_path);
        }

        // Validate file from path
        if (!$csv_path || !is_file($csv_path) || !is_readable($csv_path)) {
            throw new Exception($this->l('File not found from given path.') . ' ' . $csv_path);
        }

        // Validate file type
        $extension = Tools::strtolower(pathinfo($csv_path, PATHINFO_EXTENSION));
        if (!in_array($extension, self::$allowed_file_types)) {
            throw new Exception(sprintf($this->l('File type %s is not allowed.'), $extension) . ' ' . $this->l('Supported file formats:') . ' ' . implode(', ', self::$allowed_file_types));
        }

        // Validate mime type
        $mime = ElegantalEasyImportTools::getMimeType($csv_path, $extension);
        if (!in_array($mime, self::$allowed_mime_types)) {
            throw new Exception($this->l('This type of file is not allowed.') . ' Mime Type: ' . $mime);
        }

        // Clear cache of old filesize
        clearstatcache(true, $csv_path);
        // Get file size
        $file_size = filesize($csv_path);
        if (!$file_size) {
            throw new Exception($this->l('File not found or it is empty.') . ' ' . $csv_path);
        }

        $local_file = ElegantalEasyImportTools::createPath($this->csv_file);

        $file_contents = Tools::file_get_contents($csv_path);
        if ($file_contents) {
            if (!file_put_contents($local_file, $file_contents)) {
                throw new Exception('An error occured while saving the file. ' . $csv_path);
            }
        } else {
            throw new Exception($this->l('File not found or it is empty.') . ' ' . $csv_path);
        }

        return $extension;
    }

    protected function downloadFileFromFtp()
    {
        if (!$this->ftp_host) {
            throw new Exception(sprintf($this->l('%s is not valid.'), $this->l('FTP Host')));
        }
        if (!$this->ftp_username) {
            throw new Exception(sprintf($this->l('%s is not valid.'), $this->l('FTP Username')));
        }
        if (!$this->ftp_password) {
            throw new Exception(sprintf($this->l('%s is not valid.'), $this->l('FTP Password')));
        }
        if (!$this->ftp_file) {
            throw new Exception(sprintf($this->l('%s is not valid.'), $this->l('FTP File')));
        }

        $ftp_file = $this->ftp_file;
        $pathinfo = pathinfo($ftp_file);

        // Validate file type
        $extension = Tools::strtolower($pathinfo['extension']);
        if (!in_array($extension, self::$allowed_file_types)) {
            throw new Exception(sprintf($this->l('File type %s is not allowed.'), $extension) . ' ' . $this->l('Supported file formats:') . ' ' . implode(', ', self::$allowed_file_types));
        }

        // Connect to FTP server
        $ftp_port = $this->ftp_port ? $this->ftp_port : 21;
        $ftp_conn = ftp_connect($this->ftp_host, $ftp_port);
        if (!$ftp_conn) {
            throw new Exception($this->l('Could not connect to FTP') . ': ' . $this->ftp_host . ':' . $ftp_port);
        }

        // Login to FTP server. You can list files this way: ftp_nlist($ftp_conn, ".")
        $ftp_login = ftp_login($ftp_conn, $this->ftp_username, $this->ftp_password);
        if (!$ftp_login) {
            ftp_close($ftp_conn);
            // Try new connection with SSL
            if (function_exists('ftp_ssl_connect')) {
                $ftp_conn = ftp_ssl_connect($this->ftp_host, $ftp_port);
                if (!$ftp_conn) {
                    throw new Exception($this->l('Could not connect to FTP') . ': ' . $this->ftp_host . ':' . $ftp_port);
                }
                $ftp_login = ftp_login($ftp_conn, $this->ftp_username, $this->ftp_password);
                if (!$ftp_login) {
                    ftp_close($ftp_conn);
                    throw new Exception($this->l('FTP login failed.'));
                }
            } else {
                throw new Exception($this->l('FTP login failed.'));
            }
        }

        if ($pathinfo['filename'] == 'GET_LATEST_FILE') {
            ftp_pasv($ftp_conn, true); // Try with passive mode
            $files = ftp_nlist($ftp_conn, $pathinfo['dirname']);
            if (!$files) {
                ftp_pasv($ftp_conn, false); // Disable passive mode and try again
                $files = ftp_nlist($ftp_conn, $pathinfo['dirname']);
                if (!$files) {
                    ftp_close($ftp_conn);
                    throw new Exception('FTP error getting files list.');
                }
            }
            if ($files && is_array($files)) {
                $filtered_files = preg_grep("/\." . $pathinfo['extension'] . "$/i", $files);
                if ($filtered_files && is_array($filtered_files)) {
                    // Find last modified file
                    $most_recent = array(
                        'time' => 0,
                        'file' => null,
                    );
                    foreach ($filtered_files as $file) {
                        // Get the last modified time for the file
                        $time = ftp_mdtm($ftp_conn, $file);
                        if ($time > $most_recent['time']) {
                            // This file is the most recent so far
                            $most_recent['time'] = $time;
                            $most_recent['file'] = $file;
                        }
                    }
                    $ftp_file = $most_recent['file'];
                }
            }
        }

        // Get file size
        $file_size = ftp_size($ftp_conn, $ftp_file);
        if (!$file_size) {
            ftp_close($ftp_conn);
            throw new Exception($this->l('File not found or it is empty.'));
        }

        $local_file = ElegantalEasyImportTools::createPath($this->csv_file);

        // Download server file
        ftp_pasv($ftp_conn, true); // Try with passive mode
        if (!ftp_get($ftp_conn, $local_file, $ftp_file, FTP_BINARY)) {
            ftp_pasv($ftp_conn, false); // Disable passive mode and try again
            if (!ftp_get($ftp_conn, $local_file, $ftp_file, FTP_BINARY)) {
                ftp_close($ftp_conn);
                throw new Exception(sprintf($this->l('Error downloading %s'), $ftp_file));
            }
        }

        ftp_close($ftp_conn);

        // Validate mime type
        $mime = ElegantalEasyImportTools::getMimeType($local_file, $extension);
        if (!in_array($mime, self::$allowed_mime_types)) {
            @unlink($local_file);
            throw new Exception($this->l('This type of file is not allowed.') . ' Mime Type: ' . $mime);
        }

        return $extension;
    }

    protected function downloadFileFromSftp()
    {
        if (!$this->ftp_host) {
            throw new Exception(sprintf($this->l('%s is not valid.'), $this->l('FTP Host')));
        }
        if (!$this->ftp_username) {
            throw new Exception(sprintf($this->l('%s is not valid.'), $this->l('FTP Username')));
        }
        if (!$this->ftp_password) {
            throw new Exception(sprintf($this->l('%s is not valid.'), $this->l('FTP Password')));
        }
        if (!$this->ftp_file) {
            throw new Exception(sprintf($this->l('%s is not valid.'), $this->l('FTP File')));
        }
        if (!function_exists('ssh2_connect')) {
            throw new Exception($this->l('Function ssh2_connect not found. You need to install it on your hosting server.'));
        }

        // Validate file type
        $extension = Tools::strtolower(pathinfo($this->ftp_file, PATHINFO_EXTENSION));
        if (!in_array($extension, self::$allowed_file_types)) {
            throw new Exception(sprintf($this->l('File type %s is not allowed.'), $extension) . ' ' . $this->l('Supported file formats:') . ' ' . implode(', ', self::$allowed_file_types));
        }

        $sftp_port = $this->ftp_port ? $this->ftp_port : 22;
        $connection = call_user_func('ssh2_connect', $this->ftp_host, $sftp_port);
        if (!$connection) {
            throw new Exception($this->l('Unable to connect to SFTP.') . ' ' . $this->ftp_host . ':' . $this->ftp_port);
        }
        if (!call_user_func('ssh2_auth_password', $connection, $this->ftp_username, $this->ftp_password)) {
            throw new Exception($this->l('SFTP authentication failed.') . ' ' . $this->ftp_username . ' : ' . $this->ftp_password);
        }
        $stream = call_user_func('ssh2_sftp', $connection);
        if (!$stream) {
            throw new Exception('Failed to create SFTP stream.');
        }

        $handle = fopen("ssh2.sftp://" . (int) $stream . "/" . $this->ftp_file, 'r');
        if (!$handle) {
            throw new Exception($this->l('Failed to read SFTP file.') . ' ' . $this->ftp_file);
        }
        $contents = stream_get_contents($handle);
        if (empty($contents)) {
            throw new Exception($this->l('File not found or it is empty.') . ' ' . $this->ftp_file);
        }

        $local_file = ElegantalEasyImportTools::createPath($this->csv_file);

        $result = file_put_contents($local_file, $contents);
        @fclose($handle);
        if (!$result) {
            throw new Exception(sprintf($this->l('Error downloading %s'), $this->ftp_file));
        }

        // Validate mime type
        $mime = ElegantalEasyImportTools::getMimeType($local_file, $extension);
        if (!in_array($mime, self::$allowed_mime_types)) {
            @unlink($local_file);
            throw new Exception($this->l('This type of file is not allowed.') . ' Mime Type: ' . $mime);
        }

        return $extension;
    }

    protected function convertFileToCsv($file, $extension)
    {
        if (!is_file($file)) {
            throw new Exception('File does not exist: ' . $file);
        }
        switch ($extension) {
            case 'csv':
            case 'txt':
                ElegantalEasyImportCsv::convertToCsv($file, $this->entity, $this->multiple_value_separator);
                break;
            case 'xml':
            case 'rss':
                ElegantalEasyImportXml::convertToCsv($file, $this->entity, $this->multiple_value_separator);
                break;
            case 'json':
                ElegantalEasyImportJson::convertToCsv($file, $this->entity, $this->multiple_value_separator);
                break;
            case 'xls':
            case 'xlsx':
            case 'ods':
                ElegantalEasyImportExcel::convertToCsv($file, $this->entity, $this->multiple_value_separator);
                break;
            case 'zip':
                ElegantalEasyImportZip::convertToCsv($file, $this->entity, $this->multiple_value_separator);
                break;
            case 'gz':
                ElegantalEasyImportGz::convertToCsv($file, $this->entity, $this->multiple_value_separator);
                break;
            default:
                break;
        }
        return true;
    }
}
