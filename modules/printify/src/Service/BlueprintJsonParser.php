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
use Invertus\Printify\Model\PrintifyBlueprint;

/**
 * Handles and validates json string and fills blueprint models with its data
 */
class BlueprintJsonParser extends AbstractJsonParser
{
    /**
     * @var array
     */
    private $data;

    /**
     * @param $json
     *
     * @throws InvalidJsonStringException
     */
    public function __construct($json)
    {
        $this->data = $this->decodeJson($json);
    }

    /**
     * @return PrintifyBlueprint
     * @throws InvalidJsonStringException
     */
    public function getBlueprint()
    {
        return new PrintifyBlueprint(
            $this->getValueOrNull($this->data, 'id', true),
            $this->getValueOrNull($this->data, 'title'),
            $this->getValueOrNull($this->data, 'brand', true),
            $this->getValueOrNull($this->data, 'model')
        );
    }
}
