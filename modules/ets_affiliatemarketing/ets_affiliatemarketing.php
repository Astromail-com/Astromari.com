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
 * versions in the future. If you wish to customize PrSearch by name, reference and idestaShop for your
 * needs please contact us for extra customization service at an affordable price
 *
 * @author ETS-Soft <contact@etssoft.net>
 * @copyright  2007-2023 ETS-Soft
 * @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */
 
if (!defined('_PS_VERSION_')) {
    exit;
}
if (!defined('_ETS_AM_MODULE_')) {
    define('_ETS_AM_MODULE_', 'ets_affiliatemarketing');
}
define('EAM_AFF_CUSTOMER_COOKIE', 'eam_aff_customer_cookie');
define('EAM_AFF_PRODUCT_COOKIE', 'eam_aff_product_cookie');
define('EAM_AFF_VISITED_PRODUCTS', 'eam_aff_visited_products');
define('EAM_CUSTOMER_VIEW_PRODUCT', 'eam_customer_view_product');
define('EAM_REFS', 'eam_refs');
define('EAM_AM_LOYALTY_REWARD', 'loy');
define('EAM_AM_AFFILIATE_REWARD', 'aff');
define('EAM_AM_REF_REWARD', 'ref');
define('URL_REGISTER_REWARD_PROGRAM', 'affiliate-marketing/register-programs');
define('URL_REF_PROGRAM', 'affiliate-marketing/referral-program');
define('URL_CUSTOMER_REWARD', 'affiliate-marketing/customer-reward');
define('URL_LOY_PROGRAM', 'affiliate-marketing/loyalty-program');
define('URL_AFF_PROGRAM', 'affiliate-marketing/affiliate');
define('URL_EAM_HISTORY', 'affiliate-marketing/reward-histories');
define('URL_EAM_WITHDRAW', 'affiliate-marketing/withdraw');
define('URL_EAM_VOUCHER', 'affiliate-marketing/voucher');
define('URL_EAM_AFF_PRODUCT', 'affiliate-marketing/affiliate-products');
define('URL_EAM_PRODUCT_VIEW', 'affiliate-marketing/product-view');
define('URL_EAM_MY_SALE', 'affiliate-marketing/my-sales');
define('ETS_AM_PROMO_PREFIX', 'EAM');
if (!defined('EAM_PATH_IMAGE_BANER')) {
    define('EAM_PATH_IMAGE_BANER', _PS_IMG_DIR_ . 'ets_affiliatemarketing/');
}
if (!defined('`_PS_ETS_EAM_IMG_`')) {
    define('_PS_ETS_EAM_IMG_', __PS_BASE_URI__ . 'img/ets_affiliatemarketing/');
}
if (!defined('_PS_ETS_EAM_LOG_DIR_')) {
    if (file_exists(_PS_ROOT_DIR_ . '/var/logs')) {
        define('_PS_ETS_EAM_LOG_DIR_', _PS_ROOT_DIR_ . '/var/logs/');
    } else
        define('_PS_ETS_EAM_LOG_DIR_', _PS_ROOT_DIR_ . '/log/');
}
define('EAM_INVOICE_PATH', 'invoices');
define('LOG_IP_CONFIGURATION_KEY', 'ETS_AM_IP_LOG');
require_once(dirname(__FILE__) . '/classes/EtsAmAdmin.php');
require_once(dirname(__FILE__) . '/classes/Ets_AM.php');
require_once(dirname(__FILE__) . '/classes/Ets_Loyalty.php');
require_once(dirname(__FILE__) . '/classes/Ets_Participation.php');
require_once(dirname(__FILE__) . '/classes/Ets_Affiliate.php');
require_once(dirname(__FILE__) . '/classes/Ets_Sponsor.php');
require_once(dirname(__FILE__) . '/classes/Ets_Reward_Usage.php');
require_once(dirname(__FILE__) . '/classes/Ets_Invitation.php');
require_once(dirname(__FILE__) . '/classes/Ets_Banner.php');
require_once(dirname(__FILE__) . '/classes/Ets_Withdraw.php');
require_once(dirname(__FILE__) . '/classes/Ets_Withdraw_Field.php');
require_once(dirname(__FILE__) . '/classes/Ets_PaymentMethod.php');
require_once(dirname(__FILE__) . '/classes/Ets_Voucher.php');
require_once(dirname(__FILE__) . '/controllers/front/all.php');
require_once(dirname(__FILE__) . '/classes/Ets_User.php');
require_once(dirname(__FILE__) . '/classes/Ets_Reward_Product.php');
require_once(dirname(__FILE__) . '/classes/Ets_Access_Key.php');
require_once(dirname(__FILE__) . '/classes/Ets_Product_View.php');
require_once(dirname(__FILE__) . '/classes/Ets_ImportExport.php');
require_once(dirname(__FILE__) . '/defines.php');
require_once(dirname(__FILE__) . '/classes/Ets_aff_email.php');
require_once(dirname(__FILE__) . '/classes/Ets_aff_qr_code.php');
class Ets_affiliatemarketing extends PaymentModule
{
    const SERVICE_LOCALE_REPOSITORY = 'prestashop.core.localization.locale.repository';
    public $_html;
    public $dashboard = array();
    public $fields_list = array();
    public $applications = array();
    public static $trans = array();
    public $_errors = array();
    public $is17;
    public $currencies = array();
    public $countries = array();
    public $_id_product = null;
    public $list_id = null;
    public $toolbar_btn = array();
    protected $_filterHaving = "";
    protected $_filter = "";
    public function __construct()
    {
        $this->name = 'ets_affiliatemarketing';
        $this->tab = 'front_office_features';
        $this->version = '1.6.4';
        $this->author = 'ETS-Soft';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->module_key = '54356e288958a33ac3a434d4f4d0d1eb';
        $this->bootstrap = true;
        $this->loyalty_groups = array();
        parent::__construct();
        self::$trans = array(
            'point' => $this->l('point'),
            'points' => $this->l('points'),
            'Edit' => $this->l('Edit'),
            'View' => $this->l('View'),
            'Expired' => $this->l('Expired'),
            'Delete' => $this->l('Delete'),
            'Approve' => $this->l('Approve'),
            'Active' => $this->l('Active'),
            'Approved' => $this->l('Approved'),
            'Pending' => $this->l('Pending'),
            'Decline' => $this->l('Decline'),
            'Declined' => $this->l('Declined'),
            'Suspended' => $this->l('Suspended'),
            'Refuse' => $this->l('Refuse'),
            'Cancel' => $this->l('Cancel'),
            'Canceled' => $this->l('Canceled'),
            'Stop' => $this->l('Stop'),
            'Validated' => $this->l('Validated'),
            'Validate' => $this->l('Validate'),
            'join_affiliate_btn' => $this->l('Join Affiliate program'),
            'copy-to-clipboard' => $this->l('Click to copy to clipboard'),
            'copy-to-clipboard-success' => $this->l('Copied to clipboard'),
            'new-reward' => $this->l('New reward was created.'),
            'customer' => $this->l('Customer'),
            'amount' => $this->l('Amount'),
            'type' => $this->l('Type'),
            'expiry' => $this->l('Expired in'),
            'reward_amount' => $this->l('Reward amount'),
            'reward_validated' => $this->l('Your reward was approved'),
            'reward_canceled' => $this->l('Your reward was canceled'),
            'reward_going_to_be_expired' => $this->l('Your reward is going to be expired!'),
            'reward_expired' => $this->l('Reward expired'),
            'turnover' => $this->l('Turnover'),
            'reward' => $this->l('Reward'),
            'net_profit' => $this->l('Net profit'),
            'orders' => $this->l('Orders'),
            'customers' => $this->l('Customers'),
            'conversion_rate' => $this->l('Conversion rate'),
            'error_fee_payment' => $this->l('Fee of payment method must be a decimal.'),
            'error_payment_method_string' => $this->l('Title of payment method must be a string.'),
            'error_payment_field_string' => $this->l('Title of payment field must be a string.'),
            'confirm_msg' => $this->l('Are you sure to do this action?'),
            'times' => $this->l('Time'),
            'dates' => $this->l('Date'),
            'banner_uploaded' => $this->l('Successful update'),
            'level' => $this->l('Level'),
            'referral_program' => $this->l('Referral program'),
            'affiliate_program' => $this->l('Affiliate program'),
            'loyalty_program' => $this->l('Loyalty program'),
            'no_fee' => $this->l('No fee'),
            'yes' => $this->l('Yes'),
            'no' => $this->l('No'),
            'user_deleted' => $this->l('User deleted'),
            'view_details' => $this->l('View details'),
            'views' => $this->l('Views'),
            'Deleted' => $this->l('Deleted'),
            'Decline_return' => $this->l('Decline - Return reward'),
            'Decline_deduct' => $this->l('Decline - Deduct reward'),
            'total_order' => $this->l('Total orders'),
            'total_view' => $this->l('Total views'),
            'earning_reward' => $this->l('Earning rewards'),
            'loyalty' => $this->l('Loyalty'),
            'affiliate' => $this->l('Affiliate'),
            'referral' => $this->l('Referral'),
            'estimated' => $this->l('estimated'),
            'view_user' => $this->l('View user'),
            'reward_unit_label_required' => $this->l('Reward unit label is required'),
            'coversion_rate_required' => $this->l('Conversion rate is required'),
            'email_receive_required' => $this->l('Email to receive is required'),
            'specific_time_required' => $this->l('Specific time is required'),
            'categories_required' => $this->l('Categories are required'),
            'discount_percent_required' => $this->l('Discount percentage is required'),
            'discount_availability_required' => $this->l('Discount availability is required'),
            'amount_required' => $this->l('Amount is required'),
            'percentage_required' => $this->l('Percentage is required'),
            'amount_fixed_required' => $this->l('Fixed amount is required'),
            'second_ago' => $this->l('second(s) ago'),
            'minute_ago' => $this->l('minute(s) ago'),
            'hour_ago' => $this->l('hour(s) ago'),
            'day_ago' => $this->l('day(s) ago'),
            'month_ago' => $this->l('month(s) ago'),
            'year_ago' => $this->l('year(s) ago'),
            'less_than_1s_ago' => $this->l('less than 1 second ago'),
            'reward_usage' => $this->l('Reward usage'),
            'suspend' => $this->l('Suspend'),
            'reward_used_label' => $this->l('Used reward'),
            'reward_earned_label' => $this->l('Earned reward'),
            'reward_created_for_you' => $this->l('A new reward created for you'),
            'a_reward_validated' => $this->l('A reward was approved'),
            'a_reward_canceled' => $this->l('A reward was canceled'),
            'a_reward_created' => $this->l('A new reward was created'),
            'voucher_sell_quantity_require' => $this->l('Quantity is required'),
            'voucher_sell_quantity_vaild' => $this->l('Quantity is not valid'),
            'subject_approve_width' => $this->l('Your withdrawal request was approved!'),
            'subject_admin_approve_width' => $this->l('You have approved a withdrawal request'),
            'subject_decline_width' => $this->l('Your withdrawal request was declined!'),
            'subject_admin_decline_width' => $this->l('You have declined a withdrawal request'),
            'Deduct' => $this->l('Deduct'),
            'Refund' => $this->l('Refund'),
            'deduct_reward' => $this->l('Deducted reward'),
            'return_reward' => $this->l('Returned reward'),
            'referral_and_affiliate_program' => $this->l('Referral and Affiliate program'),
            'your_application_was_declined' => $this->l('Your application was declined'),
            'your_application_was_approved' => $this->l('Your application was approved'),
            'your_reward_is_going_be_expired' => $this->l('Your reward is going to be expired'),
            'a_new_reward_was_created' => $this->l('A new reward was created'),
            'your_reward_was_expired' => $this->l('Your reward was expired'),
            'note_reward_ref_user' => $this->l('Refer new user (#%s)'),
            'note_reward_ref_order' => $this->l('Referral commission (Order: #%s, Level: %s)'),
            'categories_valid' => $this->l('Categories are not valid'),
        );
        $this->displayName = $this->l('Loyalty, referral and affiliate program (reward points)');
        $this->description = $this->l('Allows customers to earn rewards (points or cash) when they buy, sell or refer new customers to your website. Includes 3 marketing programs: Loyalty, Referral and Affiliate programs to boost your sales and customers.');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
        if (version_compare(_PS_VERSION_, '1.7', '>=')) {
            $this->is17 = true;
        }
    }
    /**
     * @param $params
     * @return string
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function hookDisplaySnwProductList($params)
    {
        if (isset($params['ids']) && ($productIds = $params['ids'])) {
            $IDs = explode(',', $productIds);
            $products = array();
            foreach ($IDs as $id) {
                $product = new Product($id, false, (int)Configuration::get('PS_LANG_DEFAULT'));
                if ($product && Validate::isLoadedObject($product) && ($image = Product::getCover($id))) {
                    $imagePath = $this->context->link->getImageLink($product->link_rewrite, $image['id_image']);
                    $product_url = $this->context->link->getProductLink((int)$id);
                    $product->image = $imagePath;
                    $product->product_url = $product_url;
                    $product->id_product = (int)$id;
                    $products[] = $product;
                }
            }
            $this->smarty->assign(array(
                'products' => $products,
                'default_lang' => (int)Configuration::get('PS_LANG_DEFAULT')
            ));
            return $this->display(__FILE__, 'block_prd_items.tpl');
        }
    }
    public function actionAjax()
    {
        if (($query = Tools::getValue('q', false)) && $query != '' && Validate::isCleanHtml($query)) {
            EtsAmAdmin::searchProducts($query);
        }
        if (($productType = Tools::getValue('product_type', false)) && Validate::isCleanHtml($productType) && ($IDs = Tools::getValue('ids', false)) && Validate::isCleanHtml($IDs)) {
            die(json_encode(array(
                'html' => $this->hookDisplaySnwProductList(array('ids' => $IDs)),
            )));
        }
        if (Tools::isSubmit('clear_log')) {
            $cleared = false;
            if (file_exists(_PS_ETS_EAM_LOG_DIR_ . '/aff_cronjob.log')) {
                @unlink(_PS_ETS_EAM_LOG_DIR_ . '/aff_cronjob.log');
                $cleared = true;
            }
            die(json_encode(array(
                'success' => $cleared ? $this->l('Log cleared') : false,
                'error' => !$cleared ? $this->l('Log is empty. Nothing to do!') : false,
            )));
        }
        if (($initSearch = Tools::getValue('initSearchProduct', false)) && Validate::isCleanHtml($initSearch) && ($ids = Tools::getValue('ids', false)) && Ets_affiliatemarketing::validateArray($ids)) {
            $this->getProductsAdded($ids);
        }
        if (($action = Tools::getValue('table_action')) && Validate::isCleanHtml($action) && ($id = Tools::getValue('id'))) {
            if (Validate::isInt($id)) {
                $id = (int)$id;
                if (in_array($action, array('APPROVE', 'DECLINE_RETURN', 'DECLINE_DEDUCT', 'DELETE'))) {
                    $response = Ets_Withdraw::updateWithdrawAndReward($id, $action);
                    $wStatus = $this->l('Approved');
                    if ($action == 'DECLINE_RETURN' || $action == 'DECLINE_DEDUCT') {
                        $wStatus = $this->l('Declined');
                    }
                    if ($response['success']) {
                        die(json_encode(array(
                            'success' => true,
                            'message' => $action == 'DELETE' ? $this->l('Successful deleted') : $this->l('Updated successfully'),
                            'actions' => $response['actions'],
                            'status' => $wStatus
                        )));
                    }
                }
            }
            die(json_encode(array(
                'success' => false,
                'message' => $this->l('Error')
            )));
        }
        if (($updateProduct = Tools::getValue('updateProductSetting', false)) && Validate::isCleanHtml($updateProduct) && ($data_settings = Tools::getValue('data', false))) {
            $setting_error = false;
            $aff_fields = array('use_default', 'id_product', 'how_to_calculate', 'default_fixed_amount', 'default_percentage', 'single_min_product');
            $loy_fields = array('use_default', 'id_product', 'base_on', 'amount', 'qty_min', 'gen_percent');
            if (isset($data_settings['loy_settings']) && $data_settings['loy_settings']) {
                foreach ($data_settings['loy_settings'] as $key => $data) {
                    if (in_array($key, $loy_fields)) {
                        if ($data && ((($key == 'amount' || $key == 'gen_percent') && !Validate::isUnsignedFloat($data)) || ($key == 'qty_min' && !Validate::isUnsignedInt($data)))) {
                            $setting_error = true;
                            break;
                        }
                    } else
                        unset($data_settings['loy_settings'][$key]);
                }
            }
            if (isset($data_settings['aff_settings']) && $data_settings['aff_settings'] && !$setting_error) {
                foreach ($data_settings['aff_settings'] as $key => $data) {
                    if (in_array($key, $aff_fields)) {
                        if ($key !== 'how_to_calculate') {
                            if ($key == 'single_min_product') {
                                if ($data && !Validate::isUnsignedInt($data)) {
                                    $setting_error = true;
                                    break;
                                }
                            } else {
                                if ($data && !Validate::isUnsignedFloat($data)) {
                                    $setting_error = true;
                                    break;
                                }
                            }
                        }
                    } else
                        unset($data_settings['aff_settings'][$key]);
                }
            }
            if ($setting_error) {
                die(json_encode(
                    array(
                        'success' => false,
                        'message' => $this->l('Update failed, data is invalid.')
                    )
                ));
            } else {
                //Create or update setting
                if ((isset($data_settings['loy_settings']) && $data_settings['loy_settings']) || (isset($data_settings['aff_settings']) && $data_settings['aff_settings'])) {
                    if ((isset($data_settings['loy_settings']) && $data_settings['loy_settings'])) {
                        $data_loy_setting = $data_settings['loy_settings'];
                        $data_loy_setting['id_shop'] = $this->context->shop->id;
                        EtsAmAdmin::createOrUpdateSetting('loyalty', $data_loy_setting);
                    }
                    if (isset($data_settings['aff_settings']) && $data_settings['aff_settings']) {
                        $data_aff_setting = $data_settings['aff_settings'];
                        $data_aff_setting['id_shop'] = $this->context->shop->id;
                        EtsAmAdmin::createOrUpdateSetting('affiliate', $data_aff_setting);
                    }
                    die(json_encode(
                        array(
                            'success' => true,
                            'message' => $this->l('Settings updated.')
                        )
                    ));
                }
                //Update fail
                die(json_encode(
                    array(
                        'success' => false,
                        'message' => $this->l('Update failed')
                    )
                ));
            }
        }
        if (($getLevel = Tools::getValue('getLevelInput')) && Validate::isCleanHtml($getLevel)) {
            $count = 2;
            $quit = false;
            $level_fields = array();
            while ($quit == false) {
                $level_data = Configuration::get('ETS_AM_REF_SPONSOR_COST_LEVEL_' . $count, false);
                if ($level_data !== false) {
                    array_push($level_fields, array(
                        'level' => $count,
                        'value' => $level_data
                    ));
                    $count++;
                } else {
                    $quit = true;
                }
            }
            if (!empty($level_fields)) {
                die(json_encode(
                    array(
                        'success' => true,
                        'data' => $level_fields
                    )
                ));
            }
            die(json_encode(
                array(
                    'success' => false,
                    'data' => $level_fields
                )
            ));
        }
        if ((int)Tools::isSubmit('actionApplication', false)) {
            $id_approve = (int)Tools::getValue('id_approve', 0);
            $action_user = ($action_user = Tools::getValue('action_user', 0)) && Validate::isCleanHtml($action_user) ? $action_user : '';
            $reason = null;
            if ($action_user == 'decline' || $action_user == 'approve') {
                $reason = ($reason = Tools::getValue('reason', null)) && Validate::isCleanHtml($reason) ? $reason : '';
            }
            $response = EtsAmAdmin::actionCustomer($id_approve, $action_user, $reason);
            $app_status = $this->l('Approved');
            if ($action_user == 'decline') {
                $app_status = $this->l('Declined');
            }
            if ($response['success']) {
                die(json_encode(array(
                    'success' => true,
                    'message' => $action_user == 'delete' ? $this->l('Deleted successfully.') : $this->l('Updated successfully.'),
                    'redirect' => $action_user == 'delete' ? $this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name . '&tabActive=applications' : '',
                    'actions' => $response['actions'],
                    'status' => $app_status
                )));
            }
            die(json_encode(array(
                'success' => false,
                'message' => $this->l('Failed')
            )));
        }
        if ((bool)Tools::isSubmit('getLanguage')) {
            $langs = Language::getLanguages(false);
            $currency = Currency::getDefaultCurrency();
            die(json_encode(array(
                'success' => true,
                'languages' => $langs,
                'currency' => $currency
            )));
        }
        if ((bool)Tools::isSubmit('get_stat_reward')) {
            $this->statsReward();
        }
        if ((bool)Tools::isSubmit('get_pie_chart_reward')) {
            $this->getPercentReward(array('status' => 1));
        }
        if ((bool)Tools::isSubmit('getTotalUserAppPending', false)) {
            $total_pedning_app = EtsAmAdmin::getTotalPendingApplications();
            if ($total_pedning_app) {
                die(json_encode(array(
                    'success' => true,
                    'message' => $this->l('Successful'),
                    'total' => $total_pedning_app
                )));
            } else {
                die(json_encode(array(
                    'success' => false,
                    'message' => $this->l('Failed'),
                    'total' => 0
                )));
            }
        }
        if ((bool)Tools::isSubmit('sortPaymentMethodField', false)) {
            if (($sort_data = Tools::getValue('sort_data')) && Ets_affiliatemarketing::validateArray($sort_data)) {
                if (EtsAmAdmin::updateSortPaymentMethodfield($sort_data)) {
                    die(json_encode(array(
                        'success' => true,
                        'message' => $this->l('Sorted successfully'),
                    )));
                }
            }
            die(json_encode(array(
                'success' => false,
                'message' => $this->l('Sort failed.'),
            )));
        }
        if ((bool)Tools::isSubmit('sortPaymentMethod', false)) {
            if (($sort_data = Tools::getValue('sort_data')) && Ets_affiliatemarketing::validateArray($sort_data)) {
                if (EtsAmAdmin::updateSortPaymentMethod($sort_data)) {
                    die(json_encode(array(
                        'success' => true,
                        'message' => $this->l('Sorted successfully'),
                    )));
                }
            }
            die(json_encode(array(
                'success' => false,
                'message' => $this->l('Sort failed.'),
            )));
        }
        if ((bool)Tools::isSubmit('getTabDataDasboard', false)) {
            $page = ($page = (int)Tools::getValue('page', 1)) ? $page : 1;
            $type = ($type = Tools::getValue('type', false)) && in_array($type, array('recent_orders', 'best_seller', 'top_reward_accounts', 'top_customer', 'top_sponsor')) ? $type : 'recent_orders';
            $data_filter = ($data_filter = Tools::getValue('data_filter', array())) && is_array($data_filter) && Ets_affiliatemarketing::validateArray($data_filter) ? $data_filter : array();
            $params = array(
                'page' => $page,
                'type' => $type,
                'data_filter' => $data_filter
            );
            $results = Ets_Am::getStatsTopTrending($params);
            die(json_encode(array(
                'success' => true,
                'html' => $this->renderTableDashboard($results, $type)
            )));
        }
        if (($action_reward = Tools::getValue('doActionRewardItem', false)) && Validate::isCleanHtml($action_reward)) {
            $id_reward = (int)Tools::getValue('id_reward', false);
            $response = EtsAmAdmin::actionReward($id_reward, $action_reward);
            $reward_status = $this->l('Approved');
            if ($action_reward == 'cancel') {
                $reward_status = $this->l('Canceled');
            }
            if ($response['success']) {
                die(json_encode(array(
                    'success' => true,
                    'message' => $this->l('The status has been successfully updated'),
                    'actions' => $response['actions'],
                    'status' => $reward_status,
                    'user' => $response['user'],
                )));
            } else {
                die(json_encode(array(
                    'success' => false,
                    'message' => $this->l('Reward update failed'),
                )));
            }
        }
        if (($action_reward = Tools::getValue('doActionRewardUsageItem', false)) && Validate::isCleanHtml($action_reward)) {
            $id_reward = (int)Tools::getValue('id_reward', false);
            $response = EtsAmAdmin::actionRewardUsage($id_reward, $action_reward);
            if ($response['success']) {
                $status = $this->l('Deducted');
                if ($action_reward == 'cancel') {
                    $status = $this->l('Refunded');
                }
                die(json_encode(array(
                    'success' => true,
                    'message' => $this->l('The status has been successfully updated'),
                    'actions' => $response['actions'],
                    'status' => $status,
                    'user' => $response['user'],
                )));
            } else {
                die(json_encode(array(
                    'success' => false,
                    'message' => $this->l('Reward update failed'),
                )));
            }
        }
        if ((bool)Tools::isSubmit('loadMoreSponsorFriend', false)) {
            $id_customer = (int)Tools::getValue('id_customer', false);
            $page = (int)Tools::getValue('page', false);
            if ($id_customer && $page) {
                $sponsors = Ets_Sponsor::getDetailSponsors($id_customer, array(
                    'page' => $page
                ));
                die(json_encode(array(
                    'success' => true,
                    'html' => $this->loadmoreSponsors($sponsors)
                )));
            }
        }
        if ((bool)Tools::isSubmit('loadMoreHistoryReward', false)) {
            $id_customer = (int)Tools::getValue('id_customer', false);
            $page = (int)Tools::getValue('page', false);
            $filter = array(
                'type_date_filter' => Tools::getValue('type_date_filter'),
                'date_from_reward' => Tools::getValue('date_from_reward'),
                'date_to_reward' => Tools::getValue('date_to_reward'),
                'program' => Tools::getValue('program'),
                'status' => Tools::getValue('status'),
                'limit' => (int)Tools::getValue('limit'),
                'page' => (int)$page,
            );
            if ($id_customer && $page) {
                $histories = EtsAmAdmin::getRewardHistory($id_customer, null, false, false, $filter);
                die(json_encode(array(
                    'success' => true,
                    'html' => $this->loadmoreRewardHistory($histories)
                )));
            }
        }
        if (($actionUser = Tools::isSubmit('actionUserReward', false)) && Validate::isCleanHtml($actionUser)) {
            if (($id_customer = (int)Tools::getValue('id_user_reward', false)) && ($action = Tools::getValue('action_user_reward', false)) && Validate::isCleanHtml($action)) {
                $response = Ets_User::processActionStatus($id_customer, $action);
                $uStatus = $this->l('Active');
                if ($action == 'decline') {
                    $uStatus = $this->l('Suspended');
                }
                if ($response) {
                    die(json_encode(array(
                        'success' => true,
                        'message' => $this->l('Saved successfully'),
                        'actions' => $response['actions'],
                        'status' => $uStatus
                    )));
                }
            }
            die(json_encode(array(
                'success' => false,
                'message' => $this->l('Error')
            )));
        }
        if ((bool)Tools::isSubmit('searchSuggestion', false)) {
            $query = ($query = Tools::getValue('query', '')) && Validate::isCleanHtml($query) ? $query : '';
            $query_type = ($query_type = Tools::getValue('query_type', '')) && Validate::isCleanHtml($query_type) ? $query_type : '';
            if ($query) {
                die(json_encode(array(
                    'success' => true,
                    'html' => $this->getSearchSuggestions($query, $query_type)
                )));
            }
        }
        if ((bool)Tools::isSubmit('deletefileBackend', false)) {
            $name_config = Tools::getValue('name_config', false);
            if ($name_config && in_array($name_config, array('ETS_AM_REF_DEFAULT_BANNER', 'ETS_AM_REF_SOCIAL_IMG', 'ETS_AM_REF_INTRO_BANNER')) && Validate::isCleanHtml($name_config)) {
                $file = Configuration::get($name_config);
                if ($file) {
                    $path = EAM_PATH_IMAGE_BANER . $file;
                    if (file_exists($path) && @unlink($path)) {
                        Configuration::updateValue($name_config, false);
                        die(json_encode(array(
                            'success' => true,
                            'message' => 'Deleted successfully'
                        )));
                    }
                }
            }
            die(json_encode(array(
                'success' => false,
                'message' => 'Can not delete this file'
            )));
        }
        if ((bool)Tools::isSubmit('actionProgramUser', false)) {
            $id_user = (int)Tools::getValue('id_user', false);
            $program = Tools::getValue('program', false);
            $action = ($action = Tools::getValue('action_user', false)) && Validate::isCleanHtml($action) ? $action : '';
            $reason = ($reason = Tools::getValue('reason', false)) && Validate::isCleanHtml($reason) ? $reason : '';
            if ($id_user && $program && Validate::isCleanHtml($program) && $action) {
                if (Ets_Participation::actionProgramUser($id_user, $program, $action, $reason)) {
                    die(json_encode(array(
                        'success' => true,
                        'message' => $this->l('Updated successfully')
                    )));
                }
            }
            die(json_encode(array(
                'success' => false,
                'message' => $this->l('Failed.')
            )));
        }
        if ((bool)Tools::isSubmit('updateCronjobSecureCode', false)) {
            if (($secure_code = Tools::getValue('secure_code')) && Validate::isCleanHtml($secure_code)) {
                Configuration::updateGlobalValue('ETS_AM_CRONJOB_TOKEN', $secure_code);
                die(json_encode(array(
                    'success' => true,
                    'message' => $this->l('Cronjob token updated successfully'),
                    'secure' => $secure_code,
                )));
            }
            die(json_encode(array(
                'success' => false,
                'message' => !$secure_code ? $this->l('Cronjob secure token is required') : $this->l('Cronjob secure token is not valid'),
            )));
        }
        if ((bool)Tools::isSubmit('close_cronjob_alert', false)) {
            $this->context->cookie->closed_alert_cronjob = 1;
            $this->cotnext->cookie->write();
            die(json_encode(array(
                'success' => true,
                'message' => ''
            )));
        }
    }
    /**
     * @param $ids
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function getProductsAdded($ids)
    {
        if ($ids && is_array($ids)) {
            $ids_str = implode(',', array_map('intval', $ids));
            die(json_encode(array(
                'html' => $this->hookDisplaySnwProductList(array('ids' => $ids_str)),
            )));
        }
    }
    public function install()
    {
        EtsAmAdmin::createRequiresTable();
        EtsAmAdmin::addIndexTable();
        return parent::install()
            && $this->registerHook('displayShoppingCartFooter')
            && $this->registerHook('displayCustomerAccount')
            && $this->registerHook('displayProductAdditionalInfo')
            && $this->registerHook('actionValidateOrder')
            && $this->registerHook('actionCustomerAccountAdd')
            && $this->registerHook('displayHeader')
            && $this->registerHook('displayBackOfficeHeader')
            && $this->registerHook('displaySnwProductList')
            && $this->registerHook('displayAdminProductsExtra')
            && $this->registerHook('payment')
            && $this->registerHook('paymentOptions')
            && $this->registerHook('actionOrderStatusPostUpdate')
            && $this->registerHook('displayFooter')
            && $this->registerHook('displayCustomerAccountForm')
            && $this->registerHook('displayRightColumnProduct')
            && $this->registerHook('actionAuthentication')
            && $this->registerHook('actionCartSave')
            && $this->registerHook('actionCustomerLogoutAfter')
            && $this->registerHook('displayOrderConfirmation')
            && $this->registerHook('actionObjectOrderDetailDeleteAfter')
            && $this->registerHook('actionObjectOrderDetailAddAfter')
            && $this->registerHook('actionObjectOrderDetailUpdateAfter')
            && $this->registerHook('actionObjectOrderUpdateAfter')
            && $this->registerHook('actionFrontControllerAfterInit')
            && $this->setDefaultValues()
            && $this->__installTabs()
            && $this->setDefaultImage() && $this->installLinkDefault();
    }
    public function installLinkDefault()
    {
        $metas = array(
            array(
                'controller' => 'my_sale',
                'title' => $this->l('My sales'),
                'url_rewrite' => 'my-sales'
            ),
            array(
                'controller' => 'aff_products',
                'title' => $this->l('Affiliate Products'),
                'url_rewrite' => 'affiliate-products'
            ),
            array(
                'controller' => 'myfriend',
                'title' => $this->l('My friends'),
                'url_rewrite' => 'my-friends'
            ),
            array(
                'controller' => 'refer_friends',
                'title' => $this->l('How to refer friends'),
                'url_rewrite' => 'how-to-refer-friends'
            ),
            array(
                'controller' => 'loyalty',
                'title' => $this->l('Loyalty program'),
                'url_rewrite' => 'loyalty-program'
            ),
            array(
                'controller' => 'dashboard',
                'title' => $this->l('Dashboard'),
                'url_rewrite' => 'affiliate-dashboard'
            ),
            array(
                'controller' => 'history',
                'title' => $this->l('Reward history'),
                'url_rewrite' => 'reward-history'
            ),
            array(
                'controller' => 'withdraw',
                'title' => $this->l('Withdraw'),
                'url_rewrite' => 'affiliate-withdraw'
            ),
            array(
                'controller' => 'voucher',
                'title' => $this->l('Convert into vouchers'),
                'url_rewrite' => 'convert-into-vouchers'
            ),
            array(
                'controller' => 'register',
                'title' => $this->l('Register program'),
                'url_rewrite' => 'register-program'
            ),
        );
        $languages = Language::getLanguages(false);
        foreach ($metas as $meta) {
            if (!Db::getInstance()->getRow('SELECT * FROM `' . _DB_PREFIX_ . 'meta_lang` WHERE url_rewrite ="' . pSQL($meta['url_rewrite']) . '"') && !Db::getInstance()->getRow('SELECT * FROM `' . _DB_PREFIX_ . 'meta` WHERE page ="module-' . pSQL($this->name) . '-' . pSQL($meta['controller']) . '"')) {
                $meta_class = new Meta();
                $meta_class->page = 'module-' . $this->name . '-' . $meta['controller'];
                $meta_class->configurable = 1;
                foreach ($languages as $language) {
                    $meta_class->title[$language['id_lang']] = $meta['title'];
                    $meta_class->url_rewrite[$language['id_lang']] = $meta['url_rewrite'];
                }
                $meta_class->add();
            }
        }
        return true;
    }
    /**
     * @return bool
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function uninstall()
    {
        return parent::uninstall()
            && EtsAmAdmin::removeModuleTable()
            && $this->__uninstallTabs()
            && $this->removeImages()
            && $this->clearLog();
    }
    /**
     * @return string
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function getContent()
    {
        if (Tools::isSubmit('submitClearQRCodeCache')) {
            Ets_affiliatemarketing::removeDir(EAM_PATH_IMAGE_BANER . 'qrcode');
            die(
            json_encode(
                array(
                    'success' => $this->l('Cleared QR code cache successfully'),
                )
            )
            );
        }
        if (!Configuration::get('ETS_AM_CRONJOB_TOKEN')) {
            $this->generateTokenCronjob();
        }
        $this->actionAjax();
        $submit_success = '';
        $caption = array(
            'title' => '',
            'icon' => ''
        );
        if (Tools::isSubmit('save' . $this->name)) {
            $this->postProcess();
            $submit_success = $this->displayConfirmation($this->l('Configuration saved'));
        }
        $activetab = Tools::getValue('tabActive');
        if (!$activetab || !Validate::isCleanHtml($activetab))
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules') . '&configure=ets_affiliatemarketing&tabActive=dashboard');
        $defined = new EtsAffDefine();
        $def_config_tabs = $defined->def_config_tabs();
        foreach ($def_config_tabs as $key => $tab) {
            if ($key == $activetab) {
                $caption['title'] = $tab['title'];
                $caption['icon'] = $tab['icon'];
            } else {
                if (isset($tab['subtabs']) && $tab['subtabs']) {
                    foreach ($tab['subtabs'] as $subkey => $subtab) {
                        if ($subtab) {
                            //
                        }
                        if ($subkey == $activetab) {
                            $caption['title'] = $tab['title'];
                            $caption['icon'] = $tab['icon'];
                            break;
                        }
                    }
                }
            }
            if ($caption['title']) {
                break;
            }
        }
        if (true) {
            $func = 'def_' . $activetab;
            $config_data = $defined->{$func}();
            if (isset($config_data['form'])) {
                $params = array(
                    'config' => $activetab,
                );
                $this->renderForm($params);
            } elseif ($activetab == 'applications') {
                $this->getApplications();
            } elseif ($activetab == 'reward_users') {
                if (($id_user = (int)Tools::getValue('id_reward_users', false)) && Tools::isSubmit('viewreward_users')) {
                    if (Tools::isSubmit('aff_search_customer'))
                        $this->ajaxSearchFriends();
                    if (Tools::isSubmit('aff_add_search_customer'))
                        $this->ajaxAddFriend();
                    $this->getDetailUser($id_user);
                } else {
                    if (Tools::isSubmit('submitAddUserReward')) {
                        $id_customer = (int)Tools::getValue('id_customer');
                        $errors = array();
                        if (!$id_customer) {
                            $errors[] = $this->l('Customer is required');
                        }
                        $customer_loyalty = (int)Tools::getValue('aff_customer_loyalty');
                        $customer_referral = (int)Tools::getValue('aff_customer_referral');
                        $customer_affiliate = (int)Tools::getValue('aff_customer_affiliate');
                        $aff_customer_loyalty = !Configuration::get('ETS_AM_LOYALTY_REGISTER') ? 0 : $customer_loyalty;
                        $aff_customer_referral = !Configuration::get('ETS_AM_REF_REGISTER_REQUIRED') ? 0 : $customer_referral;
                        $aff_customer_affiliate = !Configuration::get('ETS_AM_AFF_REGISTER_REQUIRED') ? 0 : $customer_affiliate;
                        if (!$customer_loyalty && !$customer_referral && !$customer_affiliate)
                            $errors[] = $this->l('Join program is required');
                        else {
                            $sql = 'SELECT * FROM (
                                SELECT id_customer FROM `' . _DB_PREFIX_ . 'ets_am_participation` WHERE id_shop = ' . (int)$this->context->shop->id . '  AND (0 ' . ($aff_customer_affiliate ? ' OR program="aff"' : '') . ($aff_customer_loyalty ? ' OR program="loy"' : '') . ($aff_customer_referral ? ' OR program="ref"' : '') . ')
                            UNION
                                SELECT id_customer FROM `' . _DB_PREFIX_ . 'ets_am_reward` r WHERE id_shop = ' . (int)$this->context->shop->id . '  AND (0 ' . ($aff_customer_affiliate ? ' OR program="aff"' : '') . ($aff_customer_loyalty ? ' OR program="loy"' : '') . ($aff_customer_referral ? ' OR program="ref"' : '') . ')
                            ' . ($aff_customer_referral ? '
                                UNION
                                SELECT id_parent as id_customer FROM `' . _DB_PREFIX_ . 'ets_am_sponsor` s WHERE s.`level` = 1 AND id_shop = ' . (int)$this->context->shop->id : '') . '
                            UNION
                                SELECT id_customer FROM `' . _DB_PREFIX_ . 'ets_am_user` WHERE id_shop = ' . (int)$this->context->shop->id . ' AND ( 0 ' . ($aff_customer_affiliate ? ' OR aff=1' : '') . ($aff_customer_loyalty ? ' OR loy=1' : '') . ($aff_customer_referral ? ' OR ref=1' : '') . ')
                            )  app WHERE app.id_customer=' . (int)$id_customer;
                            if (Db::getInstance()->getRow($sql)) {
                                $errors[] = $this->l('This user is already joined marketing program');
                            }
                        }
                        if (!$errors) {
                            if (!Db::getInstance()->getValue('SELECT id_customer FROM `' . _DB_PREFIX_ . 'ets_am_user` WHERE id_customer="' . (int)$id_customer . '" AND id_shop = ' . (int)$this->context->shop->id)) {
                                Db::getInstance()->execute('INSERT INTO `' . _DB_PREFIX_ . 'ets_am_user` (id_customer,loy,ref,aff,status,id_shop) VALUES("' . (int)$id_customer . '","' . (int)$customer_loyalty . '","' . (int)$customer_referral . '","' . (int)$customer_affiliate . '","1","' . (int)$this->context->shop->id . '")');
                                $data = array(
                                    'id_customer' => $id_customer,
                                    'datetime_added' => date('Y-m-d H:i:s'),
                                    'status' => 1,
                                    'program' => 'aff',
                                    'id_shop' => $this->context->shop->id,
                                    'intro' => '',
                                );
                                if ($aff_customer_loyalty) {
                                    $data['program'] = 'loy';
                                    Db::getInstance()->insert('ets_am_participation', $data, true);
                                }
                                if ($aff_customer_affiliate) {
                                    $data['program'] = 'aff';
                                    Db::getInstance()->insert('ets_am_participation', $data, true);
                                }
                                if ($aff_customer_referral) {
                                    $data['program'] = 'ref';
                                    Db::getInstance()->insert('ets_am_participation', $data, true);
                                }
                            } else {
                                $set_value = '';
                                if ($aff_customer_loyalty || !Configuration::get('ETS_AM_LOYALTY_REGISTER'))
                                    $set_value .= ' loy = 1,';
                                if ($aff_customer_affiliate || !Configuration::get('ETS_AM_AFF_REGISTER_REQUIRED'))
                                    $set_value .= ' aff = 1,';
                                if ($aff_customer_referral || !Configuration::get('ETS_AM_REF_REGISTER_REQUIRED'))
                                    $set_value .= ' ref = 1,';
                                Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'ets_am_user` SET ' . trim($set_value, ',') . ' WHERE  id_customer="' . (int)$id_customer . '" AND id_shop="' . (int)$this->context->shop->id . '"');
                            }
                            $this->context->smarty->assign(
                                array(
                                    'id_customer' => $id_customer,
                                    'link' => $this->context->link,
                                    'aff_customer' => new Customer($id_customer),
                                    'price_program' => Ets_AM::displayRewardAdmin(0),
                                    'price_widthraw' => Ets_affiliatemarketing::displayPrice(0, (int)Configuration::get('PS_CURRENCY_DEFAULT')),
                                )
                            );
                            die(
                            json_encode(
                                array(
                                    'tr_html' => $this->display(__FILE__, 'row_user.tpl'),
                                    'success' => $this->displaySuccessMessage($this->l('Added successfully'))
                                )
                            )
                            );
                        } else {
                            die(
                            json_encode(
                                array(
                                    'errors' => $this->displayError($errors)
                                )
                            )
                            );
                        }
                    }
                    $this->renderList($defined->def_reward_users());
                }
            } elseif ($activetab == 'import_export') {
                $this->renderImportExportForm();
            } elseif (isset($config_data['list'])) {
                $func = 'def_' . $activetab;
                $list_data = $defined->{$func}();
                $params = $list_data['list'] + array(
                        'fields_list' => $list_data['fields'],
                    );
                $this->renderDatatable($params);
            } elseif ($activetab == 'dashboard') {
                $this->renderStatisticReward();
            } elseif ($activetab == 'payment_settings') {
                $this->getPaymentMethods();
            } elseif ($activetab == 'cronjob_config') {
                $this->cronjobSettings();
            } elseif ($activetab == 'cronjob_history') {
                $this->cronjobHistory();
            }
        }

        $cookie_filter = $this->context->cookie->getFamily('reward_usersFilter_');
        $setting_tabs = array();
        $breadcrumb_admin = array();
        $def_config_tabs = $defined->def_config_tabs();
        $menuActive = $activetab;
        foreach ($def_config_tabs as $key => $tab) {
            if ($key == 'loyalty_program' || $key == 'affiliate_program' || $key == 'rs_program') {
                if ($menuActive == $key) {
                    $menuActive = 'marketing_program';
                }
                $setting_tabs['marketing_program']['sub'][$key] = $tab;
                $setting_tabs['marketing_program']['img'] = 'marketing_program.png';
                $setting_tabs['marketing_program']['title'] = $this->l('Marketing programs');
                $breadcrumb_admin['marketing_program']['title'] = $this->l('Marketing programs');
                $breadcrumb_admin['marketing_program']['subtabs'][$key] = $tab;
                if (isset($tab['subtabs']) && is_array($tab['subtabs'])) {
                    foreach ($tab['subtabs'] as $ks => $isub) {
                        if ($menuActive == $ks && $isub) {
                            $menuActive = 'marketing_program';
                            break;
                        }
                    }
                }
            } else if ($key == 'usage_settings' || $key == 'reward_history' || $key == 'withdraw_list') {
                if ($menuActive == $key) {
                    $menuActive = 'rewards';
                }
                $setting_tabs['rewards']['sub'][$key] = $tab;
                $setting_tabs['rewards']['img'] = 'rewards.png';
                $setting_tabs['rewards']['title'] = $this->l('Rewards');
                $breadcrumb_admin['rewards']['title'] = $this->l('Rewards');
                $breadcrumb_admin['rewards']['subtabs'][$key] = $tab;
                if (isset($tab['subtabs']) && is_array($tab['subtabs'])) {
                    foreach ($tab['subtabs'] as $ks => $isub) {
                        if ($menuActive == $ks && $isub) {
                            $menuActive = 'rewards';
                            break;
                        }
                    }
                }
            } else if ($key == 'applications' || $key == 'reward_users') {
                if ($menuActive == $key) {
                    $menuActive = 'customers';
                }
                $setting_tabs['customers']['sub'][$key] = $tab;
                $setting_tabs['customers']['img'] = 'customers.png';
                $setting_tabs['customers']['title'] = $this->l('Customers');
                $breadcrumb_admin['customers']['title'] = $this->l('Customers');
                $breadcrumb_admin['customers']['subtabs'][$key] = $tab;
                if (isset($tab['subtabs']) && is_array($tab['subtabs'])) {
                    foreach ($tab['subtabs'] as $ks => $isub) {
                        if ($menuActive == $ks && $isub) {
                            $menuActive = 'customers';
                            break;
                        }
                    }
                }
            } else {
                $setting_tabs[$key] = $tab;
                if (isset($tab['subtabs']) && is_array($tab['subtabs'])) {
                    foreach ($tab['subtabs'] as $ks => $isub) {
                        if ($menuActive == $ks && $isub) {
                            $menuActive = $key;
                            break;
                        }
                    }
                }
            }
            if ($key == 'othermodules' && isset($this->refs)) {
                $setting_tabs[$key]['class'] = 'refs_othermodules';
                $setting_tabs[$key]['link'] = $this->refs . $this->context->language->iso_code;
                $setting_tabs[$key]['target'] = '_blank';
            }
        }
        $this->smarty->assign(array(
            'html' => $this->_html,
            'config_tabs' => $def_config_tabs,
            'activetab' => $activetab,
            'menuActive' => $menuActive,
            'link_tab' => $this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name,
            'linkJs' => $this->_path . 'views/js/admin.js',
            'caption' => $caption,
            'currency' => Currency::getDefaultCurrency(),
            'cookie_filter' => $cookie_filter,
            'submit_errors' => $this->_errors ? 1 : 0,
            'setting_tabs' => $setting_tabs,
            'linkImg' => $this->_path . 'views/img/',
            'breadcrumb_admin' => $breadcrumb_admin,
            'idRewardUser' => (int)Tools::getValue('id_reward_users')
        ));
        $output = $this->_errors ? $this->displayError($this->_errors) : $submit_success;
        return $output . $this->display(__FILE__, 'admin_form.tpl');
    }
    /**
     * @param $params
     * @return bool
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function renderForm($params)
    {
        if (!$params || !isset($params['config'])) {
            return false;
        }
        $defined = new EtsAffDefine();
        $func_config = 'def_' . $params['config'];
        $configForm = $defined->{$func_config}();
        $fields_form = array();
        $fields_form['form'] = $configForm['form'];
        if (!empty($fields_form['form']['buttons'])) {
            $fields_form['form']['buttons']['back']['href'] = AdminController::$currentIndex . '&configure=' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules') . (($tab = Tools::getValue('tabActive', false)) && Validate::isCleanHtml($tab) ? '&tabActive=' . $tab : '');
        }
        $configs = $configForm['config'];
        if ($configs) {
            foreach ($configs as $key => $config) {
                $config_fields = array(
                    'name' => $key,
                    'type' => $config['type'],
                    'label' => $config['label'],
                    'desc' => isset($config['desc']) ? $config['desc'] : false,
                    'required' => isset($config['required']) && $config['required'] ? true : false,
                    'showrequired' => isset($config['showrequired']) ? $config['showrequired']:false,
                    'autoload_rte' => isset($config['autoload_rte']) && $config['autoload_rte'] ? true : false,
                    'options' => isset($config['options']) && $config['options'] ? $config['options'] : array(),
                    'multiple' => isset($config['multiple']) && $config['multiple'],
                    'form_group_class' => isset($config['form_group_class']) ? $config['form_group_class'] : false,
                    'values' => $config['type'] == 'switch' ? array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Yes')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('No')
                        )
                    ) : (isset($config['values']) && $config['values'] ? $config['values'] : false),
                    'lang' => isset($config['lang']) ? $config['lang'] : false,
                    'col' => isset($config['col']) ? $config['col'] : '9',
                    'rows' => isset($config['rows']) ? $config['rows'] : '3',
                    'group' => isset($config['group']) ? $config['group'] : false,
                    'class' => isset($config['class']) ? $config['class'] : false,
                    'is_image' => isset($config['is_image']) ? $config['is_image'] : false,
                    'size' => isset($config['size']) ? $config['size'] : false,
                    'caption_before' => isset($config['caption_before']) ? $config['caption_before'] : false,
                    'divider_before' => isset($config['divider_before']) ? $config['divider_before'] : false,
                    'default' => isset($config['default']) && $config['default'] ? $config['default'] : false,
                    'fill' => isset($config['fill']) && $config['fill'] ? $config['fill'] : false,
                    'id' => isset($config['id']) && $config['id'] ? $config['id'] : '',
                    'items' => isset($config['items']) && $config['items'] ? $config['items'] : array(),
                    '_currencies' => isset($config['_currencies']) && $config['_currencies'] ? $config['_currencies'] : array(),
                    'default_currency' => isset($config['default_currency']) && $config['default_currency'] ? $config['default_currency'] : array(),
                );
                if (isset($config['tree']))
                    $config_fields['tree'] = $config['tree'];
                if (!empty($config['suffix']))
                    $config_fields = $config_fields + array('suffix' => $config['suffix']);
                if (!empty($config['cols']))
                    $config_fields = $config_fields + array('cols' => $config['cols']);
                if (!empty($config['rows']))
                    $config_fields = $config_fields + array('rows' => $config['rows']);
                if (!empty($config['img_dir']))
                    $config_fields = $config_fields + array('img_dir' => $config['img_dir']);
                if (!empty($config['group']))
                    $config_fields = $config_fields + array('group' => $config['group']);
                if (!$config_fields['multiple']) {
                    unset($config_fields['multiple']);
                } elseif ($config['type'] == 'select' && stripos($config_fields['name'], '[]') === false) {
                    $config_fields['name'] .= '[]';
                }
                array_push($fields_form['form']['input'], $config_fields);
            }
        }
        $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper = new HelperForm();
        $helper->show_toolbar = true;
        $helper->toolbar_scroll = true;
        $helper->table = $this->table;
        $helper->default_form_language = $language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'save' . $this->name;
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name . $this->getUrlParams();
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->override_folder = '/';
        $helper->show_cancel_button = false;
        $fields = array();
        $languages = Language::getLanguages(false);
        if (Tools::isSubmit('save' . $this->name)) {
            if ($configs) {
                foreach ($configs as $key => $config) {
                    if (isset($config['lang']) && $config['lang']) {
                        foreach ($languages as $l) {
                            $fields[$key][$l['id_lang']] = Tools::getValue($key . '_' . $l['id_lang'], isset($config['default']) ? $config['default'] : '');
                        }
                    } elseif ($config['type'] == 'select' && isset($config['multiple']) && $config['multiple']) {
                        $fields[$key . ($config['type'] == 'select' ? '[]' : '')] = Tools::getValue($key, array());
                    } elseif ($config['type'] == 'ets_checkbox_group') {
                        $fields[$key] = implode(',', Tools::getValue($key, array()));
                    } elseif ($config['type'] == 'file') {
                        $fields[$key] = $this->getFields(false, $key, $config);
                    } else {
                        $fields[$key] = Tools::getValue($key, isset($config['default']) ? $config['default'] : '');
                    }
                }
            }
        } else {
            if ($configs) {
                $obj = !empty($params['obj']) ? $params['obj'] : false;
                foreach ($configs as $key => $config) {
                    if (isset($config['lang']) && $config['lang']) {
                        foreach ($languages as $l) {
                            $fields[$key][$l['id_lang']] = $this->getFields($obj, $key, $config, (int)$l['id_lang']);
                        }
                    } elseif ($config['type'] == 'select' && isset($config['multiple']) && $config['multiple']) {
                        $fields[$key . ($config['type'] == 'select' ? '[]' : '')] = ($result = $this->getFields($obj, $key, $config)) != '' ? explode(',', $result) : array();
                    } else {
                        $fields[$key] = $this->getFields($obj, $key, $config);
                    }
                }
            }
        }
        $helper->tpl_vars = array(
            'table' => isset($fields_form['form']['name']) && $fields_form['form']['name'] ? $fields_form['form']['name'] : null,
            'base_url' => $this->context->shop->getBaseURL(),
            'language' => array(
                'id_lang' => $language->id,
                'iso_code' => $language->iso_code
            ),
            'fields_value' => $fields,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'path_banner' => _PS_ETS_EAM_IMG_
        );
        $fields_form['form']['submit'] = array(
            'title' => $this->l('Save'),
            'class' => 'btn btn-default pull-right'
        );
        $this->_html .= $helper->generateForm(array($fields_form));
    }
    /**
     * @return void
     */
    public function hookDisplayBackOfficeHeader()
    {
        $order = new Order(23);
        Ets_Loyalty::getOrderReward($order,null,true);
        $configure = Tools::getValue('configure');
        if ($configure == $this->name) {
            $this->context->controller->addJquery();
        }
        if ($configure == $this->name && !Tools::isSubmit('tabActive') && !Tools::isSubmit('getTotalUserAppPending')) {
            $this->context->cookie->closed_alert_cronjob = 0;
            $this->context->cookie->write();
        }
        $this->context->controller->addCss($this->_path . 'views/css/admin_all.css');
        $controller = Tools::getValue('controller');
        if ($configure == $this->name && $controller == 'AdminModules') {
            $this->context->controller->addCss($this->_path . 'views/css/admin.css');
            $this->context->controller->addCss($this->_path . 'views/css/other.css');
        }
        if (!$this->is17) {
            $this->context->controller->addCss($this->_path . 'views/css/admin16.css');
        }
        if (version_compare(_PS_VERSION_, '1.7.6.0', '>=') && version_compare(_PS_VERSION_, '1.7.7.0', '<'))
            $this->context->controller->addJS(_PS_JS_DIR_ . 'jquery/jquery-' . _PS_JQUERY_VERSION_ . '.min.js');
        elseif(version_compare(_PS_VERSION_, '1.7.7.0', '<='))
            $this->context->controller->addJquery();
        $activetab = Tools::getValue('tabActive');
        if ($configure == $this->name) {
            if($activetab=='payment_settings')
                $this->context->controller->addJqueryUI('ui.sortable');
            $this->context->controller->addJS($this->_path . 'views/js/other.js');
            $this->context->controller->addCss($this->_path . 'views/css/header.css');
            if ($activetab == 'dashboard') {
                $this->context->controller->addJS($this->_path . 'views/js/chart.js');
            }
            if ($activetab == 'dashboard' || $activetab == 'rs_program_reward_history' || $activetab == 'affiliate_reward_history' || $activetab == 'loyalty_reward_history' || $activetab == 'applications' || $activetab == 'withdraw_list' || $activetab == 'reward_history' || !$activetab) {
                $this->context->controller->addCss($this->_path . 'views/css/daterangepicker.css');
                $this->context->controller->addJs($this->_path . 'views/js/moment.min.js');
                $this->context->controller->addJs($this->_path . 'views/js/daterangepicker.js');
            }
        } elseif ($controller == 'AdminProducts') {
            $this->context->controller->addCss($this->_path . 'views/css/admin_product.css');
            if ($this->is17) {
                $this->context->controller->addJs($this->_path . 'views/js/admin_product.js');
            }
        }
        $this->context->controller->addJs($this->_path . 'views/js/admin_all.js');
    }

