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

use Invertus\Printify\Exception\InvalidJsonStringException;

class WebHookJsonParser extends AbstractJsonParser
{
    /**
     * @var array
     */
    private $data;

    /**
     * @param string $json
     *
     * @throws InvalidJsonStringException
     */
    public function __construct($json)
    {
        $this->data = $this->decodeJson($json);
    }

    /**
     * @param array $hooks
     * @return bool
     */
    public function areHooksRegistered($hooks)
    {
        $topics = array_map(function ($row){
            return $row['topic'];
        }, $this->data);

        foreach ($hooks as $hook) {
            if (!in_array($hook['hook'],$topics)) {
                return false;
            }
        }

        return true;
    }

    public function getHookIdsList()
    {
        return array_map(function ($row){
            return $row['id'];
        }, $this->data);
    }
}
