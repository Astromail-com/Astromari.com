<?php
/**
 * 2007-2019 PrestaShop SA and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2019 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

namespace Invertus\Printify\Service;

use Configuration;
use DateInterval;
use DateTime;
use Exception;
use Invertus\Printify\Config\Config;
use Invertus\Printify\Entity\Log;
use Invertus\Printify\Repository\PrintifyLogRepository;
use PrestaShopDatabaseException;
use PrestaShopException;

class Logger
{
    /**
     * @var PrintifyLogRepository
     */
    private $logRepository;

    /**
     * @param PrintifyLogRepository $logRepository
     *
     */
    public function __construct(PrintifyLogRepository $logRepository)
    {
        $this->logRepository = $logRepository;
    }

    /**
     * @param string $type
     * @param string $message
     * @param string $objectId
     * @param string $status
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function log($type, $message, $objectId = null, $status = Config::PRINTIFY_LOG_STATUS_FAILED)
    {
        $log = new Log();

        $log->type = $type;
        $log->message = $message;
        $log->status = $status;

        if ($objectId !== null) {
            $log->id_object = $objectId;
        }

        $log->date = (new DateTime())->format('Y-m-d H:i:s');

        $log->save();
    }

    /**
     * @throws Exception
     */
    public function clearOldLogs()
    {
        $checkInterval = Config::PRINTIFY_LOG_DELETE_CHECK_INTERVAL_IN_DAYS;
        $lastDeleteDate = new DateTime(Configuration::get(Config::PRINTIFY_LAST_LOG_DELETE_DATE));
        $lastDeleteDate->add(new DateInterval('P' . $checkInterval . 'D'));
        $currentDate = new DateTime();

        if ($currentDate < $lastDeleteDate) {
            return;
        }

        Configuration::updateValue(Config::PRINTIFY_LAST_LOG_DELETE_DATE, (new DateTime())->format('Y-m-d H:i:s'));

        $deleteUntil = (new DateTime)->sub(new DateInterval('P' . Configuration::get(Config::LOG_STORAGE_DURATION) . 'D'));

        $this->logRepository->deleteLogs($deleteUntil->format('Y-m-d H:i:s'));
    }
}