    /*== Add tab to sidebar admin === */
    /**
     * @return bool
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    private function __installTabs()
    {
        $languages = Language::getLanguages(false);
        $tab = new Tab();
        $tab->class_name = 'AdminEtsAm';
        $tab->module = $this->name;
        if (!$this->is17) {
            $tab->icon = 'trophy';
        }
        $tab->id_parent = 0;
        foreach ($languages as $lang) {
            $tab->name[$lang['id_lang']] = $this->l('Marketing programs');
        }
        $tab->save();
        $eam_tab_id = Tab::getIdFromClassName('AdminEtsAm');
        if ($eam_tab_id) {
            $subTabs = array();
            $defined = new EtsAffDefine();
            $def_config_tabs = $defined->def_config_tabs();
            foreach ($def_config_tabs as $tb) {
                if (isset($tb['class']) && $tb['class'] && isset($tb['title']) && $tb['title'] && $tb['class'] != 'othermodules') {
                    $ct = array(
                        'class_name' => $tb['class'],
                        'tab_name' => $tb['title']
                    );
                    if ($this->is17) {
                        $ct['icon'] = isset($tb['icon17']) && $tb['icon17'] ? $tb['icon17'] : '';
                    } else {
                        $ct['icon'] = isset($tb['icon']) && $tb['icon'] ? $tb['icon'] : '';
                    }
                    array_push($subTabs, $ct);
                }
            }
            foreach ($subTabs as $tabArg) {
                $tab = new Tab();
                $tab->class_name = $tabArg['class_name'];
                $tab->module = $this->name;
                $tab->icon = $tabArg['icon'];
                $tab->id_parent = $eam_tab_id;
                foreach ($languages as $lang) {
                    $tab->name[$lang['id_lang']] = $tabArg['tab_name'];
                }
                $tab->save();
            }
        }
        return true;
    }
    /**
     * @return bool
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    private function __uninstallTabs()
    {
        $defined = new EtsAffDefine();
        $tabs = $defined->def_config_tabs();
        if (!empty($tabs)) {
            foreach ($tabs as $k => $item) {
                if (isset($item['class']) && $item['class'] && $item['class'] != 'othermodules') {
                    if ($tabId = Tab::getIdFromClassName($item['class'])) {
                        $tab = new Tab($tabId);
                        if ($tab) {
                            $tab->delete();
                        }
                    }
                }
                if (isset($item['subtabs']) && $item['subtabs']) {
                    foreach (array_keys($item['subtabs']) as $key_sub) {
                        $func = 'def_' . $key_sub;
                        if (!method_exists($defined, $func)) {
                            continue;
                        }
                        $cfg = $defined->{$func}();
                        if ($cfg && isset($cfg['config']) && $cfg['config']) {
                            $configs = $cfg['config'];
                            $this->delelteConfig($configs);
                        }
                    }
                }
                $func = 'def_' . $k;
                if (!method_exists($defined, $func)) {
                    continue;
                }
                $cfg = $defined->{$func}();
                if ($cfg && isset($cfg['config']) && $cfg['config']) {
                    $configs = $cfg['config'];
                    $this->delelteConfig($configs);
                }
            }
        }
        if ($tabId = Tab::getIdFromClassName('AdminEtsAm')) {
            $tab = new Tab($tabId);
            if ($tab) {
                $tab->delete();
            }
        }
        return true;
    }
    public function delelteConfig($configs)
    {
        if ($configs) {
            foreach (array_keys($configs) as $key) {
                Configuration::deleteByName($key);
                if ($key == 'ETS_AM_REF_SPONSOR_COST_LEVEL_1') {
                    Db::getInstance()->execute('DELETE FROM `' . _DB_PREFIX_ . 'configuration` where name like "ETS_AM_REF_SPONSOR_COST_LEVEL_%"');
                }
            }
        }
    }
    /**
     * @return string
     */
    public function getUrlParams()
    {
        $params = '';
        if (($currentTabs = Tools::getValue('tabActive', false)) && Validate::isCleanHtml($currentTabs))
            $params .= '&tabActive=' . $currentTabs;
        if (($subTab = Tools::getValue('subTab', false)) && Validate::isCleanHtml($subTab))
            $params .= '&subTab=' . $subTab;
        return $params;
    }
    /**
     * @param $obj
     * @param $key
     * @param $config
     * @param bool $id_lang
     * @return bool|int|null|string
     */
    public function getFields($obj, $key, $config, $id_lang = false)
    {
        $default_value = false;
        if (isset($config['default']) && $config['default']) {
            $default_value = $config['default'] === true ? 1 : $config['default'];
        }
        if ($obj) {
            if (!$obj->id)
                return (isset($config['default']) ? $config['default'] : null);
            elseif ($id_lang)
                return !empty($obj->{$key}) && !empty($obj->{$key}[$id_lang]) ? $obj->{$key}[$id_lang] : '';
            else
                return $obj->$key;
        } else {
            if ($id_lang)
                return ($value = Configuration::get($key, $id_lang)) || (Configuration::get($key, $id_lang) !== false && Configuration::get($key, $id_lang) == 0) ? $value : $default_value;
            else
                return ($value = Configuration::get($key)) || (Configuration::get($key, $id_lang) !== false && Configuration::get($key, $id_lang) == 0) ? $value : $default_value;
        }
    }
    /**
     * @return void
     * @throws PrestaShopException
     */
    private function postProcess()
    {
        if (Tools::isSubmit('save' . $this->name)) {
            $tabActive = Tools::getValue('tabActive', 'general_settings');
            if (!$this->_errors && Validate::isCleanHtml($tabActive)) {
                $defined = new EtsAffDefine();
                $func = 'def_' . $tabActive;
                if (method_exists($defined, $func)) {
                    $tab_fields = $defined->{$func}();
                    if (isset($tab_fields['config']) && !empty($tab_fields['config'])) {
                        $params = array(
                            'tab' => $tabActive,
                            'configs' => $tab_fields['config']
                        );
                        $this->processSave($params);
                    }
                }
            }
        }
    }
    /**
     * @param $params
     * @return bool
     * @throws PrestaShopException
     */
    private function processSave($params)
    {
        if (empty($params)) {
            return false;
        }
        $languages = Language::getLanguages(false);
        $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
        $configs = array();
        if (isset($params['configs']) && $params['configs']) {
            $configs = $params['configs'];
        }
        $obj = isset($params['obj']) ? $params['obj'] : false;
        if ($configs) {
            foreach ($configs as $key => $config) {
                if (isset($config['lang']) && $config['lang']) {
                    $val_lang_default = Tools::getValue($key . '_' . $id_lang_default);
                    if (isset($config['required']) && $config['required'] && $config['type'] != 'switch' && trim($val_lang_default) == '') {
                        $this->_errors[] = sprintf($this->l('%s is required'), $config['label']);
                    } elseif ($val_lang_default && !Validate::isCleanHtml($val_lang_default))
                        $this->_errors[] = sprintf($this->l('%s is not valid'), $config['label']);
                    else {
                        foreach ($languages as $lang) {
                            $val_lang = Tools::getValue($key . '_' . $lang['id_lang']);
                            if ($val_lang && !Validate::isCleanHtml($val_lang))
                                $this->_errors[] = sprintf($this->l('%s is not valid in %s'), $config['label'], $lang['iso_code']);
                        }
                    }
                } else {
                    $val = Tools::getValue($key);
                    if (isset($config['required']) && $config['required'] && $config['type'] != 'switch' && !$val) {
                        $this->_errors[] = sprintf($this->l('%s is required'), $config['label']);
                    } elseif (!is_array($val) && isset($config['validate']) && method_exists('Validate', $config['validate'])) {
                        if ($key !== 'ETS_AM_LOYALTY_AMOUNT' && $key !== 'ETS_AM_LOYALTY_AMOUNT' && $key !== 'ETS_AM_LOYALTY_BASE_ON') {
                            $validate = $config['validate'];
                            if (trim($val) && !Validate::$validate(trim($val))) {
                                $this->_errors[] = sprintf($this->l('%s is invalid'), $config['label']);
                            }
                            unset($validate);
                        }
                    } elseif (!is_array($val) && !Validate::isCleanHtml(trim($val))) {
                        if ($key !== 'ETS_AM_LOYALTY_AMOUNT' && $key !== 'ETS_AM_LOYALTY_AMOUNT' && $key !== 'ETS_AM_LOYALTY_BASE_ON')
                            $this->_errors[] = sprintf($this->l('%s is invalid'), $config['label']);
                    } elseif (is_array($val) && !Ets_affiliatemarketing::validateArray($val))
                        $this->_errors[] = sprintf($this->l('%s is invalid'), $config['label']);
                    if ($key == 'ETS_AM_LOYALTY_TIME') {
                        if ($val !== 'ALL') {
                            $from_date = Tools::getValue('ETS_AM_LOYALTY_TIME_FROM');
                            if ($from_date && !Validate::isDate($from_date))
                                $this->_errors[] = $this->l('From date is not valid');
                            $to_date = Tools::getValue('ETS_AM_LOYALTY_TIME_TO');
                            if ($to_date && !Validate::isDate($to_date))
                                $this->_errors[] = $this->l('To date is not valid');
                            if ($from_date && $to_date) {
                                if (date(strtotime($from_date)) > date(strtotime($to_date))) {
                                    $this->_errors[] = $this->l('From date must be smaller than To date');
                                }
                            } else {
                                $this->_errors[] = $this->l('From date and To date must be fill');
                            }
                        }
                    }
                    if ($key == 'ETS_AM_AFF_OFFER_VOUCHER') {
                        if ($val) {
                            $this->validatePromoCode(EAM_AM_AFFILIATE_REWARD);
                        }
                    }
                    if ($key == 'ETS_AM_REF_OFFER_VOUCHER') {
                        if ($val) {
                            $this->validatePromoCode(EAM_AM_REF_REWARD);
                        }
                    }
                    if ($key == 'ETS_AM_WAITING_STATUS') {
                        $waiting_states = Tools::getValue('ETS_AM_WAITING_STATUS', array());
                        $validated_states = Tools::getValue('ETS_AM_VALIDATED_STATUS', array());
                        $canceled_states = Tools::getValue('ETS_AM_CANCELED_STATUS', array());
                        if (!Ets_affiliatemarketing::validateArray($waiting_states) || !Ets_affiliatemarketing::validateArray($validated_states) || !Ets_affiliatemarketing::validateArray($canceled_states))
                            $this->_errors[] = $this->l('Status of reward should be unique in 3 cases: Awaiting, Approved and Canceled');
                        else {
                            $dublicate_states1 = array_intersect($waiting_states, $validated_states);
                            $dublicate_states2 = array_intersect($waiting_states, $canceled_states);
                            $dublicate_states3 = array_intersect($canceled_states, $validated_states);
                            if ($dublicate_states1 || $dublicate_states2 || $dublicate_states3) {
                                $this->_errors[] = $this->l('Status of reward should be unique in 3 cases: Awaiting, Approved and Canceled');
                            }
                        }
                    }
                    if ($config['type'] == 'file') {
                        $file_types = isset($config['file_type']) && $config['file_type'] ? $config['file_type'] : null;
                        $file_size_allow = isset($config['file_size']) && $config['file_size'] ? $config['file_size'] : null;
                        if (isset($_FILES[$key]['tmp_name']) && $_FILES[$key]['error'] <= 0 && $file_types) {
                            if (!Validate::isFileName(str_replace(' ', '_', $_FILES[$key]['name']))) {
                                $this->_errors[] = sprintf($this->l('The file name is invalid "%s"'), $_FILES[$key]['name']);
                            } else {
                                $file_data = $_FILES[$key];
                                $file_ext = pathinfo($file_data['name'], PATHINFO_EXTENSION);
                                $file_types = explode(',', $file_types);
                                $file_size = (int)$file_data['size'] / 1024;
                                if (!in_array($file_ext, $file_types)) {
                                    $this->_errors[] = sprintf($this->l('The file name "%s" is not in the correct format, accepted formats: %s'), $_FILES[$key]['name'], '.' . trim(implode(', .', $file_types), ', .'));
                                } else if ($file_size > $file_size_allow) {
                                    $this->_errors[] = sprintf($this->l('%s is too large. Please upload file less than or equal to %s'), $config['label'], Tools::ps_round($file_size_allow, 2) . 'Mb');
                                }
                            }
                        }
                        if (isset($_FILES[$key]['name']) && $_FILES[$key]['name'] && !Validate::isFileName(str_replace(' ', '_', $_FILES[$key]['name'])))
                            $this->_errors[] = sprintf($this->l('The file name "%s" is invalid'), $_FILES[$key]['name']);
                    }
                    if (($key == 'ETS_AM_LOYALTY_BASE_ON') && ($BASE_ON = Tools::getValue($key))) {
                        if ($BASE_ON == 'FIXED' || $BASE_ON == 'SPC_FIXED') {
                            $amount = Tools::getValue('ETS_AM_LOYALTY_AMOUNT');
                            if (!$amount) {
                                $this->_errors[] = $this->l('Amount field is required');
                            } elseif (!Validate::isUnsignedFloat($amount)) {
                                $this->_errors[] = $this->l('Amount must be an unsigned number');
                            }
                        } else {
                            $percent = Tools::getValue('ETS_AM_LOYALTY_GEN_PERCENT');
                            if ($percent == '') {
                                $this->_errors[] = $this->l('Percentage field is required');
                            } elseif (!Validate::isUnsignedFloat($percent)) {
                                $this->_errors[] = $this->l('Percentage must be an unsigned number');
                            } elseif ($percent <= 0 || $percent > 100) {
                                $this->_errors[] = $this->l('Percentage is not valid');
                            }
                        }
                    }
                }
            }
        }
        $errors_validate = self::validateDataConfig($params['tab']);
        $this->_errors = array_merge($this->_errors, $errors_validate);
        $ETS_AM_REF_SPONSOR_COST_PERCENT = Tools::getValue('ETS_AM_REF_SPONSOR_COST_PERCENT');
        if ($ETS_AM_REF_SPONSOR_COST_PERCENT && Validate::isUnsignedFloat($ETS_AM_REF_SPONSOR_COST_PERCENT) && ($ETS_AM_REF_SPONSOR_COST_PERCENT < 0 || $ETS_AM_REF_SPONSOR_COST_PERCENT > 100))
            $this->_errors[] = $this->l('Sponsor cost is not valid');
        $ETS_AM_REF_SPONSOR_COST_LEVEL_1 = Tools::getValue('ETS_AM_REF_SPONSOR_COST_LEVEL_1');
        if ($ETS_AM_REF_SPONSOR_COST_LEVEL_1 && Validate::isUnsignedFloat($ETS_AM_REF_SPONSOR_COST_LEVEL_1) && ($ETS_AM_REF_SPONSOR_COST_LEVEL_1 < 0 || $ETS_AM_REF_SPONSOR_COST_LEVEL_1 > 100))
            $this->_errors[] = $this->l('Level 1 is not valid');
        $ETS_AM_REF_ENABLED_MULTI_LEVEL = (int)Tools::getValue('ETS_AM_REF_ENABLED_MULTI_LEVEL');
        if ($ETS_AM_REF_ENABLED_MULTI_LEVEL) {
            $level_count = 2;
            $quit = false;
            $exists = false;
            while ($quit == false) {
                $level_data = Tools::getValue('ETS_AM_REF_SPONSOR_COST_LEVEL_' . $level_count, false);
                if ($level_data !== false) {
                    if (trim($level_data) == '')
                        $this->_errors[] = sprintf($this->l('Level %d is required'), $level_count);
                    elseif ((!Validate::isUnsignedFloat($level_data) || $level_data < 0 || $level_data > 100)) {
                        $this->_errors[] = sprintf($this->l('Level %d is not valid'), $level_count);
                    }
                    $exists = true;
                    $level_count++;
                } else {
                    $quit = true;
                }
            }
            if (!$exists)
                $this->_errors[] = $this->l('Level 2 is required');
        }
        $ETS_AM_REF_SPONSOR_COST_LEVEL_LOWER = Tools::getValue('ETS_AM_REF_SPONSOR_COST_LEVEL_LOWER');
        if ($ETS_AM_REF_SPONSOR_COST_LEVEL_LOWER && Validate::isUnsignedFloat($ETS_AM_REF_SPONSOR_COST_LEVEL_LOWER) && ($ETS_AM_REF_SPONSOR_COST_LEVEL_LOWER <= 0 || $ETS_AM_REF_SPONSOR_COST_LEVEL_LOWER > 100))
            $this->_errors[] = $this->l('Lower levels are not valid');
        $ETS_AM_AFF_DEFAULT_PERCENTAGE = Tools::getValue('ETS_AM_AFF_DEFAULT_PERCENTAGE');
        if ($ETS_AM_AFF_DEFAULT_PERCENTAGE && Validate::isUnsignedFloat($ETS_AM_AFF_DEFAULT_PERCENTAGE) && ($ETS_AM_AFF_DEFAULT_PERCENTAGE <= 0 || $ETS_AM_AFF_DEFAULT_PERCENTAGE > 100))
            $this->_errors[] = $this->l('Percentage is not valid');
        if (!$this->_errors) {
            if ($configs) {
                foreach ($configs as $key => $config) {
                    if (isset($config['lang']) && $config['lang']) {
                        $values = array();
                        $val_lang_default = trim(Tools::getValue($key . '_' . $id_lang_default));
                        foreach ($languages as $lang) {
                            if ($config['type'] == 'switch') {
                                $val = (int)trim(Tools::getValue($key . '_' . $lang['id_lang']));
                                $values[$lang['id_lang']] = $val ? 1 : 0;
                            } else {
                                $val_lang = trim(Tools::getValue($key . '_' . $lang['id_lang']));
                                $values[$lang['id_lang']] = $val_lang && Validate::isCleanHtml($val_lang) ? $val_lang : (Validate::isCleanHtml($val_lang_default) ? $val_lang_default : '');
                            }
                        }
                        $this->setFields($obj, $key, $values, true);
                    } else {
                        if ($config['type'] == 'switch') {
                            $val = (int)trim(Tools::getValue($key));
                            $this->setFields($obj, $key, $val ? 1 : 0, true);
                        } elseif ($config['type'] == 'select' && isset($config['multiple']) && $config['multiple']) {
                            $val = Tools::getValue($key);
                            if (Ets_affiliatemarketing::validateArray($val))
                                $this->setFields($obj, $key, implode(',', $val));
                        } elseif ($config['type'] == 'categories_tree' || $config['type'] == 'categories') {
                            $val = Tools::getValue($key);
                            if (Ets_affiliatemarketing::validateArray($val))
                                Configuration::updateValue($key, $val ? implode(',', $val) : '');
                        } elseif ($config['type'] == 'ets_checkbox_group') {
                            if (Tools::getIsset($key)) {
                                $val = ($getVal = Tools::getValue($key, array())) && Ets_affiliatemarketing::validateArray($getVal) && !in_array('ALL', $getVal) && ($result = implode(',', $getVal)) != 'ALL' ? $result : 'ALL';
                                $this->setFields($obj, $key, $val);
                            } else {
                                $this->setFields($obj, $key, null);
                            }
                        } elseif ($config['type'] == 'ets_radio_group') {
                            if (Tools::getIsset($key)) {
                                $val = Tools::getValue($key, '');
                                if (Validate::isCleanHtml($val))
                                    $this->setFields($obj, $key, $val);
                            } else {
                                $this->setFields($obj, $key, null);
                            }
                        } elseif ($config['type'] == 'text_search_prd') {
                            if (Tools::getIsset($key)) {
                                $val = Tools::getValue($key, '');
                                if (Validate::isCleanHtml($val))
                                    $this->setFields($obj, $key, $val);
                            } else {
                                $this->setFields($obj, $key, null);
                            }
                        } elseif ($config['type'] == 'file' && isset($config['is_image']) && $config['is_image']) {
                            $path_img = $this->uploadImage($key);
                            if ($path_img) {
                                $this->setFields($obj, $key, $path_img);
                            }
                        } elseif ($key == 'ETS_AM_LOYALTY_CATEGORIES') {
                            $key_values = Tools::getValue($key);
                            if ($key_values == 'ALL') {
                                $this->setFields($obj, $key, 'ALL');
                            } else {
                                if (is_array($key_values) && !empty($key_values)) {
                                    if (Ets_affiliatemarketing::validateArray($key_values))
                                        $this->setFields($obj, $key, implode(',', $key_values));
                                } else {
                                    $this->setFields($obj, $key, 'ALL');
                                }
                            }
                        } elseif ($key != 'position') {
                            $field_value = Tools::getValue($key);
                            if ($field_value !== false) {
                                if ($key == 'ETS_AM_REF_SPONSOR_COST_LEVEL_1') {
                                    self::saveSponsorLevel();
                                }
                                if (!is_array($field_value)) {
                                    $field_value = Validate::isCleanHtml($field_value) ? trim($field_value) : '';
                                } else {
                                    $field_value = Ets_affiliatemarketing::validateArray($field_value) ? implode(',', $field_value) : '';
                                }
                                $this->setFields($obj, $key, $field_value, true);
                            }
                        }
                    }
                }
                if ($params['tab'] == 'rs_program_voucher') {
                    $cart_rules = Db::getInstance()->executeS('SELECT id_cart_rule FROM ' . _DB_PREFIX_ . 'ets_am_cart_rule_seller');
                    if ($cart_rules)
                        foreach ($cart_rules as $cart_rule)
                            $this->saveCartRule($cart_rule['id_cart_rule']);
                }
            }
        }
        //custom multishop.
        if (!count($this->_errors) && isset($obj->id_shop)) {
            $shops = Shop::getShops(false);
            $result = true;
            if (Shop::CONTEXT_ALL == Shop::getContext() && count($shops) > 1 && !$obj->id) {
                foreach ($shops as $shop) {
                    $obj->id_shop = (int)$shop['id_shop'];
                    $obj->position = (int)$obj->maxVal($shop['id_shop']) + 1;
                    $result &= $obj->add();
                }
            } else {
                if (!$obj->id)
                    $obj->position = (int)$obj->maxVal() + 1;
                $result &= ($obj->id && $obj->update() || !$obj->id && $obj->add());
            }
            if ($result) {
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true) . '&conf=4&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name . (!empty($params['tab']) ? '&tabActive=' . $params['tab'] : '') . (!empty($params['list_id']) ? '&id_' . $params['list_id'] . '=' . $obj->id . '&update' . $params['list_id'] : ''));
            }
        }
    }
    public static function saveSponsorLevel()
    {
        $count = 2;
        $quit = false;
        while ($quit == false) {
            if (Configuration::hasKey('ETS_AM_REF_SPONSOR_COST_LEVEL_' . $count)) {
                $ETS_AM_REF_SPONSOR_COST_LEVEL = Tools::getValue('ETS_AM_REF_SPONSOR_COST_LEVEL_' . $count);
                if ($ETS_AM_REF_SPONSOR_COST_LEVEL === false) {
                    Configuration::deleteByName('ETS_AM_REF_SPONSOR_COST_LEVEL_' . $count);
                }
            } else {
                $quit = true;
                break;
            }
            $count++;
        }
        //Add new config
        $level_count = 2;
        $quit = false;
        while ($quit == false) {
            $level_data = Tools::getValue('ETS_AM_REF_SPONSOR_COST_LEVEL_' . $level_count);
            if ($level_data !== false && Validate::isUnsignedFloat($level_data)) {
                Configuration::updateValue('ETS_AM_REF_SPONSOR_COST_LEVEL_' . $level_count, $level_data);
            } else {
                $quit = true;
                break;
            }
            $level_count++;
        }
        return true;
    }
    public static function validateDataConfig($tab)
    {
        $trans = Ets_affiliatemarketing::$trans;
        $errors = array();
        if ($tab == 'general_settings') {
            $ETS_AM_REWARD_DISPLAY = Tools::getValue('ETS_AM_REWARD_DISPLAY');
            if ($ETS_AM_REWARD_DISPLAY == 'point') {
                $rewardUnit = Tools::getValue('ETS_AM_REWARD_UNIT_LABEL_' . (int)Configuration::get('PS_LANG_DEFAULT'), false);
                if (!$rewardUnit || !Validate::isCleanHtml($rewardUnit)) {
                    $errors[] = $trans['reward_unit_label_required'];
                }
                $conver = Tools::getValue('ETS_AM_CONVERSION', false);
                if (!$conver || !Validate::isCleanHtml($conver)) {
                    $errors[] = $trans['coversion_rate_required'];
                }
            }
        } elseif ($tab == 'general_email') {
            $ETS_AM_ENABLED_EMAIL_CONFIRM_REG = (int)Tools::getValue('ETS_AM_ENABLED_EMAIL_CONFIRM_REG', false);
            $ETS_AM_ENABLED_EMAIL_RES_REG = (int)Tools::getValue('ETS_AM_ENABLED_EMAIL_RES_REG', false);
            if ($ETS_AM_ENABLED_EMAIL_CONFIRM_REG || $ETS_AM_ENABLED_EMAIL_RES_REG) {
                $emailConfirm = Tools::getValue('ETS_AM_EMAILS_CONFIRM', false);
                if (!$emailConfirm || !Validate::isCleanHtml($emailConfirm)) {
                    $errors[] = $trans['email_receive_required'];
                }
            }
        } elseif ($tab == 'loyalty_conditions') {
            $ETS_AM_LOYALTY_ENABLED = (int)Tools::getValue('ETS_AM_LOYALTY_ENABLED', false);
            if ($ETS_AM_LOYALTY_ENABLED) {
                $ETS_AM_LOYALTY_TIME = Tools::getValue('ETS_AM_LOYALTY_TIME', false);
                if ($ETS_AM_LOYALTY_TIME == 'specific') {
                    $loyTimeFrom = Tools::getValue('ETS_AM_LOYALTY_TIME_FROM', false);
                    $loyTimeTo = Tools::getValue('ETS_AM_LOYALTY_TIME_TO', false);
                    if (!$loyTimeFrom || !Validate::isDate($loyTimeFrom) || !$loyTimeTo || !Validate::isDate($loyTimeTo)) {
                        $errors[] = $trans['specific_time_required'];
                    }
                }
                $ETS_AM_LOY_CAT_TYPE = Tools::getValue('ETS_AM_LOY_CAT_TYPE');
                if ($ETS_AM_LOY_CAT_TYPE == 'SPECIFIC') {
                    $loyCate = Tools::getValue('ETS_AM_LOYALTY_CATEGORIES', false);
                    if (!$loyCate) {
                        $errors[] = $trans['categories_required'];
                    } elseif ($loyCate && !Ets_affiliatemarketing::validateArray($loyCate))
                        $errors[] = $trans['categories_valid'];
                }
            }
        } elseif ($tab == 'rs_program_voucher') {
            $ETS_AM_REF_OFFER_VOUCHER = (int)Tools::getValue('ETS_AM_REF_OFFER_VOUCHER', false);
            if ($ETS_AM_REF_OFFER_VOUCHER) {
                $ETS_AM_REF_VOUCHER_TYPE = Tools::getValue('ETS_AM_REF_VOUCHER_TYPE');
                if ($ETS_AM_REF_VOUCHER_TYPE == 'DYNAMIC') {
                    $ETS_AM_REF_APPLY_DISCOUNT = Tools::getValue('ETS_AM_REF_APPLY_DISCOUNT');
                    if ($ETS_AM_REF_APPLY_DISCOUNT == 'PERCENT') {
                        $ETS_AM_REF_REDUCTION_PERCENT = (float)Tools::getValue('ETS_AM_REF_REDUCTION_PERCENT', false);
                        if (!$ETS_AM_REF_REDUCTION_PERCENT) {
                            $errors[] = $trans['discount_percent_required'];
                        }
                    } elseif ($ETS_AM_REF_APPLY_DISCOUNT == 'AMOUNT') {
                        $ETS_AM_REF_REDUCTION_AMOUNT = (float)Tools::getValue('ETS_AM_REF_REDUCTION_AMOUNT', false);
                        if (!$ETS_AM_REF_REDUCTION_AMOUNT) {
                            $errors[] = $trans['amount_required'];
                        }
                    }
                    $ETS_AM_REF_APPLY_DISCOUNT_IN = (float)Tools::getValue('ETS_AM_REF_APPLY_DISCOUNT_IN', false);
                    if (!$ETS_AM_REF_APPLY_DISCOUNT_IN) {
                        $errors[] = $trans['discount_availability_required'];
                    }
                }
            }
            $ETS_AM_SELL_OFFER_VOUCHER = (int)Tools::getValue('ETS_AM_SELL_OFFER_VOUCHER', false);
            if ($ETS_AM_SELL_OFFER_VOUCHER) {
                $ETS_AM_SELL_APPLY_DISCOUNT = Tools::getValue('ETS_AM_SELL_APPLY_DISCOUNT');
                if ($ETS_AM_SELL_APPLY_DISCOUNT == 'PERCENT') {
                    $ETS_AM_SELL_REDUCTION_PERCENT = (float)Tools::getValue('ETS_AM_SELL_REDUCTION_PERCENT', false);
                    $ETS_AM_SELL_APPLY_DISCOUNT_IN = (float)Tools::getValue('ETS_AM_SELL_APPLY_DISCOUNT_IN', false);
                    if (!$ETS_AM_SELL_REDUCTION_PERCENT) {
                        $errors[] = $trans['discount_percent_required'];
                    } elseif (!$ETS_AM_SELL_APPLY_DISCOUNT_IN) {
                        $errors[] = $trans['discount_availability_required'];
                    }
                } elseif ($ETS_AM_SELL_APPLY_DISCOUNT == 'AMOUNT') {
                    $ETS_AM_SELL_REDUCTION_AMOUNT = (float)Tools::getValue('ETS_AM_SELL_REDUCTION_AMOUNT', false);
                    $ETS_AM_SELL_APPLY_DISCOUNT_IN = (float)Tools::getValue('ETS_AM_SELL_APPLY_DISCOUNT_IN', false);
                    if (!$ETS_AM_SELL_REDUCTION_AMOUNT) {
                        $errors[] = $trans['amount_required'];
                    } elseif (!$ETS_AM_SELL_APPLY_DISCOUNT_IN) {
                        $errors[] = $trans['discount_availability_required'];
                    }
                }
                $ETS_AM_SELL_QUANTITY = Tools::getValue('ETS_AM_SELL_QUANTITY');
                if (!$errors && $ETS_AM_SELL_QUANTITY == '')
                    $errors[] = $trans['voucher_sell_quantity_require'];
                elseif (!Validate::isInt($ETS_AM_SELL_QUANTITY) || $ETS_AM_SELL_QUANTITY <= 0)
                    $errors[] = $trans['voucher_sell_quantity_vaild'];
            }
        } elseif ($tab == 'affiliate_conditions') {
            $ETS_AM_AFF_ENABLED = (int)Tools::getValue('ETS_AM_AFF_ENABLED', false);
            if ($ETS_AM_AFF_ENABLED) {
                $ETS_AM_AFF_CAT_TYPE = Tools::getValue('ETS_AM_AFF_CAT_TYPE');
                if ($ETS_AM_AFF_CAT_TYPE == 'SPECIFIC') {
                    $ETS_AM_AFF_CATEGORIES = Tools::getValue('ETS_AM_AFF_CATEGORIES');
                    if (!$ETS_AM_AFF_CATEGORIES) {
                        $errors[] = $trans['categories_required'];
                    } elseif ($ETS_AM_AFF_CATEGORIES && !Ets_affiliatemarketing::validateArray($ETS_AM_AFF_CATEGORIES))
                        $errors[] = $trans['categories_valid'];
                }
            }
        } elseif ($tab == 'affiliate_reward_caculation') {
            $ETS_AM_AFF_HOW_TO_CALCULATE = Tools::getValue('ETS_AM_AFF_HOW_TO_CALCULATE');
            if ($ETS_AM_AFF_HOW_TO_CALCULATE == 'PERCENT') {
                $ETS_AM_AFF_DEFAULT_PERCENTAGE = (float)Tools::getValue('ETS_AM_AFF_DEFAULT_PERCENTAGE', false);
                if (!$ETS_AM_AFF_DEFAULT_PERCENTAGE) {
                    $errors[] = $trans['percentage_required'];
                }
            } elseif ($ETS_AM_AFF_HOW_TO_CALCULATE == 'FIXED') {
                $ETS_AM_AFF_DEFAULT_FIXED_AMOUNT = (float)Tools::getValue('ETS_AM_AFF_DEFAULT_FIXED_AMOUNT', false);
                if (!$ETS_AM_AFF_DEFAULT_FIXED_AMOUNT) {
                    $errors[] = $trans['amount_fixed_required'];
                }
            }
        } elseif ($tab == 'affiliate_voucher') {
            $ETS_AM_AFF_OFFER_VOUCHER = (int)Tools::getValue('ETS_AM_AFF_OFFER_VOUCHER', false);
            if ($ETS_AM_AFF_OFFER_VOUCHER) {
                $ETS_AM_AFF_VOUCHER_TYPE = Tools::getValue('ETS_AM_AFF_VOUCHER_TYPE');
                if ($ETS_AM_AFF_VOUCHER_TYPE == 'DYNAMIC') {
                    $ETS_AM_AFF_APPLY_DISCOUNT = Tools::getValue('ETS_AM_AFF_APPLY_DISCOUNT');
                    if ($ETS_AM_AFF_APPLY_DISCOUNT == 'PERCENT') {
                        $ETS_AM_AFF_REDUCTION_PERCENT = (float)Tools::getValue('ETS_AM_AFF_REDUCTION_PERCENT', false);
                        $ETS_AM_AFF_APPLY_DISCOUNT_IN = (float)Tools::getValue('ETS_AM_AFF_APPLY_DISCOUNT_IN', false);
                        if (!$ETS_AM_AFF_REDUCTION_PERCENT) {
                            $errors[] = $trans['discount_percent_required'];
                        } elseif (!$ETS_AM_AFF_APPLY_DISCOUNT_IN) {
                            $errors[] = $trans['discount_availability_required'];
                        }
                    } elseif ($ETS_AM_AFF_APPLY_DISCOUNT == 'AMOUNT') {
                        $ETS_AM_AFF_REDUCTION_AMOUNT = (float)Tools::getValue('ETS_AM_AFF_REDUCTION_AMOUNT', false);
                        if (!$ETS_AM_AFF_REDUCTION_AMOUNT) {
                            $errors[] = $trans['amount_required'];
                        }
                    }
                }
            }
        }
        return $errors;
    }
    /**
     * Validate promo code
     *
     * @param $program
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    protected function validatePromoCode($program)
    {
        if ($program == EAM_AM_AFFILIATE_REWARD) {
            $type = Tools::getValue('ETS_AM_AFF_VOUCHER_TYPE');
            $voucherCode = Tools::getValue('ETS_AM_AFF_VOUCHER_CODE');
        } elseif ($program == EAM_AM_REF_REWARD) {
            $type = Tools::getValue('ETS_AM_REF_VOUCHER_TYPE');
            $voucherCode = Tools::getValue('ETS_AM_REF_VOUCHER_CODE');
        } else {
            $type = false;
        }
        if (!$type) {
            $this->_errors[] = $this->l('Voucher type field is required.');
            return;
        }
        if ($type == 'FIXED') {
            if (!$voucherCode) {
                $this->_errors[] = $this->l('Voucher code is required.');
                return;
            }
            if (!Validate::isGenericName($voucherCode)) {
                $this->_errors[] = $this->l('Voucher code is invalid.');
                return;
            }
            $promoId = CartRule::cartRuleExists($voucherCode);
            if ($promoId) {
                if ($cartRule = new CartRule($promoId)) {
                    if (!$cartRule->active) {
                        $this->_errors[] = $this->l('Voucher is not active.');
                        return;
                    }
                }
            } else {
                $this->_errors[] = $this->l('Voucher does not exists.');
                return;
            }
        }
    }
    /**
     * @param $obj
     * @param $key
     * @param $values
     * @param bool $html
     */
    public function setFields($obj, $key, $values, $html = false)
    {
        if ($obj) {
            $obj->$key = $values;
        } else {
            Configuration::updateValue($key, $values, $html);
        }
    }
    /**
     * @param $type
     * @param null $label
     * @param null $value
     * @return bool|string
     */
    public function displaySmarty($type, $label = null, $value = null)
    {
        if (!$type)
            return false;
        $assign = array(
            'type' => $type,
            'label' => $label
        );
        if ($value)
            $assign = array_merge($assign, array(
                'value' => $value
            ));
        $this->smarty->assign($assign);
        return $this->display(__FILE__, 'admin-smarty.tpl');
    }
    /**
     * @param $key
     * @return bool|string
     */
    private function uploadImage($key)
    {
        if (isset($_FILES[$key])) {
            $allowExtentions = array('png', 'jpg', 'jpeg', 'gif');
            $imagesize = @getimagesize($_FILES[$key]['tmp_name']);
            $ext = Tools::strtolower(Tools::substr(strrchr($_FILES[$key]['name'], '.'), 1));
            $ext2 = isset($imagesize['mime']) && $imagesize['mime'] ? Tools::strtolower(Tools::substr(strrchr($imagesize['mime'], '/'), 1)) : '';
            if ($_FILES[$key]['error'] <= 0 && in_array($ext, $allowExtentions) && in_array($ext2, $allowExtentions)) {
                $img_exists = Configuration::get($key);
                $tmp_name = microtime() . rand(1111, 99999) . $img_exists;
                if ($img_exists && file_exists(EAM_PATH_IMAGE_BANER . $img_exists)) {
                    Ets_affiliatemarketing::makeCacheDir();
                    rename(EAM_PATH_IMAGE_BANER . $img_exists, _PS_CACHE_DIR_ . 'ets_affiliatemarketing/' . $tmp_name);
                    @unlink(EAM_PATH_IMAGE_BANER . $img_exists);
                }
                $success = false;
                if (!ImageManager::validateUpload($_FILES[$key], 2097152)) {
                    $temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');
                    if (move_uploaded_file($_FILES[$key]['tmp_name'], $temp_name)) {
                        Ets_AM::createPath(EAM_PATH_IMAGE_BANER);
                        $img_name = Tools::strtolower($key) . '.' . $ext;
                        $resize_with = null;
                        $resize_height = null;
                        if ($key == 'ETS_AM_REF_DEFAULT_BANNER') {
                            $img_name = 'default_banner' . '.' . $ext;
                            if ((int)Configuration::get('ETS_AM_RESIZE_BANNER')) {
                                $resize_with = (int)Configuration::get('ETS_AM_RESIZE_BANNER_WITH');
                                $resize_height = (int)Configuration::get('ETS_AM_RESIZE_BANNER_HEIGHT');
                            }
                        }
                        $path_img = EAM_PATH_IMAGE_BANER . $img_name;
                        if (ImageManager::resize($temp_name, $path_img, $resize_with, $resize_height, $ext)) {
                            $success = true;
                            if (isset($temp_name) && file_exists($temp_name)) {
                                @unlink($temp_name);
                            }
                            if (file_exists(_PS_CACHE_DIR_ . 'ets_affiliatemarketing/' . $tmp_name))
                                @unlink(_PS_CACHE_DIR_ . 'ets_affiliatemarketing/' . $tmp_name);
                            return $img_name;
                        }
                        if (isset($temp_name) && file_exists($temp_name)) {
                            @unlink($temp_name);
                        }
                    }
                }
                if (!$success && $img_exists && file_exists(_PS_CACHE_DIR_ . 'ets_affiliatemarketing/' . $tmp_name)) {
                    rename(_PS_CACHE_DIR_ . 'ets_affiliatemarketing/' . $tmp_name, EAM_PATH_IMAGE_BANER . $img_exists);
                    @unlink(_PS_CACHE_DIR_ . 'ets_affiliatemarketing/' . $tmp_name);
                    return $img_exists;
                }
                return false;
            }
        }
        return false;
    }
    /**
     * @param $params
     * @throws PrestaShopException
     */
    public function hookActionObjectOrderDetailDeleteAfter($params)
    {
        return $this->hookActionObjectOrderDetailUpdateAfter($params);
    }
    public function hookActionObjectOrderDetailUpdateAfter($params)
    {
        if (Configuration::get('ETS_AM_RECALCULATE_COMMISSION') && isset($params['object']) && ($order_detail = $params['object']) && Validate::isLoadedObject($order_detail) && isset($order_detail->id_order) && $order_detail->id_order) {
            $order = new Order($order_detail->id_order);
            $cart_loyalty = Ets_Loyalty::getOrderReward($order, null, true);
            if ($cart_loyalty) {
                $amount = is_array($cart_loyalty) ? (float)$cart_loyalty['reward'] : (float)$cart_loyalty;
                $data = array(
                    'id_friend' => (int)$order->id_customer,
                    'amount' => $amount,
                    'program' => EAM_AM_LOYALTY_REWARD,
                    'id_currency' => (int)Configuration::get('PS_CURRENCY_DEFAULT'),
                    'datetime_added' => date('Y-m-d H:i:s'),
                );
                $data['id_customer'] = (int)$order->id_customer;
                $data['id_order'] = (int)$order->id;
                $data['id_currency'] = (int)Configuration::get('PS_CURRENCY_DEFAULT');
                $products = is_array($cart_loyalty) && isset($cart_loyalty['products']) ? $cart_loyalty['products'] : array();
                if ($products)
                    $data['note'] = sprintf($this->l('Purchased loyalty product (Order: #%s)'), $order->id);
                else
                    $data['note'] = sprintf($this->l('Purchased loyalty shopping cart (Order: #%s)'), $order->id);
                Ets_Reward_Product::updateAmReward($data, $products);
            }
        }
    }
    public function hookActionObjectOrderUpdateAfter($params)
    {
        return $this->hookActionObjectOrderDetailUpdateAfter($params);
    }
    public function hookActionObjectOrderDetailAddAfter($params)
    {
        return $this->hookActionObjectOrderDetailUpdateAfter($params);
    }
    public function hookActionValidateOrder($params)
    {
        if (!(isset($params['cart'])) || !(isset($params['order'])) || !($cart = $params['cart']) || !($order = $params['order']))
            return;
        if ($order->module == $this->name) {
            $this->actionPaymentByReward($params['order']);
        }
        if(isset($params['orderStatus']) && $params['orderStatus'])
        {
            $order->current_state = $params['orderStatus']->id;
        }
        if (($cart_loyalty = Ets_Loyalty::calculateCartTotalReward($params, true)) && ($amount = is_array($cart_loyalty) ? (float)$cart_loyalty['reward'] : (float)$cart_loyalty)) {
            if ((float)$amount) {
                $data = array(
                    'id_friend' => $cart->id_customer,
                    'amount' => $amount,
                    'program' => EAM_AM_LOYALTY_REWARD,
                    'id_currency' => (int)Configuration::get('PS_CURRENCY_DEFAULT'),
                    'datetime_added' => date('Y-m-d H:i:s'),
                );
                $data['id_customer'] = (int)$this->context->customer->id;
                $data['id_shop'] = $cart->id_shop;
                $data['id_order'] = $order->id;
                $data['id_currency'] = Configuration::get('PS_CURRENCY_DEFAULT');
                $products = is_array($cart_loyalty) && isset($cart_loyalty['products']) ? $cart_loyalty['products'] : array();
                if ($products)
                    $data['note'] = sprintf($this->l('Purchased loyalty product (Order: #%s)'), $order->id);
                else
                    $data['note'] = sprintf($this->l('Purchased loyalty shopping cart (Order: #%s)'), $order->id);
                $rewardLoy = self::createNewAmReward($data, $products);
                Ets_Loyalty::sendEmailToAdminWhenNewRewardCreated($rewardLoy);
                Ets_Loyalty::sendEmailToCustomerWhenNewRewardCreated($rewardLoy);
            }
        }
        if ($aff_customer = $this->context->cookie->__get(EAM_AFF_CUSTOMER_COOKIE)) {
            $aff_customer = explode('-', $aff_customer);
            $aff_product = explode('-', $this->context->cookie->__get(EAM_AFF_PRODUCT_COOKIE));
            $customers = array();
            foreach ($aff_customer as $key => $customer) {
                if (!isset($customers[$customer]))
                    $customers[$customer] = array($aff_product[$key]);
                else
                    $customers[$customer][] = $aff_product[$key];
            }
            if ($customers) {
                $i = 0;
                foreach ($customers as $id_customer => $aff_pro) {
                    $i++;
                    $cartAffiliate = Ets_Affiliate::calculateAffiliateCartReward($cart, $this->context, true, $id_customer, $aff_pro, count($customers) == $i ? true : false);
                    if ($cartAffiliate && $cartAffiliate !== 0) {
                        if ($this->context->cookie->__get(EAM_AFF_CUSTOMER_COOKIE)) {
                            if ($this->context->cookie->__get(EAM_AFF_PRODUCT_COOKIE)) {
                                if (is_array($cartAffiliate)) {
                                    $products = $cartAffiliate['products'];
                                    $amount = $cartAffiliate['reward'];
                                } else {
                                    $products = array();
                                    $amount = $cartAffiliate;
                                }
                                if ($amount > 0) {
                                    $date = date('Y-m-d H:i:s');
                                    $data = array(
                                        'id_friend' => $cart->id_customer,
                                        'amount' => $amount,
                                        'program' => EAM_AM_AFFILIATE_REWARD,
                                        'datetime_added' => $date,
                                        'datetime_canceled' => null,
                                        'datetime_validated' => null,
                                        'id_customer' => $id_customer,
                                        'id_shop' => $params['cart']->id_shop,
                                        'id_order' => $params['order']->id,
                                        'note' => sprintf($this->l('Affiliate commission (Order: #%s)'), $params['order']->id),
                                        'id_currency' => Configuration::get('PS_CURRENCY_DEFAULT')
                                    );
                                    $data['expired_date'] = null;
                                    $reward = self::createNewAmReward($data, $products);
                                    if ((int)Configuration::get('ETS_AM_ENABLED_EMAIL_ADMIN_RC')) {
                                        Ets_Affiliate::sendEmailWhenAffiliateRewardCreated($this->l('A new reward was created'), $reward, true);
                                    }
                                    if ((int)Configuration::get('ETS_AM_ENABLED_EMAIL_CUSTOMER_RC')) {
                                        Ets_Affiliate::sendEmailWhenAffiliateRewardCreated($this->l('A new reward created for you'), $reward, false);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if (!$this->context->cookie->__get(EAM_REFS)) {
            $ref = Ets_Sponsor::getIdRefByCart($cart->id, $this->context->customer->id);
        }
        if (isset($ref) && $ref) {
            $this->context->cookie->__unset(EAM_REFS);
            $this->context->cookie->__unset('ets_am_show_voucher_ref');
            if (Ets_Sponsor::addFriendSponsored($ref))
                Ets_Sponsor::getRewardWithoutOrder($ref);
        }
        Ets_Sponsor::getRewardWithFirstOrder($cart, $order);
        Ets_Sponsor::getRewardOnOrder($params);
    }
    /**
     * @param $data
     * @param array $products
     * @return bool|Ets_AM
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    protected function createNewAmReward($data, $products = array())
    {
        $reward = new Ets_AM();
        foreach ($data as $key => $value) {
            $reward->{$key} = $value;
        }
        $reward->add(true, true) ? $reward : false;
        if ($reward->id && $products) {
            foreach ($products as $product) {
                $product_reward = new Ets_Reward_Product();
                $product_reward->id_product = $product['id_product'];
                if(isset($data['program']) && $data['program']== EAM_AM_LOYALTY_REWARD)
                {
                    $product_reward->quantity = 1;
                }
                else
                {
                    if(Configuration::get('ETS_AM_AFF_MULTIPLE')) {
                        $product_reward->quantity = isset($product['product_quantity']) ? (int)$product['product_quantity'] : (int)$product['quantity'];
                    } else{
                        $product_reward->quantity = 1;
                    }
                }
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
    /**
     * @param $params
     * @return null|string
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function hookDisplayShoppingCartFooter($params)
    {
        $context = $this->context;
        if ($context->customer->id && (Configuration::get('ETS_AM_AFF_ALLOW_VOUCHER_IN_CART') === false || Configuration::get('ETS_AM_AFF_ALLOW_VOUCHER_IN_CART'))) {
            $total_earn = Ets_Reward_Usage::getTotalEarn(null, $context->customer->id, $context);
            $total_spent = Ets_Reward_Usage::getTotalSpent($context->customer->id, false, null, $context);
            $total_balance = $total_earn - $total_spent;
        }
        if (!Ets_Loyalty::isCustomerSuspendedOrBannedLoyaltyProgram($this->context->customer->id)) {
            $cart = $params['cart'];
            $message = Ets_Loyalty::getCartMessage($cart, $this->context);
        }
        $convert_message = Configuration::get('ETS_AM_AFF_CONVERT_VOUCHER_MSG', $this->context->language->id) ? Configuration::get('ETS_AM_AFF_CONVERT_VOUCHER_MSG', $this->context->language->id) : $this->l('You have [available_reward_to_convert] in your balance. It can be converted into voucher code. [Convert_now]');
        $this->smarty->assign(array(
            'message' => isset($message) && $message ? $message : false,
            'link' => $this->context->link,
            'convert_message' => $convert_message,
            'total_balance' => isset($total_balance) && $total_balance ? Ets_AM::displayRewardInMsg($total_balance, $this->context) : false,
        ));
        $button = $this->display(__FILE__, 'convert_now_button.tpl');
        $this->context->smarty->assign('convert_now_button', $button);
        return $this->display(__FILE__, 'cart-message.tpl');
    }
    /**
     * @return bool
     */
    private function setDefaultValues()
    {
        $this->generateTokenCronjob();
        $languages = Language::getLanguages(false);
        $order_state_exists = Db::getInstance()->getRow("SELECT * FROM `" . _DB_PREFIX_ . "order_state` WHERE `module_name` = '" . pSQL($this->name) . "'");
        if ($order_state_exists) {
            $orderState = new OrderState((int)$order_state_exists['id_order_state']);
        } else
            $orderState = new OrderState();
        foreach ($languages as $lang) {
            $orderState->name[(int)$lang['id_lang']] = $this->l('Reward payment accepted');
        }
        $orderState->invoice = 0;
        $orderState->send_email = false;
        $orderState->module_name = $this->name;
        $orderState->color = '#32CD32';
        $orderState->unremovable = 1;
        $orderState->paid = 1;
        if ($orderState->save()) {
            $source = _PS_MODULE_DIR_ . $this->name . '/views/img/temp/os_payment.gif';
            $destination = _PS_ROOT_DIR_ . '/img/os/' . (int)$orderState->id . '.gif';
            copy($source, $destination);
            Configuration::updateValue('PS_ETS_AM_REWARD_PAID', $orderState->id);
        }
        $obj = false;
        $defined = new EtsAffDefine();
        $def_config_tabs = $defined->def_config_tabs();
        if ($def_config_tabs) {
            foreach ($def_config_tabs as $keytab => $tab) {
                if (isset($tab['subtabs']) && $tab['subtabs']) {
                    foreach ($tab['subtabs'] as $k => $subtab) {
                        if ($subtab) {
                            //
                        }
                        $func = 'def_' . $k;
                        if (!method_exists($defined, $func)) {
                            continue;
                        }
                        $cfg = $defined->{$func}();
                        if ($cfg && isset($cfg['form']) && isset($cfg['config']) && $cfg['config']) {
                            $configs = $cfg['config'];
                            $this->insertDefaultData($configs, $languages, $obj);
                        }
                    }
                } else {
                    $func = 'def_' . $keytab;
                    if (!method_exists($defined, $func)) {
                        continue;
                    }
                    $cfg = $defined->{$func}();
                    if ($cfg && isset($cfg['form']) && isset($cfg['config']) && $cfg['config']) {
                        $configs = $cfg['config'];
                        $this->insertDefaultData($configs, $languages, $obj);
                    }
                }
            }
        }
        //Create default payment method
        $pm_params = array();
        $pmf_params = array(
            array(
                'type' => 'text',
                'required' => 1,
                'enable' => 1,
                'sort' => 1,
            ),
            array(
                'type' => 'text',
                'required' => 1,
                'enable' => 1,
                'sort' => 2,
            ),
            array(
                'type' => 'text',
                'required' => 1,
                'enable' => 1,
                'sort' => 3,
            ),
            array(
                'type' => 'text',
                'required' => 1,
                'enable' => 1,
                'sort' => 4,
            ),
        );
        $languages = Language::getLanguages(false);
        foreach ($languages as $lang) {
            $pm_params['title'][$lang['id_lang']] = $this->l('PayPal');
            $pm_params['desc'][$lang['id_lang']] = $this->l('The fastest method to withdraw funds, directly to your local bank account!');
            $pm_params['note'][$lang['id_lang']] = null;
            foreach ($pmf_params as &$p) {
                if ($p['sort'] == 1) {
                    $p['title'][$lang['id_lang']] = $this->l('First name');
                    $p['desc'][$lang['id_lang']] = $this->l('Type your first name');
                } elseif ($p['sort'] == 2) {
                    $p['title'][$lang['id_lang']] = $this->l('Last name');
                    $p['desc'][$lang['id_lang']] = $this->l('Type your last name');
                } elseif ($p['sort'] == 3) {
                    $p['title'][$lang['id_lang']] = $this->l('PayPal email');
                    $p['desc'][$lang['id_lang']] = $this->l('Type your PayPal email to receive money');
                } elseif ($p['sort'] == 4) {
                    $p['title'][$lang['id_lang']] = $this->l('Phone');
                    $p['desc'][$lang['id_lang']] = $this->l('Type your phone');
                }
            }
        }
        $pm_params['fee_fixed'] = 1;
        $pm_params['fee_type'] = 'NO_FEE';
        $pm_params['fee_percent'] = null;
        $pm_params['enable'] = 1;
        $pm_params['estimate_processing_time'] = 7;
        $pm = new Ets_PaymentMethod();
        $id_pm = $pm->createPaymentMethod($pm_params);
        if ($id_pm) {
            foreach ($pmf_params as $pmf_param) {
                $pmf = new Ets_PaymentMethodField();
                $pmf_param['id_payment_method'] = $id_pm;
                $pmf->createPaymentMethodField($pmf_param);
            }
        }
        //Set cookie notification cronjob
        $this->context->cookie->closed_alert_cronjob = 1;
        $this->context->cookie->write();
        return true;
    }
    public function setDefaultImage()
    {
        if (!is_dir(EAM_PATH_IMAGE_BANER))
            @mkdir(EAM_PATH_IMAGE_BANER, 0755, true);
        @copy(_PS_ROOT_DIR_ . '/modules/ets_affiliatemarketing/views/img/temp/default_popup_banner.jpg', EAM_PATH_IMAGE_BANER . 'ets_am_ref_intro_banner.jpg');
        @copy(_PS_ROOT_DIR_ . '/modules/ets_affiliatemarketing/views/img/temp/default_banner.jpg', EAM_PATH_IMAGE_BANER . 'default_banner.jpg');
        return true;
    }
    private function insertDefaultData($configs, $languages, $obj)
    {
        foreach ($configs as $key => $config) {
            $default_value = false;
            if (isset($config['default']) && $config['default']) {
                $default_value = $config['default'];
            }
            if (isset($config['lang']) && $config['lang']) {
                $values = array();
                foreach ($languages as $lang) {
                    if ($config['type'] == 'switch') {
                        $values[$lang['id_lang']] = (int)$default_value ? 1 : 0;
                    } else {
                        $values[$lang['id_lang']] = $default_value ? $default_value : null;
                    }
                }
                $this->setFields($obj, $key, $values, true);
            } else {
                if ($config['type'] == 'switch') {
                    $this->setFields($obj, $key, (int)$default_value);
                } elseif ($config['type'] == 'select' && isset($config['multiple']) && $config['multiple']) {
                    if ($default_value) {
                        $this->setFields($obj, $key, $default_value);
                    } else {
                        $this->setFields($obj, $key, null);
                    }
                } elseif ($config['type'] == 'ets_checkbox_group') {
                    $checkbox_value = array();
                    if (isset($config['values']) && $config['values']) {
                        foreach ($config['values'] as $option) {
                            if (isset($option['default']) && $option['default'] && isset($option['value']) && $option['value']) {
                                $checkbox_value[] = $option['value'];
                            }
                        }
                    }
                    $this->setFields($obj, $key, implode(',', $checkbox_value));
                } elseif ($config['type'] == 'ets_radio_group') {
                    $radio_value = null;
                    if (isset($config['values']) && $config['values']) {
                        foreach ($config['values'] as $option) {
                            if (isset($option['default']) && $option['default'] && isset($option['value']) && $option['value']) {
                                $radio_value = $option['value'];
                                break;
                            }
                        }
                    }
                    $this->setFields($obj, $key, $radio_value);
                } elseif ($config['type'] == 'ets_radio_group_tree') {
                    $tree_value = null;
                    if (isset($config['values']) && $config['values']) {
                        foreach ($config['values'] as $option) {
                            if (isset($option['default']) && $option['default'] && isset($option['value']) && $option['value']) {
                                $tree_value = $option['value'];
                                break;
                            }
                        }
                    }
                    $this->setFields($obj, $key, $tree_value);
                } elseif ($config['type'] == 'text_search_prd') {
                    $this->setFields($obj, $key, null);
                } elseif ($config['type'] == 'file' && isset($config['is_image']) && $config['is_image']) {
                    $this->setFields($obj, $key, $default_value);
                } elseif ($key != 'position') {
                    if ($default_value) {
                        $this->setFields($obj, $key, $default_value, true);
                    } else {
                        $this->setFields($obj, $key, null, true);
                    }
                }
            }
        }
    }
    /**
     * @return string
     * @throws Exception
     */
    public function hookDisplayHeader()
    {
        if (!$this->is17 && ($code = Tools::getValue('discount_name')) && (Tools::getValue('controller') == 'cart' || Tools::getValue('controller') == 'order') && Tools::isSubmit('addDiscount') && (Tools::isSubmit('ajax') || Tools::isSubmit('ajax_request')))
            Ets_Voucher::getInstance()->checkCartRuleValidity($code);
        $lang = $this->context->language->id;
        $aff_customer = (int)Tools::getValue('affp');
        $aff_product = (int)Tools::getValue('id_product');
        Ets_Affiliate::setAffCustomer($aff_customer,$aff_product);
        if (($ref = (int)Tools::getValue('refs')) && !$this->context->customer->isLogged()) {
            Ets_Sponsor::setCookieRef($ref);
            $this->smarty->assign(array(
                'og_url' => Ets_AM::getBaseUrl() . '?refs=' . $ref,
                'og_type' => 'article',
                'og_title' => Configuration::get('ETS_AM_REF_SOCIAL_TITLE', $lang) ? Configuration::get('ETS_AM_REF_SOCIAL_TITLE', $lang) : '',
                'og_description' => Configuration::get('ETS_AM_REF_SOCIAL_DESC', $lang) ? Configuration::get('ETS_AM_REF_SOCIAL_DESC', $lang) : '',
                'og_image' => Configuration::get('ETS_AM_REF_SOCIAL_IMG') ? Ets_AM::getBaseUrl() . EAM_PATH_IMAGE_BANER . Configuration::get('ETS_AM_REF_SOCIAL_IMG') : '',
                '_token' => Tools::getToken(false),
            ));
        }
        $controller = Tools::getValue('controller');
        if (($module = Tools::getValue('module')) && $module == 'ets_affiliatemarketing') {
            $this->context->controller->addJS($this->_path . 'views/js/front/ets_affiliatemarketing.js');
            if($controller =='dashboard')
            {
                $this->context->controller->addCss(_PS_MODULE_DIR_ . 'ets_affiliatemarketing/views/css/nv.d3.css');
                $this->context->controller->addJs(_PS_MODULE_DIR_ . 'ets_affiliatemarketing/views/js/d3.v3.min.js');
                $this->context->controller->addJs(_PS_MODULE_DIR_ . 'ets_affiliatemarketing/views/js/nv.d3.min.js');
            }
            $this->context->controller->addCss(_PS_MODULE_DIR_ . 'ets_affiliatemarketing/views/css/daterangepicker.css');
            $this->context->controller->addJs(_PS_MODULE_DIR_ . 'ets_affiliatemarketing/views/js/moment.min.js');
            $this->context->controller->addJs(_PS_MODULE_DIR_ . 'ets_affiliatemarketing/views/js/daterangepicker.js');
        }
        $this->context->controller->addCss($this->_path . 'views/css/front.css');
        if (!$this->is17) {
            $this->context->controller->addCss($this->_path . 'views/css/front16.css');
        }
        $this->context->controller->addJS($this->_path . 'views/js/front.js');
        if ( $controller == 'product' && $aff_customer) {
            $id_product = (int)Tools::getValue('id_product');
            $this->smarty->assign(array(
                'ets_am_product_view_link' => Ets_AM::getBaseUrlDefault('product_view', array('id_product' => $id_product, 'affp' => $aff_customer)),
                'eam_id_seller' => $aff_customer ? (int)$aff_customer : 0
            ));
        }
        $this->smarty->assign(array(
            'link_cart' => $this->context->link->getPageLink('cart', Tools::usingSecureMode() ? true : false),
            'link_reward' => $this->context->link->getModuleLink($this->name, 'dashboard', array('ajax' => 1), Tools::usingSecureMode() ? true : false),
            'link_shopping_cart' => $this->context->link->getModuleLink('ps_shoppingcart', 'ajax', array(), Tools::usingSecureMode() ? true : false),
            '_token' => Tools::getToken(false),
        ));
        return $this->display(__FILE__, 'head.tpl');
    }
    /**
     * @param $key
     * @param $value
     * @return void
     * @throws Exception
     */
    public function setCookie($key, $value)
    {
        $this->context->cookie->__set($key, $value);
    }
    /**
     * @param $key
     * @return string
     */
    public function getCookie($key)
    {
        return $this->context->cookie->__get($key);
    }
    /**
     * @param $params
     * @return string
     * @throws PrestaShopException
     */
    public function hookDisplayAdminProductsExtra($params)
    {
        if (!($loyaltyBaseOn = Configuration::get('ETS_AM_LOYALTY_BASE_ON')))
            return;
        $id_product = (int)Tools::getValue('id_product');
        if ((isset($params['id_product']) && (int)$params['id_product']) || $id_product) {
            $id_product = isset($params['id_product']) && (int)$params['id_product'] ? (int)$params['id_product'] : $id_product;
            $this->_id_product = $id_product;
            $id_shop = $this->context->shop->id;
            $loyalty_reward = array();
            $loyalty_reward_fields = array(
                'ETS_AM_LOYALTY_BASE_ON', 'ETS_AM_LOYALTY_AMOUNT', 'ETS_AM_LOYALTY_AMOUNT_PER', 'ETS_AM_LOYALTY_GEN_PERCENT', 'ETS_AM_QTY_MIN'
            );
            $aff_reward = array();
            $aff_reward_fields = array(
                'ETS_AM_AFF_HOW_TO_CALCULATE',
                'ETS_AM_AFF_DEFAULT_PERCENTAGE',
                'ETS_AM_AFF_DEFAULT_FIXED_AMOUNT'
            );
            $loyalty_reward_data = EtsAmAdmin::getLoyaltySettings($id_product, $id_shop);
            $aff_reward_data = EtsAmAdmin::getAffiliateSettings($id_product, $id_shop);
            $defined = new EtsAffDefine();
            if ($loyaltyBaseOn && $loyaltyBaseOn !== 'DYNAMIC') {
                if (isset($defined->def_reward_settings()['config']) && $defined->def_reward_settings()['config']) {
                    foreach ($defined->def_reward_settings()['config'] as $key => $config) {
                        if (in_array($key, $loyalty_reward_fields)) {
                            $name = Tools::strtolower(str_replace('ETS_AM_LOYALTY_', '', $key));
                            $name = str_replace('ets_am_', '', $name);
                            $config['class'] = $key;
                            if (!empty($loyalty_reward_data)) {
                                $config['value'] = $loyalty_reward_data[$name];
                            }
                            if ($key == 'ETS_AM_LOYALTY_BASE_ON') {
                                $loyalty_bases = $config['values'];
                                unset($loyalty_bases['SPC_FIXED'], $loyalty_bases['SPC_PERCENT']);
                                $config['values'] = $loyalty_bases;
                            }
                            $loyalty_reward[$name] = $config;
                        }
                    }
                    $loyalty_reward['use_default'] = !empty($loyalty_reward_data) ? $loyalty_reward_data['use_default'] : 1;
                }
            }
            if (isset($defined->def_affiliate_reward_caculation()['config']) && $defined->def_affiliate_reward_caculation()['config']) {
                foreach ($defined->def_affiliate_reward_caculation()['config'] as $key => $config) {
                    if (in_array($key, $aff_reward_fields)) {
                        $name = Tools::strtolower(str_replace('ETS_AM_AFF_', '', $key));
                        $config['class'] = $key;
                        if (!empty($aff_reward_data)) {
                            $config['value'] = $aff_reward_data[$name];
                        }
                        $aff_reward[$name] = $config;
                    }
                }
                $aff_reward['use_default'] = !empty($aff_reward_data) ? $aff_reward_data['use_default'] : 1;
            }
            $aff_excluded = Configuration::get('ETS_AM_AFF_PRODUCTS_EXCLUDED') ? explode(',', Configuration::get('ETS_AM_AFF_PRODUCTS_EXCLUDED')) : array();
            $discount_excluded = Configuration::get('ETS_AM_AFF_PRODUCTS_EXCLUDED_DISCOUNT') && $this->checkSpecificProudct($id_product);
            $this->smarty->assign(array(
                'settings' => array(
                    'aff_reward' => !in_array($id_product, $aff_excluded) && !$discount_excluded ? $aff_reward : array(),
                    'loyalty_reward' => Configuration::get('ETS_AM_LOYALTY_BASE_ON') == 'SPC_FIXED' || Configuration::get('ETS_AM_LOYALTY_BASE_ON') == 'SPC_PERCENT' ? false : $loyalty_reward
                ),
                'loyalty_base_on' => $loyaltyBaseOn,
                'id_product' => $id_product,
                'linkAjax' => $this->context->link->getAdminLink('AdminModules', true) . '&conf=4&configure=' . $this->name,
                'using_cart' => Configuration::get('ETS_AM_LOYALTY_BASE_ON') == 'SPC_FIXED' || Configuration::get('ETS_AM_LOYALTY_BASE_ON') == 'SPC_PERCENT' ? 1 : 0,
                'is17' => $this->is17,
                'linkJs' => $this->_path . 'views/js/admin_product.js'
            ));
            return $this->display(__FILE__, 'product_settings.tpl');
        }
    }
    public function checkSpecificProudct($id_product)
    {
        $sql = 'SELECT id_specific_price FROM `' . _DB_PREFIX_ . 'specific_price` WHERE id_product ="' . (int)$id_product . '" AND (`from` = "0000-00-00 00:00:00" OR `from` <="' . pSQL(date('Y-m-d H:i:s')) . '" ) AND (`to` = "0000-00-00 00:00:00" OR `to` >="' . pSQL(date('Y-m-d H:i:s')) . '" )';
        return Db::getInstance()->getRow($sql);
    }
    /**
     * @return string
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function hookDisplayCustomerAccount()
    {
        $customer = $this->context->customer;
        $output = '';
        $this->smarty->assign(array(
            'customer' => $customer,
            'is17' => $this->is17
        ));
        if (Ets_Sponsor::isRefferalProgramReady() && Ets_AM::isCustomerBelongToValidGroup($customer, 'ETS_AM_REF_GROUPS')) {
            if (Configuration::get('ETS_AM_REF_MSG_CONDITION', $this->context->language->id) != '') {
                $this->smarty->assign(array(
                    'refUrl' => Ets_AM::getBaseUrlDefault('refer_friends')
                ));
                $output .= $this->display(__FILE__, 'referral_box.tpl');
            } else {
                if (Ets_Sponsor::canUseRefferalProgram((int)$customer->id) || Ets_Sponsor::registeredReferralProgram((int)$customer->id)) {
                    $this->smarty->assign(array(
                        'refUrl' => Ets_AM::getBaseUrlDefault('refer_friends')
                    ));
                    $output .= $this->display(__FILE__, 'referral_box.tpl');
                }
            }
        }
        if ((int)Configuration::get('ETS_AM_LOYALTY_ENABLED') && Ets_AM::isCustomerBelongToValidGroup($customer, 'ETS_AM_LOYALTY_GROUPS')) {
            if (Configuration::get('ETS_AM_LOY_MSG_CONDITION', $this->context->language->id) != '') {
                $this->smarty->assign(array(
                    'refUrl' => Ets_AM::getBaseUrlDefault('loyalty')
                ));
                $output .= $this->display(__FILE__, 'loyalty_box.tpl');
            } else {
                if (Ets_Loyalty::isCustomerCanJoinLoyaltyProgram()) {
                    if ($min = Configuration::get('ETS_AM_LOYALTY_MIN_SPENT')) {
                        $minSpent = Ets_Loyalty::calculateCustomerSpent();
                        if ($minSpent >= (float)$min) {
                            $this->smarty->assign(array(
                                'refUrl' => Ets_AM::getBaseUrlDefault('loyalty')
                            ));
                            $output .= $this->display(__FILE__, 'loyalty_box.tpl');
                        }
                    } else {
                        $this->smarty->assign(array(
                            'refUrl' => Ets_AM::getBaseUrlDefault('loyalty')
                        ));
                        $output .= $this->display(__FILE__, 'loyalty_box.tpl');
                    }
                }
            }
        }
        if ((int)Configuration::get('ETS_AM_AFF_ENABLED') && Ets_AM::isCustomerBelongToValidGroup($customer, 'ETS_AM_AFF_GROUPS')) {
            if (Configuration::get('ETS_AM_AFF_MSG_CONDITION', $this->context->language->id) != '') {
                $this->smarty->assign(array(
                    'refUrl' => Ets_AM::getBaseUrlDefault('aff_products')
                ));
                $output .= $this->display(__FILE__, 'affiliate_box.tpl');
            } else {
                if (Configuration::get('ETS_AM_AFF_ENABLED')) {
                    $valid = false;
                    if (Ets_Affiliate::isCustomerCanJoinAffiliateProgram()) {
                        $valid = true;
                    }
                    if ($valid) {
                        $this->smarty->assign(array(
                            'refUrl' => Ets_AM::getBaseUrlDefault('aff_products')
                        ));
                        $output .= $this->display(__FILE__, 'affiliate_box.tpl');
                    }
                }
            }
        }
        if (!Configuration::get('ETS_AM_LOY_MSG_CONDITION', $this->context->language->id) && !Configuration::get('ETS_AM_REF_MSG_CONDITION', $this->context->language->id) && !Configuration::get('ETS_AM_AFF_MSG_CONDITION', $this->context->language->id)) {
            if ($output) {
                $this->smarty->assign(array(
                    'refUrl' => Ets_AM::getBaseUrlDefault('dashboard')
                ));
                $output .= $this->display(__FILE__, 'customer_reward.tpl');
            }
        } else {
            if ($output) {
                $this->smarty->assign(array(
                    'refUrl' => Ets_AM::getBaseUrlDefault('dashboard')
                ));
                $output .= $this->display(__FILE__, 'customer_reward.tpl');
            }
        }
        return $output;
    }
    /**
     * @return array
     */
    protected function getTemplateVarInfos()
    {
        $total_balance = Ets_Reward_Usage::getTotalBalance($this->context->customer->id);
        if (Ets_AM::needExchange($this->context)) {
            $total_balance = Tools::convertPrice($total_balance);
        }
        $show_point = Configuration::get('ETS_AM_REWARD_DISPLAY') == 'point' ? 1 : 0;
        return array(
            'eam_reward_total_balance' => Ets_affiliatemarketing::displayPrice($total_balance),
            'eam_reward_point' => $show_point ? Ets_AM::displayReward($total_balance) : 0,
            'show_point' => $show_point,
        );
    }
    /**
     *
     */
    public function getApplications()
    {
        if (($id_app = (int)Tools::getValue('id_application', false)) && Tools::isSubmit('viewapp') && ($app = Ets_Participation::getApplicationById($id_app))) {
            $this->smarty->assign(array(
                'app' => $app,
                'id_data' => $id_app,
                'user_link' => $this->getLinkCustomerAdmin($app['id_customer']),
                'link_app' => $this->context->link->getAdminLink('AdminModules', true) . '&configure=ets_affiliatemarketing&tabActive=applications'
            ));
            $this->_html .= $this->display(__FILE__, 'view_app.tpl');
        } else {
            $filter = array(
                'type_date_filter' => Tools::getValue('type_date_filter'),
                'date_from_reward' => Tools::getValue('date_from_reward'),
                'date_to_reward' => Tools::getValue('date_to_reward'),
                'status' => Tools::getValue('status'),
                'search' => Tools::getValue('search'),
                'limit' => (int)Tools::getValue('limit'),
                'page' => (int)Tools::getValue('page'),
            );
            $pagination = EtsAmAdmin::getDataApplications($filter);
            if ($pagination['results']) {
                foreach ($pagination['results'] as &$result) {
                    $result['link'] = $this->getLinkCustomerAdmin($result['id_customer']);
                }
            }
            $this->smarty->assign(array(
                'results' => $pagination['results'],
                'current_page' => $pagination['current_page'],
                'total_page' => $pagination['total_page'],
                'total_data' => $pagination['total_data'],
                'per_page' => $pagination['per_page'],
                'search' => ($search = Tools::getValue('search', '')) && Validate::isCleanHtml($search) ? $search : '',
                'limit' => (int)Tools::getValue('limit', 10),
                'search_placeholder' => $this->l('Search for id, status, email...'),
                'params' => Tools::getAllValues(),
                'link_customer' => $this->context->link->getAdminLink('AdminCustomers', true),
                'enable_email_approve_app' => (int)Configuration::get('ETS_AM_ENABLED_EMAIL_RES_REG'),
                'enable_email_decline_app' => (int)Configuration::get('ETS_AM_ENABLED_EMAIL_DECLINE_APP')
            ));
            $this->_html .= $this->display(__FILE__, 'list_applications.tpl');
        }
    }
    public function getLinkCustomerAdmin($id_customer)
    {
        if (version_compare(_PS_VERSION_, '1.7.6', '>=')) {
            $sfContainer = call_user_func(array('\PrestaShop\PrestaShop\Adapter\SymfonyContainer', 'getInstance'));
            if (null !== $sfContainer) {
                $sfRouter = $sfContainer->get('router');
                $link_customer = $sfRouter->generate(
                    'admin_customers_view',
                    array('customerId' => $id_customer)
                );
            }
        } else
            $link_customer = $this->context->link->getAdminLink('AdminCustomers') . '&id_customer=' . (int)$id_customer . '&viewcustomer';
        return $link_customer;
    }
    /**
     * @param $params
     * @return string
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function hookDisplayProductAdditionalInfo($params)
    {
        if (!(isset($params['product'])) || !$params['product'])
            return;
        $cart = $this->context->cart;
        $id_product = (int)Tools::getValue('id_product');
        $product = $params['product'];
        $count_current_product = 0;
        if ($products = $cart->getProducts()) {
            foreach ($products as $p) {
                if ((int)$p['id_product'] == (int)$product['id_product']) {
                    $count_current_product = (int)$p['cart_quantity'];
                    break;
                }
            }
        }
        $loyalty_suspended = Ets_Loyalty::isCustomerSuspendedOrBannedLoyaltyProgram($this->context->customer->id);
        $affiliate_suspended = Ets_Affiliate::isCustomerSuspendedOrBannedAffiliateProgram($this->context->customer->id);
        if (!$loyalty_suspended || !$affiliate_suspended) {
            $data_product = array();
            $p = new Product($product['id_product']);
            $data_product['price_with_reduction_without_tax'] = $p->getPrice(false);
            $data_product['price_with_reduction'] = $p->getPrice(true);
            $data_product['id_product'] = $p->id;
            $product['price_with_tax_with_reduction'] = $p->getPrice();
            $product['price_without_tax_with_reduction'] = $p->getPrice(false);
            $product['price_with_tax_without_reduction'] = $p->getPriceWithoutReduct(false);
            $product['price_without_tax_without_reduction'] = $p->getPriceWithoutReduct(true);
            $assignment = array(
                'loyalty_suspended' => $loyalty_suspended,
                'affiliate_suspended' => $affiliate_suspended,
            );
            $assignment['eam_product_addition_loy_message'] = 'ban';
            $assignment['eam_product_addition_aff_message'] = 'ban';
            if (!$loyalty_suspended) {
                $qty_min = Configuration::get('ETS_AM_QTY_MIN');
                $productRewardSetting = Db::getInstance()->getRow("SELECT * FROM `" . _DB_PREFIX_ . "ets_am_loy_reward` WHERE `id_product` = " . (int)$product['id_product']);
                if ($productRewardSetting && count($productRewardSetting) && (int)$productRewardSetting['use_default'] != 1) {
                    $qty_min = $productRewardSetting['qty_min'];
                }
                if (!$qty_min || (int)$qty_min > $count_current_product) {
                    $eam_product_addition_loy_message = Ets_Loyalty::getLoyaltyMessageOnProductPage($product, $this->context, $cart);
                } else {
                    $eam_product_addition_loy_message = Ets_Loyalty::getLoyaltyMessageOnProductPage($product, $this->context);
                }
                $assignment['eam_product_addition_loy_message'] = $eam_product_addition_loy_message;
            }
            $productClass = new Product($product['id_product']);
            if (!$affiliate_suspended) {
                $data_message = Ets_Affiliate::getAffiliateMessage($data_product, $this->context);
                $eam_product_addition_aff_message = null;
                if ($data_message && is_array($data_message)) {
                    $eam_product_addition_aff_message = $this->getAffiliateMessage($data_message);
                    if ($data_message['is_aff'])
                        $assignment['link_share'] = $data_message['link'];
                }
                $assignment['eam_product_addition_aff_message'] = $eam_product_addition_aff_message;
            }
            $this->smarty->assign($assignment);
            if (Configuration::get('ETS_AM_AFF_ENABLED') && $this->getCookie(EAM_AFF_PRODUCT_COOKIE)) {
                $aff_products_cookie = explode('-', $this->getCookie(EAM_AFF_PRODUCT_COOKIE));
                $aff_customers = explode('-', $this->getCookie(EAM_AFF_CUSTOMER_COOKIE));
                if ($aff_products_cookie) {
                    foreach ($aff_products_cookie as $key => $aff_product)
                        if ($aff_product == $product['id_product'])
                            $aff_customer = isset($aff_customers[$key]) ? $aff_customers[$key] : 0;
                }
                $display_aff_promo_code = false;
                $aff_promo_code_msg = null;
                if (in_array($product['id_product'], $aff_products_cookie) && Ets_Voucher::canAddAffiliatePromoCode($product['id_product'], $aff_customer, true)) {
                    if (Ets_Affiliate::productValidAffiliateProgram($productClass) && $discount_value = Ets_AM::getDiscountVoucher('aff')) {
                        $display_aff_promo_code = true;
                        $mesage_code = strip_tags(Configuration::get('ETS_AM_AFF_WELCOME_MSG', $this->context->language->id));
                        $aff_promo_code_msg = str_replace('[discount_value]', $discount_value, $mesage_code);
                    }
                }
                if ($display_aff_promo_code && $aff_promo_code_msg) {
                    $this->smarty->assign(array(
                        'eam_display_aff_promo_code' => true,
                        'eam_aff_promo_code_message' => $aff_promo_code_msg,
                    ));
                }
            }
            $product_classs = new Product($id_product, false, $this->context->language->id);
            $this->smarty->assign(
                array(
                    'product' => $product_classs,
                    'link' => $this->context->link,
                )
            );
            return $this->display(__FILE__, 'product-additional.tpl');
        }
    }
    /**
     * @param $params
     * @return string
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function hookDisplayRightColumnProduct($params)
    {
        if (!$this->is17) {
            $loyalty_suspended = Ets_Loyalty::isCustomerSuspendedOrBannedLoyaltyProgram($this->context->customer->id);
            $affiliate_suspended = Ets_Affiliate::isCustomerSuspendedOrBannedAffiliateProgram($this->context->customer->id);
            if (!$loyalty_suspended || !$affiliate_suspended) {
                $id_product = (int)Tools::getValue('id_product');
                $p = new Product($id_product);
                $product = (array)$p;
                $cart = $this->context->cart;
                $count_current_product = 0;
                if ($products = $cart->getProducts()) {
                    foreach ($products as $prd) {
                        if ((int)$prd['id_product'] == (int)$id_product) {
                            $count_current_product = (int)$prd['cart_quantity'];
                            break;
                        }
                    }
                }
                $priceWithTaxWithReduct = $p->getPrice();
                $priceWithoutTaxWithReduct = $p->getPrice(false);
                $priceWithTaxWithoutReduct = $p->getPriceWithoutReduct(false);
                $priceWithoutTaxWithoutReduct = $p->getPriceWithoutReduct(true);
                $product['price_with_tax_with_reduction'] = $priceWithTaxWithReduct;
                $product['price_without_tax_with_reduction'] = $priceWithoutTaxWithReduct;
                $product['price_with_tax_without_reduction'] = $priceWithTaxWithoutReduct;
                $product['price_without_tax_without_reduction'] = $priceWithoutTaxWithoutReduct;
                $product['id_product'] = $p->id;
                $assignment = array(
                    'loyalty_suspended' => $loyalty_suspended,
                    'affiliate_suspended' => $affiliate_suspended,
                );
                $assignment['eam_product_addition_loy_message'] = '';
                $assignment['eam_product_addition_aff_message'] = '';
                if (!$loyalty_suspended) {
                    if (!Configuration::get('ETS_AM_QTY_MIN') || (int)Configuration::get('ETS_AM_QTY_MIN') > $count_current_product) {
                        $eam_product_addition_loy_message = Ets_Loyalty::getLoyaltyMessageOnProductPage($product, $this->context, $cart);
                    } else {
                        $eam_product_addition_loy_message = Ets_Loyalty::getLoyaltyMessageOnProductPage($product, $this->context);
                    }
                    $assignment['eam_product_addition_loy_message'] = $eam_product_addition_loy_message;
                }
                if (!$affiliate_suspended) {
                    $data_message = Ets_Affiliate::getAffiliateMessage($product, $this->context);
                    $eam_product_addition_aff_message = null;
                    if ($data_message && is_array($data_message)) {
                        $eam_product_addition_aff_message = $this->getAffiliateMessage($data_message);
                        $assignment['link_share'] = $data_message['link'];
                    }
                    $assignment['eam_product_addition_aff_message'] = $eam_product_addition_aff_message;
                }
                $this->smarty->assign($assignment);
                if (Configuration::get('ETS_AM_AFF_ENABLED') && $this->getCookie(EAM_AFF_PRODUCT_COOKIE)) {
                    $aff_products_cookie = explode('-', $this->getCookie(EAM_AFF_PRODUCT_COOKIE));
                    $display_aff_promo_code = false;
                    $aff_promo_code_msg = null;
                    if (in_array($product['id_product'], $aff_products_cookie) && Ets_Voucher::canAddAffiliatePromoCode($product['id_product'], $this->context->customer->id, true)) {
                        $productClass = new Product($product['id_product']);
                        if (Ets_Affiliate::productValidAffiliateProgram($productClass) && $discount_value = Ets_AM::getDiscountVoucher('aff')) {
                            $display_aff_promo_code = true;
                            $mesage_code = strip_tags(Configuration::get('ETS_AM_AFF_WELCOME_MSG', $this->context->language->id));
                            $aff_promo_code_msg = str_replace('[discount_value]', $discount_value, $mesage_code);
                        }
                    }
                    if ($display_aff_promo_code && $aff_promo_code_msg) {
                        $this->smarty->assign(array(
                            'eam_display_aff_promo_code' => true,
                            'eam_aff_promo_code_message' => $aff_promo_code_msg,
                        ));
                    }
                }
                $product_classs = new Product($id_product, false, $this->context->language->id);
                $this->smarty->assign(
                    array(
                        'product' => $product_classs,
                    )
                );
                return $this->display(__FILE__, 'product-additional.tpl');
            }
        }
    }
    public function hookActionCustomerAccountAdd($params)
    {
        $ref = null;
        if ((int)$this->context->cookie->__get(EAM_REFS)) {
            $ref = (int)$this->context->cookie->__get(EAM_REFS);
        } else {
            if (($code = Tools::getValue('eam_code_ref', false)) && Validate::isCleanHtml($code)) {
                $ref = Ets_Sponsor::checkSponsorCode($code);
                if (!$ref) {
                    $ref = null;
                } else {
                    if (Ets_Sponsor::isActive($ref)) {
                        $this->context->cookie->__set('ets_am_show_voucher_ref', (int)$this->context->customer->id);
                    }
                }
            }
        }
        $id_customer = $params['newCustomer']->id;
        $id_sponsor = 0;
        if ($this->context->cart->id) {
            $id_sponsor = Ets_Sponsor::getIdRefByCart($this->context->cart->id, $id_customer);
            if ($id_sponsor) {
                $this->context->cookie->__unset('ets_am_show_voucher_ref');
                $this->context->cookie->__unset(EAM_REFS);
            }
        }
        if (!$ref) {
            $ref = $id_sponsor;
        }
        if (Ets_Sponsor::addFriendSponsored($ref)) {
            Ets_Sponsor::getRewardWithoutOrder($ref);
        }
        $email_customer = $params['newCustomer']->email;
        Ets_Invitation::updateIdFriend($id_customer, $email_customer);
    }
    /**
     * @param $params
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function hookActionOrderStatusPostUpdate($params)
    {
        Ets_AM::actionWhenOrderStatusChange($params);
    }
    public function renderDatatable($params)
    {
        $link_withdraw = $this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name . '&tabActive=withdraw_list';
        if (Tools::isSubmit('submitSaveNoteWithdrawal', false)) {
            if (($note = Tools::getValue('note', false)) && Validate::isCleanHtml($note) && ($id_usage = (int)Tools::getValue('id_usage'))) {
                $usage = new Ets_Reward_Usage($id_usage);
                $usage->note = $note;
                $usage->update();
                $this->_html .= $this->displayConfirmation($this->l('Saved successfully'));
            }
        }
        if (Tools::isSubmit('submitApproveWithdrawItem', false)) {
            if ($id_usage = (int)Tools::getValue('id_usage', false)) {
                Ets_Withdraw::updateWithdrawAndReward($id_usage, 'APPROVE');
                $this->_html .= $this->displayConfirmation($this->l('Saved successfully'));
            }
        }
        if (Tools::isSubmit('submitDeclineReturnWithdrawItem', false)) {
            if ($id_usage = (int)Tools::getValue('id_usage', false)) {
                Ets_Withdraw::updateWithdrawAndReward($id_usage, 'DECLINE_RETURN');
                $this->_html .= $this->displayConfirmation($this->l('Saved successfully'));
            }
        }
        if (Tools::isSubmit('submitDeclineDeductWithdrawItem', false)) {
            if ($id_usage = (int)Tools::getValue('id_usage', false)) {
                Ets_Withdraw::updateWithdrawAndReward($id_usage, 'DECLINE_DEDUCT');
                $this->_html .= $this->displayConfirmation($this->l('Saved successfully'));
            }
        }
        if (Tools::isSubmit('submitDeleteWithdrawItem', false)) {
            if ($id_usage = (int)Tools::getValue('id_usage', false)) {
                $usage = new Ets_Reward_Usage($id_usage);
                $usage->deleted = 1;
                $usage->update();
                $this->_html .= $this->displayConfirmation($this->l('Saved successfully'));
                Tools::redirectAdmin($link_withdraw);
            }
        }
        if (isset($params['withdrawal']) && $params['withdrawal'] && ($view = Tools::getValue('view', false)) && Validate::isCleanHtml($view)) {
            if (($id_withdrawal = (int)Tools::getValue('id_withdrawal', false))) {
                $this->smarty->assign(array(
                    'user' => Ets_Withdraw::getUserWithdrawal($id_withdrawal),
                    'user_link' => $this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name . '&tabActive=reward_users',
                    'link_withdraw' => $link_withdraw,
                    'id_data' => $id_withdrawal,
                    'link' => $this->context->link,
                ));
                $this->_html .= $this->display(__FILE__, 'withdrawal_view.tpl');
            }
        } else {
            if (isset($params['withdrawal']) && $params['withdrawal']) {
                $pagination = Ets_Withdraw::getCustomerWithdrawalRequests(null, array(
                    'type_date_filter' => Tools::getValue('type_date_filter'),
                    'date_from_reward' => Tools::getValue('date_from_reward'),
                    'date_to_reward' => Tools::getValue('date_to_reward'),
                    'status' => Tools::getValue('status'),
                ), (int)Tools::getValue('page'), (int)Tools::getValue('limit'));
                $placeholder = $this->l('Customer\'s ID or name');
            } else {
                $filter = array(
                    'type_date_filter' => Tools::getValue('type_date_filter'),
                    'date_from_reward' => Tools::getValue('date_from_reward'),
                    'date_to_reward' => Tools::getValue('date_to_reward'),
                    'program' => Tools::getValue('program'),
                    'status' => Tools::getValue('status'),
                    'limit' => (int)Tools::getValue('limit'),
                    'page' => (int)Tools::getValue('page'),
                    'id_customer' => (int)Tools::getValue('id_customer'),
                );
                $pagination = EtsAmAdmin::getRewardHistory(null, null, false, false, $filter);
                $placeholder = $this->l('Customer\'s ID or name');
            }
            $this->smarty->assign(array(
                'fields' => $params['fields_list'],
                'results' => $pagination['results'],
                'current_page' => $pagination['current_page'],
                'total_page' => $pagination['total_page'],
                'total_data' => $pagination['total_data'],
                'per_page' => $pagination['per_page'],
                'search' => ($search = Tools::getValue('search', '')) && Validate::isCleanHtml($search) ? $search : '',
                'limit' => (int)Tools::getValue('limit', 10),
                'search_placeholder' => $placeholder,
                'params' => Tools::getAllValues(),
                'link_customer' => $this->context->link->getAdminLink('AdminModules', true)
            ));
            if (isset($params['withdrawal']) && $params['withdrawal']) {
                $this->_html .= $this->display(__FILE__, 'withdrawal.tpl');
            } else {
                $this->_html .= $this->display(__FILE__, 'datatable.tpl');
            }
        }
    }
    /**
     * @param $params
     * @return array
     * @throws Exception
     */
    public function hookPaymentOptions($params)
    {
        if (!Configuration::get('ETS_AM_AFF_ALLOW_BALANCE_TO_PAY')) {
            return;
        }
        $cart = $params['cart'];
        $cart_total = $cart->getOrderTotal(true, Cart::BOTH);
        if (Ets_AM::needExchange($this->context)) {
            $cart_total = Tools::convertPrice($cart_total, null, false);
        }
        if ($min = Configuration::get('ETS_AM_MIN_BALANCE_REQUIRED_FOR_ORDER')) {
            $min = (float)$min;
            if ($cart_total < $min) {
                return;
            }
        }
        if ($max = Configuration::get('ETS_AM_MAX_BALANCE_REQUIRED_FOR_ORDER')) {
            $max = (float)$max;
            if ($cart_total > $max) {
                return;
            }
        }
        $total_balance = Ets_Reward_Usage::getTotalBalance($this->context->customer->id);
        if ($total_balance < $cart_total) {
            return;
        }
        $this->smarty->assign(
            $this->getTemplateVarInfos()
        );
        $newOption = new PrestaShop\PrestaShop\Core\Payment\PaymentOption();
        $newOption->setModuleName($this->name)
            ->setCallToActionText($this->l('Pay by reward'))
            ->setAction($this->context->link->getModuleLink($this->name, 'validation', array(), true))
            ->setAdditionalInformation($this->fetch('module:ets_affiliatemarketing/views/templates/hook/payment_info.tpl'));
        $payment_options = array(
            $newOption,
        );
        return $payment_options;
    }
    public function hookPayment($params)
    {
        if (!Configuration::get('ETS_AM_AFF_ALLOW_BALANCE_TO_PAY')) {
            return;
        }
        $cart = $params['cart'];
        $cart_total = $cart->getOrderTotal(true, Cart::BOTH);
        if (Ets_AM::needExchange($this->context)) {
            $cart_total = Tools::convertPrice($cart_total, null, false);
        }
        if ($min = Configuration::get('ETS_AM_MIN_BALANCE_REQUIRED_FOR_ORDER')) {
            $min = (float)$min;
            if ($cart_total < $min) {
                return;
            }
        }
        if ($max = Configuration::get('ETS_AM_MAX_BALANCE_REQUIRED_FOR_ORDER')) {
            $max = (float)$max;
            if ($cart_total > $max) {
                return;
            }
        }
        $total_balance = Ets_Reward_Usage::getTotalBalance($this->context->customer->id);
        if ($total_balance < $cart_total) {
            return;
        }
        $this->smarty->assign(
            $this->getTemplateVarInfos()
        );
        return $this->display(__FILE__, 'payment.tpl');
    }
    /**
     * @param $params
     * @return bool|Ets_Reward_Usage
     */
    public function actionPaymentByReward($order)
    {
        $context = $this->context;
        if ($order) {
            $count_order = (int)Db::getInstance()->getValue("SELECT COUNT(*) FROM `" . _DB_PREFIX_ . "ets_am_reward_usage` WHERE id_customer = " . (int)$this->context->customer->id . " AND id_order = " . (int)$order->id);
            if ($count_order) {
                return false;
            }
            $amount = Tools::convertPrice($order->total_paid, $this->context->currency, false);
            $usageLOY = 0;
            $usageANR = 0;
            $totalLoy = Ets_Reward_Usage::getTotalEarn('loy', $context->customer->id, $context, $order->id);
            $totalSpentLoy = Ets_Reward_Usage::getTotalSpentLoy($context->customer->id, false, null, $context);
            $remainLoy = (float)$totalLoy - (float)$totalSpentLoy;
            if ($remainLoy > (float)$amount) {
                $usageLOY = $amount;
            } else {
                if ($remainLoy > 0) {
                    $usageLOY = $remainLoy;
                    $usageANR = (float)$amount - (float)$usageLOY;
                } else {
                    $usageANR = (float)$amount;
                }
            }
            if ($usageLOY > 0) {
                $usage = new Ets_Reward_Usage();
                $usage->type = 'loy';
                $usage->id_customer = $this->context->customer->id;
                $usage->id_shop = $this->context->shop->id;
                $usage->id_currency = $this->context->currency->id;
                $usage->id_order = $order->id;
                $usage->status = 1;
                $usage->amount = $usageLOY;
                $usage->datetime_added = date('Y-m-d H:i:s');
                $usage->note = sprintf($this->l('Paid for order #%s'), $order->id);
                $usage->add();
                Ets_affiliatemarketing::loyRewardUsed($usageLOY, $usage->id, $usage->id_customer);
            }
            if ($usageANR > 0) {
                $programs = array('mnu', 'aff', 'ref');
                foreach ($programs as $program) {
                    $total = Ets_Reward_Usage::getTotalEarn($program, $context->customer->id, $context);
                    $totalSpent = Ets_Reward_Usage::getTotalSpent($context->customer->id, false, null, $context, $program);
                    $remain = (float)$total - (float)$totalSpent;
                    if ($remain > 0) {
                        if ($usageANR < $remain) {
                            $usage = $usageANR;
                            $continue = false;
                        } else {
                            $usage = $remain;
                            $continue = true;
                            $usageANR = $usageANR - $remain;
                        }
                        $rewardUsage = new Ets_Reward_Usage();
                        $rewardUsage->id_customer = $this->context->customer->id;
                        $rewardUsage->id_shop = $this->context->shop->id;
                        $rewardUsage->id_currency = $this->context->currency->id;
                        $rewardUsage->id_order = $order->id;
                        $rewardUsage->status = 1;
                        $rewardUsage->amount = $usage;
                        $rewardUsage->type = $program;
                        $rewardUsage->datetime_added = date('Y-m-d H:i:s');
                        $rewardUsage->note = sprintf($this->l('Paid for order #%s'), $order->id);
                        $rewardUsage->add();
                        if (!$continue)
                            break;
                    }
                }
            }
            return isset($rewardUsage) ? true : false;
        }
        return false;
    }
    /**
     * @return string
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function displayFooterBefore()
    {
        $output = '';
        $show_popup_banner = 0;
        if (Tools::isSubmit('action') || Tools::isSubmit('ajax'))
            return '';
        if ($this->context->customer && Ets_Sponsor::isRefferalProgramReady()) {
            if ((int)Configuration::get('ETS_AM_REF_INTRO_ENABLED')) {
                $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
                $banner = Configuration::get('ETS_AM_REF_INTRO_BANNER');
                if (!$banner) {
                    $banner = Configuration::get('ETS_AM_REF_DEFAULT_BANNER');
                }
                $banner_img = '';
                if ($banner) {
                    $banner_img = Context::getContext()->link->getMediaLink(_PS_ETS_EAM_IMG_ . $banner);
                }
                $title = Configuration::get('ETS_AM_REF_INTRO_TITLE', $default_lang);
                $content = Configuration::get('ETS_AM_REF_INTRO_CONTENT', $default_lang);
                $delay = (int)Configuration::get('ETS_AM_REF_INTRO_REDISPLAY');
                $link_ajax = $this->context->link->getModuleLink($this->name, 'exec');
                $link_ref = Ets_AM::getBaseUrlDefault('myfriend');
                $show_popup = (int)Ets_Banner::showPopupBanner($delay);
                $show_popup_banner = $show_popup;
                $this->smarty->assign(array(
                    'banner' => $banner_img,
                    'title' => $title,
                    'content' => $content,
                    'delay' => $delay,
                    'link_ref' => $link_ref,
                    'show_popup' => $show_popup,
                    'link_ajax' => $link_ajax
                ));
                $output .= $this->display(__FILE__, 'popup_referral.tpl');
            }
        }
        if ($this->context->customer->id && (int)Configuration::get('ETS_AM_REF_OFFER_VOUCHER') && Configuration::get('ETS_AM_REF_ENABLED')) {
            if (Ets_Sponsor::allowGetVoucher()) {
                $voucher = Ets_AM::generateVoucher('ref');
                if ($voucher && !$show_popup_banner) {
                    $link_ajax = $this->context->link->getModuleLink($this->name, 'exec');
                    $this->smarty->assign(array(
                        'voucher' => $voucher,
                        'show_popup_voucher' => 1,
                        'link_ajax' => $link_ajax
                    ));
                    $output .= $this->display(__FILE__, 'popup_voucher_ref.tpl');
                }
            }
        }
        if (Configuration::get('ETS_AM_AFF_ENABLED')) {
            $display_aff_promo_code = false;
            $aff_promo_code_msg = null;
            if (($aff_product = (int)Tools::getValue('affp')) && ($id_product = (int)Tools::getValue('id_product')) && Ets_Voucher::canAddAffiliatePromoCode($id_product, $aff_product, true)) {
                $product = new Product($id_product);
                if (Ets_Affiliate::productValidAffiliateProgram($product) && $discount_value = Ets_AM::getDiscountVoucher('aff')) {
                    $display_aff_promo_code = true;
                    $mesage_code = strip_tags(Configuration::get('ETS_AM_AFF_WELCOME_MSG', $this->context->language->id));
                    $aff_promo_code_msg = str_replace('[discount_value]', $discount_value, $mesage_code);
                }
            }
            if ($display_aff_promo_code && $aff_promo_code_msg) {
                $this->smarty->assign(array(
                    'eam_display_aff_promo_code' => true,
                    'eam_aff_promo_code_message' => $aff_promo_code_msg,
                ));
                $output .= $this->display(__FILE__, 'popup_voucher_aff.tpl');
            }
        }
        return $output;
    }
    public function hookActionCustomerLogoutAfter()
    {
        $this->setCookie(EAM_AFF_CUSTOMER_COOKIE, '');
        $this->setCookie(EAM_AFF_PRODUCT_COOKIE, '');
        $this->setCookie(EAM_REFS, '');
    }
    public function hookActionCartSave()
    {
        if (Configuration::get('ETS_AM_AFF_OFFER_VOUCHER') && Configuration::get('ETS_AM_AFF_ENABLED') && $this->getCookie(EAM_AFF_PRODUCT_COOKIE)) {
            $aff_products = explode('-', $this->getCookie(EAM_AFF_PRODUCT_COOKIE));
            $aff_customers = explode('-', $this->getCookie(EAM_AFF_CUSTOMER_COOKIE));
            if ($aff_products) {
                if (Configuration::get('ETS_AM_AFF_VOUCHER_TYPE') == 'FIXED') {
                    foreach ($aff_products as $key => $aff_product) {
                        $product = new Product($aff_product);
                        if (Ets_Affiliate::productValidAffiliateProgram($product) && Ets_Affiliate::isCustomerCanJoinAffiliateProgram($aff_customers[$key])) {
                            $voucher_code = Configuration::get('ETS_AM_AFF_VOUCHER_CODE');
                            $cartRule = CartRule::getCartsRuleByCode($voucher_code, $this->context->language->id);
                            if ($cartRule) {
                                $id_cart_rule = $cartRule[0]['id_cart_rule'];
                                $cartRuleClas = new CartRule($id_cart_rule);
                                if (!$cartRuleClas->checkValidity($this->context, false, true)) {
                                    $this->context->cart->addCartRule($cartRuleClas->id);
                                }
                            }
                            break;
                        }
                    }
                } else {
                    foreach ($aff_products as $key => $aff_product) {
                        $product = new Product($aff_product);
                        if (Ets_Affiliate::productValidAffiliateProgram($product) && Ets_Affiliate::isCustomerCanJoinAffiliateProgram($aff_customers[$key])) {
                            if (Ets_Voucher::canAddAffiliatePromoCode($aff_product, $aff_customers[$key]) && (!Ets_Voucher::hasOtherVoucherInCart() || Configuration::get('ETS_AM_AFF_USE_OTHER_VOUCHER'))) {
                                $promo_code = Ets_AM::generateVoucher('aff', $aff_product, 0);
                                if (isset($promo_code['id_cart_rule']) && $promo_code['id_cart_rule']) {
                                    $cartRuleClas = new CartRule($promo_code['id_cart_rule']);
                                    $this->context->cart->addCartRule($cartRuleClas->id);
                                }
                            }
                        }
                    }
                }
            }
            if($this->context->customer->isLogged())
            {
                Ets_Voucher::addVoucherToCustomer($this->context->customer->id);
                if(Configuration::get('ETS_AM_AFF_FIST_PRODUCT'))
                {
                   $aff_rules = Ets_Voucher::getCartRuleAff();
                   if($aff_rules)
                   {
                       foreach($aff_rules as $rule)
                       {
                            if(!Ets_Voucher::checkFirstRuleAff($rule['id_cart_rule'],$rule['id_product']))
                            {
                                $this->context->cart->removeCartRule($rule['id_cart_rule']);
                                $cartRule = new CartRule($rule['id_cart_rule']);
                                $cartRule->delete();
                            }
                       }
                   }
                }
            }
        }
    }
    public function hookDisplayFooter()
    {
        return $this->displayFooterBefore();
    }
    /**
     *
     */
    protected function statsReward()
    {
        $params = array();
        if (Tools::isSubmit('filter_status')) {
            $params['status'] = (int)Tools::getValue('filter_status');
        } else {
            $params['stats_type'] = 'reward';
            $params['status'] = 1;
        }
        if (($filter_reward_status = Tools::strtolower(Tools::getValue('filter_reward_status'))) && ($filter_reward_status == 'all' || Validate::isInt($filter_reward_status))) {
            $params['reward_status'] = $filter_reward_status;
        }
        if (($filter_order_status = Tools::getValue('filter_order_status')) && Validate::isCleanHtml($filter_order_status)) {
            $params['order_status'] = $filter_order_status;
        }
        if (($filter_date_from = Tools::getValue('filter_date_from')) && Validate::isDate($filter_date_from)) {
            $params['date_from'] = $filter_date_from;
        }
        if (($filter_date_to = Tools::getValue('filter_date_to')) && Validate::isDate($filter_date_to)) {
            $params['date_to'] = $filter_date_to;
        }
        if (($filter_date_type = Tools::getValue('filter_date_type')) && in_array($filter_date_type,array('this_month','this_year','all_times','time_ranger'))) {
            $params['date_type'] = $filter_date_type;
        }
        if (($filter_type_stats = Tools::strtolower(Tools::getValue('filter_type_stats'))) && in_array($filter_type_stats, array('customers', 'reward', 'orders', 'turnover'))) {
            $params['stats_type'] = $filter_type_stats;
        }
        if (($program = Tools::strtolower(Tools::getValue('program'))) && Validate::isTablePrefix($program)) {
            $params['program'] = $program;
        }
        $results = Ets_AM::getStartChartReward($params);
        die(json_encode($results));
    }
    protected function renderStatisticReward()
    {
        $params = array();
        if (($tabActive = Tools::getValue('tabActive')) && Validate::isCleanHtml($tabActive)) {
            if (($filter_status = Tools::getValue('filter_status')) && Validate::isCleanHtml($filter_status)) {
                $params['status'] = $filter_status;
            } else {
                $params['stats_type'] = 'reward';
                $params['status'] = 1;
            }
            if (($filter_date_from = Tools::getValue('filter_date_from')) && Validate::isDate($filter_date_from)) {
                $params['date_from'] = $filter_date_from;
            }
            if (($filter_date_to = Tools::getValue('filter_date_to')) && Validate::isDate($filter_date_to)) {
                $params['date_to'] = $filter_date_to;
            }
            if (($program = Tools::getValue('program')) && Validate::isCleanHtml($program)) {
                $params['program'] = $program;
            }
        }
        $results = Ets_AM::getStartChartReward($params);
        $score_counter = Ets_Am::getStatsCounter();
        $order_states = OrderState::getOrderStates((int)Configuration::get('PS_LANG_DEFAULT'));
        $default_currency = Currency::getDefaultCurrency();
        $recently_rewards = Ets_Am::getRecentReward();
        $pie_reward = Ets_Am::getPercentReward(array('status' => 1));
        $last_cronjob = array();
        if ($cronjob_time = trim(Configuration::getGlobalValue('ETS_AM_TIME_RUN_CRONJOB'))) {
            $last_cronjob['time'] = $cronjob_time;
            $date1 = strtotime(date('Y-m-d H:i:s'));
            $date2 = strtotime($cronjob_time);
            $diff = $date1 - $date2;
            $diff_hour = $diff / 3600;
            $last_cronjob['warning'] = 0;
            if ($diff_hour > 12) {
                $last_cronjob['warning'] = 1;
            }
        }
        $assignment = array(
            'data_stats' => $results,
            'pie_reward' => $pie_reward,
            'last_cronjob' => $last_cronjob,
            'recently_rewards' => $recently_rewards,
            'score_counter' => $score_counter,
            'order_states' => $order_states,
            'recent_orders' => Ets_AM::getStatsTopTrending(array('type' => 'recent_orders')),
            'customer_link' => $this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name . '&tabActive=reward_users',
            'order_link' => $this->context->link->getAdminLink('AdminOrders', true),
            'default_currency' => $default_currency,
            'reward_history_link' => $this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name . '&tabActive=reward_history',
            'module_link' => $this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name,
            'cronjob_closed_alert' => $this->context->cookie->closed_alert_cronjob,
            'loyaltyPrograEnabled' => Configuration::get('ETS_AM_LOYALTY_ENABLED'),
            'loyaltyRewardAvailability' => Configuration::get('ETS_AM_LOYALTY_MAX_DAY'),
            'eam_currency_code' => $this->context->currency->iso_code,
        );
        if ($this->is17) {
            $assignment['is17'] = true;
        } else {
            $assignment['is17'] = false;
        }
        $this->smarty->assign($assignment);
        $this->_html = $this->display(__FILE__, 'stats.tpl');
    }
    public function hookActionAuthentication()
    {
        $this->hookActionCartSave();
        if ($back = Tools::getValue('back', false)) {
            if ($back == URL_REF_PROGRAM) {
                Tools::redirect(Ets_AM::getBaseUrlDefault('myfriend'));
            } elseif ($back == URL_CUSTOMER_REWARD) {
                Tools::redirect(Ets_AM::getBaseUrlDefault('dashboard'));
            } elseif ($back == URL_AFF_PROGRAM) {
                Tools::redirect(Ets_AM::getBaseUrlDefault('affiliate'));
            } elseif ($back == URL_LOY_PROGRAM) {
                Tools::redirect(Ets_AM::getBaseUrlDefault('loyalty'));
            }
        }
    }
    protected function getPaymentMethods()
    {
        $link_pm = $this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name . '&tabActive=payment_settings';
        if (Tools::isSubmit('update_payment_method', false)) {
            if ($pm_name = Tools::getValue('payment_method_name', array())) {
                $title_fill = 0;
                foreach ($pm_name as $item) {
                    if ($item) {
                        if (!Validate::isString($item)) {
                            $this->_errors[] = $this->l('Title of payment method must be a string.');
                        } else {
                            $title_fill = 1;
                        }
                    }
                }
                if (!$title_fill) {
                    $this->_errors[] = $this->l('Title of payment method is required.');
                }
            }
            if ($pm_desc = Tools::getValue('payment_method_desc', array())) {
                foreach ($pm_desc as $item) {
                    if ($item) {
                        if (!Validate::isCleanHtml($item)) {
                            $this->_errors[] = $this->l('Description of payment method must be a string.');
                        }
                    }
                }
            }
            if ($pm_note = Tools::getValue('payment_method_note', array())) {
                foreach ($pm_note as $item) {
                    if ($item) {
                        if (!Validate::isCleanHtml($item)) {
                            $this->_errors[] = $this->l('Note of payment method must be a string.');
                        }
                    }
                }
            }
            if (($pm_fee_type = Tools::getValue('payment_method_fee_type')) && $pm_fee_type != 'NO_FEE') {
                if ($pm_fee_type == 'FIXED') {
                    if (!($pm_fee_fixed = Tools::getValue('payment_method_fee_fixed'))) {
                        $this->_errors[] = $this->l('Fee (fixed amount) is required');
                    } elseif (!Validate::isFloat($pm_fee_fixed)) {
                        $this->_errors[] = $this->l('Fee (fixed amount) must be a decimal number.');
                    }
                } elseif ($pm_fee_type == 'PERCENT') {
                    if (($pm_fee_percent = Tools::getValue('payment_method_fee_percent')) == '') {
                        $this->_errors[] = $this->l('Fee (percentage) is required');
                    } elseif (!Validate::isFloat($pm_fee_percent)) {
                        $this->_errors[] = $this->l('Fee (percentage) must be a decimal number.');
                    } elseif ($pm_fee_percent <= 0 || $pm_fee_percent > 100)
                        $this->_errors[] = $this->l('Fee (percentage) is not valid.');
                }
            }
            if ($pm_estimated = Tools::getValue('payment_method_estimated', false)) {
                if (!Validate::isUnsignedInt($pm_estimated)) {
                    $this->_errors[] = $this->l('Estimated processing time must be a integer');
                }
            }
            if ($pmf = Tools::getValue('payment_method_field', array())) {
                foreach ($pmf as $item) {
                    if (isset($item['title']) && is_array($item['title']) && $item['title']) {
                        $title_fill = 0;
                        foreach ($item['title'] as $title) {
                            if ($title) {
                                if (!Validate::isString('$title')) {
                                    $this->_errors[] = $this->l('Title of payment method field must be a string');
                                } else {
                                    $title_fill = 1;
                                }
                            }
                        }
                        if (!$title_fill) {
                            $this->_errors[] = $this->l('Title of payment method field is required');
                        }
                    }
                }
            }
            if (!$this->_errors) {
                if (($id_pm = (int)Tools::getValue('payment_method')) && ($paymentMethod = new Ets_PaymentMethod($id_pm)) && Validate::isLoadedObject($paymentMethod)) {
                    EtsAmAdmin::updatePaymentMethod($id_pm,
                        $pm_name,
                        $pm_fee_type,
                        isset($pm_fee_fixed) ? $pm_fee_fixed : null,
                        isset($pm_fee_percent) ? $pm_fee_percent : null,
                        (int)Tools::getvalue('payment_method_enabled'),
                        $pm_estimated,
                        $pm_desc,
                        $pmf,
                        $pm_note
                    );
                    $this->_html .= $this->displayConfirmation($this->l('Payment method updated successfully'));
                } else
                    $this->_errors[] = $this->l('Method not exists');
            }
        } elseif (Tools::isSubmit('create_payment_method', false)) {
            if ($pm_name = Tools::getValue('payment_method_name', array())) {
                $title_fill = 0;
                foreach ($pm_name as $item) {
                    if ($item) {
                        if (!Validate::isString($item)) {
                            $this->_errors[] = $this->l('Title of payment method must be a string.');
                        } else {
                            $title_fill = 1;
                        }
                    }
                }
                if (!$title_fill) {
                    $this->_errors[] = $this->l('Title of payment method is required.');
                }
            }
            if ($pm_desc = Tools::getValue('payment_method_desc', array())) {
                foreach ($pm_desc as $item) {
                    if ($item) {
                        if (!Validate::isCleanHtml($item)) {
                            $this->_errors[] = $this->l('Description of payment method must be a string.');
                        }
                    }
                }
            }
            if ($pm_note = Tools::getValue('payment_method_note', array())) {
                foreach ($pm_note as $item) {
                    if ($item) {
                        if (!Validate::isCleanHtml($item)) {
                            $this->_errors[] = $this->l('Note of payment method must be a string.');
                        }
                    }
                }
            }
            if (($pm_fee_type = Tools::getValue('payment_method_fee_type')) && $pm_fee_type != 'NO_FEE') {
                if ($pm_fee_type == 'FIXED') {
                    if (!($pm_fee_fixed = Tools::getValue('payment_method_fee_fixed'))) {
                        $this->_errors[] = $this->l('Fee (fixed amount) is required');
                    } elseif (!Validate::isFloat($pm_fee_fixed)) {
                        $this->_errors[] = $this->l('Fee (fixed amount) must be a decimal number.');
                    }
                } elseif ($pm_fee_type == 'PERCENT') {
                    if (!($pm_fee_percent = Tools::getValue('payment_method_fee_percent'))) {
                        $this->_errors[] = $this->l('Fee (percentage) is required');
                    } elseif (!Validate::isFloat($pm_fee_percent)) {
                        $this->_errors[] = $this->l('Fee (percentage) must be a decimal number.');
                    }
                }
            }
            if ($pm_estimated = Tools::getValue('payment_method_estimated', false)) {
                if (!Validate::isUnsignedInt($pm_estimated)) {
                    $this->_errors[] = $this->l('Estimated processing time must be a integer');
                }
            }
            if (!$this->_errors) {
                $id_pm = EtsAmAdmin::createPaymentMethod(
                    $pm_name,
                    $pm_fee_type,
                    isset($pm_fee_fixed) ? $pm_fee_fixed : null,
                    isset($pm_fee_percent) ? $pm_fee_percent : null,
                    (int)Tools::getvalue('payment_method_enabled'),
                    $pm_estimated,
                    $pm_desc,
                    $pm_note
                );
                if ($id_pm) {
                    $this->context->cookie->__set('flash_created_pm_success', $this->l('Payment method created successfully.'));
                    return Tools::redirectAdmin($link_pm . '&payment_method=' . $id_pm . '&edit_pm=1');
                }
            } else {
                $languages = Language::getLanguages('false');
                $currency = Currency::getDefaultCurrency();
                $this->smarty->assign(array(
                    'languages' => $languages,
                    'currency' => $currency,
                    'link_pm' => $link_pm,
                    'query' => Tools::getAllValues()
                ));
                return $this->_html .= $this->display(__FILE__, 'payment/create_payment_method.tpl');
            }
        } elseif (Tools::isSubmit('delete_payment_method') && ($id_pm = (int)Tools::getValue('payment_method'))) {
            EtsAmAdmin::deletePaymentMethod($id_pm);
        }
        $languages = Language::getLanguages('false');
        $currency = Currency::getDefaultCurrency();
        if (Tools::isSubmit('create_pm')) {
            $this->smarty->assign(array(
                'languages' => $languages,
                'currency' => $currency,
                'link_pm' => $link_pm,
            ));
            return $this->_html .= $this->display(__FILE__, 'payment/create_payment_method.tpl');
        } elseif (Tools::isSubmit('edit_pm') && ($id_pm = (int)Tools::getValue('payment_method', false))) {
            $payment_method = EtsAmAdmin::getPaymentMethod($id_pm);
            $pmf = EtsAmAdmin::getListPaymentMethodField($id_pm);
            $this->smarty->assign(array(
                'payment_method' => $payment_method,
                'payment_method_fields' => $pmf,
                'languages' => $languages,
                'default_lang' => (int)Configuration::get('PS_LANG_DEFAULT'),
                'currency' => $currency,
                'link_pm' => $link_pm
            ));
            if ($msg = $this->context->cookie->__get('flash_created_pm_success')) {
                $this->_html .= $this->displayConfirmation($msg);
                $this->context->cookie->__set('flash_created_pm_success', null);
            }
            return $this->_html .= $this->display(__FILE__, 'payment/edit_payment_method.tpl');
        }
        $payment_methods = EtsAmAdmin::getListPaymentMethods();
        $default_currency = Currency::getDefaultCurrency()->iso_code;
        $this->smarty->assign(array(
            'payment_methods' => $payment_methods,
            'default_currency' => $default_currency,
            'link_pm' => $link_pm
        ));
        return $this->_html .= $this->display(__FILE__, 'payment/payment_methods.tpl');
    }
    protected function renderTableDashboard($data, $type)
    {
        $default_currency = Currency::getDefaultCurrency();
        $temp = 'dashboard/recent_orders.tpl';
        switch ($type) {
            case 'recent_orders':
                $temp = 'dashboard/recent_orders.tpl';
                break;
            case 'best_seller':
                $temp = 'dashboard/best_seller.tpl';
                break;
            case 'top_sponsor':
                $temp = 'dashboard/top_sponsor.tpl';
                break;
            case 'top_affiliate':
                $temp = 'dashboard/top_affiliate.tpl';
                break;
            case 'top_customer':
                $temp = 'dashboard/top_customer.tpl';
                break;
            case 'top_reward_accounts':
                $temp = 'dashboard/top_reward_accounts.tpl';
                break;
        }
        $this->smarty->assign(array(
            'data' => $data,
            'default_currency' => $default_currency,
            'customer_link' => $this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name . '&tabActive=reward_users',
            'order_link' => $this->context->link->getAdminLink('AdminOrders', true),
        ));
        return $this->display(__FILE__, $temp);
    }
    public function getDetailUser($id_customer)
    {
        if (Tools::isSubmit('deduct_reward_by_admin') || Tools::isSubmit('add_reward_by_admin')) {
            $amount = Tools::getValue('amount', false);
            $action = Tools::getValue('action', false);
            $reason = Tools::getValue('reason', false);
            $program = Tools::getValue('type_program', false);
            if (!in_array($program, array('loy', 'aff', 'ref', 'mnu')))
                $program = 'mnu';
            if (!$amount) {
                $this->_errors = $this->l('Amount is required');
            } elseif (!Validate::isPrice($amount)) {
                if ($action == 'deduct')
                    $this->_errors = $this->l('The reward is not enough to deduct');
                else
                    $this->_errors = $this->l('Amount must be a decimal');
            }
            if ($reason && !Validate::isCleanHtml($reason))
                $this->_errors[] = $this->l('Reason is not valid');
            if ($action != 'add' && $action != 'deduct')
                $this->_errors[] = $this->l('Action is not valid');
            if (!$this->_errors) {
                $customer = new Customer($id_customer);
                $type_program = Tools::getValue('type_program');
                if ($action == 'deduct') {
                    $remain = Ets_Reward_Usage::getTotalRemaining($id_customer, $program);
                    if ($remain < $amount) {
                        $this->_errors = $this->l('Reward remaining not enough to deduct.');
                    } else {
                        $usage = new Ets_Reward_Usage();
                        $usage->amount = $amount;
                        $usage->status = 1;
                        $usage->id_customer = $id_customer;
                        $usage->note = $reason ? $reason : null;
                        $usage->datetime_added = date('Y-m-d H:i:s');
                        $usage->type = $program;
                        $usage->id_shop = $this->context->shop->id;
                        $usage->save(true, true);
                        $this->_html .= $this->displayConfirmation($this->l('Deducted successfully'));
                        $data = array(
                            '{customer_name}' => $customer->firstname . ' ' . $customer->lastname,
                            '{id_reward}' => $usage->id,
                            '{amount}' => Tools::displayPrice($usage->amount),
                            '{program}' => ($type_program == 'loy' ? $this->l('Loyalty program') : ($type_program == 'aff' ? $this->l('Affiliate program') : ($type_program == 'ref' ? $this->l('Referral program') : '---'))),
                            '{reason}' => $usage->note,
                        );
                        if (Configuration::get('ETS_EMAIL_ADMIN_DEDUCT_REWARD') || Configuration::get('ETS_EMAIL_ADMIN_DEDUCT_REWARD') === false) {
                            $subjects = array(
                                'translation' => $this->l('Admin has deducted a reward from you'),
                                'origin' => 'Admin has deducted a reward from you',
                                'specific' => false
                            );
                            Ets_aff_email::send($customer->id_lang, 'admin_deduct_reward', $subjects, $data, $customer->email);
                        }
                    }
                } elseif ($action == 'add') {
                    $reward = new Ets_AM();
                    $reward->amount = $amount;
                    $reward->note = $reason ? $reason : null;
                    $reward->status = 1;
                    $reward->id_shop = $this->context->shop->id;
                    $reward->id_customer = $id_customer;
                    $reward->program = $program;
                    $reward->datetime_added = date('Y-m-d H:i:s');
                    $reward->datetime_validated = date('Y-m-d H:i:s');
                    $reward->save(true, true);
                    $this->_html .= $this->displayConfirmation($this->l('Added successfully'));
                    $data = array(
                        '{customer_name}' => $customer->firstname . ' ' . $customer->lastname,
                        '{id_reward}' => $reward->id,
                        '{amount}' => Tools::displayPrice($reward->amount),
                        '{program}' => ($type_program == 'loy' ? $this->l('Loyalty program') : ($type_program == 'aff' ? $this->l('Affiliate program') : ($type_program == 'ref' ? $this->l('Referral program') : '---'))),
                        '{reason}' => $reward->note,
                    );
                    if (Configuration::get('ETS_EMAIL_ADMIN_ADD_REWARD') || Configuration::get('ETS_EMAIL_ADMIN_ADD_REWARD') === false) {
                        $subjects = array(
                            'translation' => $this->l('Admin has added a reward to you'),
                            'origin' => 'Admin has added a reward to you',
                            'specific' => false
                        );
                        Ets_aff_email::send($customer->id_lang, 'admin_add_reward', $subjects, $data, array('customer' => $customer->email));
                    }
                }
            }
        }
        if (($id_parent = Ets_Sponsor::getIdParentByIdCustomer($id_customer)) && ($customerParent = new Customer($id_parent)) && Validate::isLoadedObject($customerParent)) {
            $this->context->smarty->assign(
                array(
                    'customerParent' => $customerParent,
                    'linkParent' => $this->getLinkCustomerAdmin($id_parent),
                )
            );
        }
        $currency = Currency::getDefaultCurrency();
        $filter = array(
            'type_date_filter' => Tools::getValue('type_date_filter'),
            'date_from_reward' => Tools::getValue('date_from_reward'),
            'date_to_reward' => Tools::getValue('date_to_reward'),
            'program' => Tools::getValue('program'),
            'status' => Tools::getValue('status'),
            'limit' => (int)Tools::getValue('limit'),
            'page' => (int)Tools::getValue('page'),
        );
        $this->smarty->assign(array(
            'user' => EtsAmAdmin::getUserInfo($id_customer),
            'reward_history' => EtsAmAdmin::getRewardHistory($id_customer, null, false, false, $filter),
            'sponsors' => Ets_Sponsor::getDetailSponsors($id_customer),
            'customer_link' => $this->getLinkCustomerAdmin($id_customer),
            'order_link' => $this->context->link->getAdminLink('AdminOrders', true),
            'link_admin' => $this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name,
            'currency' => $currency,
            'id_data' => $id_customer,
            'enable_email_approve_app' => (int)Configuration::get('ETS_AM_ENABLED_EMAIL_RES_REG'),
            'enable_email_decline_app' => (int)Configuration::get('ETS_AM_ENABLED_EMAIL_DECLINE_APP')
        ));
        $this->_html .= $this->display(__FILE__, 'user/view.tpl');
    }
    public function renderList($params)
    {
        if (!$params) return $this->_html;
        $params = $params['list'] + array('fields_list' => $params['fields'], 'toolbar_btn' => isset($params['toolbar_btn']) ? $params['toolbar_btn'] : false);
        $fields_list = isset($params['fields_list']) && $params['fields_list'] ? $params['fields_list'] : false;
        if (!$fields_list) return false;
        $helper = new HelperList();
        $helper->title = isset($params['title']) && $params['title'] ? $params['title'] : '';
        $helper->table = isset($params['list_id']) && $params['list_id'] ? $params['list_id'] : $this->list_id;
        $helper->identifier = $params['primary_key'];
        if (version_compare(_PS_VERSION_, '1.6.1', '>=')) {
            $helper->_pagination = array(25, 50, 100);
            $helper->_default_pagination = 25;
        }
        $helper->_defaultOrderBy = $params['orderBy'];
        $this->processFilter($params);
        //Sort order
        $table_orderBy = $helper->table . 'Orderby';
        $table_orderway = $helper->table . 'Orderway';
        $order_by = urldecode(Tools::getValue($table_orderBy));
        if (!$order_by || !Validate::isCleanHtml($order_by)) {
            if ($this->context->cookie->{$table_orderBy}) {
                $order_by = $this->context->cookie->{$table_orderBy};
            } elseif ($helper->orderBy) {
                $order_by = $helper->orderBy;
            } else {
                $order_by = $helper->_defaultOrderBy;
            }
        }
        $order_way = urldecode(Tools::getValue($table_orderway));
        if (!$order_way || !Validate::isCleanHtml($order_way)) {
            if ($this->context->cookie->{$table_orderway}) {
                $order_way = $this->context->cookie->{$table_orderway};
            } elseif ($helper->orderWay) {
                $order_way = $helper->orderWay;
            } else {
                $order_way = $params['orderWay'];
            }
        }
        if (isset($fields_list[$order_by]) && isset($fields_list[$order_by]['filter_key'])) {
            $order_by = $fields_list[$order_by]['filter_key'];
        }
        //Pagination.
        $key_pagination = $helper->table . '_pagination';
        $limit = (int)Tools::getValue($key_pagination);
        if (!$limit) {
            if (isset($this->context->cookie->{$key_pagination}) && $this->context->cookie->{$key_pagination})
                $limit = $this->context->cookie->{$key_pagination};
            else
                $limit = (version_compare(_PS_VERSION_, '1.6.1', '>=') ? $helper->_default_pagination : 20);
        }
        if ($limit) {
            $this->context->cookie->{$key_pagination} = $limit;
        } else {
            unset($this->context->cookie->{$key_pagination});
        }
        $start = 0;
        $key = $helper->table . '_start';
        $submit = (int)Tools::getValue('submitFilter' . $helper->table);
        if ($submit) {
            $start = ($submit - 1) * $limit;
        } elseif (empty($start) && isset($this->context->cookie->{$key})) {
            $start = $this->context->cookie->{$key};
        }
        if ($start) {
            $this->context->cookie->{$key} = $start;
        } elseif (isset($this->context->cookie->{$key})) {
            unset($this->context->cookie->{$key});
        }
        if (!Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way)
            || !is_numeric($start) || !is_numeric($limit)) {
            $this->_errors = $this->l('Parameter list is not valid');
        }
        $helper->orderBy = $order_by;
        if (preg_match('/[.!]/', $order_by)) {
            $order_by_split = preg_split('/[.!]/', $order_by);
            $order_by = bqSQL($order_by_split[0]) . '.`' . bqSQL($order_by_split[1]) . '`';
        } elseif ($order_by) {
            $order_by = '`' . bqSQL($order_by) . '`';
        }
        $args = array(
            'filter' => $this->_filter,
            'having' => $this->_filterHaving,
        );
        if (isset($params['id_customer']) && $params['id_customer']) {
            $args += array('id_customer' => (int)$params['id_customer']);
        }
        if (isset($params['status'])) {
            $args['status'] = $params['status'];
        }
        if (!empty($_POST)) {
            $prefix = 'reward_users';
            $having = "";
            $filter_where = "";
            $point = Ets_AM::usingCustomUnit();
            if (Tools::isSubmit('submitFilter' . $prefix, false)) {
                if (($_reward_balance_min = Tools::getValue($prefix . 'Filter_reward_balance', false)) && Validate::isCleanHtml($_reward_balance_min)) {
                    $filter_where .= " AND reward_balance >= " . ($point == false ? (float)$_reward_balance_min : ((float)$_reward_balance_min / $point));
                }
                if (($_loy_rewards_min = Tools::getValue($prefix . 'Filter_loy_rewards', false)) && $_loy_rewards_min !== '' && Validate::isCleanHtml($_loy_rewards_min)) {
                    $filter_where .= " AND loy_rewards >= " . ($point == false ? (float)$_loy_rewards_min : ((float)$_loy_rewards_min / $point));
                }
                if (($_ref_rewards_min = Tools::getValue($prefix . 'Filter_ref_rewards', false)) && $_ref_rewards_min !== '' && Validate::isCleanHtml($_ref_rewards_min)) {
                    $filter_where .= " AND ref_rewards >= " . ($point == false ? (float)$_ref_rewards_min : ((float)$_ref_rewards_min / $point));
                }
                if (($_ref_orders_min = Tools::getValue($prefix . 'Filter_ref_orders', false)) && $_ref_orders_min !== '' && Validate::isCleanHtml($_ref_orders_min)) {
                    $filter_where .= " AND ref_orders >= " . (float)$_ref_orders_min;
                }
                if (($_aff_rewards_min = Tools::getValue($prefix . 'Filter_aff_rewards', false)) && $_aff_rewards_min !== '' && Validate::isCleanHtml($_aff_rewards_min)) {
                    $filter_where .= " AND aff_rewards >= " . ($point == false ? (float)$_aff_rewards_min : ((float)$_aff_rewards_min / $point));
                }
                if (($_mnu_rewards_min = Tools::getValue($prefix . 'Filter_mnu_rewards', false)) && $_mnu_rewards_min !== '' && Validate::isCleanHtml($_mnu_rewards_min)) {
                    $filter_where .= " AND mnu_rewards >= " . ($point == false ? (float)$_mnu_rewards_min : ((float)$_mnu_rewards_min / $point));
                }
                if (($_aff_orders_min = Tools::getValue($prefix . 'Filter_aff_orders', false)) && $_aff_orders_min !== '' && Validate::isCleanHtml($_aff_orders_min)) {
                    $filter_where .= " AND aff_orders >= " . (float)$_aff_orders_min;
                }
                if (($_total_withdraw_min = Tools::getValue($prefix . 'Filter_total_withdraws', false)) && $_total_withdraw_min !== '' && Validate::isCleanHtml($_total_withdraw_min)) {
                    $filter_where .= " AND total_withdraws >= " . ($point == false ? (float)$_total_withdraw_min : ((float)$_total_withdraw_min / $point));
                }
                if (($_reward_balance_max = Tools::getValue($prefix . 'Filter_reward_balance_max', false)) && $_reward_balance_max !== '' && Validate::isCleanHtml($_reward_balance_max)) {
                    $filter_where .= " AND reward_balance <= " . ($point == false ? (float)$_reward_balance_max : ((float)$_reward_balance_max / $point));
                }
                if (($_loy_rewards_max = Tools::getValue($prefix . 'Filter_loy_rewards_max', false)) && $_loy_rewards_max !== '' && Validate::isCleanHtml($_loy_rewards_max)) {
                    $filter_where .= " AND loy_rewards <= " . ($point == false ? (float)$_loy_rewards_max : ((float)$_loy_rewards_max / $point));
                }
                if (($_ref_rewards_max = Tools::getValue($prefix . 'Filter_ref_rewards_max', false)) && $_ref_rewards_max !== '' && Validate::isCleanHtml($_ref_rewards_max)) {
                    $filter_where .= " AND ref_rewards <= " . ($point == false ? (float)$_ref_rewards_max : ((float)$_ref_rewards_max / $point));
                }
                if (($_ref_orders_max = Tools::getValue($prefix . 'Filter_ref_orders_max', false)) && $_ref_orders_max !== '' && Validate::isCleanHtml($_ref_orders_max)) {
                    $filter_where .= " AND ref_orders <= " . (float)$_ref_orders_max;
                }
                if (($_aff_rewards_max = Tools::getValue($prefix . 'Filter_aff_rewards_max', false)) && $_aff_rewards_max !== '' && Validate::isCleanHtml($_aff_rewards_max)) {
                    $filter_where .= " AND aff_rewards <= " . ($point == false ? (float)$_aff_rewards_max : ((float)$_aff_rewards_max / $point));
                }
                if (($_mnu_rewards_max = Tools::getValue($prefix . 'Filter_mnu_rewards_max', false)) && $_mnu_rewards_max !== '' && Validate::isCleanHtml($_mnu_rewards_max)) {
                    $filter_where .= " AND mnu_rewards <= " . ($point == false ? (float)$_mnu_rewards_max : ((float)$_mnu_rewards_max / $point));
                }
                if (($_aff_orders_max = Tools::getValue($prefix . 'Filter_aff_orders_max', false)) && $_aff_orders_max !== '' && Validate::isCleanHtml($_aff_orders_max)) {
                    $filter_where .= " AND aff_orders <= " . (float)$_aff_orders_max;
                }
                if (($_total_withdraw_max = Tools::getValue($prefix . 'Filter_total_withdraws_max', false)) && $_total_withdraw_max !== '' && Validate::isCleanHtml($_total_withdraw_max)) {
                    $filter_where .= " AND total_withdraws <= " . ($point == false ? (float)$_total_withdraw_max : ((float)$_total_withdraw_max / $point));
                }
                $_has_reward = Tools::getValue($prefix . 'Filter_has_reward', false);
                if ($_has_reward !== '' && $_has_reward !== false) {
                    if ((int)$_has_reward == 1) {
                        $filter_where .= " AND has_reward =1";
                    } else {
                        $filter_where .= " AND (has_reward = 0 or has_reward = '' or has_reward is null)";
                    }
                }
                if (($_id_customer = Tools::getValue($prefix . 'Filter_id_customer', false)) && Validate::isCleanHtml($_id_customer)) {
                    $filter_where .= " AND app.id_customer = " . (int)$_id_customer;
                }
                if (($_username = Tools::getValue($prefix . 'Filter_username', false)) && Validate::isCleanHtml($_username)) {
                    $filter_where .= " AND username LIKE '%" . pSQL($_username) . "%'";
                }
                $_status = Tools::getValue($prefix . 'Filter_user_status', false);
                if ($_status !== false && $_status !== '' && Validate::isCleanHtml($_status)) {
                    $filter_where .= " AND (user_status = " . (int)$_status . " " . ($_status == 1 ? ' OR user_status is null' : '') . ")";
                }
            }
            if (!Tools::getIsset('submitFilter' . $prefix) && !Tools::getIsset('submitReset' . $prefix)) {
                $filter_where .= " AND has_reward  = 1";
                $filter_where .= " AND user_status =1";
            }
        }
        $helper->listTotal = EtsAmAdmin::{$params['nb']}(true, $filter_where);
        $args += array(
            'start' => $start,
            'limit' => $limit,
            'sort' => $params['alias'] . '.' . $order_by . ' ' . Tools::strtoupper($order_way),
        );
        if (!Tools::getIsset('submitFilter' . $helper->table) && !Tools::getIsset('submitReset' . $helper->table)) {
            $this->context->cookie->__set($helper->table . 'Filter_user_status', 1);
            $this->context->cookie->__set($helper->table . 'Filter_has_reward', 1);
        }
        if (Tools::getIsset('submitReset' . $helper->table)) {
            $this->context->cookie->__set($helper->table . 'Filter_has_reward', '');
        }
        $list = EtsAmAdmin::{$params['nb']}(false, $filter_where, Tools::getValue('orderBy'), Tools::getValue('orderWay'), (int)Tools::getValue('page'), (int)Tools::getValue('selected_pagination', 25), $having);
        $helper->orderWay = Tools::strtoupper($order_way);
        $helper->shopLinkType = '';
        $helper->row_hover = true;
        $helper->no_link = $params['no_link'];
        $helper->simple_header = false;
        $helper->actions = !(isset($params['id_customer'])) ? $params['actions'] : array();
        $this->_helperlist = $helper;
        $helper->show_toolbar = false;
        $helper->page = 4;
        $helper->tpl_vars = array(
            'page' => $submit ?: (int)Context::getContext()->cookie->submitFilterreward_users,
        );
        if ($params['toolbar_btn'])
            $helper->toolbar_btn = $params['toolbar_btn'];
        $helper->module = $this;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name . '&tabActive=reward_users';
        $helper->bulk_actions = $params['bulk_actions'] ? $params['bulk_actions'] : false;
        $helper->actions = array('view', 'active');
        $this->context->smarty->assign(
            array(
                'aff_link_search_customer' => $this->context->link->getAdminLink('AdminEtsAmAffiliate') . '&ajax_search_customer=1',
            )
        );
        if (isset($params['id_customer']) && $params['id_customer']) {
            return $helper->generateList($list, $fields_list);
        }
        $this->_html .= (!empty($params['html']) ? $params['html'] : '') . $helper->generateList($list, $fields_list);
    }
    public function getBaseLink()
    {
        $link = (Configuration::get('PS_SSL_ENABLED_EVERYWHERE') ? 'https://' : 'http://') . $this->context->shop->domain . $this->context->shop->getBaseURI();
        return trim($link, '/');
    }
    public function displayActiveLink($token = null, $id)
    {
        $customer = new Customer($id);
        if ($token) {
        }
        $user = array();
        if ($customer && $customer->id) {
            $user = Ets_User::getUserByCustomerId($id);
        }
        $this->smarty->assign(array(
            'customer' => $customer,
            'user' => $user,
            'item_id' => $id
        ));
        return $this->display(__FILE__, 'helper_active_link.tpl');
    }
    /**
     * @param $params
     * @return bool
     * @throws PrestaShopException
     */
    public function maxFilter($key, $value)
    {
        $search_max = array(
            'reward_balance',
            'loy_rewards',
            'ref_rewards',
            'ref_orders',
            'aff_rewards',
            'aff_orders',
            'total_withdraws',
        );
        foreach ($search_max as $max) {
            if (stripos($key, $max) !== -1) {
                $index = $key . '_max';
                $this->context->cookie->{$index} = !is_array($value) ? $value : serialize($value);
            }
        }
        $this->context->cookie->write();
    }
    public function processFilter($params)
    {
        if (empty($params) || empty($params['list_id']))
            return false;
        if (!empty($_POST) && isset($params['list_id'])) {
            foreach ($_POST as $key => $value) {
                if ($value === '') {
                    unset($this->context->cookie->{$key});
                } elseif (stripos($key, $params['list_id'] . 'Filter_') === 0) {
                    $this->context->cookie->{$key} = !is_array($value) ? $value : serialize($value);
                } elseif (stripos($key, 'submitFilter') === 0) {
                    $this->context->cookie->$key = !is_array($value) ? $value : serialize($value);
                }
            }
        }
        if (!empty($_GET) && isset($params['list_id'])) {
            foreach ($_GET as $key => $value) {
                if (stripos($key, $params['list_id'] . 'Filter_') === 0) {
                    $this->maxFilter($key, $value);
                    $this->context->cookie->{$key} = !is_array($value) ? $value : serialize($value);
                } elseif (stripos($key, 'submitFilter') === 0) {
                    $this->context->cookie->$key = !is_array($value) ? $value : serialize($value);
                }
                if (stripos($key, $params['list_id'] . 'Orderby') === 0 && Validate::isOrderBy($value)) {
                    if ($value === '' || $value == $params['orderBy']) {
                        unset($this->context->cookie->{$key});
                    } else {
                        $this->context->cookie->{$key} = $value;
                    }
                } elseif (stripos($key, $params['list_id'] . 'Orderway') === 0 && Validate::isOrderWay($value)) {
                    if ($value === '' || $value == $params['orderWay']) {
                        unset($this->context->cookie->{$key});
                    } else {
                        $this->context->cookie->{$key} = $value;
                    }
                }
            }
        }
        $filters = $this->context->cookie->getFamily($params['list_id'] . 'Filter_');
        foreach ($filters as $key => $value) {
            /* Extracting filters from $_POST on key filter_ */
            if ($value != null && !strncmp($key, $params['list_id'] . 'Filter_', 7 + Tools::strlen($params['list_id']))) {
                $key = Tools::substr($key, 7 + Tools::strlen($params['list_id']));
                /* Table alias could be specified using a ! eg. alias!field */
                $tmp_tab = explode('!', $key);
                $filter = count($tmp_tab) > 1 ? $tmp_tab[1] : $tmp_tab[0];
                if ($field = $this->filterToField($key, $filter, $params['fields_list'])) {
                    $type = (array_key_exists('filter_type', $field) ? $field['filter_type'] : (array_key_exists('type', $field) ? $field['type'] : false));
                    if (($type == 'date' || $type == 'datetime') && is_string($value))
                        $value = Tools::unSerialize($value);
                    $key = isset($tmp_tab[1]) ? $tmp_tab[0] . '.`' . $tmp_tab[1] . '`' : '`' . $tmp_tab[0] . '`';
                    $sql_filter = '';
                    /* Only for date filtering (from, to) */
                    if (is_array($value)) {
                        if (isset($value[0]) && !empty($value[0])) {
                            if (!Validate::isDate($value[0])) {
                                $this->errors[] = Tools::displayError('The \'From\' date format is invalid (YYYY-MM-DD)');
                            } else {
                                $sql_filter .= ' AND ' . pSQL($key) . ' >= \'' . pSQL(Tools::dateFrom($value[0])) . '\'';
                            }
                        }
                        if (isset($value[1]) && !empty($value[1])) {
                            if (!Validate::isDate($value[1])) {
                                $this->errors[] = Tools::displayError('The \'To\' date format is invalid (YYYY-MM-DD)');
                            } else {
                                $sql_filter .= ' AND ' . pSQL($key) . ' <= \'' . pSQL(Tools::dateTo($value[1])) . '\'';
                            }
                        }
                    } else {
                        $sql_filter .= ' AND ';
                        $check_key = ($key == 'id_' . $params['list_id'] || $key == '`id_' . $params['list_id'] . '`');
                        $alias = $params['alias'];
                        if ($type == 'int' || $type == 'bool') {
                            $sql_filter .= (($check_key || $key == '`active`') ? pSQL($alias) . '.' : '') . pSQL($key) . ' = ' . (int)($key == '`position`' ? $value - 1 : $value) . ' ';
                        } elseif ($type == 'decimal') {
                            $sql_filter .= ($check_key ? pSQL($alias) . '.' : '') . pSQL($key) . ' = ' . (float)$value . ' ';
                        } elseif ($type == 'select') {
                            $sql_filter .= ($check_key ? pSQL($alias) . '.' : '') . pSQL($key) . ' = \'' . pSQL($value) . '\' ';
                        } elseif ($type == 'price') {
                            $value = (float)str_replace(',', '.', $value);
                            $sql_filter .= ($check_key ? pSQL($alias) . '.' : '') . pSQL($key) . ' = ' . pSQL(trim($value)) . ' ';
                        } else {
                            $sql_filter .= ($check_key ? pSQL($alias) . '.' : '') . pSQL($key) . ' LIKE \'%' . pSQL(trim($value)) . '%\' ';
                        }
                    }
                    if (isset($field['havingFilter']) && $field['havingFilter'])
                        $this->_filterHaving .= $sql_filter;
                    else
                        $this->_filter .= $sql_filter;
                }
            }
        }
    }
    /**
     * @param $key
     * @param $filter
     * @param $fields_list
     * @return bool
     */
    protected function filterToField($key, $filter, $fields_list)
    {
        if (empty($fields_list))
            return false;
        foreach ($fields_list as $field)
            if (array_key_exists('filter_key', $field) && $field['filter_key'] == $key)
                return $field;
        if (array_key_exists($filter, $fields_list))
            return $fields_list[$filter];
        return false;
    }
    /**
     * @param $params
     */
    public function initToolbar($params)
    {
        $this->toolbar_btn['new'] = array(
            'href' => AdminController::$currentIndex . '&configure=' . $this->name . $params['list_id'] . '&token=' . Tools::getAdminTokenLite('AdminModules'),
            'desc' => $this->l('Add') . ' ' . Tools::strtolower($params['title']),
        );
    }
    protected function loadmoreSponsors($sponsors)
    {
        $this->smarty->assign(array(
            'sponsors' => $sponsors
        ));
        return $this->display(__FILE__, 'user/paginate_sponsors.tpl');
    }
    protected function loadmoreRewardHistory($histories)
    {
        $this->smarty->assign(array(
            'reward_history' => $histories
        ));
        return $this->display(__FILE__, 'user/paginate_history_reward.tpl');
    }
    public function renderImportExportForm()
    {
        if (Tools::isSubmit('exportAllData', false)) {
            $export = new Ets_ImportExport();
            $export->generateArchive();
        } elseif (Tools::isSubmit('importAllData', false)) {
            $import = new Ets_ImportExport();
            $this->context->smarty->assign(
                array(
                    'restore_reward' => (int)Tools::getValue('restore_reward', false),
                    'restore_config' => (int)Tools::getValue('restore_config', false),
                    'delete_reawrd' => (int)Tools::getValue('delete_reawrd', false),
                )
            );
            $errors = $import->processImport(false,
                (int)Tools::getValue('restore_reward', false) ? true : false,
                (int)Tools::getValue('restore_config', false) ? true : false,
                (int)Tools::getValue('delete_reward', false) ? true : false
            );
            if ($errors) {
                $this->_html .= $this->displayError($errors);
            } else {
                $this->_html .= $this->displayConfirmation($this->l('Import successfully'));
            }
        }
        $this->_html .= $this->display(__FILE__, 'import_export.tpl');
    }
    public function getSearchSuggestions($query, $query_type)
    {
        $results = EtsAmAdmin::getSearchSuggestionsReward($query, $query_type);
        $this->smarty->assign(array(
            'results' => $results,
        ));
        return $this->display(__FILE__, 'search_suggestion.tpl');
    }
    public function hookDisplayCustomerAccountForm($params)
    {
        if ((int)Configuration::get('ETS_AM_REF_ENABLED') && !$this->context->customer->logged) {
            $ref = $this->context->cookie->__get(EAM_REFS);
            $email_sponsor = '';
            if ($ref) {
                $customer = new Customer((int)$ref);
                if ($customer) {
                    $email_sponsor = $customer->email;
                }
            }
            $this->smarty->assign(array(
                'query' => Tools::getAllValues(),
                'email_sponsor' => $email_sponsor,
                'is17' => $this->is17,
            ));
            return $this->display(__FILE__, 'reg_code_ref.tpl');
        }
        return '';
    }
    public function removeImages()
    {
        if (is_dir(EAM_PATH_IMAGE_BANER)) {
            $dir = scandir(EAM_PATH_IMAGE_BANER);
            if (!empty($dir)) {
                foreach ($dir as $file) {
                    if ($file !== '.' && $file !== '..' && $file !== 'index.php' && file_exists(EAM_PATH_IMAGE_BANER . $file)) {
                        @unlink(EAM_PATH_IMAGE_BANER . $file);
                    }
                }
            }
            Ets_affiliatemarketing::removeDir(EAM_PATH_IMAGE_BANER . 'qrcode');
        }
        return true;
    }
    public function clearLog()
    {
        if(file_exists( _PS_ETS_EAM_LOG_DIR_ . '/aff_cronjob.log'))
            @unlink(_PS_ETS_EAM_LOG_DIR_ . '/aff_cronjob.log');
        return true;
    }
    public function getAffiliateMessage($data)
    {
        $this->smarty->assign($data);
        return $this->display(__FILE__, 'affiliate_message.tpl');
    }
    public function getHtmlColum($params = array())
    {
        $this->smarty->assign($params);
        return $this->display(__FILE__, 'html_col.tpl');
    }
    public function cronjobSettings()
    {
        $cronjob_last = '';
        $run_cronjob = false;
        if ($cronjob_time = Configuration::getGlobalValue('ETS_AM_TIME_RUN_CRONJOB')) {
            $last_time = strtotime($cronjob_time);
            $time = strtotime(date('Y-m-d H:i:s')) - $last_time;
            if ($time <= 43200 && $time)
                $run_cronjob = true;
            else
                $run_cronjob = false;
            if ($time > 86400)
                $cronjob_last = $cronjob_time;
            elseif ($time) {
                if ($hours = floor($time / 3600)) {
                    $cronjob_last .= $hours . ' ' . $this->l('hours') . ' ';
                    $time = $time % 3600;
                }
                if ($minutes = floor($time / 60)) {
                    $cronjob_last .= $minutes . ' ' . $this->l('minutes') . ' ';
                    $time = $time % 60;
                }
                if ($time)
                    $cronjob_last .= $time . ' ' . $this->l('seconds') . ' ';
                $cronjob_last .= $this->l('ago');
            }
        }
        $this->smarty->assign(array(
            'cronjob_token' => Configuration::getGlobalValue('ETS_AM_CRONJOB_TOKEN'),
            'cronjob_link' => $this->context->link->getAdminLink('AdminEtsAmCronjob'),
            'cronjob_dir' => _PS_MODULE_DIR_ . 'ets_affiliatemarketing/cronjob.php',
            'cronjob_demo' => Ets_AM::getBaseUrl(true) . 'cronjob.php',
            'cronjob_last' => $cronjob_last,
            'run_cronjob' => $run_cronjob,
            'loyaltyPrograEnabled' => Configuration::get('ETS_AM_LOYALTY_ENABLED'),
            'loyaltyRewardAvailability' => Configuration::get('ETS_AM_LOYALTY_MAX_DAY'),
            'php_path' => (defined('PHP_BINDIR') && PHP_BINDIR && is_string(PHP_BINDIR) ? PHP_BINDIR . '/' : '') . 'php',
        ));
        $this->_html .= $this->display(__FILE__, 'cronjob_settings.tpl');
    }
    public function generateTokenCronjob()
    {
        $code = $this->generateRandomString();
        Configuration::updateGlobalValue('ETS_AM_CRONJOB_TOKEN', $code);
    }
    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = Tools::strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function cronjobHistory()
    {
        if (Tools::isSubmit('ETS_AM_SAVE_LOG')) {
            $ETS_AM_SAVE_LOG = (int)Tools::getValue('ETS_AM_SAVE_LOG');
            Configuration::updateGlobalValue('ETS_AM_SAVE_LOG', $ETS_AM_SAVE_LOG);
            die(
            json_encode(array(
                'success' => $this->l('Updated successful')
            ))
            );
        }
        $log_path = _PS_ETS_EAM_LOG_DIR_ . 'aff_cronjob.log';
        $log = '';
        if (file_exists($log_path)) {
            $log = Tools::file_get_contents($log_path);
        }
        $cronjob_last = '';
        if ($cronjob_time = Configuration::getGlobalValue('ETS_AM_TIME_RUN_CRONJOB')) {
            $last_time = strtotime($cronjob_time);
            $time = strtotime(date('Y-m-d H:i:s')) - $last_time;
            if ($time <= 43200 && $time)
                $run_cronjob = true;
            else
                $run_cronjob = false;
            if ($time > 86400)
                $cronjob_last = $cronjob_time;
            elseif ($time) {
                if ($hours = floor($time / 3600)) {
                    $cronjob_last .= $hours . ' ' . $this->l('hours') . ' ';
                    $time = $time % 3600;
                }
                if ($minutes = floor($time / 60)) {
                    $cronjob_last .= $minutes . ' ' . $this->l('minutes') . ' ';
                    $time = $time % 60;
                }
                if ($time)
                    $cronjob_last .= $time . ' ' . $this->l('seconds') . ' ';
                $cronjob_last .= $this->l('ago');
            }
        } else
            $run_cronjob = false;
        $this->smarty->assign(array(
            'log' => $log,
            'ETS_AM_SAVE_LOG' => Configuration::getGlobalValue('ETS_AM_SAVE_LOG'),
            'post_url' => $this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name,
            'cronjob_last' => $cronjob_last,
            'run_cronjob' => $run_cronjob,
            'loyaltyPrograEnabled' => Configuration::get('ETS_AM_LOYALTY_ENABLED'),
            'loyaltyRewardAvailability' => Configuration::get('ETS_AM_LOYALTY_MAX_DAY'),
        ));
        $this->_html = $this->display(__FILE__, 'cronjob_history.tpl');
    }
    public function getPercentReward($params = array())
    {
        if (($filter_date_from = Tools::getValue('filter_date_from')) && Validate::isDate($filter_date_from)) {
            $params['date_from'] = $filter_date_from;
        }
        if (($filter_date_to = Tools::getValue('filter_date_to')) && Validate::isDate($filter_date_to)) {
            $params['date_to'] = $filter_date_to;
        }
        if (($filter_date_type = Tools::getValue('filter_date_type')) && Validate::isCleanHtml($filter_date_type)) {
            $params['date_type'] = $filter_date_type;
        }
        die(json_encode(Ets_AM::getPercentReward($params)));
    }
    public function getBreadcrumb()
    {
        $controller = Tools::getValue('controller');
        $node = array();
        $node[] = array(
            'title' => $this->l('Home'),
            'url' => $this->context->link->getPageLink('index', true),
        );
        $node[] = array(
            'title' => $this->l('Your account'),
            'url' => $this->context->link->getPageLink('my-account', true),
        );
        if ($controller == 'aff_products') {
            $node[] = array(
                'title' => $this->l('Affiliate program'),
                'url' => $this->context->link->getModuleLink($this->name, 'aff_products'),
            );
            $node[] = array(
                'title' => $this->l('Affiliate Products'),
                'url' => $this->context->link->getModuleLink($this->name, 'aff_products'),
            );
        }
        if ($controller == 'my_sale') {
            $node[] = array(
                'title' => $this->l('Affiliate program'),
                'url' => $this->context->link->getModuleLink($this->name, 'aff_products'),
            );
            $node[] = array(
                'title' => $this->l('My sales'),
                'url' => $this->getLinks('my_sale')
            );
            if (($id_product = (int)Tools::getValue('id_product', false))) {
                $product = new Product($id_product, false, (int)$this->context->language->id);
                $product_link = Ets_Affiliate::generateAffiliateLinkForProduct($product, $this->context, false);
                $node[] = array(
                    'title' => $product->name,
                    'url' => $product_link
                );
            } elseif (($tab_active = Tools::getValue('tab_active', false)) && $tab_active == 'statistics') {
                $node[] = array(
                    'title' => $this->l('Statistics'),
                    'url' => $this->getLinks('my_sale', array('tab_active' => 'statistics'))
                );
            }
        }
        if ($controller == 'myfriend') {
            if (($tab = Tools::getValue('tab', false)) && $tab == 'how-to-refer-friends') {
                $node[] = array(
                    'title' => $this->l('Referral program'),
                    'url' => $this->getLinks('refer_friends')
                );
                $node[] = array(
                    'title' => $this->l('How to refer friends'),
                    'url' => $this->getLinks('myfriend', array('tab' => 'how-to-refer-friends'))
                );
            } else {
                $node[] = array(
                    'title' => $this->l('Referral program'),
                    'url' => $this->getLinks('refer_friends')
                );
                $node[] = array(
                    'title' => $this->l('My friends'),
                    'url' => $this->getLinks('myfriend')
                );
            }
        }
        if ($controller == 'refer_friends') {
            $node[] = array(
                'title' => $this->l('Referral program'),
                'url' => $this->getLinks('refer_friends')
            );
            $node[] = array(
                'title' => $this->l('How to refer friends'),
                'url' => $this->getLinks('refer-friends')
            );
        }
        if ($controller == 'loyalty') {
            $node[] = array(
                'title' => $this->l('Loyalty program'),
                'url' => $this->getLinks('loyalty')
            );
        }
        if ($controller == 'register') {
            $node[] = array(
                'title' => $this->l('Register program'),
                'url' => $this->getLinks('register')
            );
        }
        if ($controller == 'dashboard') {
            $node[] = array(
                'title' => $this->l('My rewards'),
                'url' => $this->getLinks('dashboard')
            );
            $node[] = array(
                'title' => $this->l('Dashboard'),
                'url' => $this->getLinks('dashboard')
            );
        }
        if ($controller == 'history') {
            $node[] = array(
                'title' => $this->l('My rewards'),
                'url' => $this->getLinks('dashboard')
            );
            $node[] = array(
                'title' => $this->l('Reward history'),
                'url' => $this->getLinks('history')
            );
        }
        if ($controller == 'withdraw') {
            $node[] = array(
                'title' => $this->l('My rewards'),
                'url' => $this->getLinks('dashboard')
            );
            $node[] = array(
                'title' => $this->l('Withdrawals'),
                'url' => $this->getLinks('withdraw')
            );
        }
        if ($controller == 'voucher') {
            $node[] = array(
                'title' => $this->l('My rewards'),
                'url' => $this->getLinks('dashboard')
            );
            $node[] = array(
                'title' => $this->l('Convert into vouchers'),
                'url' => $this->getLinks('voucher')
            );
        }
        if ($this->is17)
            return array('links' => $node, 'count' => count($node));
        return $this->displayBreadcrumb($node);
    }
    public function getLinks($controller, $params = array())
    {
        if ($controller == 'aff_product') {
            return Ets_AM::getBaseUrlDefault('aff_product', $params);
        } elseif ($controller == 'my_sale') {
            return Ets_AM::getBaseUrlDefault('my_sale', $params);
        } elseif ($controller == 'myfriend') {
            if (!$params) {
                return Ets_AM::getBaseUrlDefault('myfriend', $params);
            } elseif ($params && isset($params['tab']) && $params['tab'] == 'how-to-refer-friends') {
                return Ets_AM::getBaseUrlDefault('myfriend', array('tab' => 'tab=how-to-refer-friends'));
            }
        } elseif ($controller == 'refer_friends')
            return Ets_AM::getBaseUrlDefault('refer_friends', $params);
        elseif ($controller == 'loyalty') {
            return Ets_AM::getBaseUrlDefault('loyalty', $params);
        } elseif ($controller == 'dashboard') {
            return Ets_AM::getBaseUrlDefault('dashboard', $params);
        } elseif ($controller == 'history') {
            return Ets_AM::getBaseUrlDefault('history', $params);
        } elseif ($controller == 'withdraw') {
            return Ets_AM::getBaseUrlDefault('withdraw', $params);
        } elseif ($controller == 'voucher') {
            return Ets_AM::getBaseUrlDefault('voucher', $params);
        } elseif ($controller == 'register') {
            return Ets_AM::getBaseUrlDefault('register', $params);
        }
        return '/';
    }
    public function displayBreadcrumb($node = array())
    {
        if ($node) {
            $this->smarty->assign(array(
                'nodes' => $node,
            ));
            return $this->display(__FILE__, 'breadcrumb.tpl');
        }
        return '';
    }
    public function saveCartRule($id_cart_rule = 0)
    {
        $languages = Language::getLanguages(false);
        if ($id_cart_rule) {
            $cartRuleObj = new CartRule($id_cart_rule);
            $cartRuleObj->active = Configuration::get('ETS_AM_SELL_OFFER_VOUCHER') ? 1 : 0;
        } else {
            $quantity = (int)Configuration::get('ETS_AM_SELL_QUANTITY') ?: 999;
            $prefix = Configuration::get('ETS_AM_SELL_DISCOUNT_PREFIX');
            $code = Ets_AM::generatePromoCode($prefix);
            $discount_in = Configuration::get('ETS_AM_SELL_APPLY_DISCOUNT_IN');
            $cartRuleObj = new CartRule();
            $cartRuleObj->quantity = $quantity;
            $cartRuleObj->code = $code;
            $cartRuleObj->date_from = date('Y-m-d H:i:s');
            $cartRuleObj->date_to = date('Y-m-d H:i:s', strtotime('+' . $discount_in . 'days', strtotime(date('Y-m-d H:i:s'))));
            foreach ($languages as $lang) {
                $cartRuleObj->name[(int)$lang['id_lang']] = Configuration::get('ETS_AM_SELL_DISCOUNT_DESC', $lang['id_lang']);
            }
            $cartRuleObj->active = 1;
            $cartRuleObj->id_customer = 0;
            $cartRuleObj->reduction_exclude_special = (int)Configuration::get('ETS_AM_SELL_EXCLUDE_SPECIAL');
        }
        $discount_percent = Configuration::get('ETS_AM_SELL_APPLY_DISCOUNT') == 'PERCENT' ? Configuration::get('ETS_AM_SELL_REDUCTION_PERCENT') : 0;
        $discount_amount = Configuration::get('ETS_AM_SELL_APPLY_DISCOUNT') == 'AMOUNT' ? Configuration::get('ETS_AM_SELL_REDUCTION_AMOUNT') : 0;
        $id_currency = Configuration::get('ETS_AM_SELL_ID_CURRENCY');
        $reduction_tax = Configuration::get('ETS_AM_SELL_REDUCTION_TAX');
        $free_shipping = Configuration::get('ETS_AM_SELL_FREE_SHIPPING');
        $voucher_min_amount = Configuration::get('ETS_AM_SELL_DISCOUNT_MIN_AMOUNT');
        $voucher_min_amount_currency = Configuration::get('ETS_AM_SELL_DISCOUNT_MIN_AMOUNT_CURRENCY');
        $voucher_min_amount_tax = Configuration::get('ETS_AM_SELL_DISCOUNT_MIN_AMOUNT_TAX');
        $voucher_min_amount_shipping = Configuration::get('ETS_AM_SELL_DISCOUNT_MIN_AMOUNT_SHIPPING');
        $cartRuleObj->quantity_per_user = 1;
        $cartRuleObj->reduction_percent = $discount_percent;
        $cartRuleObj->reduction_amount = $discount_amount;
        $cartRuleObj->reduction_currency = $id_currency;
        $cartRuleObj->reduction_product = 0;
        $cartRuleObj->reduction_tax = $reduction_tax;
        $cartRuleObj->free_shipping = $free_shipping;
        $cartRuleObj->minimum_amount = $voucher_min_amount;
        if ($voucher_min_amount) {
            $cartRuleObj->minimum_amount_tax = $voucher_min_amount_tax;
            $cartRuleObj->minimum_amount_currency = $voucher_min_amount_currency;
            $cartRuleObj->minimum_amount_shipping = $voucher_min_amount_shipping;
        }
        if ($id_cart_rule)
            $cartRuleObj->update();
        elseif (!$cartRuleObj->add())
            return false;
        if (!$id_cart_rule && $cartRuleObj->id) {
            Ets_Voucher::AddCartRuleCombination($cartRuleObj);
        }
        return $cartRuleObj;
    }
    public function ajaxSearchFriends()
    {
        if (($customer = Tools::getValue('customer')) && Validate::isCleanHtml($customer)) {
            $id_customer = (int)Tools::getValue('id_reward_users');
            $customers = Ets_Sponsor::searchFriends($customer, $id_customer);
            $this->context->smarty->assign(
                array(
                    'customers' => $customers,
                )
            );
            die(
            json_encode(
                array(
                    'list_customers' => $this->display(__FILE__, 'user/list_customer.tpl'),
                )
            )
            );
        }
    }
    public function ajaxAddFriend()
    {
        $id_sponsor = (int)Tools::getValue('id_customer');
        $customerParent = new Customer($id_sponsor);
        $id_customer = (int)Tools::getValue('id_friend');
        $customerFriend = new Customer($id_customer);
        if ($id_sponsor != $id_customer && Validate::isLoadedObject($customerFriend) && Validate::isLoadedObject($customerParent) && ($sponsor = Ets_Sponsor::addFriend($id_sponsor, $id_customer))) {
            die(
            json_encode(
                array(
                    'success' => $this->l('Added successful'),
                    'sponsor' => (array)$sponsor,
                )
            )
            );
        } else {
            die(
            json_encode(
                array(
                    'errors' => $this->l('This customer is already in friends list of another sponsor'),
                )
            )
            );
        }
    }
    public function hookDisplayOrderConfirmation()
    {
        if (($id_order = (int)Tools::getValue('id_order')) && ($order = new Order($id_order)) && Validate::isLoadedObject($order) && $order->id_customer == Context::getContext()->customer->id && ($reward = Ets_AM::getRewardByIDOrder($id_order, 'loy'))) {
            $reward['status'] = trim($this->getStatus($reward['status']));
            $msg = Configuration::get('ETS_AM_LOYALTY_MSG_ORDER', $this->context->language->id);
            $this->context->smarty->assign(
                array(
                    'loyaty_msg' => str_replace(array('[amount]', '[reward_status]'), array(Configuration::get('ETS_AM_REWARD_DISPLAY') == 'point' ? Ets_AM::displayReward($reward['total_amount']) : Ets_affiliatemarketing::displayPrice(Tools::convertPrice($reward['total_amount'])), $reward['status']), $msg),
                )
            );
            return $this->display(__FILE__, 'order_confirmation.tpl');
        }
    }
    public function getStatus($status)
    {
        switch ($status) {
            case 0:
                return $this->displayHtml($this->l('Pending'), 'span', 'loy_status pending');
            case 1:
                return $this->displayHtml($this->l('Approved'), 'span', 'loy_status approved');
            case -1:
                return $this->displayHtml($this->l('Canceled'), 'span', 'loy_status canceled');
            case -2:
                return $this->displayHtml($this->l('Expired'), 'span', 'loy_status expired');
        }
        return '';
    }
    public function getPopupDefault()
    {
        return $this->display(__FILE__, 'ref_popup_default_content.tpl');
    }
    public function displaySuccessMessage($msg, $title = false, $link = false)
    {
        $this->smarty->assign(array(
            'msg' => $msg,
            'title' => $title,
            'link' => $link
        ));
        if ($msg)
            return $this->display(__FILE__, 'success_message.tpl');
    }
    public static function displayPrice($price, $currency = null)
    {
        if(!is_object($currency))
            $currency = (int)$currency;
        return Tools::displayPrice(Tools::ps_round($price,2), $currency);
    }
    public static function getContextLocale(Context $context)
    {
        $locale = $context->getCurrentLocale();
        if (null !== $locale) {
            return $locale;
        }
        $container = isset($context->controller) ? $context->controller->getContainer() : null;
        if (null === $container) {
            $container = call_user_func(array('SymfonyContainer', 'getInstance'));
        }
        /** @var LocaleRepository $localeRepository */
        $localeRepository = $container->get(self::SERVICE_LOCALE_REPOSITORY);
        $locale = $localeRepository->getLocale(
            $context->language->getLocale()
        );
        return $locale;
    }
    public function hookActionFrontControllerAfterInit()
    {
        if (($code = Tools::getValue('discount_name')) && (Tools::getValue('controller') == 'cart' || Tools::getValue('controller') == 'order') && Tools::isSubmit('addDiscount') && (Tools::isSubmit('ajax') || Tools::isSubmit('ajax_request')))
            Ets_Voucher::getInstance()->checkCartRuleValidity($code);
    }
    public function addOverride($classname)
    {
        if (Module::isInstalled('ets_abandonedcart') && $classname == 'CartRule')
            return true;
        return parent::addOverride($classname);
    }
    public function removeOverride($classname)
    {
        if (Module::isInstalled('ets_abandonedcart') && $classname == 'CartRule')
            return true;
        return parent::removeOverride($classname);
    }
    public static function loyRewardUsed($usageLOY, $id_reward_usage, $id_customer = 0)
    {
        if (!$id_customer)
            $id_customer = Context::getContext()->customer->id;
        $id_shop = Context::getContext()->shop->id;
        $sql = 'SELECT id_ets_am_reward,amount FROM `' . _DB_PREFIX_ . 'ets_am_reward` WHERE used=0 AND id_shop="' . (int)$id_shop . '" AND id_customer="' . (int)$id_customer . '" AND status=1 AND deleted=0 AND program="' . pSQL(EAM_AM_LOYALTY_REWARD) . '" ORDER BY datetime_added ASC';
        $rewards = Db::getInstance()->executeS($sql);
        if ($rewards) {
            foreach ($rewards as $reward) {
                if ($usageLOY > 0) {
                    Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'ets_am_reward` SET used="' . (int)$id_reward_usage . '" WHERE id_ets_am_reward= "' . (int)$reward['id_ets_am_reward'] . '"');
                    $usageLOY = Tools::ps_round($usageLOY - $reward['amount'], 2);
                    if ($usageLOY < 0) {
                        $usageLOY = -1 * $usageLOY;
                        $new_reward = new Ets_AM($reward['id_ets_am_reward']);
                        $new_reward->amount = $new_reward->amount - $usageLOY;
                        if ($new_reward->update()) {
                            $new_reward->amount = $usageLOY;
                            $new_reward->used = 0;
                            unset($new_reward->id);
                            $new_reward->add();
                        }
                        break;
                    }
                } else
                    break;
            }
        }
    }
    public function renderCategoryTree($params)
    {
        $tree = new HelperTreeCategories($params['tree']['id'], isset($params['tree']['title']) ? $params['tree']['title'] : null);
        if (isset($params['name'])) {
            $tree->setInputName($params['name']);
        }
        if (isset($params['tree']['selected_categories'])) {
            $tree->setSelectedCategories($params['tree']['selected_categories']);
        }
        if (isset($params['tree']['disabled_categories'])) {
            $tree->setDisabledCategories($params['tree']['disabled_categories']);
        }
        if (isset($params['tree']['root_category'])) {
            $tree->setRootCategory($params['tree']['root_category']);
        }
        if (isset($params['tree']['use_search'])) {
            $tree->setUseSearch($params['tree']['use_search']);
        }
        if (isset($params['tree']['use_checkbox'])) {
            $tree->setUseCheckBox($params['tree']['use_checkbox']);
        }
        if (isset($params['tree']['set_data'])) {
            $tree->setData($params['tree']['set_data']);
        }
        return $tree->render();
    }
    public function getTextLang($text, $lang, $file_name = '')
    {
        if (is_array($lang))
            $iso_code = $lang['iso_code'];
        elseif (is_object($lang))
            $iso_code = $lang->iso_code;
        else {
            $language = new Language($lang);
            $iso_code = $language->iso_code;
        }
        $modulePath = rtrim(_PS_MODULE_DIR_, '/') . '/' . $this->name;
        $fileTransDir = $modulePath . '/translations/' . $iso_code . '.' . 'php';
        if (!@file_exists($fileTransDir)) {
            return $text;
        }
        $fileContent = Tools::file_get_contents($fileTransDir);
        $text_tras = preg_replace("/\\\*'/", "\'", $text);
        $strMd5 = md5($text_tras);
        $keyMd5 = '<{' . $this->name . '}prestashop>' . ($file_name ?: $this->name) . '_' . $strMd5;
        preg_match('/(\$_MODULE\[\'' . preg_quote($keyMd5) . '\'\]\s*=\s*\')(.*)(\';)/', $fileContent, $matches);
        if ($matches && isset($matches[2])) {
            return $matches[2];
        }
        return $text;
    }
    public function displayHtml($content = null, $tag, $class = null, $id = null, $href = null, $blank = false, $src = null, $name = null, $value = null, $type = null, $data_id_product = null, $rel = null, $attr_datas = null)
    {
        $this->smarty->assign(
            array(
                'content' => $content,
                'tag' => $tag,
                'class' => $class,
                'id' => $id,
                'href' => $href,
                'blank' => $blank,
                'src' => $src,
                'name' => $name,
                'value' => $value,
                'type' => $type,
                'data_id_product' => $data_id_product,
                'attr_datas' => $attr_datas,
                'rel' => $rel,
            )
        );
        return $this->display(__FILE__, 'html.tpl');
    }
    public static function validateArray($array, $validate = 'isCleanHtml')
    {
        if (!is_array($array))
            return false;
        if (method_exists('Validate', $validate)) {
            if ($array && is_array($array)) {
                $ok = true;
                foreach ($array as $val) {
                    if (!is_array($val)) {
                        if ($val && !Validate::$validate($val)) {
                            $ok = false;
                            break;
                        }
                    } else
                        $ok = self::validateArray($val, $validate);
                }
                return $ok;
            }
        }
        return true;
    }
    public static function isImageName($name)
    {
        $allowedTypes = array('png', 'jpg', 'jpeg', 'gif');
        return Validate::isString($name) && $name != '' && in_array(Tools::substr(strrchr($name, '.'), 1), $allowedTypes) && in_array(pathinfo($name, PATHINFO_EXTENSION), $allowedTypes) ? true : false;
    }
    public static function removeDir($dir)
    {
        $dir = rtrim($dir, '/');
        if ($dir && is_dir($dir)) {
            if ($objects = scandir($dir)) {
                foreach ($objects as $object) {
                    if ($object != "." && $object != "..") {
                        if (is_dir($dir . "/" . $object) && !is_link($dir . "/" . $object))
                            self::removeDir($dir . "/" . $object);
                        else
                            @unlink($dir . "/" . $object);
                    }
                }
            }
            rmdir($dir);
        }
    }
    public static function copyDir($src, $dst)
    {
        if (!file_exists($src))
            return true;
        $dir = opendir($src);
        if (!is_dir($dst))
            @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    self::copyDir($src . '/' . $file, $dst . '/' . $file);
                } elseif (!file_exists($dst . '/' . $file)) {
                    @copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
    public static function makeCacheDir()
    {
        $cacheDir = _PS_CACHE_DIR_ . 'ets_affiliatemarketing/';
        if (!is_dir($cacheDir))
            @mkdir($cacheDir, 0755, true);
    }
}
