<?php
namespace Invertus\Printify\Service;

use Configuration;
use Exception;
use Invertus\Printify\Api\ShopApi;
use Invertus\Printify\Config\Config;
use PrestaShopDatabaseException;
use PrestaShopException;

class PrintifyConnectionManager
{
    /** @var Logger */
    private $logger;

    /** @var WebHookRegisterer */
    private $webhookRegisterer;

    /** @var ShopApi */
    private $shopApi;

    /**
     * @param Logger $logger
     * @param WebHookRegisterer $webhookRegisterer
     * @param ShopApi $shopApi
     */
    public function __construct(
        Logger $logger,
        WebHookRegisterer $webhookRegisterer,
        ShopApi $shopApi
    ) {
        $this->logger = $logger;
        $this->webhookRegisterer = $webhookRegisterer;
        $this->shopApi = $shopApi;
    }

    /**
     * @return bool
     * @throws PrestaShopException
     */
    public function checkConnection()
    {
        try {
            $areHooksRegistered = $this->webhookRegisterer->areHooksRegistered();
            $shopsJsonParser = new ShopsJsonParser($this->shopApi->getShops());
            $isShopRegistered = $shopsJsonParser->isShopRegistered();
            $connected = $isShopRegistered && $areHooksRegistered;
        } catch (Exception $e) {
            $connected = false;
            $this->logger->log(Config::PRINTIFY_LOG_TYPE_CONNECTION_CHECK, $e->getMessage());
        }

        return $connected;
    }

    /**
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function disconnectFromPrintify()
    {
        try {
            $this->shopApi->disconnectPritifyShop(Configuration::get(Config::ID_SHOP));
            $this->webhookRegisterer->unregisterHooks();
            Configuration::deleteByName(Config::ID_SHOP);
            Configuration::deleteByName(Config::REFRESH_TOKEN);
            Configuration::deleteByName(Config::ACCESS_TOKEN);
        } catch (Exception $e) {
            $this->logger->log(
                Config::PRINTIFY_LOG_TYPE_WEBHOOK,
                sprintf('Failed to disconnect: %s', $e->getMessage())
            );
        }

        $this->logger->log(
            Config::PRINTIFY_LOG_TYPE_WEBHOOK,
            sprintf('Succeeded to disconnect'),
            null,
            Config::PRINTIFY_LOG_STATUS_SUCCESS
        );
    }
}
