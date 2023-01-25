<?php
/**
 * 2007-2019 PrestaShop SA and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
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
 * @author INVERTUS UAB www.invertus.eu <support@invertus.eu>
 * @copyright printify.com Limited
 * @license   https://opensource.org/licenses/AFL-3.0  Academic Free License (AFL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

namespace Invertus\Printify\Entity;

use DateTime;
use ObjectModel;

class Log extends ObjectModel
{
    /**
     * @var string
     */
    public $message;

    /**
     * @var DateTime
     */
    public $date;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $id_object;

    /**
     * @var string
     */
    public $status;

    /**
     * @var array
     */
    public static $definition = [
        'table' => 'printify_log',
        'primary' => 'id_printify_log',
        'fields' => [
            'type' => ['type' => self::TYPE_STRING, 'validate' => 'isString'],
            'id_object' => ['type' => self::TYPE_STRING],
            'status' => ['type' => self::TYPE_STRING, 'validate' => 'isString'],
            'message' => ['type' => self::TYPE_STRING, 'validate' => 'isString'],
            'date' => ['type' => self::TYPE_DATE, 'validate' => 'isDate'],
        ],
    ];
}
