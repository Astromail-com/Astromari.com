<?php

use Invertus\Printify\Exception\InvalidPrintifyRoutingConfiguration;
use Invertus\Printify\Exception\RouteDefinitionNotFoundException;
use Invertus\Printify\Service\PrintifyLink;
use Invertus\Printify\Config\Config;

class PrintifyConnectModuleFrontController extends ModuleFrontController
{
    /**
     * @throws InvalidPrintifyRoutingConfiguration
     * @throws RouteDefinitionNotFoundException
     */
    public function postProcess()
    {
        $state = Tools::hash(time());
        Configuration::updateValue(Config::STATE_TOKEN, $state);

        /** @var PrintifyLink $printifyLink */
        $printifyLink = $this->module->getModuleContainer()->get('printify_router');

        $url = $printifyLink->buildPrintifyAuthorizeUrl($state);
        Tools::redirect($url);
    }
}


