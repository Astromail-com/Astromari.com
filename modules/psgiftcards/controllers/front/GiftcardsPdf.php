<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */
class psgiftcardsGiftcardsPdfModuleFrontController extends ModuleFrontController
{
    /**
     * Override property definition from parent class
     *
     * @var Psgiftcards
     */
    public $module;

    /**
     * @var GiftCardToken
     */
    private $giftcardToken;

    public function initContent()
    {
        $this->giftcardToken = new GiftCardToken();

        $content = ob_get_clean();
        $content .= $this->getPdfData();

        $pageLayout = [1050, 450]; // px
        $pdf = new TCPDF('l', 'px', $pageLayout, true, 'UTF-8', false);
        $pdf->SetMargins(0, 0, 0);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->setFont('dejavusans');

        $pdf->AddPage();

        ob_end_clean();
        $pdf->writeHTML($content);
        $pdf->output('giftcard.pdf', 'D');
    }

    public function getPdfData()
    {
        if (file_exists(_PS_ROOT_DIR_ . '/tools/tcpdf/tcpdf.php')) {
            require_once _PS_ROOT_DIR_ . '/tools/tcpdf/tcpdf.php';
        }

        $context = Context::getContext();
        $id_giftcard = (int) Tools::getValue('id_giftcard');
        $this->checkToken($id_giftcard);
        $this->module->generateCartRule($id_giftcard);
        $giftcard = GiftcardHistory::getGiftcardById($id_giftcard);

        $iTemplateId = 0;
        switch (Configuration::get('PS_GIFCARDS_TEMPLATE')) {
            case 'sendy':
                $iTemplateId = 0;
                break;
            case 'boxy':
                $iTemplateId = 1;
                break;
            case 'puffy':
                $iTemplateId = 2;
                break;
        }

        $gfLang = GiftcardHistory::getGiftcardsMailsLangbyLang($context->language->id, $iTemplateId);

        $currencySymbol = $context->currency->sign;
        $price = str_replace('.00', '', number_format(Product::getPriceStatic($giftcard['id_product'], true), 2)) . ' ' . $currencySymbol;

        $cartRule = new CartRule((int) $giftcard['id_cartRule']);

        /** @var Psgiftcards $module */
        $module = Module::getInstanceByName('psgiftcards');
        $translations = $module->pdfTranslations;

        $content = html_entity_decode($gfLang[0]['email_content']);

        $data = [
            '{{message}}' => html_entity_decode($content),
            '{{shopName}}' => Configuration::get('PS_SHOP_NAME'),
            '{{recipientName}}' => $giftcard['recipientName'],
            '{{buyerName}}' => $giftcard['buyerName'],
            '{{text}}' => $giftcard['text'],
            '{{send_date}}' => date('d-m-Y', strtotime($cartRule->date_to)),
            '{{cart_rule_code}}' => $cartRule->code,
            '{{price}}' => $price,
            '{{site_url}}' => Configuration::get('PS_SHOP_DOMAIN'),
            '{{from}}' => $translations['from'],
            '{{to}}' => $translations['to'],
            '{{message1}}' => $translations['message1'],
            '{{message2}}' => $translations['message2'],
            '{{message3}}' => $translations['message3'],
            '{{color}}' => Configuration::get('PS_GIFCARDS_PRIMARY_COLOR'),
            '{{excellent_shooping}}' => $translations['excellent_shooping'],
            '{{text_footer1}}' => $translations['text_footer1'],
            '{{text_footer2}}' => $translations['text_footer2'],
            '{{img}}' => Tools::getShopDomain(true) . __PS_BASE_URI__ . '/modules/psgiftcards/views/img/giftcard.jpg',
            '{{circle}}' => Tools::getShopDomain(true) . __PS_BASE_URI__ . '/modules/psgiftcards/views/img/circle.png',

            '{{text_footer}}' => html_entity_decode($gfLang[0]['email_unsubscribe']),

            '{gift_card_value}' => $price,
            '{gift_card_validity}' => date('d-m-Y', strtotime($cartRule->date_to)),
            '{discount_value}' => $price,
            '{discount_validity}' => date('d-m-Y', strtotime($cartRule->date_to)),
            '{site_url}' => Configuration::get('PS_SHOP_NAME'),

            '{buyer_message}' => '',
            '{discount_code}' => $cartRule->code,
            '{shop_link}' => Configuration::get('PS_SHOP_NAME'),
            '{$site_url}' => Configuration::get('PS_SHOP_NAME'),
            '{recipient_name}' => $giftcard['recipientName'],
            '{buyer_name}' => $giftcard['buyerName'],
        ];

        $filename = _PS_MODULE_DIR_ . 'psgiftcards/views/templates/pdf/giftcardPdf.html';
        $pdfContent = Tools::file_get_contents($filename);
        $pdfContent = str_replace(array_keys($data), $data, $pdfContent);

        GiftcardHistory::setStatus($id_giftcard, 4);

        return $pdfContent;
    }

    private function checkToken($id_giftcard)
    {
        $id_customer = GiftcardHistory::getCustomerById($id_giftcard);
        if (!$this->giftcardToken->isTokenValid($id_customer, Tools::getValue('token'))) {
            http_response_code(403);
            exit('bad token');
        }
    }
}
