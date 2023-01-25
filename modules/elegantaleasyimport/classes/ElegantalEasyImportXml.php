<?php
/**
 * @author    ELEGANTAL <info@elegantal.com>
 * @copyright (c) 2023, ELEGANTAL <www.elegantal.com>
 * @license   Proprietary License - It is forbidden to resell or redistribute copies of the module or modified copies of the module.
 */

/**
 * This is helper class for XML functions
 */
class ElegantalEasyImportXml
{
    public static function convertToCsv($file, $entity, $multiple_value_separator)
    {
        $f = fopen($file, 'r');
        $line = fgets($f);
        $line = trim($line);
        fclose($f);
        if ($line == 'This XML file does not appear to have any style information associated with it. The document tree is shown below.') {
            $fileArr = file($file);
            unset($fileArr[0]);
            file_put_contents($file, $fileArr);
            unset($fileArr);
        }

        // Replace & in XML file, as it is not allowed
        $file_content = Tools::file_get_contents($file);
        $file_content = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $file_content);
        file_put_contents($file, $file_content);
        unset($file_content);

        // Load XML and convert to associative array. LIBXML_NOCDATA ignores <![CDATA[...]]>
        $xml = simplexml_load_file($file, 'SimpleXMLElement', LIBXML_NOCDATA);

        if (empty($xml) || !is_object($xml)) {
            throw new Exception("XML file is not valid.");
        }

        // Step 1
        // Make changes in xml object here if necessary
        if ($entity == 'product' && isset($xml->shop) && isset($xml->shop->categories) && isset($xml->shop->offers->offer)) {
            // Get categories into array
            $shop_categories = array();
            if (isset($xml->shop->categories)) {
                foreach ($xml->shop->categories->category as $category) {
                    $shop_categories[(int) $category->attributes()->id[0]] = $category . "";
                }
            }
            foreach ($xml->shop->offers->offer as $offer) {
                // Replace category ID with category name
                if (isset($offer->categoryId) && isset($shop_categories[(int) $offer->categoryId]) && $shop_categories[(int) $offer->categoryId]) {
                    $offer->categoryId[0] = $shop_categories[(int) $offer->categoryId];
                }
                // Parse features into one column
                if (isset($offer->param)) {
                    $n = 1;
                    foreach ($offer->param as $param) {
                        $param[0] = (isset($param->attributes()->name[0]) ? $param->attributes()->name[0] . "" : "") . ":" . $param . ":" . $n . ":0";
                        $n++;
                    }
                }
            }
        } elseif ($entity == 'product' && isset($xml->categories) && isset($xml->categories->category) && isset($xml->products->product)) {
            $shop_categories = array();
            // Anonymous function to get category name including its parents
            $getCategoriesWithParents = function ($xml_category) use (&$getCategoriesWithParents, $xml) {
                if (empty($xml_category->parent[0] . "")) {
                    return $xml_category->name[0] . "";
                }
                $parent_cat = null;
                foreach ($xml->categories->category as $tmp_cat) {
                    if ($tmp_cat->id[0] . "" == $xml_category->parent[0] . "") {
                        $parent_cat = $tmp_cat;
                        break;
                    }
                }
                return ($parent_cat) ? $getCategoriesWithParents($parent_cat) . "->" . $xml_category->name[0] : $xml_category->name[0] . "";
            };
            foreach ($xml->categories->category as $category) {
                $shop_categories[(int) $category->id[0]] = $getCategoriesWithParents($category);
            }
            foreach ($xml->products->product as $xml_product) {
                if (isset($xml_product->categories->category)) {
                    foreach ($xml_product->categories->category as $xml_cat) {
                        $xml_cat[0] = isset($shop_categories[(int) $xml_cat[0]]) ? $shop_categories[(int) $xml_cat[0]] : "";
                    }
                }
            }
        } elseif ($entity == 'product' && isset($xml->categories) && isset($xml->categories->category) && isset($xml->product)) {
            $shop_categories = array();
            foreach ($xml->categories->category as $category) {
                $shop_categories[(int) $category->id[0]] = $category->name[0] . "";
            }
            foreach ($xml->product as $xml_product) {
                if (isset($xml_product->categories->category)) {
                    foreach ($xml_product->categories->category as $xml_cat) {
                        $xml_cat[0] = isset($shop_categories[(int) $xml_cat[0]]) ? $shop_categories[(int) $xml_cat[0]] : "";
                    }
                }
            }
        } elseif ($entity == 'product' && isset($xml->Product) && isset($xml->Product[0]->SellingPrices)) {
            foreach ($xml->Product as $product) {
                if (isset($product->SellingPrices->SellingPrice)) {
                    $count = 1;
                    foreach ($product->SellingPrices->SellingPrice as $sellingPrice) {
                        $product->addChild("SellingPrice" . $count . "_Price", $sellingPrice->Price . "");
                        $product->addChild("SellingPrice" . $count . "_PriceIncludingVAT", $sellingPrice->PriceIncludingVAT . "");
                        $product->addChild("SellingPrice" . $count . "_MinQuantity", $sellingPrice->MinQuantity . "");
                        $count++;
                    }
                }
                foreach ($product as $key => $child) {
                    // Remove original nodes that has lang attribute and create new nodes for lang
                    if (isset($child->attributes()->lang) && $child->attributes()->lang && count($product->{$key}) > 1) {
                        $count = 0;
                        foreach ($product->{$key} as $node) {
                            if (isset($node->attributes()->lang)) {
                                $lang = Tools::strtoupper(preg_replace("/[^a-zA-Z]+/", "", $node->attributes()->lang . ""));
                                if ($lang && !$product->{$key . $lang}) {
                                    $product->addChild($key . $lang, $node . "");
                                    unset($product->{$key}[$count]);
                                }
                            }
                            $count++;
                        }
                    }
                }
            }
        } elseif ($entity == 'combination' && isset($xml->Product[0]->Product_code) && isset($xml->Product[0]->Product_id)) {
            // Check if this file has variants
            $variants_exist = false;
            foreach ($xml->Product as $product) {
                if (isset($product->variants->variant[0]->spec)) {
                    $variants_exist = true;
                    break;
                }
            }
            if ($variants_exist) {
                foreach ($xml->Product as $product) {
                    foreach ($product->variants->variant as $variant) {
                        $attribute_names = "";
                        $attribute_values = "";
                        if (isset($variant->spec)) {
                            foreach ($variant->spec as $spec) {
                                $attribute_names .= $attribute_names ? $multiple_value_separator : "";
                                $attribute_names .= $spec->attributes()->name . "";
                                $attribute_values .= $attribute_values ? $multiple_value_separator : "";
                                $attribute_values .= $spec . "";
                            }
                        }
                        $variant->AttributeNames = $attribute_names;
                        $variant->AttributeValues = $attribute_values;
                    }
                }
            }
        } elseif ($entity == 'combination' && isset($xml->ITEM[0]) && isset($xml->ITEM[0]->ID) && isset($xml->ITEM[0]->ID_MAIN) && isset($xml->ITEM[0]->CODE) && isset($xml->ITEM[0]->PARAMS)) {
            foreach ($xml->ITEM as $product) {
                $attribute_names = "";
                $attribute_values = "";
                if (isset($product->PARAMS->PARAM)) {
                    foreach ($product->PARAMS->PARAM as $param) {
                        $attribute_names .= $attribute_names ? $multiple_value_separator : "";
                        $attribute_names .= $param->attributes()->name . "";
                        $attribute_values .= $attribute_values ? $multiple_value_separator : "";
                        $attribute_values .= $param . "";
                    }
                }
                $product->AttributeNames = $attribute_names;
                $product->AttributeValues = $attribute_values;
            }
        } elseif ($entity == 'product' && isset($xml->titul) && isset($xml->titul->attributes()->ean) && isset($xml->titul->attributes()->id) && isset($xml->titul->attributes()->timestamp)) {
            $xml_tmp = array();
            foreach ($xml->titul as $titul) {
                $xml_tmp[] = array(
                    'ean' => $titul->attributes()->ean . "",
                    'id' => $titul->attributes()->id . "",
                    'timestamp' => $titul->attributes()->timestamp . "",
                    'pocet' => $titul->attributes()->pocet . "",
                    'titul' => $titul . "",
                );
            }
            $xml = $xml_tmp;
        } elseif ($entity == 'product' && isset($xml->article[0]->article_nr) && isset($xml->article[0]->article_configurations->configuration)) {
            foreach ($xml->article as $product) {
                if (isset($product->article_configurations->configuration[0]->code)) {
                    foreach ($product->article_configurations->configuration as $c) {
                        if (isset($c->prices->price)) {
                            $key = 1;
                            foreach ($c->prices->price as $price) {
                                $product->{'price_original_' . $key} = $price->attributes()->original_price . '';
                                $product->{'price_quantity_' . $key} = $price->attributes()->quantity . '';
                                $product->{'price_discount_percentage_' . $key} = $price->attributes()->discount_percentage . '';
                                $key++;
                            }
                        }
                    }
                }
            }
        } elseif (isset($xml->group->o[0]) && isset($xml->group->o[0]->attributes()->id) && isset($xml->group->o[0]->attrs->a) && isset($xml->group->o[0]->versions->a)) {
            if ($entity == 'combination') {
                $xml_tmp = array();
                foreach ($xml->group->o as $product) {
                    foreach ($product->versions->a as $v) {
                        $xml_tmp[] = array(
                            'id' => $product->attributes()->id . "",
                            'combination_reference' => $v->attributes()->option_id . "",
                            'Size' => $v->attributes()->name . "",
                            'ean' => $v->attributes()->ean . "",
                            'stock' => trim($v[0]) . "",
                            'nr_cat' => $v->attributes()->nr_cat . "",
                        );
                    }
                }
                $xml = $xml_tmp;
            } else {
                foreach ($xml->group->o as $product) {
                    $attrs_feature = "";
                    foreach ($product->attrs->a as $a) {
                        $attrs_feature .= $attrs_feature ? $multiple_value_separator : "";
                        $attrs_feature .= $a->attributes()->name . ":" . trim($a[0]);
                    }
                    $product->attrs = $attrs_feature;
                    $product->cat = str_replace("/", "|", $product->cat . "");
                    unset($product->versions);
                }
            }
        } elseif (isset($xml->Categories) && isset($xml->Producers) && isset($xml->Products->Product[0]->TechnicalSpecification)) {
            unset($xml->Categories);
            unset($xml->Producers);
            foreach ($xml->Products->Product as $product) {
                unset($product->TechnicalSpecification);
            }
        } elseif (isset($xml->ITEM) && isset($xml->ITEM[0]->PRICES->PRICE) && isset($xml->ITEM[0]->PRICES->PRICE[0]->attributes()->level) && isset($xml->ITEM[0]->PRICES_VAT->PRICE_VAT) && isset($xml->ITEM[0]->PRICES_VAT->PRICE_VAT[0]->attributes()->level)) {
            foreach ($xml->ITEM as $ITEM) {
                foreach ($ITEM->PRICES->PRICE as $PRICE) {
                    if (isset($PRICE->attributes()->level)) {
                        $ITEM->{'PRICE_' . $PRICE->attributes()->level . ""} = $PRICE . "";
                    }
                }
                foreach ($ITEM->PRICES_VAT->PRICE_VAT as $PRICE_VAT) {
                    if (isset($PRICE_VAT->attributes()->level)) {
                        $ITEM->{'PRICE_VAT_' . $PRICE_VAT->attributes()->level . ""} = $PRICE_VAT . "";
                    }
                }
                unset($ITEM->PRICES);
                unset($ITEM->PRICES_VAT);
            }
        } elseif (isset($xml->product) && isset($xml->product[0]->param) && isset($xml->product[0]->param[0]->attributes()->name)) {
            foreach ($xml->product as $product) {
                $params = "";
                foreach ($product->param as $param) {
                    $params .= $params ? $multiple_value_separator : "";
                    $params .= $param->attributes()->name . ":" . str_replace(":", "∶", $param . "");
                }
                unset($product->param);
                $product->param = $params;
            }
        } elseif (isset($xml->group->product[0]) && isset($xml->group->product[0]->attrs->a) && isset($xml->group->product[0]->attrs->a->attributes()->name)) {
            foreach ($xml->group->product as $product) {
                $attrs = "";
                foreach ($product->attrs->a as $a) {
                    if ($a . "" === "") {
                        continue;
                    }
                    $attrs .= $attrs ? $multiple_value_separator : "";
                    $attrs .= $a->attributes()->name . ":" . str_replace(":", "∶", $a . "");
                }
                unset($product->attrs);
                $product->attrs = $attrs;
            }
        } elseif ($entity == 'product' && isset($xml->products->product[0]->prime_costs)) {
            $attributes_exist = false;
            foreach ($xml->products->product as $product) {
                if (isset($product->attributes->attribute) && isset($product->attributes->attribute->attributes()->title)) {
                    $attributes_exist = true;
                    break;
                }
            }
            if ($attributes_exist) {
                foreach ($xml->products->product as $product) {
                    $attrs = "";
                    if (isset($product->attributes->attribute)) {
                        foreach ($product->attributes->attribute as $attr) {
                            $attrs .= $attrs ? $multiple_value_separator : "";
                            $attrs .= $attr->attributes()->title . ':"' . $attr . '"';
                        }
                    }
                    unset($product->attributes);
                    $product->attributes = $attrs;
                }
            }
        }

