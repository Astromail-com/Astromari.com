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

namespace Invertus\Printify\Service;

use Invertus\Printify\Exception\InvalidJsonStringException;

/**
 * Holds common methods for json parsers
 */
abstract class AbstractJsonParser
{
    /**
     * @param $json
     * @return mixed
     * @throws InvalidJsonStringException
     */
    protected function decodeJson($json)
    {
        $data = json_decode($json, true);

        if (null === $data) {
            throw new InvalidJsonStringException(sprintf('Failed to validate string as valid json: %s', $json));
        }

        return $data;
    }

    /**
     * @param $data
     * @param $key
     * @param $die
     * @return mixed|null
     * @throws InvalidJsonStringException
     */
    protected function getValueOrNull($data, $key, $die = false)
    {
        $value = isset($data[$key]) ? $data[$key] : null;

        if (null === $value && $die) {
            throw new InvalidJsonStringException(sprintf('Missing required field %s in json', $key));
        }

        return $value;
    }

    /**
     * @param $data
     * @param $key
     * @return mixed|bool
     */
    protected function getBool($data, $key)
    {
        return isset($data[$key]) ? $data[$key] : false;
    }

    /**
     * @param $data
     * @param $key
     * @return array
     */
    protected function getValueOrEmptyArray($data, $key)
    {
        return isset($data[$key]) && is_array($data[$key]) ? $data[$key] : [];
    }
}
