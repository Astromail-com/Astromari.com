<?php
/**
 * NOTICE OF LICENSE
 *
 * @author    INVERTUS, UAB www.invertus.eu <support@invertus.eu>
 * @copyright Copyright (c) permanent, INVERTUS, UAB
 * @license   MIT
 * @see       /LICENSE
 *
 *  International Registered Trademark & Property of INVERTUS, UAB
 */

use Invertus\Printify\Config\Config;
use Invertus\Printify\Install\Installer;
use Invertus\Printify\Install\Uninstaller;
use Invertus\Printify\Repository\PrintifyOrderRepository;
use Invertus\Printify\Repository\ProductRepository;
use Invertus\Printify\Service\Logger;
use Invertus\Printify\Service\PrintifyOrderResolver;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use \Invertus\Printify\Install\Tab;

class Printify extends Module
{
    /**
     * Front controllers
     */
    const PRODUCT_EVENTS_CONTROLLER = 'productEvents';
    const CONNECT_CONTROLLER = 'connect';
    const CONNECTION_ACCEPTED_CONTROLLER = 'connectionAccepted';
    const ORDER_EVENTS_CONTROLLER = 'orderEvents';
    const SHOP_EVENTS_CONTROLLER = 'shopEvents';

    /**
     * Admin controllers
     */
    const ADMIN_PARENT_CONTROLLER = 'AdminPrintifyParent';
    const ADMIN_PRODUCT_CONTROLLER = 'AdminPrintifyProduct';
    const ADMIN_ORDER_CONTROLLER = 'AdminPrintifyOrder';
    const ADMIN_SETTINGS_CONTROLLER = 'AdminPrintifySettings';
    const ADMIN_LOG_CONTROLLER = 'AdminPrintifyLog';
    const ADMIN_CONNECT_CONTROLLER = 'AdminPrintifyConnect';

    /**
     * can move them to config
     */
    const PRESTASHOP_APP_ID = '5d7755be67565700013765d2';

    /**
     * If false, then PrintifyContainer is in immutable state
     */
    const DISABLE_CACHE = true;

    /**
     * @var PrintifyContainer
     */
    private $moduleContainer;

    /**
     * Printify constructor.
     * @throws Exception@
     */
    public function __construct()
    {
        $this->tab = 'other_modules';
        $this->name = 'printify';
        $this->version = '1.0.1';
        $this->author = 'Invertus';

        parent::__construct();
        $this->autoLoad();
        $this->compile();
        $this->displayName = $this->l('Printify');
        $this->description = $this->l('This is module description');
    }

    public function getTabs()
    {
        return array(
            array(
                'name' => $this->l('Printify'),
                'class_name' => self::ADMIN_PARENT_CONTROLLER,
                'ParentClassName' => 'SELL',
            ),
            array(
                'name' => $this->l('Products', __CLASS__),
                'class_name' => self::ADMIN_PRODUCT_CONTROLLER,
                'ParentClassName' => self::ADMIN_PARENT_CONTROLLER,
            ),
            array(
                'name' => $this->l('Orders', __CLASS__),
                'class_name' => self::ADMIN_ORDER_CONTROLLER,
                'ParentClassName' => self::ADMIN_PARENT_CONTROLLER,
            ),
               array(
                'name' => $this->l('Settings', __CLASS__),
                'class_name' => self::ADMIN_SETTINGS_CONTROLLER,
                'ParentClassName' => self::ADMIN_PARENT_CONTROLLER,
            ),
               array(
                'name' => $this->l('Logs', __CLASS__),
                'class_name' => self::ADMIN_LOG_CONTROLLER,
                'ParentClassName' => self::ADMIN_PARENT_CONTROLLER,
            ),
               array(
                'name' => $this->l('Connect', __CLASS__),
                'class_name' => self::ADMIN_CONNECT_CONTROLLER,
                'ParentClassName' => self::ADMIN_PARENT_CONTROLLER,
            ),
        );
    }

    public function getContent()
    {
        /** @var Tab $tab */
        $tab = $this->getModuleContainer()->get('install.tab');

        $redirectLink = $this->context->link->getAdminLink(self::ADMIN_CONNECT_CONTROLLER);
        Tools::redirectAdmin($redirectLink);
    }

    public function install()
    {

        /** @var Installer $installer */
        $installer = $this->getModuleContainer()->get('installer');

        return parent::install() && $installer->init();
    }

    public function uninstall()
    {
        /** @var Uninstaller $unInstaller */
        $unInstaller = $this->getModuleContainer()->get('uninstaller');

        return parent::uninstall() && $unInstaller->init();
    }

    /**
     * Gets container with loaded classes defined in src folder
     *
     * @return PrintifyContainer
     */
    public function getModuleContainer()
    {
        return $this->moduleContainer;
    }

    /**
     * Autoload's project files from /src directory
     */
    private function autoLoad()
    {
        $autoLoadPath = $this->getLocalPath() . 'vendor/autoload.php';

        require_once $autoLoadPath;
    }

    /**
     * Creates compiled dependency injection container which holds data configured in config/config.yml file.
     *
     * @throws Exception
     */
    private function compile()
    {
        $containerCache = $this->getLocalPath().'var/cache/container.php';
        $containerConfigCache = new ConfigCache($containerCache, self::DISABLE_CACHE);

        $containerClass = get_class($this).'Container';

        if (!$containerConfigCache->isFresh()) {
            $containerBuilder = new ContainerBuilder();
            $locator = new FileLocator($this->getLocalPath().'/config');
            $loader  = new YamlFileLoader($containerBuilder, $locator);
            $loader->load('services.yml');
            $containerBuilder->compile();
            $dumper = new PhpDumper($containerBuilder);

            $containerConfigCache->write(
                $dumper->dump(['class' => $containerClass]),
                $containerBuilder->getResources()
            );
        }

        require_once $containerCache;

        $this->moduleContainer = new $containerClass();
    }