        // Step 2
        // Here you can remove namespaces if exist. This code is generic but you can allow it only for xml files that need it.
        if ((isset($xml->channel) && isset($xml->channel->title) && isset($xml->channel->link) && isset($xml->channel->description)) ||
            (isset($xml->title) && isset($xml->link) && isset($xml->entry))
            // (isset($xml->attributes()->file_format) && isset($xml->attributes()->generated) && isset($xml->attributes()->expires) && isset($xml->attributes()->version) && isset($xml->attributes()->extensions))
        ) {
            $namespaces = $xml->getDocNamespaces(true);
            if ($namespaces && is_array($namespaces)) {
                $file_content = Tools::file_get_contents($file);
                foreach ($namespaces as $ns => $ns_url) {
                    $file_content = str_replace(array('<' . $ns . ':', '</' . $ns . ':'), array('<', '</'), $file_content);
                }
                file_put_contents($file, $file_content);
                unset($file_content);
                $xml = simplexml_load_file($file, 'SimpleXMLElement', LIBXML_NOCDATA);
            }
        }

        $json = json_encode($xml);
        unset($xml);

        $first_array = json_decode($json, true);
        unset($json);

        $array = $first_array;

        // Step 3
        if (isset($array['@attributes'])) {
            unset($array['@attributes']);
        }
        if (isset($array['message_header'])) {
            unset($array['message_header']);
        }
        if (isset($array['products']['@attributes'])) {
            unset($array['products']['@attributes']);
        }
        if (isset($array['Header'])) {
            unset($array['Header']);
        }
        if (isset($array['Service']['Header'])) {
            unset($array['Service']['Header']);
        }
        if (isset($array['envelop'])) {
            unset($array['envelop']);
        }
        if (isset($array['channel']['title'])) {
            unset($array['channel']['title']);
        }
        if (isset($array['channel']['link'])) {
            unset($array['channel']['link']);
        }
        if (isset($array['channel']['description'])) {
            unset($array['channel']['description']);
        }
        if (isset($array['channel']['comment'])) {
            unset($array['channel']['comment']);
        }
        if (isset($array['created_at'])) {
            unset($array['created_at']);
        }
        if (isset($array['lastupdate'])) {
            unset($array['lastupdate']);
        }
        if (isset($array['updated'])) {
            unset($array['updated']);
        }
        if (isset($array['status'])) {
            unset($array['status']);
        }
        if (isset($array['methodName'])) {
            unset($array['methodName']);
        }
        if (isset($array['EXPORT_INFO'])) {
            unset($array['EXPORT_INFO']);
        }
        if (isset($array['DATE'])) {
            unset($array['DATE']);
        }
        if (isset($array['DATE_CREATED'])) {
            unset($array['DATE_CREATED']);
        }
        if (isset($array['HEAD'])) {
            unset($array['HEAD']);
        }
        if (isset($array['headerInfo'])) {
            unset($array['headerInfo']);
        }
        if (isset($array['categories'])) {
            unset($array['categories']);
        }
        if (isset($array['Categories'])) {
            unset($array['Categories']);
        }
        if (isset($array['Producers'])) {
            unset($array['Producers']);
        }
        if (isset($array['shop']['name'])) {
            unset($array['shop']['name']);
        }
        if (isset($array['shop']['company'])) {
            unset($array['shop']['company']);
        }
        if (isset($array['shop']['currencies'])) {
            unset($array['shop']['currencies']);
        }
        if (isset($array['shop']['categories'])) {
            unset($array['shop']['categories']);
        }
        if (isset($array['shop']['url'])) {
            unset($array['shop']['url']);
        }
        if (isset($array['Shop']['id'])) {
            unset($array['Shop']['id']);
        }
        if (isset($array['Shop']['Categories'])) {
            unset($array['Shop']['Categories']);
        }
        if (isset($array['estado'])) {
            unset($array['estado']);
        }
        if (isset($array['Дата'])) {
            unset($array['Дата']);
        }
        if (isset($array['DocTimeStamp'])) {
            unset($array['DocTimeStamp']);
        }
        if (isset($array['datetime'])) {
            unset($array['datetime']);
        }
        if (isset($array['creationdate'])) {
            unset($array['creationdate']);
        }
        if (isset($array['generation_date'])) {
            unset($array['generation_date']);
        }
        if (isset($array['title'])) {
            unset($array['title']);
        }
        if (isset($array['link'])) {
            unset($array['link']);
        }
        if (isset($array['description'])) {
            unset($array['description']);
        }
        if (isset($array['comment'])) {
            unset($array['comment']);
        }
        if (isset($array['site_url'])) {
            unset($array['site_url']);
        }
        if (isset($array['created_for_customer_email'])) {
            unset($array['created_for_customer_email']);
        }
        if (isset($array['customer_key'])) {
            unset($array['customer_key']);
        }
        if (isset($array['customer_categories'])) {
            unset($array['customer_categories']);
        }
        if (isset($array['products_found_num'])) {
            unset($array['products_found_num']);
        }
        if (isset($array['time_for_creation'])) {
            unset($array['time_for_creation']);
        }
        if (isset($array['shop']['platform'])) {
            unset($array['shop']['platform']);
        }
        if (isset($array['shop']['version'])) {
            unset($array['shop']['version']);
        }
        if (isset($array['shop']['agency'])) {
            unset($array['shop']['agency']);
        }
        if (isset($array['shop']['email'])) {
            unset($array['shop']['email']);
        }
        if (isset($array['shop']['local_delivery_cost'])) {
            unset($array['shop']['local_delivery_cost']);
        }
        if (isset($array['COMP_CODE'])) {
            unset($array['COMP_CODE']);
        }
        if (isset($array['LANG'])) {
            unset($array['LANG']);
        }
        if (isset($array['COMP_CODE_BUYER'])) {
            unset($array['COMP_CODE_BUYER']);
        }
        if (isset($array['SEARCH_CODE'])) {
            unset($array['SEARCH_CODE']);
        }
        if (isset($array['MANUFACTURER_NAME'])) {
            unset($array['MANUFACTURER_NAME']);
        }
        if (isset($array['TYPE_NAME'])) {
            unset($array['TYPE_NAME']);
        }
        if (isset($array['SUPPLY_TYPE'])) {
            unset($array['SUPPLY_TYPE']);
        }
        if (isset($array['SUPPLIER'])) {
            unset($array['SUPPLIER']);
        }
        if (isset($array['TIME'])) {
            unset($array['TIME']);
        }
        if (isset($array['LANGUAGE'])) {
            unset($array['LANGUAGE']);
        }
        if (isset($array['total_products'])) {
            unset($array['total_products']);
        }
        if (isset($array['MessageNumber'])) {
            unset($array['MessageNumber']);
        }
        if (isset($array['MessageFunctionCode'])) {
            unset($array['MessageFunctionCode']);
        }
        if (isset($array['MessageDate'])) {
            unset($array['MessageDate']);
        }
        if (isset($array['ETIMVersion'])) {
            unset($array['ETIMVersion']);
        }
        if (isset($array['Datapool'])) {
            unset($array['Datapool']);
        }
        if (isset($array['RETURN_STATUS'])) {
            unset($array['RETURN_STATUS']);
        }
        if (isset($array['STATUS_TEXT'])) {
            unset($array['STATUS_TEXT']);
        }
        if (isset($array['CUSTOMER_NUMBER'])) {
            unset($array['CUSTOMER_NUMBER']);
        }
        if (isset($array['CURRENCY'])) {
            unset($array['CURRENCY']);
        }
        if (isset($array['PRICELIST_DATE'])) {
            unset($array['PRICELIST_DATE']);
        }
        if (isset($array['Mensaje'])) {
            unset($array['Mensaje']);
        }
        if (isset($array['Estado'])) {
            unset($array['Estado']);
        }
        if (isset($array['ib_note'])) {
            unset($array['ib_note']);
        }
        if (isset($array['generator'])) {
            unset($array['generator']);
        }
        if (isset($array['categories_list'])) {
            unset($array['categories_list']);
        }
        if ($entity == 'combination' && isset($array['Produs']) && is_array($array['Produs']) && isset($array['Produs'][0]) && is_array($array['Produs'][0]) && isset($array['Produs'][0]['Combinatii'])) {
            foreach ($array['Produs'] as $key => $produs) {
                $array['Produs'][$key]['Combination Attributes'] = '';
                $array['Produs'][$key]['Combination Values'] = '';
                $array['Produs'][$key]['Combination Referinta'] = '';
                $array['Produs'][$key]['Combination EAN13'] = '';
                $array['Produs'][$key]['Combination DataDisponibilitate'] = '';
                $array['Produs'][$key]['Combination StocFurnizor'] = '';
                $array['Produs'][$key]['Combination Stoc'] = '';
                if (isset($produs['Combinatii']) && is_array($produs['Combinatii']) && isset($produs['Combinatii']['Combinatie']) && is_array($produs['Combinatii']['Combinatie']) && $produs['Combinatii']['Combinatie']) {
                    if (isset($produs['Combinatii']['Combinatie'][0]) && is_array($produs['Combinatii']['Combinatie'][0]) && isset($produs['Combinatii']['Combinatie'][0]['Nume'])) {
                        foreach ($produs['Combinatii']['Combinatie'] as $combination_key => $combinatie) {
                            $combinatie_numes = explode(';', $combinatie['Nume']);
                            if ($combination_key === 0) {
                                foreach ($combinatie_numes as $combinatie_nume) {
                                    $combinatie_nume = explode(':', $combinatie_nume);
                                    $array['Produs'][$key]['Combination Attributes'] .= $array['Produs'][$key]['Combination Attributes'] ? $multiple_value_separator : '';
                                    $array['Produs'][$key]['Combination Attributes'] .= trim($combinatie_nume[0]);
                                    $array['Produs'][$key]['Combination Values'] .= $array['Produs'][$key]['Combination Values'] ? $multiple_value_separator : '';
                                    $array['Produs'][$key]['Combination Values'] .= trim($combinatie_nume[1]);
                                }
                                $array['Produs'][$key]['Combination Referinta'] = trim($combinatie['Referinta']);
                                $array['Produs'][$key]['Combination EAN13'] = trim($combinatie['EAN13']);
                                $array['Produs'][$key]['Combination DataDisponibilitate'] = trim($combinatie['DataDisponibilitate']);
                                $array['Produs'][$key]['Combination StocFurnizor'] = trim($combinatie['StocFurnizor']);
                                $array['Produs'][$key]['Combination Stoc'] = trim($combinatie['Stoc']);
                            } else {
                                $produs['Combination Attributes'] = '';
                                $produs['Combination Values'] = '';
                                foreach ($combinatie_numes as $combinatie_nume) {
                                    $combinatie_nume = explode(':', $combinatie_nume);
                                    $produs['Combination Attributes'] .= $produs['Combination Attributes'] ? $multiple_value_separator : '';
                                    $produs['Combination Attributes'] .= trim($combinatie_nume[0]);
                                    $produs['Combination Values'] .= $produs['Combination Values'] ? $multiple_value_separator : '';
                                    $produs['Combination Values'] .= trim($combinatie_nume[1]);
                                }
                                $produs['Combination Referinta'] = trim($combinatie['Referinta']);
                                $produs['Combination EAN13'] = trim($combinatie['EAN13']);
                                $produs['Combination DataDisponibilitate'] = trim($combinatie['DataDisponibilitate']);
                                $produs['Combination StocFurnizor'] = trim($combinatie['StocFurnizor']);
                                $produs['Combination Stoc'] = trim($combinatie['Stoc']);
                                $array['Produs'][] = $produs;
                            }
                        }
                    } elseif (isset($produs['Combinatii']['Combinatie']['Nume'])) {
                        $combinatie_numes = explode(';', $produs['Combinatii']['Combinatie']['Nume']);
                        foreach ($combinatie_numes as $combinatie_nume) {
                            $combinatie_nume = explode(':', $combinatie_nume);
                            $array['Produs'][$key]['Combination Attributes'] .= $array['Produs'][$key]['Combination Attributes'] ? $multiple_value_separator : '';
                            $array['Produs'][$key]['Combination Attributes'] .= trim($combinatie_nume[0]);
                            $array['Produs'][$key]['Combination Values'] .= $array['Produs'][$key]['Combination Values'] ? $multiple_value_separator : '';
                            $array['Produs'][$key]['Combination Values'] .= trim($combinatie_nume[1]);
                        }
                        $array['Produs'][$key]['Combination Referinta'] = trim($produs['Combinatii']['Combinatie']['Referinta']);
                        $array['Produs'][$key]['Combination EAN13'] = trim($produs['Combinatii']['Combinatie']['EAN13']);
                        $array['Produs'][$key]['Combination DataDisponibilitate'] = trim($produs['Combinatii']['Combinatie']['DataDisponibilitate']);
                        $array['Produs'][$key]['Combination StocFurnizor'] = trim($produs['Combinatii']['Combinatie']['StocFurnizor']);
                        $array['Produs'][$key]['Combination Stoc'] = trim($produs['Combinatii']['Combinatie']['Stoc']);
                    }
                }
            }
        }
        if (isset($array['Ladu'][0]['Rida']) && is_array($array['Ladu'][0]['Rida']) && isset($array['Ladu'][0]['Rida'][0]['s']) && isset($array['Ladu'][0]['Rida'][0]['a'])) {
            $array_new = array();
            foreach ($array['Ladu'] as $ladu) {
                $array_new = array_merge($array_new, $ladu['Rida']);
            }
            $array = $array_new;
            unset($array_new);
        }
        if (isset($array['CODEBOOKS']) && isset($array['PRODUCTS'])) {
            unset($array['CODEBOOKS']);
        }
        if (isset($array['Shopdaten']) && isset($array['Artikeldaten'])) {
            $array = $array['Artikeldaten'];
        }
        if (isset($array['priceInfo']['models']['model'])) {
            $array = $array['priceInfo']['models'];
            if (isset($array['@attributes'])) {
                unset($array['@attributes']);
            }
        }
        if (isset($array['stockFeed']['models']['model'])) {
            $array = $array['stockFeed']['models'];
            if (isset($array['@attributes'])) {
                unset($array['@attributes']);
            }
        }
        if (isset($array['productfeed']['@attributes'])) {
            unset($array['productfeed']['@attributes']);
        }
        if (isset($array['group']['o'][0]['@attributes']['id'])) {
            $array = $array['group']['o'];
        }
        if (isset($array['channel']['item'][0]['title'])) {
            $array = $array['channel']['item'];
        }
        if (isset($array['group']['@attributes']['name']) && isset($array['group']['product'])) {
            unset($array['group']['@attributes']);
        }
        if (isset($array['grupy'][0]['products'])) {
            $array = $array['grupy'][0]['products'];
        }
        if (isset($array['ProductCatalog']['Product'][0])) {
            $array = $array['ProductCatalog']['Product'];
        }

