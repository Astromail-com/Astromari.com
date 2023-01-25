<?php
/**
 * 2007-2023 ETS-Soft
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 website only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please, contact us for extra customization service at an affordable price
 *
 * @author ETS-Soft <contact@etssoft.net>
 * @copyright  2007-2023 ETS-Soft
 * @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */
 
class Ets_Reward_Product extends ObjectModel
{
    /**
     * @var int
     */
    public $id_ets_am_reward_product;
    /**
     * @var int
     */
    public $id_product;
    /**
     * @var int
     */
    public $id_ets_am_reward;
    /**
     * @var string
     */
    public $program;
    /**
     * @var float
     */
    public $amount;
    /**
     * @var int
     */
    public $id_order;
    /**
     * @var int
     */
    public $id_seller;
    /**
     * @var int
     */
    public $status;
    /**
     * @var int
     */
    public $quantity;
    /**
     * @var datetime
     */
    public $datetime_added;
    public static $definition = array(
        'table' => 'ets_am_reward_product',
        'primary' => 'id_ets_am_reward_product',
        'multilang_shop' => true,
        'fields' => array(
            'id_ets_am_reward_product' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt'
            ),
            'id_product' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt'
            ),
            'id_ets_am_reward' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt'
            ),
            'program' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isString'
            ),
            'amount' => array(
                'type' => self::TYPE_FLOAT,
                'validate' => 'isFloat'
            ),
            'quantity' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt'
            ),
            'id_order' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt'
            ),
            'id_seller' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt'
            ),
            'status' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt'
            ),
            'datetime_added' => array(
                'type' => self::TYPE_DATE,
                'validate' => 'isDate',
                'allow_null' => true
            )
        )
    );
    /**
     * @param null $context
     * @return array
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public static function getAffiliateProducts($params = array())
    {
        $query = array();
        $orderby = isset($params['orderby']) && ($orderby = Tools::strtolower((string)$params['orderby'])) && in_array($orderby, array('commission_rate', 'name','id_product','price')) ? $orderby : "name";
        $orderway = isset($params['orderway']) && ($orderway = Tools::strtolower((string)$params['orderway'])) && in_array($orderway, array('asc', 'desc')) ? $orderway : "asc";
        $page = isset($params['page']) && ($page = (int)$params['page']) && $page > 0 ? $page : 1;
        $limit = isset($params['limit']) && ($limit = (int)$params['limit']) && $limit > 0 ? $limit : 20;
        $category = isset($params['category']) && ($category = $params['category']) && $category == 'all' ? 'all' : (isset($params['category'])&&($category = (int)$category) && $category > 0 ? $category : false);
        $search = isset($params['search']) && ($search = trim(strip_tags($params['search'])))? $search : '';
        $context = Context::getContext();
        $offset = ($page - 1) * $limit;
        $order_prefix = 'pl';
        $query['page'] = $page;
        $query['orderBy'] = $orderby;
        $query['orderWay'] = $orderway;
        $query['category'] = $category;
        if ($orderby == 'commission_rate') {
            $order_prefix = '';
        }
        elseif ($orderby != 'name') {
            $order_prefix = 'p';
        }
        $c_type = Configuration::get('ETS_AM_AFF_CAT_TYPE');
        if (!$c_type || $c_type == 'ALL') {
            $aff_cats = array();
        } else {
            $aff_cats = explode(',', Configuration::get('ETS_AM_AFF_CATEGORIES'));
        }
        $categories = array();
        if($category!='all' && $category)
            $categories[] = $category;
        else
            $categories = $aff_cats;
        $includes = array_map('intval',explode(',', Configuration::get('ETS_AM_AFF_SPECIFIC_PRODUCTS')));
        $excludes = array_map('intval',explode(',', Configuration::get('ETS_AM_AFF_PRODUCTS_EXCLUDED')));
        if (Configuration::get('ETS_AM_AFF_PRODUCTS_EXCLUDED_DISCOUNT')) {
            $sql = 'SELECT id_product FROM `' . _DB_PREFIX_ . 'specific_price` WHERE (`from` = "0000-00-00 00:00:00" OR `from` <="' . pSQL(date('Y-m-d H:i:s')) . '" ) AND (`to` = "0000-00-00 00:00:00" OR `to` >="' . pSQL(date('Y-m-d H:i:s')) . '" )';
            $products = Db::getInstance()->executeS($sql);
            if ($products) {
                foreach ($products as $product)
                    $excludes[] = $product['id_product'];
            }
        }
        $default_reward_config = self::getAffProductRewardDefaultConfig();
        $select = 'SELECT p.`id_product`, pl.`link_rewrite`, pr.`how_to_calculate`, pr.`use_default`, IF(pa.`id_product_attribute` is NOT NULL, pa.`id_product_attribute`, 0) as id_product_attribute, p.`reference`, pl.`name`, p.price, image_shop.`id_image` id_image, il.`legend`,pr.use_default,pr.how_to_calculate,pr.default_percentage,pr.default_fixed_amount, (IF(pr.use_default IS NOT NULL, IF(pr.how_to_calculate = \'PERCENT\', pr.default_percentage / 100, pr.default_fixed_amount) , ' . (float)$default_reward_config['amount'] . ')) as commission_rate';
        $cat_sql_part = self::buildCategorySqlPart($aff_cats, $excludes, $categories, $search);
        $product_sql_part = self::buildProductSqlPart($excludes, $includes, $categories, $search);
        $s_total = 'SELECT COUNT(*) as total FROM ((SELECT p.id_product ' . (string)$cat_sql_part . ') UNION (SELECT p.id_product ' . (string)$product_sql_part . ')) r';
        $sql_order = '';
        if ($order_prefix != '') {
            $sql_order .=  pSQL($order_prefix.'.'.$orderby);
        } else {
            $sql_order .= pSQL($orderby);
        }
        $cat_sql_part .= 'GROUP BY p.id_product ORDER BY ' . pSQL($sql_order) . ' ' . pSQL($orderway);
        $product_sql_part .= 'GROUP BY p.id_product ORDER BY ' . pSQL($sql_order) . ' ' . pSQL($orderway);
        $sql = '(' . (string)$select . ' ' . (string)$cat_sql_part . ') UNION (' . (string)$select . ' ' . (string)$product_sql_part . ') ORDER BY ' . pSQL($orderby) . ' ' . pSQL($orderway) . ' LIMIT ' . (int)$limit . ' OFFSET ' . (int)$offset;
        $total = Db::getInstance()->getValue($s_total);
        $results = Db::getInstance()->executeS($sql);
        $total_page = (int)ceil($total / $limit);
        $imageType = version_compare(_PS_VERSION_, '1.7.0', '>=') ? ImageType::getFormattedName('small') : ImageType::getFormatedName('small');
        foreach ($results as &$result) {
            $image = ($result['id_product_attribute'] && ($image = self::getCombinationImageById($result['id_product_attribute'], $context->language->id))) ? $image : Product::getCover($result['id_product']);
            $result['image'] = $context->link->getImageLink($result['link_rewrite'], isset($image['id_image']) ? $image['id_image'] : 0, $imageType);
            $product = new Product((int)$result['id_product']);
            $no_tax = Configuration::get('ETS_AM_AFF_TAX_EXCLUDED');
            $productPrice = $product->getPrice(!$no_tax, null, 6);
            $productPriceWithoutReduction = $product->getPriceWithoutReduct($no_tax, null);
            $tax = $product->getTaxesRate();
            $result['reduction'] = $productPriceWithoutReduction - $productPrice;
            $result['price'] = $productPrice;
            if (!$result['use_default'] || $result['use_default'] == 0) {
                if ($default_reward_config['type'] == 'PERCENT') {
                    $result['commission_rate'] = (float)$result['price'] * (float)$result['commission_rate'];
                }
            } else {
                if ($result['how_to_calculate'] == 'PERCENT') {
                    $result['commission_rate'] = (float)$result['price'] * (float)$result['commission_rate'];
                }
            }
            $percentage = $result['price'] && (float)$result['price'] > 0 ? ((float)$result['commission_rate'] / (float)$result['price']) * 100 : 0;
            $result['commission_rate_percentage'] = Tools::ps_round($percentage, 2) . '%';
            $result['display_price'] = Ets_affiliatemarketing::displayPrice($productPrice);
            $result['price_without_reduction'] = $productPriceWithoutReduction;
            $result['price_tax_exc'] = $result['price_without_reduction'] - $tax;
            $result['price_tax_inc'] = $result['price_without_reduction'];
            $result['display_price_without_reduction'] = Ets_affiliatemarketing::displayPrice($productPriceWithoutReduction);
            if ($result['use_default'] || trim($result['use_default']) === '') {
                if ($default_reward_config['type'] == 'PERCENT') {
                    $result['commission_rate'] = $productPrice * $default_reward_config['amount'];
                } else {
                    $result['commission_rate'] = $default_reward_config['amount'];
                }
            } else {
                if ($result['how_to_calculate'] == 'PERCENT')
                    $result['commission_rate'] = $productPrice * $result['default_percentage'] / 100;
                else
                    $result['commission_rate'] = $result['default_fixed_amount'];
            }
            $percentage = $result['price'] && (float)$result['price'] > 0 ? ((float)$result['commission_rate'] / (float)$result['price']) * 100 : 0;
            $result['commission_rate_percentage'] = Tools::ps_round($percentage, 2) . ' %';
            $result['commission_rate'] = Ets_AM::displayPriceOnly($result['commission_rate'], $context);
            $product = new Product($result['id_product']);
            $aff_link = Ets_Affiliate::generateAffiliateLinkForProduct($product, $context);
            $p_link = Ets_Affiliate::generateAffiliateLinkForProduct($product, $context, false);
            $result['link'] = $p_link;
            $result['aff_link'] = $aff_link;
        }
        return array(
            'current_page' => $page,
            'per_page' => $limit,
            'results' => $results,
            'total_page' => $total_page,
            'query' => $query
        );
    }
    public static function getCombinationImageById($id_product_attribute, $id_lang)
    {
        if (version_compare(_PS_VERSION_, '1.6.1.0', '<')) {
            if (!Combination::isFeatureActive() || !$id_product_attribute)
                return false;
            $result = Db::getInstance()->executeS('
				SELECT pai.`id_image`, pai.`id_product_attribute`, il.`legend`
				FROM `' . _DB_PREFIX_ . 'product_attribute_image` pai
				LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il ON (il.`id_image` = pai.`id_image`)
				LEFT JOIN `' . _DB_PREFIX_ . 'image` i ON (i.`id_image` = pai.`id_image`)
				WHERE pai.`id_product_attribute` = ' . (int)$id_product_attribute . ' AND il.`id_lang` = ' . (int)$id_lang . ' ORDER by i.`position` LIMIT 1'
            );
            if (!$result)
                return false;
            return $result[0];
        } else
            return Product::getCombinationImageById($id_product_attribute, $id_lang);
    }
    protected static function getAffProductRewardDefaultConfig()
    {
        $cal_by = Configuration::get('ETS_AM_AFF_HOW_TO_CALCULATE');
        if ($cal_by == 'PERCENT') {
            return array(
                'type' => 'PERCENT',
                'amount' => (float)Configuration::get('ETS_AM_AFF_DEFAULT_PERCENTAGE') / 100
            );
        } elseif ($cal_by == 'FIXED') {
            return array(
                'type' => $cal_by,
                'amount' => (float)Configuration::get('ETS_AM_AFF_DEFAULT_FIXED_AMOUNT')
            );
        } else {
            return array(
                'type' => $cal_by,
                'amount' => 0
            );
        }
    }
    /**
     * @param array $cat
     * @param null $context
     * @return string
     */
    protected static function buildCategorySqlPart($cat = array(), $excludes = array(), $filter_cats = array(),$search = '')
    {
        $context = Context::getContext();
        $search = trim(strip_tags($search));
        $cat = array_map('intval',$cat);
        $excludes = array_map('intval',$excludes);
        $filter_cats = array_map('intval',$filter_cats);
        $sql_part = 'FROM `' . _DB_PREFIX_ . 'product` p ' . Shop::addSqlAssociation('product', 'p') . '
           LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (pl.id_product = p.id_product AND pl.id_lang = ' . (int)$context->language->id . ' AND pl.id_shop = ' . (int)$context->shop->id . ')
           LEFT JOIN `' . _DB_PREFIX_ . 'image_shop` image_shop ON (image_shop.`id_product` = p.`id_product` AND image_shop.id_shop = ' . (int)$context->shop->id . ')
           LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = ' . (int)$context->shop->id . ')
           INNER JOIN `' . _DB_PREFIX_ . 'category_product`  c ON (c.`id_product` = p.`id_product`) 
           LEFT JOIN `' . _DB_PREFIX_ . 'ets_am_aff_reward` pr ON pr.id_product = p.id_product
           LEFT JOIN  `' . _DB_PREFIX_ . 'product_attribute` pa ON pa.id_product = p.id_product
           WHERE product_shop.active = 1 ';
        if (count($filter_cats)) {
            $sql_part .= ' AND c.id_category IN (' . implode(',', $filter_cats) . ') ';
        }
        if (count($cat)) {
            $sql_part .= ' AND c.id_category IN (' . implode(',', $cat) . ') ';
        }
        if (count($excludes)) {
            $sql_part .= ' AND c.id_product NOT IN (' . implode(',', $excludes) . ') ';
        }
        if ($search!='')
            $sql_part .= ' AND pl.name like "%' . pSQL($search) . '%" ';
        return $sql_part;
    }
    /**
     * @param array $excludes
     * @param array $includes
     * @param null $context
     * @return string
     */
    protected static function buildProductSqlPart($excludes = array(), $includes = array(), $cat = array(), $search = '')
    {
        $context = Context::getContext();
        $search = trim(strip_tags($search));
        $cat = array_map('intval',$cat);
        $excludes = array_map('intval',$excludes);
        $includes = array_map('intval',$includes);
        $sql_part = 'FROM `' . _DB_PREFIX_ . 'product` p ' . Shop::addSqlAssociation('product', 'p') . '
           LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (pl.id_product = p.id_product AND pl.id_lang = ' . (int)$context->language->id . ' AND pl.id_shop = ' . (int)$context->shop->id . ')
           LEFT JOIN `' . _DB_PREFIX_ . 'image_shop` image_shop ON (image_shop.`id_product` = p.`id_product` AND image_shop.id_shop = ' . (int)$context->shop->id . ')
           LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = ' . (int)$context->shop->id . ')
           INNER JOIN `' . _DB_PREFIX_ . 'category_product`  c ON (c.`id_product` = p.`id_product`) 
           LEFT JOIN `' . _DB_PREFIX_ . 'ets_am_aff_reward` pr ON pr.id_product = p.id_product
           LEFT JOIN  `' . _DB_PREFIX_ . 'product_attribute` pa ON pa.id_product = p.id_product
           WHERE product_shop.active = 1 ';
        $intersect = array_intersect($includes, $excludes);
        if (count($intersect)) {
            foreach ($intersect as $item) {
                foreach ($excludes as $key => $value) {
                    if ($value === $item) {
                        unset($excludes[$key]);
                    }
                }
            }
        }
        if (count($cat)) {
            $sql_part .= ' AND c.id_category IN (' . implode(',', $cat) . ') ';
        }
        if ($search!='')
            $sql_part .= ' AND pl.name like "%' . pSQL($search) . '%" ';
        if (!Configuration::get('ETS_AM_AFF_CAT_TYPE') || Configuration::get('ETS_AM_AFF_CAT_TYPE') == 'ALL') {
            if (count($excludes)) {
                $sql_part .= ' AND c.id_product NOT IN (' . implode(',', $excludes) . ') ';
            }
            return $sql_part;
        }
        if (count($excludes)) {
            $sql_part .= ' AND c.id_product NOT IN (' . implode(',', $excludes) . ') ';
        }
        if (count($includes)) {
            $sql_part .= ' AND c.id_product IN (' . implode(',', $includes) . ')';
        }
        return $sql_part;
    }
    /**
     * @param array $categories
     * @param null $context
     * @return array|false|mysqli_result|null|PDOStatement|resource
     * @throws PrestaShopDatabaseException
     */
    public static function getAffiliateProductCat($context = null)
    {
        if (!$context) {
            $context = Context::getContext();
        }
        $response = array();
        $type = Configuration::get('ETS_AM_AFF_CAT_TYPE');
        if ($type && $type == 'ALL') {
            $cat = Category::getSimpleCategories($context->language->id);
            if (count($cat)) {
                $response = $cat;
            }
        } else {
            $configCat = Configuration::get('ETS_AM_AFF_CATEGORIES');
            if ($configCat && ($configCat = array_map('intval',explode(',', $configCat)))) {
                foreach ($configCat as $config) {
                    $cat = new Category($config);
                    if ($cat->id) {
                        $response[] = array(
                            'id_category' => $config,
                            'name' => $cat->name[$context->language->id]
                        );
                    }
                }
            }
        }
        return $response;
    }
    public static function updateAmReward($data,$products= array())
    {
        if(isset($data['id_order']) && isset($data['program']) && ( $id_reward = Db::getInstance()->getValue('SELECT id_ets_am_reward FROM `'._DB_PREFIX_.'ets_am_reward` WHERE id_order="'.(int)$data['id_order'].'" AND program="'.pSQL($data['program']).'"')))
        {
            $reward = new Ets_AM($id_reward);
            $reward->amount = $data['amount'];
            if ($reward->update() && $products) {
                Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'ets_am_reward_product` WHERE id_ets_am_reward="'.(int)$reward->id.'"');
                foreach ($products as $product) {
                    $product_reward = new Ets_Reward_Product();
                    $product_reward->id_product = $product['id_product'];
                    $product_reward->quantity = (int)$product['quantity'];
                    $product_reward->id_ets_am_reward = $reward->id;
                    $product_reward->amount = $product['reward_amount'];
                    $product_reward->id_order = $data['id_order'];
                    $product_reward->id_seller = $data['id_customer'];
                    $product_reward->program = $data['program'];
                    $product_reward->datetime_added = date('Y-m-d H:i:s');
                    $product_reward->add();
                }
            }
            return $reward ? $reward : false;
        }
    }
}