    /**
     * @param $params
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function hookActionOrderStatusPostUpdate($params)
    {
        $order = new Order($params['id_order']);

        /** @var OrderState $orderStatus */
        $orderStatus = $params['newOrderStatus'];
        /** @var PrintifyOrderRepository $orderRepository */
        $orderRepository = $this->getModuleContainer()->get('printify_order_repository');

        $shouldNotResolveOrder = !$order instanceof Order ||
            !$orderStatus->paid ||
            !Configuration::get(Config::SEND_ORDER_ON_PAID) ||
            $orderRepository->checkIfOrderExists($order->reference)
        ;

        if ($shouldNotResolveOrder) {
            return;
        }

        $container = $this->getModuleContainer();

        /** @var PrintifyOrderResolver $orderResolver */
        $orderResolver = $container->get('printify_order_resolver');
        /** @var Logger $logger */
        $logger = $container->get('printify_logger');

        try {
            $orderResolver->resolveOrder($order);
        } catch (Exception $e) {
            $logger->log(Config::PRINTIFY_LOG_TYPE_ORDER, $e->getMessage(), $params['id_order']);
        }

        $logger->log(
            Config::PRINTIFY_LOG_TYPE_ORDER,
            'Order updated succesfully',
            $params['id_order'],
            Config::PRINTIFY_LOG_STATUS_SUCCESS
        );
    }

    public function hookActionAdminControllerSetMedia()
    {
        $this->context->controller->addCSS($this->getPathUri() . 'views/css/removePrintifyController.css');
    }

    /**
     * @param $params
     * @throws Exception
     */
    public function hookActionValidateOrder($params)
    {
        $order = $params['order'];

        /** @var ProductRepository $productRepository */
        $productRepository = $this->getModuleContainer()->get('product_repository');
        $productData = $productRepository->getPrintifyProductsFromOrder($order->reference);
        if (!$order instanceof Order || Configuration::get(Config::SEND_ORDER_ON_PAID) || count($productData) === 0) {
            return;
        }

        $container = $this->getModuleContainer();

        /** @var PrintifyOrderResolver $orderResolver */
        $orderResolver = $container->get('printify_order_resolver');
        /** @var Logger $logger */
        $logger = $container->get('printify_logger');

        try {
            $orderResolver->resolveOrder($order);
        } catch (Exception $e) {
            $logger->log(Config::PRINTIFY_LOG_TYPE_ORDER, $e->getMessage(), $params['order']->id);
        }

        $logger->log(
            Config::PRINTIFY_LOG_TYPE_ORDER,
            'Order validated succesfully',
            $params['order']->id,
            Config::PRINTIFY_LOG_STATUS_SUCCESS
        );
    }

    public function hookActionDispatcherBefore($params)
    {
        $string = $_SERVER['REQUEST_URI'];
        if (strpos($string, '/printifyConnectionSucceed/')
            && Tools::getValue('app_id')
            && Tools::getValue('code')
            && Tools::getValue('shop_id')
            && Tools::getValue('state')
        ) {
            Tools::redirectAdmin(
                $this->context->link->getAdminLink(
                self::ADMIN_CONNECT_CONTROLLER,
                    true,
                    array(),
                    array(
                        'app_id' =>Tools::getValue('app_id'),
                        'code' => Tools::getValue('code'),
                        'shop_id' => Tools::getValue('shop_id'),
                        'state' => Tools::getValue('state'),
                        'succeededToConnect' => '1'
                    )
                )
            );
        }

        if (strpos($string, '/printifyConnectionFailed/')) {
            Tools::redirectAdmin(
                $this->context->link->getAdminLink(
                    self::ADMIN_CONNECT_CONTROLLER,
                    true,
                    array(),
                    array(
                        'failedToConnect' => '1'
                    )
                )
            );
        }
    }

    public function hookActionProductDelete($data)
    {
        $handler = $this->getModuleContainer()->get('printify_product_delete_handler');
        $idProduct = $data['id_product'];

        /** @var Logger $logger */
        $logger = $this->getModuleContainer()->get('printify_logger');
        try {
            $handler->handle($idProduct);
        } catch (Exception $e) {
            $logger->log(
                Config::PRINTIFY_LOG_TYPE_PRODUCT,
                sprintf('Failed to delete product data id: %s, reason: %s', $idProduct, $e->getMessage()),
                $idProduct
            );

            return;
        }
    }

    public function hookActionProductAttributeDelete($data)
    {
        $handler = $this->getModuleContainer()->get('product_attribute_delete_handler');
        $idProductAttribute = $data['id_product_attribute'];

        /** @var Logger $logger */
        $logger = $this->getModuleContainer()->get('printify_logger');
        try {
            $handler->handle($idProductAttribute);
        } catch (Exception $e) {
            $logger->log(
                Config::PRINTIFY_LOG_TYPE_PRODUCT,
                sprintf('Failed to delete product data id: %s, reason: %s', $idProductAttribute, $e->getMessage()),
                $idProductAttribute
            );

            return;
        }
    }

    public function hookActionAttributeDelete($data)
    {
        $handler = $this->getModuleContainer()->get('attribute_delete_handler');
        $idAttribute = $data['id_attribute'];

        /** @var Logger $logger */
        $logger = $this->getModuleContainer()->get('printify_logger');
        try {
            $handler->handle($idAttribute);
        } catch (Exception $e) {
            $logger->log(
                Config::PRINTIFY_LOG_TYPE_PRODUCT,
                sprintf('Failed to delete product data id: %s, reason: %s', $idAttribute, $e->getMessage()),
                $idAttribute
            );

            return;
        }
    }
}