        // Step 4
        // Find array of products. Array of products are under a node which has numeric keys.
        $key = key($array);
        while ($key !== 0 && $key && isset($array[$key])) {
            $array = $array[$key];
            if (is_array($array)) {
                $key = key($array);
            } else {
                $key = false;
            }
        }

        if (!is_array($array)) {
            $array = $first_array;
        }

        // Step 5
        // Process products array before writing to csv
        if ($entity == 'combination' && isset($array[0]) && isset($array[0]['id']) && isset($array[0]['title']) && isset($array[0]['sku']) && isset($array[0]['categories']) && isset($array[0]['childrens'])) {
            foreach ($array as $key => $product) {
                if (isset($product['childrens']['child']) && is_array($product['childrens']['child'])) {
                    foreach ($product['childrens']['child'] as $child) {
                        $product['Combination SKU'] = $child['sku'];
                        $product['Size'] = $child['size'];
                        $product['Count'] = $child['count'];
                        unset($product['description']);
                        unset($product['childrens']);
                        $array[] = $product;
                    }
                    unset($array[$key]);
                }
            }
        } elseif ($entity == 'combination' && isset($array[0]) && isset($array[0]['model']) && isset($array[0]['category_name']) && isset($array[0]['variants'])) {
            foreach ($array as $key => $product) {
                if (isset($product['variants']['variant']) && is_array($product['variants']['variant'])) {
                    foreach ($product['variants']['variant'] as $variant) {
                        if (isset($variant['@attributes']['code']) && isset($variant['@attributes']['size'])) {
                            $product['Combination Code'] = $variant['@attributes']['code'];
                            $product['Size'] = $variant['@attributes']['size'];
                            unset($product['description']);
                            unset($product['description_long']);
                            unset($product['variants']);
                            $array[] = $product;
                        }
                    }
                    unset($array[$key]);
                }
            }
        } elseif ($entity == 'combination' && isset($array[0]) && isset($array[0]['NAME']) && isset($array[0]['ITEM_TYPE']) && isset($array[0]['VARIANTS'])) {
            foreach ($array as $key => $product) {
                if (isset($product['VARIANTS']['VARIANT']) && is_array($product['VARIANTS']['VARIANT'])) {
                    foreach ($product['VARIANTS']['VARIANT'] as $variant) {
                        if (isset($variant['PARAMETERS']['PARAMETER']) && is_array($variant['PARAMETERS']['PARAMETER'])) {
                            $comb_attributes = "";
                            $comb_values = "";
                            if (isset($variant['PARAMETERS']['PARAMETER']['NAME']) && isset($variant['PARAMETERS']['PARAMETER']['VALUE'])) {
                                $comb_attributes = $variant['PARAMETERS']['PARAMETER']['NAME'];
                                $comb_values = $variant['PARAMETERS']['PARAMETER']['VALUE'];
                            } elseif (isset($variant['PARAMETERS']['PARAMETER'][0]['NAME']) && isset($variant['PARAMETERS']['PARAMETER'][0]['VALUE'])) {
                                foreach ($variant['PARAMETERS']['PARAMETER'] as $parameter) {
                                    $comb_attributes .= $comb_attributes ? $multiple_value_separator : "";
                                    $comb_attributes .= $parameter['NAME'];
                                    $comb_values .= $comb_values ? $multiple_value_separator : "";
                                    $comb_values .= $parameter['VALUE'];
                                }
                            }
                            $product['VARIANT PARAMETER NAME'] = $comb_attributes;
                            $product['VARIANT PARAMETER VALUE'] = $comb_values;
                            $product['VARIANT CODE'] = $variant['CODE'];
                            $product['VARIANT EAN'] = $variant['EAN'];
                            $product['VARIANT CURRENCY'] = $variant['CURRENCY'];
                            $product['VARIANT VAT'] = $variant['VAT'];
                            $product['VARIANT PRICE'] = $variant['PRICE'];
                            $product['VARIANT PURCHASE_PRICE'] = $variant['PURCHASE_PRICE'];
                            $product['VARIANT STANDARD_PRICE'] = $variant['STANDARD_PRICE'];
                            $product['VARIANT PRICE_VAT'] = $variant['PRICE_VAT'];
                            $product['VARIANT AVAILABILITY'] = $variant['AVAILABILITY'];
                            unset($product['SHORT_DESCRIPTION']);
                            unset($product['DESCRIPTION']);
                            unset($product['CATEGORIES']);
                            unset($product['VARIANTS']);
                            $array[] = $product;
                        }
                    }
                    unset($array[$key]);
                }
            }
        } elseif ($entity == 'combination' && isset($array[0]['Product_code']) && isset($array[0]['Product_id'])) {
            // Check if this file has variants
            $variants_exist = false;
            foreach ($array as $key => $product) {
                if (isset($product['variants']['variant'][0]['spec']) || isset($product['variants']['variant']['spec'])) {
                    $variants_exist = true;
                    break;
                }
            }
            if ($variants_exist) {
                foreach ($array as $key => $product) {
                    if (isset($product['variants']['variant'][0]['spec'])) {
                        foreach ($product['variants']['variant'] as $variant) {
                            unset($variant['spec']); // This is taken care of in the beginning $xml
                            $new_product = array_merge(array('Product_code' => $product['Product_code']), $variant);
                            $array[] = $new_product;
                        }
                    } elseif (isset($product['variants']['variant']['spec'])) {
                        unset($product['variants']['variant']['spec']);
                        $new_product = array_merge(array('Product_code' => $product['Product_code']), $product['variants']['variant']);
                        $array[] = $new_product;
                    }
                    unset($array[$key]);
                }
            }
        } elseif (isset($array[0]) && isset($array[0]['inventory']['quantity']) && isset($array[0]['inventory']['price'])) {
            foreach ($array as $key => $product) {
                if (isset($product['inventory']) && is_array($product['inventory']) && isset($product['inventory']['quantity']) && isset($product['inventory']['price'])) {
                    $array[$key]['inventory_quantity'] = $product['inventory']['quantity'];
                    $array[$key]['inventory_price'] = $product['inventory']['price'];
                    unset($array[$key]['inventory']);
                }
            }
        } elseif (isset($first_array['SHOPITEM'][0]['ITEM_ID']) && isset($array[0]['EAN']) && isset($array[0]['PRODUCT'])) {
            $ITEMGROUP_IDs = array();
            foreach ($array as $key => $product) {
                if (isset($product['DELIVERY']) && is_array($product['DELIVERY']) && isset($product['DELIVERY'][0]['DELIVERY_ID']) && $product['DELIVERY'][0]['DELIVERY_ID'] && isset($product['DELIVERY'][0]['DELIVERY_PRICE'])) {
                    $delivery_id = "";
                    $delivery_price = "";
                    foreach ($product['DELIVERY'] as $delivery) {
                        if (isset($delivery['DELIVERY_ID']) && isset($delivery['DELIVERY_PRICE'])) {
                            $delivery_id .= $delivery_id ? $multiple_value_separator : "";
                            $delivery_id .= $delivery['DELIVERY_ID'];
                            $delivery_price .= $delivery_price ? $multiple_value_separator : "";
                            $delivery_price .= $delivery['DELIVERY_PRICE'];
                        }
                    }
                    $product['DELIVERY_ID'] = $delivery_id;
                    $product['DELIVERY_PRICE'] = $delivery_price;
                    $array[$key]['DELIVERY_ID'] = $delivery_id;
                    $array[$key]['DELIVERY_PRICE'] = $delivery_price;
                }
                if ($entity == 'product' && isset($product['ITEMGROUP_ID']) && isset($product['PARAM'])) {
                    if (!in_array($product['ITEMGROUP_ID'], $ITEMGROUP_IDs)) {
                        $ITEMGROUP_IDs[] = $product['ITEMGROUP_ID'];
                        $array[] = $product;
                    }
                    unset($array[$key]);
                } elseif ($entity == 'combination') {
                    if (isset($product['ITEMGROUP_ID']) && isset($product['PARAM'])) {
                        $attribute_names = "";
                        $attribute_values = "";
                        if (isset($product['PARAM']['PARAM_NAME'])) {
                            $attribute_names = $product['PARAM']['PARAM_NAME'];
                            $attribute_values = $product['PARAM']['VAL'];
                        } elseif (isset($product['PARAM'][0])) {
                            foreach ($product['PARAM'] as $param) {
                                $attribute_names .= $attribute_names ? $multiple_value_separator : "";
                                $attribute_names .= $param['PARAM_NAME'];
                                $attribute_values .= $attribute_values ? $multiple_value_separator : "";
                                $attribute_values .= $param['VAL'];
                            }
                        }
                        $array[$key]['AttributeNames'] = $attribute_names;
                        $array[$key]['AttributeValues'] = $attribute_values;
                        unset($array[$key]['PARAM']);
                    } else {
                        unset($array[$key]);
                    }
                }
            }
        } elseif (isset($first_array['Produkt'][0]['ID']) && isset($array[0]['WID']) && isset($array[0]['Ilosc']) && isset($array[0]['Nazwa'])) {
            $Produkt_IDs = array();
            if ($entity == 'product') {
                foreach ($array as $key => $product) {
                    if (isset($product['ID']) && $product['ID'] && !in_array($product['ID'], $Produkt_IDs)) {
                        $Produkt_IDs[] = $product['ID'];
                    } else {
                        unset($array[$key]);
                    }
                }
            } elseif ($entity == 'combination') {
                foreach ($array as $key => $product) {
                    if (isset($product['Atrybuty']) && isset($product['Atrybuty']['Atrybut'])) {
                        unset($array[$key]['Opis']);
                        $attribute_names = "";
                        $attribute_values = "";
                        if (isset($product['Atrybuty']['Atrybut'][0])) {
                            foreach ($product['Atrybuty']['Atrybut'] as $Atrybut) {
                                $attribute_names .= $attribute_names ? $multiple_value_separator : "";
                                $attribute_names .= $Atrybut['NazwaAtrybutu'];
                                $attribute_values .= $attribute_values ? $multiple_value_separator : "";
                                $attribute_values .= $Atrybut['WartoscAtrybutu'];
                            }
                        }
                        $array[$key]['AttributeNames'] = $attribute_names;
                        $array[$key]['AttributeValues'] = $attribute_values;
                        unset($array[$key]['Atrybuty']);
                    } else {
                        unset($array[$key]);
                    }
                }
            }
        } elseif ($entity == 'combination' && isset($first_array['product'][0]) && isset($array[0]['reward']) && isset($array[0]['product_id']) && isset($array[0]['reference'])) {
            foreach ($array as $key => $product) {
                if (isset($product['attributes']) && is_array($product['attributes'])) {
                    $product_attributes = $product['attributes'];
                    foreach ($product_attributes as $key => $attribute) {
                        if (isset($attribute['group_name']) && isset($attribute['attribute_name']) && isset($attribute['quantity'])) {
                            $product['attribute_reference'] = $product['reference'] . str_replace("attributes", "", $key);
                            $product['attribute_group_name'] = $attribute['group_name'];
                            $product['attribute_name'] = $attribute['attribute_name'];
                            $product['attribute_quantity'] = $attribute['quantity'];
                        }
                        unset($product['attributes']);
                        unset($product['description']);
                        unset($product['description_short']);
                        unset($product['meta_description']);
                        unset($product['manufacturer_name']);
                        $array[] = $product;
                    }
                    unset($array[$key]);
                }
            }
        } elseif ($entity == 'product' && isset($first_array['product'][0]['attr_group_1']) && isset($first_array['product'][0]['attribute_1']) && isset($first_array['product'][0]['attribute_value_1'])) {
            foreach ($array as $key => $product) {
                $features = "";
                for ($i = 1; $i <= 30; $i++) {
                    if (isset($product['attribute_' . $i]) && $product['attribute_' . $i] && isset($product['attribute_value_' . $i]) && $product['attribute_value_' . $i]) {
                        $features .= $features ? $multiple_value_separator : "";
                        $features .= $product['attribute_' . $i] . ':' . $product['attribute_value_' . $i];
                    }
                }
                $array[$key]['FEATURES'] = $features;
            }
        } elseif ($entity == 'product' && isset($first_array['product'][0]['product_names']['product_name'][0]['language_code']) && isset($first_array['product'][0]['product_names']['product_name'][0]['name'])) {
            foreach ($array as $key => $product) {
                if (isset($product['product_names']['product_name'])) {
                    if (isset($product['product_names']['product_name']['name'])) {
                        $array[$key]['product_name_' . $product['product_names']['product_name']['language_code']] = $product['product_names']['product_name']['name'];
                    } else {
                        foreach ($product['product_names']['product_name'] as $n) {
                            $array[$key]['product_name_' . $n['language_code']] = $n['name'];
                        }
                    }
                    unset($array[$key]['product_names']);
                }
                if (isset($product['product_descriptions']['product_description'])) {
                    if (isset($product['product_descriptions']['product_description']['description'])) {
                        $array[$key]['product_description_' . $product['product_descriptions']['product_description']['language_code']] = $product['product_descriptions']['product_description']['description'];
                    } else {
                        foreach ($product['product_descriptions']['product_description'] as $d) {
                            $array[$key]['product_description_' . $d['language_code']] = $d['description'];
                        }
                    }
                    unset($array[$key]['product_descriptions']);
                }
            }
        } elseif ($entity == 'product' && isset($first_array['productfeedRow'][0]['Model']) && isset($first_array['productfeedRow'][0]['ItemCode']) && isset($first_array['productfeedRow'][0]['ItemDesc']) && isset($first_array['productfeedRow'][0]['ExtDesc'])) {
            $Model_IDs = array();
            foreach ($array as $key => $product) {
                if (isset($product['Model']) && $product['Model'] && !in_array($product['Model'], $Model_IDs)) {
                    $Model_IDs[] = $product['Model'];
                } else {
                    unset($array[$key]);
                }
            }
        } elseif ($entity == 'combination' && isset($first_array['priceInfo']['models']['model'][0]['items']['item'])) {
            foreach ($array as $key => $product) {
                if (isset($product['items']['item'][0])) {
                    foreach ($product['items']['item'] as $item) {
                        $new_item = array(
                            'modelcode' => $product['@attributes']['modelcode'],
                            'itemcode' => $item['@attributes']['itemcode'],
                            'nettPrice' => $item['scales']['scale'][0]['nettPrice'],
                        );
                        $array[] = $new_item;
                    }
                } elseif (isset($product['items']['item']['scales'])) {
                    $new_item = array(
                        'modelcode' => $product['@attributes']['modelcode'],
                        'itemcode' => $product['items']['item']['@attributes']['itemcode'],
                        'nettPrice' => $product['items']['item']['scales']['scale'][0]['nettPrice'],
                    );
                    $array[] = $new_item;
                }
                unset($array[$key]);
            }
        } elseif ($entity == 'combination' && isset($first_array['stockFeed']['models']['model'][0]['items']['item'])) {
            foreach ($array as $key => $product) {
                if (isset($product['items']['item'][0])) {
                    foreach ($product['items']['item'] as $item) {
                        $new_item = array(
                            'modelCode' => $product['@attributes']['modelCode'],
                            'itemCode' => $item['@attributes']['itemCode'],
                            'stockDirect' => $item['stockDirect'],
                        );
                        $array[] = $new_item;
                    }
                } elseif (isset($product['items']['item']['stockDirect'])) {
                    $new_item = array(
                        'modelCode' => $product['@attributes']['modelCode'],
                        'itemCode' => $product['items']['item']['@attributes']['itemCode'],
                        'stockDirect' => $product['items']['item']['stockDirect'],
                    );
                    $array[] = $new_item;
                }
                unset($array[$key]);
            }
        } elseif (isset($first_array['article'][0]['article_nr']) && isset($first_array['article'][0]['article_configurations']['configuration'])) {
            if ($entity == 'product') {
                foreach ($array as $key => $product) {
                    $array[$key]['title_it'] = "";
                    $array[$key]['description_it'] = "";
                    $array[$key]['categories'] = "";
                    $array[$key]['price'] = "";

                    if (isset($product['article_configurations']['configuration'])) {
                        if (isset($product['article_configurations']['configuration']['code'])) {
                            $first_configuration = $product['article_configurations']['configuration'];
                        } else {
                            $first_configuration = $product['article_configurations']['configuration'][0];
                        }

                        $array[$key]['title_it'] = isset($first_configuration['title']['it']) ? $first_configuration['title']['it'] : "";
                        $array[$key]['description_it'] = isset($first_configuration['description']['it']) ? $first_configuration['description']['it'] : "";

                        if (isset($first_configuration['categories']['category'][0])) {
                            $all_cats = array();
                            foreach ($first_configuration['categories']['category'] as $cat) {
                                if (!in_array($cat['@attributes']['id'], $all_cats)) {
                                    $all_cats[$cat['@attributes']['id']] = $cat['it'];
                                }
                            }
                            foreach ($first_configuration['categories']['category'] as $cat) {
                                if (!isset($cat['@attributes']['parent_id'])) {
                                    continue;
                                }
                                if ($array[$key]['categories']) {
                                    $array[$key]['categories'] .= $multiple_value_separator;
                                }
                                if (isset($cat['@attributes']['parent_id']) && isset($all_cats[$cat['@attributes']['parent_id']])) {
                                    $array[$key]['categories'] .= $all_cats[$cat['@attributes']['parent_id']] . '/';
                                }
                                $array[$key]['categories'] .= $cat['it'];
                            }
                        }

                        $array[$key]['price'] = is_array($first_configuration['prices']['price']) ? end($first_configuration['prices']['price']) : "";

                        unset($array[$key]['article_configurations']);
                        unset($array[$key]['labels']);
                        unset($array[$key]['materials']);
                        unset($array[$key]['videos']);
                    }
                }
            } elseif ($entity == 'combination') {
                foreach ($array as $key => $product) {
                    if (isset($product['article_configurations']['configuration'][0]['code'])) {
                        foreach ($product['article_configurations']['configuration'] as $c) {
                            $new_item = array(
                                'article_nr' => $product['article_nr'],
                                'code' => $c['code'],
                                'ean' => $c['ean'],
                                'color' => $c['color']['it'],
                                'version' => $c['version']['it'],
                                'size' => $c['size']['it'],
                                'images' => $c['images'],
                            );
                            $array[] = $new_item;
                        }
                    } elseif (isset($product['article_configurations']['configuration']['code'])) {
                        $c = $product['article_configurations']['configuration'];
                        $new_item = array(
                            'article_nr' => $product['article_nr'],
                            'code' => $c['code'],
                            'ean' => $c['ean'],
                            'color' => $c['color']['it'],
                            'version' => $c['version']['it'],
                            'size' => $c['size']['it'],
                        );
                        $array[] = $new_item;
                    }
                    unset($array[$key]);
                }
            }
        } elseif ($entity == 'product' && isset($first_array['PRODUCTS']['PRODUCT'][0]['PRODUCT_NUMBER']) && isset($first_array['PRODUCTS']['PRODUCT'][0]['PRODUCT_BASE_NUMBER']) && isset($first_array['PRODUCTS']['PRODUCT'][0]['PRODUCT_PRINT_ID'])) {
            $PRODUCT_IDs = array();
            foreach ($array as $key => $product) {
                if (isset($product['PRODUCT_BASE_NUMBER']) && $product['PRODUCT_BASE_NUMBER'] && !in_array($product['PRODUCT_BASE_NUMBER'], $PRODUCT_IDs)) {
                    $PRODUCT_IDs[] = $product['PRODUCT_BASE_NUMBER'];
                } else {
                    unset($array[$key]);
                }
            }
        } elseif (isset($first_array['productfeed']['models']['model'][0]['items']['item'])) {
            if ($entity == 'product') {
                foreach ($array as $key => $product) {
                    $categoryData = array();
                    $first_item = array();
                    if (isset($product['items']['item'][0]['categoryData']['groupDesc'])) {
                        $first_item = $product['items']['item'][0];
                        $categoryData = $product['items']['item'][0]['categoryData'];
                    } elseif (isset($product['items']['item']['categoryData']['groupDesc'])) {
                        $first_item = $product['items']['item'];
                        $categoryData = $product['items']['item']['categoryData'];
                    }
                    $categoryDataText = "";
                    if (isset($categoryData['groupDesc']) && $categoryData['groupDesc']) {
                        $categoryDataText = $categoryData['groupDesc'];
                    }
                    if (isset($categoryData['catDesc']) && $categoryData['catDesc']) {
                        $categoryDataText .= $categoryDataText ? $multiple_value_separator : "";
                        $categoryDataText .= $categoryData['catDesc'];
                    }
                    $array[$key]['categoryData'] = $categoryDataText;

                    if (isset($first_item['colors']['color'])) {
                        if (isset($first_item['colors']['color'][0])) {
                            $first_item['colors']['color'] = $first_item['colors']['color'][0];
                        }
                        $first_item = array_merge($first_item, $first_item['colors']['color']);
                    }
                    if (isset($first_item['measurements'])) {
                        $first_item = array_merge($first_item, $first_item['measurements']);
                    }
                    unset($first_item['@attributes']);
                    unset($first_item['colors']);
                    unset($first_item['measurements']);
                    unset($first_item['decorationSettings']);
                    unset($first_item['categoryData']);
                    unset($first_item['battery']);
                    unset($first_item['imageData']);
                    unset($first_item['catalogues']);
                    unset($first_item['themes']);
                    unset($array[$key]['items']);

                    $array[$key] = array_merge($array[$key], $first_item);
                }
            } elseif ($entity == 'combination') {
                foreach ($array as $key => $product) {
                    $modelCode = isset($product['@attributes']['modelCode']) ? $product['@attributes']['modelCode'] : "";
                    if (isset($product['items']['item']['@attributes']['itemCode'])) {
                        $product['items']['item'] = array($product['items']['item']);
                    }
                    if (isset($product['items']['item'][0])) {
                        foreach ($product['items']['item'] as $item) {
                            $itemCode = isset($item['@attributes']['itemCode']) ? $item['@attributes']['itemCode'] : "";
                            if (isset($item['colors']['color'])) {
                                if (isset($item['colors']['color'][0])) {
                                    $item['colors']['color'] = $item['colors']['color'][0];
                                }
                                $item = array_merge($item, $item['colors']['color']);
                            }
                            if (isset($item['imageData'])) {
                                $item = array_merge($item, $item['imageData']);
                            }
                            if (isset($item['measurements'])) {
                                $item = array_merge($item, $item['measurements']);
                            }
                            unset($item['@attributes']);
                            unset($item['categoryData']);
                            unset($item['colors']);
                            unset($item['imageData']);
                            unset($item['measurements']);
                            unset($item['decorationSettings']);
                            unset($item['battery']);
                            unset($item['catalogues']);
                            unset($item['themes']);
                            $new_item = array_merge(array('modelCode' => $modelCode, 'itemCode' => $itemCode), $item);
                            $array[] = $new_item;
                        }
                    }
                    unset($array[$key]);
                }
            }
        } elseif (isset($first_array['articolo'][0]['@attributes']['codice']) && isset($first_array['articolo'][0]['articolo_padre']) && isset($first_array['articolo'][0]['nome_articolo'])) {
            $Produkt_IDs = array();
            if ($entity == 'product') {
                foreach ($array as $key => $product) {
                    if (isset($product['articolo_padre']) && $product['articolo_padre'] && !in_array($product['articolo_padre'], $Produkt_IDs)) {
                        $Produkt_IDs[] = $product['articolo_padre'];
                    } else {
                        unset($array[$key]);
                    }
                }
            } elseif ($entity == 'combination') {
                foreach ($array as $key => $product) {
                    if ((isset($product['deco_colore_articolo']) && $product['deco_colore_articolo']) || (isset($product['taglia_articolo']) && $product['taglia_articolo'])) {
                        // Make sure at least one attribute exists. Otherwise this product has no combinations.
                    } else {
                        unset($array[$key]);
                    }
                }
            }
        } elseif (isset($array[0]['STOCK']['AMOUNT']) && isset($array[0]['STOCK']['MINIMAL_AMOUNT'])) {
            foreach ($array as $key => $product) {
                if (isset($product['STOCK']['AMOUNT']) && isset($product['STOCK']['MINIMAL_AMOUNT'])) {
                    $array[$key]['STOCK_AMOUNT'] = $product['STOCK']['AMOUNT'];
                    $array[$key]['STOCK_MINIMAL_AMOUNT'] = $product['STOCK']['MINIMAL_AMOUNT'];
                    unset($array[$key]['STOCK']);
                }
            }
        } elseif (isset($array[0]['CHARACTERISTICS']['WEIGHT'])) {
            foreach ($array as $key => $product) {
                if (isset($product['CHARACTERISTICS']) && is_array($product['CHARACTERISTICS'])) {
                    foreach ($product['CHARACTERISTICS'] as $char_name => $char_value) {
                        $array[$key][$char_name] = $char_value;
                    }
                    unset($array[$key]['CHARACTERISTICS']);
                }
            }
        } elseif (isset($array[0]['ProductIdentifier']['ProductIDType']) && isset($array[0]['ProductIdentifier']['IDValue'])) {
            foreach ($array as $key => $product) {
                $array[$key]['NAME'] = '';
                if (isset($product['DescriptiveDetail']['TitleDetail']['TitleStatement'])) {
                    $array[$key]['NAME'] = $product['DescriptiveDetail']['TitleDetail']['TitleStatement'];
                }
                $array[$key]['EAN'] = '';
                if (isset($product['ProductIdentifier']['IDValue'])) {
                    $array[$key]['EAN'] = $product['ProductIdentifier']['IDValue'];
                }
                $array[$key]['DESCRIPTION'] = '';
                if (isset($product['CollateralDetail']['TextContent']['Text'])) {
                    $array[$key]['DESCRIPTION'] = $product['CollateralDetail']['TextContent']['Text'];
                }
                $array[$key]['WHOLESALE_PRICE'] = '';
                if (isset($product['ProductSupply']['SupplyDetail']['Price']['PriceAmount'])) {
                    $array[$key]['WHOLESALE_PRICE'] = $product['ProductSupply']['SupplyDetail']['Price']['PriceAmount'];
                }
                $array[$key]['CATEGORIES'] = '';
                if (isset($product['DescriptiveDetail']['Collection']['TitleDetail']['TitleElement']['TitleWithoutPrefix'])) {
                    $array[$key]['CATEGORIES'] = $product['DescriptiveDetail']['Collection']['TitleDetail']['TitleElement']['TitleWithoutPrefix'];
                }
                $array[$key]['PRODUCT_IMAGES'] = '';
                if (isset($product['CollateralDetail']['SupportingResource']) && is_array($product['CollateralDetail']['SupportingResource'])) {
                    foreach ($product['CollateralDetail']['SupportingResource'] as $supportingResource) {
                        if (isset($supportingResource['ResourceVersion']['ResourceLink'])) {
                            $array[$key]['PRODUCT_IMAGES'] .= $array[$key]['PRODUCT_IMAGES'] ? $multiple_value_separator : "";
                            $array[$key]['PRODUCT_IMAGES'] .= $supportingResource['ResourceVersion']['ResourceLink'];
                        }
                    }
                }
                unset($array[$key]['ProductIdentifier']);
                unset($array[$key]['DescriptiveDetail']);
                unset($array[$key]['CollateralDetail']);
                unset($array[$key]['PublishingDetail']);
                unset($array[$key]['ProductSupply']);
            }
        } elseif (isset($first_array['SHOPITEM'][0]['PRODUCT']) && isset($first_array['SHOPITEM'][0]['ID_PRODUCT']) && isset($first_array['SHOPITEM'][0]['SKUPINA']) && isset($first_array['SHOPITEM'][0]['ID_PRODUCT'])) {
            $product_refs = array();
            if ($entity == 'product') {
                foreach ($array as $key => $product) {
                    if (isset($product['PRODUCT']) && $product['PRODUCT'] && !in_array($product['PRODUCT'], $product_refs)) {
                        $product_refs[] = $product['PRODUCT'];
                    } else {
                        unset($array[$key]);
                    }
                }
            }
        } elseif ($entity == 'combination' && isset($first_array['SHOPITEM'][0]['PRODUCT_ID']) && isset($array[0]['PRODUCT_OPTIONS'])) {
            foreach ($array as $key => $product) {
                if (isset($product['DESCRIPTION'])) {
                    $array[$key]['DESCRIPTION'] = "";
                    $product['DESCRIPTION'] = "";
                }
                if (isset($product['CATEGORY'])) {
                    $array[$key]['CATEGORY'] = "";
                    $product['CATEGORY'] = "";
                }
                if ((isset($product['PRODUCT_OPTIONS']['OPTIONS']['OPTION_GROUP']) || isset($product['PRODUCT_OPTIONS']['OPTIONS'][0]['OPTION_GROUP'])) &&
                    (isset($product['PRODUCT_OPTIONS']['OPTIONS']['CHOICES']['CHOICE']) || isset($product['PRODUCT_OPTIONS']['OPTIONS'][0]['CHOICES']['CHOICE']))) {
                    if (!isset($product['PRODUCT_OPTIONS']['OPTIONS'][1])) {
                        $product['PRODUCT_OPTIONS']['OPTIONS'] = array($product['PRODUCT_OPTIONS']['OPTIONS']);
                    }
                    $tmp_product = $product;
                    $tmp_product['PRODUCT_OPTIONS'] = "";
                    foreach ($product['PRODUCT_OPTIONS']['OPTIONS'] as $OPTION) {
                        $tmp_product['PRODUCT_OPTIONS_GROUP'] = $OPTION['OPTION_GROUP'];
                        if (isset($OPTION['CHOICES']['CHOICE']['NAME'])) {
                            $OPTION['CHOICES']['CHOICE'] = array($OPTION['CHOICES']['CHOICE']);
                        }
                        foreach ($OPTION['CHOICES']['CHOICE'] as $CHOICE) {
                            $tmp_product['PRODUCT_OPTIONS_CHOICE_NAME'] = $CHOICE['NAME'];
                            $tmp_product['PRODUCT_OPTIONS_CHOICE_PRICE'] = $CHOICE['PRICE'];
                            $tmp_product['PRODUCT_OPTIONS_CHOICE_UPC'] = $CHOICE['UPC'];
                            $array[] = $tmp_product;
                        }
                    }
                    unset($array[$key]);
                }
            }
        } elseif (isset($first_array['SHOPITEM'][0]['ID']) && isset($first_array['SHOPITEM'][0]['PRODUCT']) && isset($first_array['SHOPITEM'][0]['CODE']) && isset($first_array['SHOPITEM'][0]['URL'])) {
            $ID_GROUPS = array();
            foreach ($array as $key => $product) {
                if ($entity == 'product') {
                    if (isset($product['ID_GROUP']) && $product['ID_GROUP']) {
                        if (in_array($product['ID_GROUP'], $ID_GROUPS)) {
                            unset($array[$key]);
                        } else {
                            $ID_GROUPS[] = $product['ID_GROUP'];
                            $array[$key]['ID'] = $product['ID_GROUP'];
                        }
                    }
                } elseif ($entity == 'combination') {
                    if (!isset($product['ID_GROUP']) || !$product['ID_GROUP']) {
                        unset($array[$key]);
                    } elseif (isset($product['SIZE']['NAME']) && isset($product['SIZE']['VALUE'])) {
                        $array[$key]['SIZE_NAME'] = $product['SIZE']['NAME'];
                        $array[$key]['SIZE_VALUE'] = str_replace(":", "∶", $product['SIZE']['VALUE']);
                    }
                }
            }
        } elseif ((isset($array[0]['name']['item'][0]['language_code']) && isset($array[0]['name']['item'][0]['text'])) || (isset($array[0]['description']['item'][0]['language_code']) && isset($array[0]['description']['item'][0]['text']))) {
            foreach ($array as $key => $product) {
                if (isset($product['name']['item'][0]['language_code']) && isset($product['name']['item'][0]['text'])) {
                    foreach ($product['name']['item'] as $name_item) {
                        $array[$key]['name_' . $name_item['language_code']] = $name_item['text'];
                    }
                    unset($array[$key]['name']);
                }
                if (isset($product['description']['item'][0]['language_code']) && isset($product['description']['item'][0]['text'])) {
                    foreach ($product['description']['item'] as $description_item) {
                        $array[$key]['description_' . $description_item['language_code']] = $description_item['text'];
                    }
                    unset($array[$key]['description']);
                }
            }
        } elseif (isset($array[0]['nazev']) && isset($array[0]['hlavniobrazek']) && isset($array[0]['dalsiobrazky']) && isset($array[0]['ceny']['moc']) && isset($array[0]['ceny']['voc'])) {
            foreach ($array as $key => $product) {
                if (isset($product['hlavniobrazek']['maly'])) {
                    unset($array[$key]['hlavniobrazek']['maly']);
                }
                if (isset($product['dalsiobrazky']['obrazek'])) {
                    if (isset($product['dalsiobrazky']['obrazek']['maly'])) {
                        $array[$key]['dalsiobrazky']['obrazek'] = array($product['dalsiobrazky']['obrazek']);
                    }
                    foreach ($array[$key]['dalsiobrazky']['obrazek'] as $i => $obrazek) {
                        if (isset($obrazek['maly'])) {
                            unset($array[$key]['dalsiobrazky']['obrazek'][$i]['maly']);
                        }
                    }
                }
                if (isset($product['ceny']['moc']['bezdph'])) {
                    $array[$key]['ceny_moc_bezdph'] = $product['ceny']['moc']['bezdph'];
                    if (isset($product['ceny']['moc']['sdph'])) {
                        $array[$key]['ceny_moc_sdph'] = $product['ceny']['moc']['sdph'];
                    }
                    if (isset($product['ceny']['voc']['bezdph'])) {
                        $array[$key]['ceny_voc_bezdph'] = $product['ceny']['voc']['bezdph'];
                    }
                    if (isset($product['ceny']['voc']['sdph'])) {
                        $array[$key]['ceny_voc_sdph'] = $product['ceny']['voc']['sdph'];
                    }
                    unset($array[$key]['ceny']);
                }
            }
        } elseif ($entity == 'combination' && isset($first_array['SHOPITEM'][0]['PRODUCT_ID']) && isset($array[0]['OBJEDNAVKA'])) {
            // check if it has VARIANT
            $has_variant = false;
            foreach ($array as $key => $product) {
                if (isset($product['VARIANT']['VARIANT_ID']) || isset($product['VARIANT'][0]['VARIANT_ID'])) {
                    $has_variant = true;
                    break;
                }
            }
            if ($has_variant) {
                foreach ($array as $key => $product) {
                    if (isset($product['VARIANT']['VARIANT_ID'])) {
                        $product['VARIANT'] = array($product['VARIANT']);
                    }
                    if (isset($product['DESCRIPTION'])) {
                        unset($product['DESCRIPTION']);
                    }
                    if (isset($product['DESCRIPTION_SHORT'])) {
                        unset($product['DESCRIPTION_SHORT']);
                    }
                    if (isset($product['CATEGORYTEXT'])) {
                        unset($product['CATEGORYTEXT']);
                    }
                    if (isset($product['VARIANT'][0]['VARIANT_ID'])) {
                        foreach ($product['VARIANT'] as $variant) {
                            if (!isset($variant['PARAM'][0])) {
                                $variant['PARAM'] = array($variant['PARAM']);
                            }
                            if (isset($variant['PARAM'][0]['PARAM_NAME']) && isset($variant['PARAM'][0]['VAL'])) {
                                $variant['PARAM_NAMES'] = "";
                                $variant['PARAM_VALS'] = "";
                                foreach ($variant['PARAM'] as $param) {
                                    $variant['PARAM_NAMES'] .= $variant['PARAM_NAMES'] ? $multiple_value_separator : "";
                                    $variant['PARAM_NAMES'] .= $param['PARAM_NAME'];
                                    $variant['PARAM_VALS'] .= $variant['PARAM_VALS'] ? $multiple_value_separator : "";
                                    $variant['PARAM_VALS'] .= $param['VAL'];
                                }
                            }
                            $tmp_product = array_merge($product, $variant);
                            unset($tmp_product['VARIANT']);
                            unset($tmp_product['PARAM']);

                            $array[] = $tmp_product;
                        }
                    }
                    unset($array[$key]);
                }
            }
        } elseif ($entity == 'product' && isset($array[0]['ITEM_ID']) && isset($array[0]['ITEMGROUP_ID'])) {
            $has_attachment = false;
            foreach ($array as $key => $product) {
                if (isset($product['FILE_ATTACHMENT']['ATTACHMENT_NAME']) || isset($product['FILE_ATTACHMENT'][0]['ATTACHMENT_NAME'])) {
                    $has_attachment = true;
                    break;
                }
            }
            if ($has_attachment) {
                foreach ($array as $key => $product) {
                    if (isset($product['FILE_ATTACHMENT']['ATTACHMENT_NAME'])) {
                        $product['FILE_ATTACHMENT'] = array($product['FILE_ATTACHMENT']);
                    }
                    if (isset($product['FILE_ATTACHMENT'][0]['ATTACHMENT_NAME'])) {
                        $attachment_names = "";
                        foreach ($product['FILE_ATTACHMENT'] as $file_attachment) {
                            if (isset($file_attachment['ATTACHMENT_NAME'])) {
                                $attachment_names .= $attachment_names ? $multiple_value_separator : "";
                                $attachment_names .= $file_attachment['ATTACHMENT_NAME'];
                            }
                        }
                        $array[$key]['ATTACHMENT_NAMES'] = $attachment_names;
                    }
                }
            }
        } elseif (isset($array[0]['id']) && isset($array[0]['barcode']) && isset($array[0]['variants']['variant']) && (isset($array[0]['variants']['variant']['@attributes']['group_title']) || isset($array[0]['variants']['variant'][0]['@attributes']['group_title']))) {
            foreach ($array as $key => $product) {
                if ($entity == 'product') {
                    unset($array[$key]['variants']);
                } else {
                    if (isset($product['variants']['variant']['title'])) {
                        $product['variants']['variant'] = [$product['variants']['variant']];
                    }
                    foreach ($product['variants']['variant'] as $variant) {
                        $tmp_product = $product;
                        $tmp_product['variant_group_title'] = isset($variant['@attributes']['group_title']) ? $variant['@attributes']['group_title'] : "";
                        $tmp_product['variant_title'] = isset($variant['title']) ? $variant['title'] : "";
                        $tmp_product['variant_quantity'] = isset($variant['quantity']) ? $variant['quantity'] : "";
                        $tmp_product['variant_barcode'] = isset($variant['barcode']) ? $variant['barcode'] : "";
                        $tmp_product['variant_price'] = isset($variant['price']) ? $variant['price'] : "";
                        unset($tmp_product['variants']);
                        $array[] = $tmp_product;
                    }
                    unset($array[$key]);
                }
            }
        } elseif (isset($first_array['@attributes']['file_format']) && isset($first_array['@attributes']['generated']) && isset($first_array['@attributes']['version']) && isset($first_array['@attributes']['extensions']) && isset($first_array['products']['product'])) {
            foreach ($array as $key => $product) {
                if (isset($product['description']['name'][0]) && is_array($product['description']['name'])) {
                    foreach ($product['description']['name'] as $key_name => $name) {
                        $product['name_' . ($key_name + 1)] = $name;
                    }
                } elseif (isset($product['description']['name'])) {
                    $product['name'] = $product['description']['name'];
                }
                if (isset($product['description']['long_desc'][0]) && is_array($product['description']['long_desc'])) {
                    foreach ($product['description']['long_desc'] as $key_long_desc => $long_desc) {
                        $product['long_desc_' . ($key_long_desc + 1)] = $long_desc;
                    }
                } elseif (isset($product['description']['long_desc'])) {
                    $product['long_desc'] = $product['description']['long_desc'];
                }
                if (isset($product['description']['short_desc'][0]) && is_array($product['description']['short_desc'])) {
                    foreach ($product['description']['short_desc'] as $key_short_desc => $short_desc) {
                        $product['short_desc_' . ($key_short_desc + 1)] = $short_desc;
                    }
                } elseif (isset($product['description']['short_desc'])) {
                    $product['short_desc'] = $product['description']['short_desc'];
                }
                unset($product['description']);
                if (isset($product['price']['@attributes']['gross']) && isset($product['price']['@attributes']['net'])) {
                    $product['price_gross'] = $product['price']['@attributes']['gross'];
                    $product['price_net'] = $product['price']['@attributes']['net'];
                    unset($product['price']);
                }
                if (isset($product['srp']['@attributes']['gross']) && isset($product['srp']['@attributes']['net'])) {
                    $product['srp_gross'] = $product['srp']['@attributes']['gross'];
                    $product['srp_net'] = $product['srp']['@attributes']['net'];
                    unset($product['srp']);
                }
                if (isset($product['strikethrough_retail_price']['@attributes']['gross']) && isset($product['strikethrough_retail_price']['@attributes']['net'])) {
                    $product['strikethrough_retail_price_gross'] = $product['strikethrough_retail_price']['@attributes']['gross'];
                    $product['strikethrough_retail_price_net'] = $product['strikethrough_retail_price']['@attributes']['net'];
                    unset($product['strikethrough_retail_price']);
                }
                if (isset($product['strikethrough_wholesale_price']['@attributes']['gross']) && isset($product['strikethrough_wholesale_price']['@attributes']['net'])) {
                    $product['strikethrough_wholesale_price_gross'] = $product['strikethrough_wholesale_price']['@attributes']['gross'];
                    $product['strikethrough_wholesale_price_net'] = $product['strikethrough_wholesale_price']['@attributes']['net'];
                    unset($product['strikethrough_wholesale_price']);
                }
                if (isset($product['parameters']['parameter']['@attributes'])) {
                    $product['parameters']['parameter'] = [$product['parameters']['parameter']];
                }
                if (isset($product['parameters']['parameter'][0]['@attributes']['name'])) {
                    $parameters = "";
                    foreach ($product['parameters']['parameter'] as $param) {
                        if (isset($param['@attributes']['name']) && isset($param['value']['@attributes']['name'])) {
                            $parameters .= $parameters ? $multiple_value_separator : "";
                            $parameters .= $param['@attributes']['name'] . ':"' . $param['value']['@attributes']['name'] . '"';
                        }
                    }
                    $product['parameters'] = $parameters;
                }
                if (isset($product['attachments']['file']['@attributes'])) {
                    $product['attachments']['file'] = [$product['attachments']['file']];
                }
                if (isset($product['attachments']['file'][0]['@attributes'])) {
                    $attachment_urls = "";
                    $attachment_names = "";
                    foreach ($product['attachments']['file'] as $attachment_file) {
                        $attachment_urls .= $attachment_urls ? $multiple_value_separator : "";
                        $attachment_urls .= $attachment_file['@attributes']['url'];
                        $attachment_names .= $attachment_names ? $multiple_value_separator : "";
                        $attachment_names .= $attachment_file['name'];
                    }
                    $product['attachments'] = $attachment_urls;
                    $product['attachment_names'] = $attachment_names;
                }
                if (isset($product['sizes']['size']['@attributes'])) {
                    $product['sizes']['size'] = [$product['sizes']['size']];
                }
                if ($entity == 'product') {
                    unset($product['sizes']);
                    $array[] = $product;
                } else {
                    if (isset($product['sizes']['size'][0]['@attributes']['id']) && isset($product['sizes']['size'][0]['price']) && isset($product['sizes']['size'][0]['srp'])) {
                        foreach ($product['sizes']['size'] as $size) {
                            $tmp_product = $product;
                            $tmp_product['size_id'] = $size['@attributes']['id'];
                            $tmp_product['size_name'] = $size['@attributes']['name'];
                            $tmp_product['size_panel_name'] = $size['@attributes']['panel_name'];
                            $tmp_product['size_code'] = $size['@attributes']['code'];
                            $tmp_product['size_weight'] = $size['@attributes']['weight'];
                            $tmp_product['size_code_producer'] = $size['@attributes']['code_producer'];
                            $tmp_product['size_available'] = isset($size['@attributes']['available']) ? $size['@attributes']['available'] : "";
                            $tmp_product['size_price_gross'] = $size['price']['@attributes']['gross'];
                            $tmp_product['size_price_net'] = $size['price']['@attributes']['net'];
                            $tmp_product['size_srp_gross'] = $size['srp']['@attributes']['gross'];
                            $tmp_product['size_srp_net'] = $size['srp']['@attributes']['net'];
                            if (isset($size['strikethrough_retail_price']['@attributes']['gross'])) {
                                $tmp_product['size_strikethrough_retail_price_gross'] = $size['strikethrough_retail_price']['@attributes']['gross'];
                            }
                            if (isset($size['strikethrough_retail_price']['@attributes']['net'])) {
                                $tmp_product['size_strikethrough_retail_price_net'] = $size['strikethrough_retail_price']['@attributes']['net'];
                            }
                            if (isset($size['strikethrough_wholesale_price']['@attributes']['gross'])) {
                                $tmp_product['size_strikethrough_wholesale_price_gross'] = $size['strikethrough_wholesale_price']['@attributes']['gross'];
                            }
                            if (isset($size['strikethrough_wholesale_price']['@attributes']['net'])) {
                                $tmp_product['size_strikethrough_wholesale_price_net'] = $size['strikethrough_wholesale_price']['@attributes']['net'];
                            }
                            if (isset($size['stock']['@attributes'])) {
                                $tmp_product['size_stock_quantity'] = $size['stock']['@attributes']['quantity'];
                            } elseif (isset($size['stock'][1]['@attributes'])) {
                                $tmp_product['size_stock_quantity'] = $size['stock'][1]['@attributes']['quantity'];
                            } else {
                                $tmp_product['size_stock_quantity'] = "";
                            }
                            unset($tmp_product['sizes']);
                            $array[] = $tmp_product;
                        }
                    } else {
                        unset($product['sizes']);
                        $array[] = $product;
                    }
                }
                unset($array[$key]);
            }
        } elseif (isset($array[0]['urun_id']) && isset($array[0]['urun_kodu']) && isset($array[0]['baslik'])) {
            foreach ($array as $key => $product) {
                if ($entity == 'product') {
                    unset($array[$key]['varyasyonlar']);
                } else {
                    if (isset($product['varyasyonlar']['varyasyon'])) {
                        if (isset($product['varyasyonlar']['varyasyon']['id'])) {
                            $product['varyasyonlar']['varyasyon'] = [$product['varyasyonlar']['varyasyon']];
                        }
                        foreach ($product['varyasyonlar']['varyasyon'] as $variant) {
                            $array[] = array_merge(array('urun_kodu' => $product['urun_kodu']), $variant);
                        }
                    }
                    unset($array[$key]);
                }
            }
        }

