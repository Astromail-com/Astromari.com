<?php
/**
 * 2007-2019 PrestaShop and Contributors
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

namespace Invertus\Printify\Collection;

use Invertus\Printify\Model\IdentifiableModelInterface;
use Invertus\Printify\Model\PrintifyAttribute;

/**
 * Class IdentifiableCollection
 * @package Invertus\Printify\Collection
 */
class IdentifiableCollection extends Collection
{
    /**
     * @param IdentifiableModelInterface $element
     * @return Collection
     */
    public function add($element)
    {
        return $this->addIdentifiableElement($element);
    }

    /**
     * @param IdentifiableModelInterface $element
     * @return Collection
     */
    private function addIdentifiableElement(IdentifiableModelInterface $element)
    {
        $this->collection[$element->getId()] = $element;

        return $this;
    }

    /**
     * @param int
     * @return IdentifiableModelInterface|null
     */
    public function get($key)
    {
        return array_key_exists($key, $this->collection) ? $this->collection[$key] : null;
    }
}
