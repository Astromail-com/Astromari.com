<?php
/**
 * 2016-2017 Leone MusicReader B.V.
 *
 * NOTICE OF LICENSE
 *
 * Source file is copyrighted by Leone MusicReader B.V.
 * Only licensed users may install, use and alter it.
 * Original and altered files may not be (re)distributed without permission.
 *
 * @author    Leone MusicReader B.V.
 *
 * @copyright 2016-2017 Leone MusicReader B.V.
 *
 * @license   custom see above
 */

class DLPAddressFormatter
{
    public static function convertAddressFormat($address)
    {
        $lines = array();
        if (Tools::strlen($address["company"]) > 1) {
            $lines[] = $address["company"];
        }

        $lines[] = $address["firstname"] . " " . $address["lastname"];
        $lines[] = $address["address1"];

        if (Tools::strlen($address["address2"]) > 0) {
            $lines[] = $address["address2"];
        }

        if ($address["iso_code"] == "NL" || $address["iso_code"] == "FR") {
            $lines[] = Tools::strtoupper($address["postcode"]) . " " . Tools::strtoupper($address["city"]);
            $lines[] = Tools::strtoupper($address["country"]);
        } elseif ($address["iso_code"] == "BE" || $address["iso_code"] == "DK"
            || $address["iso_code"] == "SE" || $address["iso_code"] == "DE" ||
            $address["iso_code"] == "NO" || $address["iso_code"] == "CH"
        ) {
            $lines[] = Tools::strtoupper($address["postcode"]) . " " . $address["city"];
            $lines[] = Tools::strtoupper($address["country"]);
        } elseif ($address["iso_code"] == "GB") {
            $lines[] = Tools::strtoupper($address["city"]);
            $lines[] = Tools::strtoupper($address["postcode"]);
            $lines[] = Tools::strtoupper("United Kingdom");
        } elseif ($address["iso_code"] == "US" || $address["iso_code"] == "AU" ||
            $address["iso_code"] == "CA" || $address["iso_code"] == "MX") {
            $lines[] = Tools::strtoupper($address["city"]) . ", " . $address["state"] . " " . $address["postcode"];
            $lines[] = Tools::strtoupper($address["country"]);
        } elseif ($address["iso_code"] == "IT") {
            $lines[] = $address["postcode"] . " " .
                Tools::strtoupper($address["city"])
                . ", " . $address["state_iso"];
            $lines[] = Tools::strtoupper($address["country"]);
        } elseif ($address["iso_code"] == "PT") {
            $lines[] = Tools::strtoupper($address["city"]);
            $lines[] = $address["postcode"] . " " . $address["state"];
            $lines[] = Tools::strtoupper($address["country"]);
        } else {
            $lines[] = Tools::strtoupper($address["postcode"]);
            $lines[] = Tools::strtoupper($address["city"]);
            $lines[] = Tools::strtoupper($address["country"]);
        }
        return $lines;
    }
}