        unset($first_array);

        // Open file pointer
        $handle = fopen($file, 'w');

        // Step 6
        // Write CSV header
        // Build header from all rows, because some rows may have columns that does not exist on other rows.
        $header = array();
        foreach ($array as $product) {
            if (!is_array($product)) {
                continue;
            }
            if (isset($product['@attributes'])) {
                // Add attributes as columns
                $attributes = $product['@attributes'];
                unset($product['@attributes']);
                $product = array_merge($attributes, $product);
            }
            foreach ($product as $attr => $value) {
                if (!in_array($attr, $header)) {
                    $header[] = $attr;
                }
            }
        }
        fputcsv($handle, $header, ';', '"');

        // Step 7
        // Write each row to csv
        foreach ($array as $product) {
            if (!is_array($product)) {
                continue;
            }
            if (isset($product['@attributes'])) {
                // Add attributes as columns
                $attributes = $product['@attributes'];
                unset($product['@attributes']);
                $product = array_merge($attributes, $product);
            }
            // Remove unwanted data
            if (isset($product['category']['@attributes']['id'])) {
                unset($product['category']['@attributes']['id']);
            }
            if (isset($product['category_idosell']['@attributes']['id'])) {
                unset($product['category_idosell']['@attributes']['id']);
            }
            if (isset($product['producer']['@attributes']['id'])) {
                unset($product['producer']['@attributes']['id']);
            }
            if (isset($product['unit']['@attributes']['id'])) {
                unset($product['unit']['@attributes']['id']);
            }
            if (isset($product['Manufacturer']['Id'])) {
                unset($product['Manufacturer']['Id']);
            }
            if (isset($product['Tax']['Id'])) {
                unset($product['Tax']['Id']);
            }
            if (isset($product['warranty']['@attributes']['id'])) {
                unset($product['warranty']['@attributes']['id']);
            }
            if (isset($product['warranty']['@attributes']['type'])) {
                unset($product['warranty']['@attributes']['type']);
            }
            if (isset($product['warranty']['@attributes']['period'])) {
                unset($product['warranty']['@attributes']['period']);
            }
            if (isset($product['SellingPrices']['SellingPrice']['Price']) && $product['SellingPrices']['SellingPrice']['Price']) {
                $product['SellingPrices'] = $product['SellingPrices']['SellingPrice']['Price'];
            }
            if (isset($product['ProdCategories']['ProdCategory']['Id'])) {
                unset($product['ProdCategories']['ProdCategory']['Id']);
            }
            if (isset($product['ProdCategories']['ProdCategory']['Code'])) {
                unset($product['ProdCategories']['ProdCategory']['Code']);
            }
            if (isset($product['ProdCategories']['ProdCategory']['FullPathName']) && $product['ProdCategories']['ProdCategory']['FullPathName']) {
                $product['ProdCategories'] = explode(' / ', $product['ProdCategories']['ProdCategory']['FullPathName']);
                if (isset($product['MainProdCategory'])) {
                    $product['MainProdCategory'] = $product['ProdCategories'];
                }
            }
            if (isset($product['ProdCategories']['ProdCategory'][0]['FullPathName']) && $product['ProdCategories']['ProdCategory'][0]['FullPathName']) {
                if (isset($product['MainProdCategory']) && $product['MainProdCategory']) {
                    $MainProdCategory = $product['MainProdCategory'];
                    // default value
                    $product['MainProdCategory'] = explode(' / ', $product['ProdCategories']['ProdCategory'][0]['FullPathName']);
                    // find default category by id
                    foreach ($product['ProdCategories']['ProdCategory'] as $key => $ProdCategory) {
                        if ($ProdCategory['Id'] == $MainProdCategory) {
                            $product['MainProdCategory'] = explode(' / ', $ProdCategory['FullPathName']);
                            unset($product['ProdCategories']['ProdCategory'][$key]);
                            break;
                        }
                    }
                }
                $product['ProdCategories']['ProdCategory'] = reset($product['ProdCategories']['ProdCategory']);
                $product['ProdCategories'] = explode(' / ', $product['ProdCategories']['ProdCategory']['FullPathName']);
            }
            if (isset($product['Photos']['Photo']) && $product['Photos']['Photo'] && is_array($product['Photos']['Photo'])) {
                if (isset($product['Photos']['Photo'][0]) && is_array($product['Photos']['Photo'][0])) {
                    foreach ($product['Photos']['Photo'] as &$photo) {
                        if (isset($photo['RelativeFilePath'])) {
                            $photo = $photo['RelativeFilePath'];
                        }
                    }
                } elseif (isset($product['Photos']['Photo']['RelativeFilePath'])) {
                    $product['Photos']['Photo'] = $product['Photos']['Photo']['RelativeFilePath'];
                }
            }
            if (isset($product['ITEMGROUP_ID']) || isset($product['ITEM_GROUP_ID'])) {
                if (isset($product['PRODUCTNAME']) && isset($product['VARIANT']) && $product['VARIANT']) {
                    $product['PRODUCTNAME'] .= " - " . $product['VARIANT'];
                }
            }
            if (isset($product['PARAM']) && $product['PARAM'] && is_array($product['PARAM'])) {
                if (isset($product['PARAM']['PARAM_NAME']) && isset($product['PARAM']['VAL'])) {
                    $product['PARAM'] = array($product['PARAM']);
                }
                if (isset($product['PARAM'][0]['PARAM_NAME']) && isset($product['PARAM'][0]['VAL'])) {
                    $params = "";
                    foreach ($product['PARAM'] as $param) {
                        if (isset($param['PARAM_NAME']) && $param['PARAM_NAME'] && isset($param['VAL'])) {
                            $params .= $params ? $multiple_value_separator : "";
                            $params .= str_replace(":", "∶", trim($param['PARAM_NAME'])) . ":" . str_replace(":", "∶", trim($param['VAL'])) . (isset($param['UNIT']) && $param['VAL'] ? " " . trim($param['UNIT']) : "");
                        }
                    }
                    $product['PARAM'] = $params;
                }
            }
            if (isset($product['Categoria']) && isset($product['SubCat1']) && isset($product['SubCat2'])) {
                if ($product['SubCat1']) {
                    $product['Categoria'] .= ',' . $product['SubCat1'];
                }
                if ($product['SubCat2']) {
                    $product['Categoria'] .= ',' . $product['SubCat2'];
                }
            }
            if (isset($product['IMGURL']) && isset($product['IMGURL_ALTERNATIVE']) && $product['IMGURL_ALTERNATIVE']) {
                if (is_array($product['IMGURL_ALTERNATIVE'])) {
                    $product['IMGURL'] = array_merge(array($product['IMGURL']), $product['IMGURL_ALTERNATIVE']);
                } else {
                    $product['IMGURL'] = array($product['IMGURL'], $product['IMGURL_ALTERNATIVE']);
                }
            }
            if (isset($product['stock']['inStockLocal']) && isset($product['stock']['inStockCentral'])) {
                $product['stock'] = $product['stock']['inStockLocal'] ? $product['stock']['inStockLocal'] : $product['stock']['inStockCentral'];
            }
            if (isset($product['priceLevels']['normalPricing']['price'])) {
                $product['priceLevels'] = $product['priceLevels']['normalPricing']['price'];
            }
            if (isset($product['description']) && is_array($product['description']) && isset($product['description']['name'][0]) && is_array($product['description']['name']) && isset($product['description']['long_desc'][0])) {
                $product['description'] = $product['description']['long_desc'][0];
            }
            if (isset($product['price']) && is_array($product['price']) && isset($product['price']['@attributes']['gross']) && isset($product['price']['@attributes']['net']) && isset($product['price']['@attributes']['vat'])) {
                $product['price'] = $product['price']['@attributes']['vat'];
            }
            if (isset($product['images']['icons']['icon'])) {
                unset($product['images']['icons']);
            }
            if (isset($product['images']['icons']['icon'])) {
                unset($product['images']['icons']);
            }
            if (isset($product['images']['large']['image']['@attributes']['url'])) {
                $product['images'] = $product['images']['large']['image']['@attributes']['url'];
            }
            if (isset($product['images']['large']['image'][0]['@attributes']['url'])) {
                $images = "";
                foreach ($product['images']['large']['image'] as $image) {
                    $images .= $images ? $multiple_value_separator : "";
                    $images .= $image['@attributes']['url'];
                }
                $product['images'] = $images;
            }
            if (isset($product['Tax']) && isset($product['Tax']['Code']) && isset($product['Tax']['PercentAmount'])) {
                $product['Tax'] = $product['Tax']['PercentAmount'] . '% VAT';
            }
            if (isset($product['arrivi']['arrivo']['qta'])) {
                $product['arrivi'] = $product['arrivi']['arrivo']['qta'];
            }
            if (isset($product['arrivi']['arrivo'][0]['qta'])) {
                $product['arrivi'] = $product['arrivi']['arrivo'][0]['qta'];
            }
            if (isset($product['Pctrs']['@attributes'])) {
                unset($product['Pctrs']['@attributes']);
            }
            if (isset($product['AttrSet']['@attributes'])) {
                unset($product['AttrSet']['@attributes']);
            }
            if (isset($product['AttrSet']['ItmAttr']) && is_array($product['AttrSet']['ItmAttr']) && $product['AttrSet']['ItmAttr']) {
                $AttrSet = "";
                foreach ($product['AttrSet']['ItmAttr'] as $key => $ItmAttr) {
                    if (isset($ItmAttr['@attributes']['No']) && isset($ItmAttr['@attributes']['Desc'])) {
                        $AttrSet .= $AttrSet ? $multiple_value_separator : "";
                        $AttrSet .= $ItmAttr['@attributes']['Desc'] . ":" . $ItmAttr['@attributes']['No'] . ":" . ($key + 1) . ":0";
                    }
                }
                $product['AttrSet'] = $AttrSet;
            }
            if (isset($product['Cats']['Cat'][0]['Sub']) && is_array($product['Cats']['Cat'][0]['Sub'])) {
                foreach ($product['Cats']['Cat'] as $key => $cat) {
                    if (is_array($cat['Sub']) && $cat['Sub']) {
                        $subCats = "";
                        foreach ($cat['Sub'] as $sub) {
                            $subCats .= $subCats ? "/" : "";
                            $subCats .= $sub;
                        }
                        $product['Cats']['Cat'][$key] = $subCats;
                    }
                }
            }
            if (isset($product['ProductCode']) && isset($product['AttrList']) && is_array($product['AttrList']) && isset($product['AttrList']['element']) && is_array($product['AttrList']['element'])) {
                $AttrListFeatures = "";
                if (isset($product['AttrList']['element']['@attributes']) && isset($product['AttrList']['element']['@attributes']['Name']) && $product['AttrList']['element']['@attributes']['Name'] && isset($product['AttrList']['element']['@attributes']['Value']) && $product['AttrList']['element']['@attributes']['Value']) {
                    $AttrListFeatures = $product['AttrList']['element']['@attributes']['Name'] . ':' . Tools::substr(strip_tags($product['AttrList']['element']['@attributes']['Value']), 0, 255);
                } else {
                    foreach ($product['AttrList']['element'] as $AttrListElement) {
                        if (isset($AttrListElement['@attributes']) && is_array($AttrListElement['@attributes']) && isset($AttrListElement['@attributes']['Name']) && $AttrListElement['@attributes']['Name'] && isset($AttrListElement['@attributes']['Value']) && $AttrListElement['@attributes']['Value']) {
                            $AttrListFeatures .= $AttrListFeatures ? $multiple_value_separator : '';
                            $AttrListFeatures .= $AttrListElement['@attributes']['Name'] . ':' . Tools::substr(strip_tags($AttrListElement['@attributes']['Value']), 0, 255);
                        }
                    }
                }
                $product['AttrList'] = $AttrListFeatures;
            }
            if ($entity == 'product' && isset($product['attributes']['attribute']) && is_array($product['attributes']['attribute'])) {
                $product_attributes_final = "";
                if (isset($product['attributes']['attribute']['@attributes']) && is_array($product['attributes']['attribute']['@attributes'])) {
                    $product['attributes']['attribute'] = array($product['attributes']['attribute']);
                }
                foreach ($product['attributes']['attribute'] as $product_attributes) {
                    if (isset($product_attributes['attributetitle']) && isset($product_attributes['attributevalue'])) {
                        $product_attributes_final .= $product_attributes_final ? $multiple_value_separator : '';
                        $product_attributes_final .= $product_attributes['attributetitle'] . ':' . $product_attributes['attributevalue'];
                    } elseif (isset($product_attributes['@attributes']['name']) && isset($product_attributes['values']['value'])) {
                        $product_attributes_final .= $product_attributes_final ? $multiple_value_separator : '';
                        $product_attributes_final .= $product_attributes['@attributes']['name'] . ':' . (is_array($product_attributes['values']['value']) ? implode('/', $product_attributes['values']['value']) : $product_attributes['values']['value']);
                    }
                }
                $product['attributes'] = $product_attributes_final;
            }
            if ($entity == 'product' && isset($product['prices']['price']) && is_array($product['prices']['price']) && isset($product['prices']['price'][0]['price_sell'])) {
                $product['prices'] = $product['prices']['price'][0]['price_sell'];
            }
            if (isset($product['artnum']) && isset($product['attributes']) && is_array($product['attributes']) && isset($product['attributes']['attribute']) && is_array($product['attributes']['attribute'])) {
                if (isset($product['attributes']['attribute'][0]['attributetitle']) && isset($product['attributes']['attribute'][0]['attributevalue'])) {
                    $features = "";
                    foreach ($product['attributes']['attribute'] as $feature) {
                        $features .= $features ? $multiple_value_separator : "";
                        $features .= $feature['attributetitle'] . ":" . $feature['attributevalue'];
                    }
                    $product['attributes'] = $features;
                } elseif (isset($product['attributes']['attribute']['attributetitle']) && isset($product['attributes']['attribute']['attributevalue'])) {
                    $product['attributes'] = $product['attributes']['attribute']['attributetitle'] . ":" . $product['attributes']['attribute']['attributevalue'];
                }
            }
            if (isset($product['IdProdus']) && $product['IdProdus'] && isset($product['Stoc']) && isset($product['StocFurnizor'])) {
                if ($product['StocFurnizor'] > $product['Stoc']) {
                    $product['Stoc'] = $product['StocFurnizor'];
                }
            }
            if (isset($product['TECHNICAL_ATTACHMENT']['ITEM'][0]['URL'])) {
                $tech_attachment = "";
                foreach ($product['TECHNICAL_ATTACHMENT']['ITEM'] as $tech_attach_item) {
                    $tech_attachment .= $tech_attachment ? $multiple_value_separator : "";
                    $tech_attachment .= $tech_attach_item['URL'];
                }
                $product['TECHNICAL_ATTACHMENT'] = trim($tech_attachment);
            }
            if (isset($product['id']) && isset($product['group']['category']['name'])) {
                $group_category = $product['group']['category']['name'];
                if (isset($product['group']['category']['subcategory']['name'])) {
                    $group_category .= $multiple_value_separator . $product['group']['category']['subcategory']['name'];
                }
                $product['group'] = $group_category;
            }
            if (isset($product['id']) && isset($product['filters']['filter'])) {
                $features = "";
                if (isset($product['filters']['filter'][0]['name']) && isset($product['filters']['filter'][0]['value'])) {
                    foreach ($product['filters']['filter'] as $filter) {
                        $features .= $features ? $multiple_value_separator : "";
                        $features .= $filter['name'] . ':' . $filter['value'];
                    }
                } elseif (isset($product['filters']['filter']['name']) && isset($product['filters']['filter']['value'])) {
                    $features = $product['filters']['filter']['name'] . ':' . $product['filters']['filter']['value'];
                }
                $product['filters'] = $features;
            }
            if (isset($product['sku']) && isset($product['title']) && isset($product['characteristics']['attribute']['@attributes']) && $product['characteristics']['attribute']['@attributes']) {
                $characteristics = "";
                foreach ($product['characteristics']['attribute']['@attributes'] as $attr_key => $attr_value) {
                    $characteristics .= $characteristics ? $multiple_value_separator : "";
                    $characteristics .= $attr_key . ':' . $attr_value;
                }
                $product['characteristics'] = $characteristics;
            }
            if (isset($product['categories']['category'][0]['name']) && isset($product['categories']['category'][0]['level']) && isset($product['categories']['category'][0]['externalId'])) {
                $product['categories']['category'] = array_reverse($product['categories']['category']);
                $categories = "";
                foreach ($product['categories']['category'] as $c) {
                    if (isset($c['name']) && $c['name']) {
                        $categories .= $categories ? $multiple_value_separator : "";
                        $categories .= $c['name'];
                    }
                }
                $product['categories'] = $categories;
            }
            if (isset($product['allCategories']['category']['name']) && isset($product['allCategories']['category']['externalId']) && isset($product['allCategories']['category']['primary'])) {
                $product['allCategories'] = $product['allCategories']['category']['name'];
            } elseif (isset($product['allCategories']['category'][0]['name']) && isset($product['allCategories']['category'][0]['externalId']) && isset($product['allCategories']['category'][0]['primary'])) {
                $allCategories = "";
                foreach ($product['allCategories']['category'] as $c) {
                    if (isset($c['primary']) && $c['primary']) {
                        $allCategories = $c['name'];
                        break;
                    }
                }
                $product['allCategories'] = $allCategories;
            }
            if (isset($product['AVAILABILITY']['img']['@attributes']['alt'])) {
                $product['AVAILABILITY'] = $product['AVAILABILITY']['img']['@attributes']['alt'];
            }
            if (isset($product['PHOTOS']['PHOTO_0']['URL'])) {
                $photos = "";
                foreach ($product['PHOTOS'] as $photo) {
                    if (isset($photo['URL'])) {
                        $photos .= $photos ? $multiple_value_separator : "";
                        $photos .= $photo['URL'];
                    }
                }
                $product['PHOTOS'] = $photos;
            }
            if (isset($product['product_categories']['@attributes']['prod_cat_num'])) {
                unset($product['product_categories']['@attributes']);
            }
            if (isset($product['price']['@attributes']) && isset($product['price']['price_original'])) {
                $product['price'] = $product['price']['price_original'];
            }
            if (isset($product['availability']['@attributes']['quantity'])) {
                $product['availability'] = $product['availability']['@attributes']['quantity'];
            }
            if (isset($product['specification']['property'][0]['name']) && isset($product['specification']['property'][0]['values']['value'])) {
                $features = "";
                foreach ($product['specification']['property'] as $property) {
                    if (isset($property['name']) && $property['name'] && isset($property['values']['value']) && $property['values']['value']) {
                        if (is_array($property['values']['value'])) {
                            foreach ($property['values']['value'] as $property_val) {
                                $features .= $features ? $multiple_value_separator : "";
                                $features .= $property['name'] . ':' . $property_val;
                            }
                        } else {
                            $features .= $features ? $multiple_value_separator : "";
                            $features .= $property['name'] . ':' . $property['values']['value'];
                        }
                    }
                }
                $product['specification'] = $features;
            }
            if (isset($product['product_listprices']['product_listprice']['listprice_value'])) {
                $product['product_listprices'] = $product['product_listprices']['product_listprice']['listprice_value'];
            }
            if (isset($product['product_retail_prices']['product_retail_price']['retail_price_value'])) {
                $product['product_retail_prices'] = $product['product_retail_prices']['product_retail_price']['retail_price_value'];
            }
            if (isset($product['category']['id']) && isset($product['category']['name'])) {
                $product['category'] = $product['category']['name'];
            }
            if (isset($product['additional_variant_attribute']['label']) && isset($product['additional_variant_attribute']['value'])) {
                $product['additional_variant_attribute'] = $product['additional_variant_attribute']['label'] . ':' . $product['additional_variant_attribute']['value'];
            }
            if (isset($product['ATTRIBUTE_LIST']['ATTRIBUTE'][0]['@attributes']['name']) && isset($product['ATTRIBUTE_LIST']['ATTRIBUTE'][0]['@attributes']['value'])) {
                $attr_list = "";
                foreach ($product['ATTRIBUTE_LIST']['ATTRIBUTE'] as $atr) {
                    $attr_list .= $attr_list ? $multiple_value_separator : "";
                    $attr_list .= $atr['@attributes']['name'] . ':' . $atr['@attributes']['value'];
                }
                $product['ATTRIBUTE_LIST'] = $attr_list;
            }
            if (isset($product['Description']['@attributes']['locale']) && count($product['Description']['@attributes']) == 1) {
                $product['Description'] = "";
            }
            if (isset($product['Attribute'][0]['Name']) && isset($product['Attribute'][0]['Value'])) {
                $attr_list = "";
                foreach ($product['Attribute'] as $atr) {
                    $attr_list .= $attr_list ? $multiple_value_separator : "";
                    $attr_list .= $atr['Name'] . ':' . $atr['Value'];
                }
                $product['Attribute'] = $attr_list;
            }
            if (isset($product['especificacion']['caracteristica1']['tipo']) && isset($product['especificacion']['caracteristica1']['valor'])) {
                $especificacion = "";
                foreach ($product['especificacion'] as $param) {
                    $especificacion .= $especificacion ? $multiple_value_separator : "";
                    $especificacion .= $param['tipo'] . ':' . $param['valor'];
                }
                $product['especificacion'] = $especificacion;
            }
            if (isset($product['existencia']) && is_array($product['existencia']) && Validate::isInt(reset($product['existencia']))) {
                $product['existencia'] = array_sum($product['existencia']);
            }
            if (isset($product['OTHERIMAGES']['OTHERIMG']) && is_array($product['OTHERIMAGES']['OTHERIMG'])) {
                $otherimages = "";
                if (isset($product['OTHERIMAGES']['OTHERIMG']['OTHERIMGURL'])) {
                    $product['OTHERIMAGES']['OTHERIMG'] = array($product['OTHERIMAGES']['OTHERIMG']);
                }
                foreach ($product['OTHERIMAGES']['OTHERIMG'] as $otherimg) {
                    if (isset($otherimg['OTHERIMGURL']) && $otherimg['OTHERIMGURL']) {
                        $otherimages .= $otherimages ? $multiple_value_separator : "";
                        $otherimages .= $otherimg['OTHERIMGURL'];
                    }
                }
                $product['OTHERIMAGES'] = $otherimages;
            }
            if (isset($product['PARAMETERS']['PARAMETER']) && is_array($product['PARAMETERS']['PARAMETER'])) {
                $params = "";
                if (isset($product['PARAMETERS']['PARAMETER']['NAME'])) {
                    $product['PARAMETERS']['PARAMETER'] = array($product['PARAMETERS']['PARAMETER']);
                }
                foreach ($product['PARAMETERS']['PARAMETER'] as $param) {
                    if (isset($param['NAME']) && $param['NAME'] && isset($param['VAL'])) {
                        $params .= $params ? $multiple_value_separator : "";
                        $params .= trim($param['NAME']) . ":" . trim($param['VAL']);
                    }
                }
                $product['PARAMETERS'] = $params;
            }
            if (isset($product['Images']['Image']['@attributes']['url']) || isset($product['Images']['Image'][0]['@attributes']['url'])) {
                if (isset($product['Images']['Image']['@attributes']['url'])) {
                    $product['Images']['Image'] = array($product['Images']['Image']);
                }
                $images = "";
                foreach ($product['Images']['Image'] as $image) {
                    if (isset($image['@attributes']['url'])) {
                        $images .= $images ? $multiple_value_separator : "";
                        $images .= trim($image['@attributes']['url']);
                    }
                }
                $product['Images'] = $images;
            }
            if (isset($product['stockInfo']['stockInfoValue']) && isset($product['stockInfo']['stockInfoData'])) {
                $product['stockInfo'] = $product['stockInfo']['stockInfoData'];
            }
            if (isset($product['parameters']['parameter'][0]['parameter_name']['item'][0]['text']) && isset($product['parameters']['parameter'][0]['option_name']['item'][0]['text'])) {
                $parameters = "";
                foreach ($product['parameters']['parameter'] as $parameter) {
                    if (isset($parameter['parameter_name']['item'][0]['text']) && isset($parameter['option_name']['item'][0]['text'])) {
                        $parameters .= $parameters ? $multiple_value_separator : "";
                        $parameters .= str_replace(":", "∶", $parameter['parameter_name']['item'][0]['text']) . ":" . str_replace(":", "∶", $parameter['option_name']['item'][0]['text']);
                    }
                }
                $product['parameters'] = $parameters;
            }
            if (isset($product['properties']['property'][0]['name']) && isset($product['properties']['property'][0]['values']['value'])) {
                $properties = "";
                foreach ($product['properties']['property'] as $property) {
                    if (isset($property['name']) && isset($property['values']['value'])) {
                        $properties .= $properties ? $multiple_value_separator : "";
                        $properties .= str_replace(":", "∶", $property['name']) . ":" . str_replace(":", "∶", $property['values']['value']);
                    }
                }
                $product['properties'] = $properties;
            }
            if (isset($product['enclosure']['@attributes']['url'])) {
                $product['enclosure'] = $product['enclosure']['@attributes']['url'];
            }
            if (isset($product['PARAM']) && $product['PARAM']) {
                if (isset($product['PARAM']['PARAM_NAME']) && isset($product['PARAM']['PARAM_VAL'])) {
                    $product['PARAM'] = array($product['PARAM']);
                }
                if (isset($product['PARAM'][0]['PARAM_NAME']) && isset($product['PARAM'][0]['PARAM_VAL'])) {
                    $params = "";
                    foreach ($product['PARAM'] as $param) {
                        if (isset($param['PARAM_NAME']) && $param['PARAM_NAME'] && isset($param['PARAM_VAL'])) {
                            $params .= $params ? $multiple_value_separator : "";
                            $params .= str_replace(":", "∶", trim($param['PARAM_NAME'])) . ":" . str_replace(":", "∶", trim($param['PARAM_VAL']) . (isset($param['PARAM_UNIT']) ? " " . trim($param['PARAM_UNIT']) : ""));
                        }
                    }
                    $product['PARAM'] = $params;
                }
            }
            if (isset($product['FILE_ATTACHMENT']) && $product['FILE_ATTACHMENT']) {
                if (isset($product['FILE_ATTACHMENT']['ATTACHMENT_URL']) && isset($product['FILE_ATTACHMENT']['ATTACHMENT_NAME'])) {
                    $product['FILE_ATTACHMENT'] = array($product['FILE_ATTACHMENT']);
                }
                if (isset($product['FILE_ATTACHMENT'][0]['ATTACHMENT_URL']) && isset($product['FILE_ATTACHMENT'][0]['ATTACHMENT_NAME'])) {
                    $attachments = "";
                    foreach ($product['FILE_ATTACHMENT'] as $attachment) {
                        if (isset($attachment['ATTACHMENT_URL']) && $attachment['ATTACHMENT_URL']) {
                            $attachments .= $attachments ? $multiple_value_separator : "";
                            $attachments .= $attachment['ATTACHMENT_URL'];
                        }
                    }
                    $product['FILE_ATTACHMENT'] = $attachments;
                }
            }
            if (isset($product['PRODUCTNAME']) && isset($product['PRODUCT']) && isset($product['ITEM_ID']) && isset($product['PRODUCTNO']) && isset($product['ITEMGROUP_ID'])) {
                $product['PRODUCTNAME'] = 'Patron ' . $product['PRODUCT'] . ' - ' . $product['PRODUCTNAME'];
            }
            if ((isset($product['parameters']['item']['name']) && isset($product['parameters']['item']['value'])) || isset($product['parameters']['item'][0]['name']) && isset($product['parameters']['item'][0]['value'])) {
                $params = "";
                if (isset($product['parameters']['item']['name']) && isset($product['parameters']['item']['value'])) {
                    $product['parameters']['item'] = array($product['parameters']['item']);
                }
                foreach ($product['parameters']['item'] as $param) {
                    $params .= $params ? $multiple_value_separator : "";
                    $params .= str_replace(":", "∶", $param['name']) . ":" . str_replace(":", "∶", $param['value']);
                }
                $product['parameters'] = $params;
            }

            // Step 8
            // Take care of multiple values
            foreach ($product as $attr => $value) {
                if (is_array($value) && empty($value)) {
                    $product[$attr] = "";
                    continue;
                } elseif (!is_array($value) || empty($value)) {
                    continue;
                }
                $new_value = "";
                foreach ($value as $sub_value) {
                    if (is_array($sub_value) && $sub_value) {
                        foreach ($sub_value as $sub_sub_value) {
                            if (is_array($sub_sub_value) && $sub_sub_value) {
                                foreach ($sub_sub_value as $sub_sub_sub_value) {
                                    if (is_array($sub_sub_sub_value) && $sub_sub_sub_value) {
                                        foreach ($sub_sub_sub_value as $sub_sub_sub_sub_value) {
                                            if (!is_array($sub_sub_sub_sub_value)) {
                                                $new_value .= $new_value ? $multiple_value_separator : "";
                                                $new_value .= $sub_sub_sub_sub_value;
                                            }
                                        }
                                    } elseif ($sub_sub_sub_value) {
                                        $new_value .= $new_value ? $multiple_value_separator : "";
                                        $new_value .= $sub_sub_sub_value;
                                    }
                                }
                            } elseif ($sub_sub_value) {
                                $new_value .= $new_value ? $multiple_value_separator : "";
                                $new_value .= $sub_sub_value;
                            }
                        }
                    } elseif ($sub_value) {
                        $new_value .= $new_value ? $multiple_value_separator : "";
                        $new_value .= $sub_value;
                    }
                }
                $product[$attr] = $new_value;
            }

            // Build new product array by header columns
            $product_final = array();
            foreach ($header as $column) {
                //$product_final[$column] = isset($product[$column]) ? str_replace('&amp;', '&', $product[$column]) : "";
                $product_final[$column] = isset($product[$column]) ? html_entity_decode($product[$column]) : "";
            }
            fputcsv($handle, $product_final, ';', '"');
        }

        unset($array);

        // Close file pointer
        fclose($handle);

        return true;
    }
}
