<?php
/**
 * @author    ELEGANTAL <info@elegantal.com>
 * @copyright (c) 2023, ELEGANTAL <www.elegantal.com>
 * @license   Proprietary License - It is forbidden to resell or redistribute copies of the module or modified copies of the module.
 */

/**
 * This is a helper class which provides some functions used all over the module
 */
class ElegantalEasyImportTools
{

    /**
     * Serializes array to store in database
     * @param array $array
     * @return string
     */
    public static function serialize($array)
    {
        // return json_encode($array);
        // return serialize($array);
        // return base64_encode(serialize($array));
        return call_user_func('base64_encode', serialize($array));
    }

    /**
     * Un-serializes serialized string
     * @param string $string
     * @return array
     */
    public static function unserialize($string)
    {
        // $array = json_decode($string, true);
        // $array = @unserialize($string);
        // $array = @unserialize(base64_decode($string));
        $array = @unserialize(call_user_func('base64_decode', $string));
        return empty($array) ? array() : $array;
    }

    /**
     * Returns formatted file size in GB, MB, KB or bytes
     * @param int $size
     * @return string
     */
    public static function displaySize($size)
    {
        $size = (int) $size;

        if ($size < 1024) {
            $size .= " bytes";
        } elseif ($size < 1048576) {
            $size = round($size / 1024) . " KB";
        } elseif ($size < 1073741824) {
            $size = round($size / 1048576, 1) . " MB";
        } else {
            $size = round($size / 1073741824, 1) . " GB";
        }

        return $size;
    }

    /**
     * Checks if given module is installed
     * @param string $module_name
     * @return bool
     * @throws PrestaShopException
     */
    public static function isModuleInstalled($module_name)
    {
        return (bool) Module::getModuleIdByName($module_name);
    }

    /**
     * Returns converted dimension value
     * @param float $value
     * @param string $from_unit
     * @param string $to_unit
     * @return float
     */
    public static function getConvertedDimension($value, $from_unit, $to_unit)
    {
        $value = (float) $value;
        if ($from_unit == 'm' && $to_unit == 'cm') { // Convert m to cm
            $value = $value * 100;
        } elseif ($from_unit == 'mm' && $to_unit == 'cm') { // Convert mm to cm
            $value = $value / 10;
        } elseif ($from_unit == 'cm' && $to_unit == 'm') { // Convert cm to m
            $value = $value / 100;
        } elseif ($from_unit == 'mm' && $to_unit == 'm') { // Convert mm to m
            $value = $value / 1000;
        } elseif ($from_unit == 'cm' && $to_unit == 'mm') { // Convert cm to mm
            $value = $value * 10;
        } elseif ($from_unit == 'm' && $to_unit == 'mm') { // Convert m to mm
            $value = $value * 1000;
        }
        return $value;
    }

    /**
     * Returns converted weight value
     * @param float $value
     * @param string $from_unit
     * @param string $to_unit
     * @return float
     */
    public static function getConvertedWeight($value, $from_unit, $to_unit)
    {
        $value = (float) $value;
        if ($from_unit == 'g' && $to_unit == 'kg') { // Convert g to kg
            $value = $value / 1000;
        } elseif ($from_unit == 'kg' && $to_unit == 'g') { // Convert kg to g
            $value = $value * 1000;
        }
        return $value;
    }

    public static function getModifiedPriceByFormula($price, $formula)
    {
        $is_price_negative = false;
        if ($price < 0) {
            $is_price_negative = true;
            $price *= -1;
        }
        $original_price = $price;

        // # symbol is used as infinity symbol, so we replace it with big number
        $formula = str_replace('#', '9999999', $formula);

        $formulas = explode(";", str_replace(' ', '', $formula));
        foreach ($formulas as $current_formula) {
            $matches = null;
            if ($current_formula && preg_match_all("/(\[([\d]+\.?[\d]*)-([\d]+\.?[\d]*)\])?([\+\-\*\/])([\d]+\.?[\d]*)/", $current_formula, $matches)) {
                // Check if price is within given range
                if ($matches[2][0] != "" && $matches[3][0] != "" && ($original_price < $matches[2][0] || $original_price > $matches[3][0])) {
                    continue;
                }
                // Apply each formula
                foreach ($matches[4] as $arithmetic_key => $arithmetic_operator) {
                    $arithmetic_value = (float) $matches[5][$arithmetic_key];
                    switch ($arithmetic_operator) {
                        case '*':
                            $price = $price * $arithmetic_value;
                            break;
                        case '/':
                            if ($arithmetic_value > 0) {
                                $price = $price / $arithmetic_value;
                            }
                            break;
                        case '+':
                            $price = $price + $arithmetic_value;
                            break;
                        case '-':
                            $price = $price - $arithmetic_value;
                            break;
                        default:
                            break;
                    }
                }
            }
        }

        if ($is_price_negative) {
            $price *= -1;
        }

        return (float) number_format($price, 6, '.', '');
    }

    /**
     * Returns real path of given file
     * @param string $fileName
     * @return boolean|string
     */
    public static function getRealPath($fileName)
    {
        $targetFile = self::getTempDir() . '/' . $fileName;
        if ($fileName && file_exists($targetFile)) {
            return $targetFile;
        }
        return false;
    }

    /**
     * Creates path to given filename. This path is to a non-existing file. It is used to create the file.
     * @param string $fileName
     * @return string
     */
    public static function createPath($fileName)
    {
        if (empty($fileName)) {
            throw new Exception("File name is not valid.");
        }
        $targetDir = self::getTempDir() . '/';
        $targetFile = $targetDir . $fileName;
        $fileType = Tools::strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $fileNameWithoutExt = pathinfo($fileName, PATHINFO_FILENAME);
        if (file_exists($targetFile)) {
            $count = 0;
            while (file_exists($targetFile)) {
                $count++;
                $targetFile = $targetDir . $fileNameWithoutExt . '_' . $count . '.' . $fileType;
            }
        }
        return $targetFile;
    }

    public static function isValidUrl($url)
    {
        $url = filter_var($url, FILTER_SANITIZE_URL);
        if (!empty($url) && filter_var($url, FILTER_VALIDATE_URL)) {
            return (boolean) preg_match('/^(https?:)\/\/[$~:;\'!#,%&_=\(\)\[\]\{\}\.\? \+\-@\/a-zA-Z0-9]+$/', $url);
        }
        return false;
    }

    public static function cleanDescription($value)
    {
        $jsevents = 'onmousedown|onmousemove|onmmouseup|onmouseover|onmouseout|onload|onunload|onfocus|onblur|onchange';
        $jsevents .= '|onsubmit|ondblclick|onclick|onkeydown|onkeyup|onkeypress|onmouseenter|onmouseleave|onerror|onselect|onreset|onabort|ondragdrop|onresize|onactivate|onafterprint|onmoveend';
        $jsevents .= '|onafterupdate|onbeforeactivate|onbeforecopy|onbeforecut|onbeforedeactivate|onbeforeeditfocus|onbeforepaste|onbeforeprint|onbeforeunload|onbeforeupdate|onmove';
        $jsevents .= '|onbounce|oncellchange|oncontextmenu|oncontrolselect|oncopy|oncut|ondataavailable|ondatasetchanged|ondatasetcomplete|ondeactivate|ondrag|ondragend|ondragenter|onmousewheel';
        $jsevents .= '|ondragleave|ondragover|ondragstart|ondrop|onerrorupdate|onfilterchange|onfinish|onfocusin|onfocusout|onhashchange|onhelp|oninput|onlosecapture|onmessage|onmouseup|onmovestart';
        $jsevents .= '|onoffline|ononline|onpaste|onpropertychange|onreadystatechange|onresizeend|onresizestart|onrowenter|onrowexit|onrowsdelete|onrowsinserted|onscroll|onsearch|onselectionchange';
        $jsevents .= '|onselectstart|onstart|onstop';
        $value = preg_replace('/(<[^>]+) (' . $jsevents . ')[\s]*=[\s]*".*?"/is', '$1', $value);
        $value = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $value);
        $value = preg_replace('/{{[\w]+ (.*?)}}/is', "", $value);
        $value = preg_replace('/(<[^>]+) href[\s]*=[\s]*"javascript.*?"/is', '$1', $value);
        $value = html_entity_decode($value); // We need this to convert special HTML entities (&gt;) back to characters
        return $value;
    }

    public static function downloadFileFromUrl($url_to_file, $local_file = null, $username = null, $password = null, $method = 'GET', $post_params = "")
    {
        $url_to_file = str_replace('\\', '/', $url_to_file);
        if (self::isValidUrl($url_to_file)) {
            $url_to_file = str_replace(' ', '%20', $url_to_file);
            $url_to_file = str_replace('&amp;', '&', $url_to_file);

            $parced_url = parse_url($url_to_file);
            if (isset($parced_url['host']) && Tools::strtolower($parced_url['host']) == 'www.dropbox.com' && Tools::substr($url_to_file, -5) == '?dl=0') {
                // Convert dropbox URL to downloadable by making ?dl=1
                $url_to_file = substr_replace($url_to_file, "1", -1);
            } elseif (isset($parced_url['host']) && Tools::strtolower($parced_url['host']) == 'drive.google.com' && isset($parced_url['path']) && preg_match("/^(\/file\/d\/)(.+?(?=\/))/", $parced_url['path'], $path_match)) {
                // Convert Google Drive link to direct download link
                $url_to_file = "https://drive.google.com/uc?id=" . $path_match[2] . "&export=download";
                // Get filename from headers
                if (!$local_file) {
                    $headers = get_headers($url_to_file, true);
                    if (isset($headers['Content-Disposition']) && preg_match("/filename=\"(.+?)\"/", $headers['Content-Disposition'], $match)) {
                        $local_file = self::getTempDir() . '/' . $match[1];
                    }
                }
            } elseif (isset($parced_url['host']) && Tools::strtolower($parced_url['host']) == 'docs.google.com' && isset($parced_url['path']) && preg_match("/^(\/spreadsheets\/d\/.+)(\/edit)$/", $parced_url['path'], $path_match)) {
                // Convert Google Docs link to direct download link
                $url_to_file = "https://docs.google.com" . $path_match[1] . "/export";
                // Get filename from headers
                if (!$local_file) {
                    $headers = get_headers($url_to_file, true);
                    if (isset($headers['Content-Disposition']) && preg_match("/filename=\"(.+?)\"/", $headers['Content-Disposition'], $match)) {
                        $local_file = self::getTempDir() . '/' . $match[1];
                    }
                }
            }
        }

        // Replace accented characters with urlencode value
        $accented = array(
            'Š' => '%C5%A0', 'š' => '%C5%A1', 'Ž' => '%C5%BD', 'ž' => '%C5%BE', 'À' => '%C3%80', 'Á' => '%C3%81', 'č' => '%C4%8D',
            'Â' => '%C3%82', 'Ã' => '%C3%83', 'Ä' => '%C3%84', 'Å' => '%C3%85', 'Æ' => '%C3%86', 'Ç' => '%C3%87', 'È' => '%C3%88',
            'É' => '%C3%89', 'Ê' => '%C3%8A', 'Ë' => '%C3%8B', 'Ì' => '%C3%8C', 'Í' => '%C3%8D', 'Î' => '%C3%8E', 'Ï' => '%C3%8F',
            'Ñ' => '%C3%91', 'Ò' => '%C3%92', 'Ó' => '%C3%93', 'Ô' => '%C3%94', 'Õ' => '%C3%95', 'Ö' => '%C3%96', 'Ø' => '%C3%98',
            'Ù' => '%C3%99', 'Ú' => '%C3%9A', 'Û' => '%C3%9B', 'Ü' => '%C3%9C', 'Ý' => '%C3%9D', 'Þ' => '%C3%9E', 'ß' => '%C3%9F',
            'à' => '%C3%A0', 'á' => '%C3%A1', 'â' => '%C3%A2', 'ã' => '%C3%A3', 'ä' => '%C3%A4', 'å' => '%C3%A5', 'æ' => '%C3%A6',
            'ç' => '%C3%A7', 'è' => '%C3%A8', 'é' => '%C3%A9', 'ê' => '%C3%AA', 'ë' => '%C3%AB', 'ì' => '%C3%AC', 'í' => '%C3%AD',
            'î' => '%C3%AE', 'ï' => '%C3%AF', 'ð' => '%C3%B0', 'ñ' => '%C3%B1', 'ò' => '%C3%B2', 'ó' => '%C3%B3', 'ô' => '%C3%B4',
            'õ' => '%C3%B5', 'ö' => '%C3%B6', 'ø' => '%C3%B8', 'ù' => '%C3%B9', 'ú' => '%C3%BA', 'û' => '%C3%BB', 'ý' => '%C3%BD',
            'þ' => '%C3%BE', 'ÿ' => '%C3%BF', 'ř' => '%C5%99',
        );
        $url_to_file = strtr($url_to_file, $accented);

        $local_file = $local_file ? $local_file : self::getTempDir() . '/' . rand(1000, 1000000) . '.' . pathinfo($url_to_file, PATHINFO_EXTENSION);

        if (self::isValidUrl($url_to_file)) {
            $file_contents = self::getFileContentsByCurl($url_to_file, $username, $password, $method, $post_params);
            if (!$file_contents) {
                // Try with deprecated SHA1 signatures
                $file_contents = self::getFileContentsByCurl($url_to_file, $username, $password, $method, $post_params, 'DEFAULT@SECLEVEL=1');
            }
        } elseif ($method == 'GET') {
            $file_contents = self::getFileContents($url_to_file, $username, $password);
        } else {
            throw new Exception('An error occured while downloading the file. Valid URL is required for POST method.');
        }

        if (empty($file_contents)) {
            throw new Exception('An error occured while downloading the file.');
        } elseif (!file_put_contents($local_file, $file_contents)) {
            throw new Exception('An error occured while downloading the file. Failed to save the file.');
        }

        return $local_file;
    }

    public static function getFileContents($url_to_file, $username = null, $password = null)
    {
        $header = "Referrer-Policy: no-referrer\r\n";
        $header .= "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/54.0.1\r\n";
        if ($username && $password) {
            $header .= "Authorization: Basic " . call_user_func('base64_encode', $username . ":" . $password) . "\r\n";
        }
        $context = stream_context_create(array(
            'http' => array(
                'header' => $header,
            ),
        ));
        return Tools::file_get_contents($url_to_file, false, $context, 500, true);
    }

    public static function getFileContentsByCurl($url_to_file, $username = null, $password = null, $method = 'GET', $post_params = "", $ssl_ciphers = null)
    {
        if (!self::isValidUrl($url_to_file)) {
            return false;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/54.0.1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url_to_file);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        if ($ssl_ciphers) {
            curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, $ssl_ciphers);
        }
        if (Tools::strtoupper($method) == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            if ($post_params) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_params);
            }
        } else {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        }

        if ($username && $password) {
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM | CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_UNRESTRICTED_AUTH, true);
            curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
        } elseif ($password) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($password));
        }

        $file_contents = null;

        $response = curl_exec($ch);

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $error = "";
        if ($response === false) {
            $error .= ". cURL error: " . curl_error($ch);
        }

        curl_close($ch);

        if ($response && $http_code == 200) {
            $file_contents = $response;
        } else {
            // die($error);
        }

        return $file_contents;
    }

    public static function copyFile($source, $destination, $stream_context = null)
    {
        if (is_null($stream_context) && !preg_match('/^https?:\/\//', $source)) {
            return @copy($source, $destination);
        }
        return @file_put_contents($destination, Tools::file_get_contents($source, false, $stream_context));
    }

    /**
     * Copies image file for product image
     * @param int $id_product
     * @param object $image Image object
     * @param string $url
     * @return boolean
     */
    public static function copyImg($id_product, $image, $url, $username = null, $password = null, $convert_to = null)
    {
        // $url = urldecode(trim($url));
        $tmp_file = self::getTempDir() . '/' . rand(1000, 1000000) . '.' . pathinfo($url, PATHINFO_EXTENSION);
        $watermark_types = explode(',', Configuration::get('WATERMARK_TYPES'));
        $path = $image->getPathForCreation();
        $context = Context::getContext();

        try {
            if (self::downloadFileFromUrl($url, $tmp_file, $username, $password)) {
                // Check if real image
                $mime_type = self::getMimeType($tmp_file);
                if (!$mime_type || strpos($mime_type, 'image') === false) {
                    return false;
                }

                // Convert image to different format
                if ($convert_to) {
                    $convert_to = Tools::strtolower($convert_to);
                    self::convertImage($tmp_file, $mime_type, $convert_to);
                }

                // Evaluate the memory required to resize the image: if it's too much, you can't resize it.
                if (!ImageManager::checkImageMemoryLimit($tmp_file)) {
                    @unlink($tmp_file);
                    return false;
                }

                ImageManager::resize($tmp_file, $path . '.' . $image->image_format, null, null, $image->image_format);

                // Regenerate. It is enabled because one customer reported that images are not generated when this is disabled.
                $regenerate = true;
                if ($regenerate) {
                    $images_types = ImageType::getImagesTypes('products', true);
                    foreach ($images_types as $image_type) {
                        ImageManager::resize($tmp_file, $path . '-' . call_user_func('stripslashes', $image_type['name']) . '.' . $image->image_format, $image_type['width'], $image_type['height'], $image->image_format);
                        if (in_array($image_type['id_image_type'], $watermark_types)) {
                            Hook::exec('actionWatermark', array('id_image' => $image->id, 'id_product' => $id_product));
                        }
                    }
                }
            } else {
                @unlink($tmp_file);
                return false;
            }
        } catch (Exception $e) {
            @unlink($tmp_file);
            return false;
        }

        @unlink($tmp_file);

        if (is_file(_PS_TMP_IMG_DIR_ . 'product_' . (int) $id_product . '.jpg')) {
            @unlink(_PS_TMP_IMG_DIR_ . 'product_' . (int) $id_product . '.jpg');
        }
        if (is_file(_PS_TMP_IMG_DIR_ . 'product_mini_' . (int) $id_product . '.jpg')) {
            @unlink(_PS_TMP_IMG_DIR_ . 'product_mini_' . (int) $id_product . '.jpg');
        }
        if (is_file(_PS_TMP_IMG_DIR_ . 'product_mini_' . (int) $id_product . '_' . (int) $context->shop->id . '.jpg')) {
            @unlink(_PS_TMP_IMG_DIR_ . 'product_mini_' . (int) $id_product . '_' . (int) $context->shop->id . '.jpg');
        }

        return true;
    }

    /**
     * Converts image from one format to another
     * @param string $file
     * @param string $from_mime
     * @param string $to_format
     * @return boolean
     */
    public static function convertImage($file, $from_mime, $to_format)
    {
        if ($from_mime == 'image/webp' && ($to_format == 'jpg' || $to_format == 'jpeg') && function_exists('imagecreatefromwebp')) {
            $image = call_user_func('imagecreatefromwebp', $file);
            call_user_func('imagejpeg', $image, $file, 100);
            call_user_func('imagedestroy', $image);
        } elseif ($from_mime == 'image/webp' && $to_format == 'png' && function_exists('imagecreatefromwebp')) {
            $image = call_user_func('imagecreatefromwebp', $file);
            call_user_func('imagepng', $image, $file, 1);
            call_user_func('imagedestroy', $image);
        } elseif ($from_mime == 'image/webp' && $to_format == 'gif' && function_exists('imagecreatefromwebp')) {
            $image = call_user_func('imagecreatefromwebp', $file);
            call_user_func('imagegif', $image, $file);
            call_user_func('imagedestroy', $image);
        } elseif ($from_mime == 'image/jpeg' && $to_format == 'webp' && function_exists('imagecreatefromjpeg')) {
            $image = call_user_func('imagecreatefromjpeg', $file);
            call_user_func('imagewebp', $image, $file, 100);
            call_user_func('imagedestroy', $image);
        } elseif ($from_mime == 'image/jpeg' && $to_format == 'png' && function_exists('imagecreatefromjpeg')) {
            $image = call_user_func('imagecreatefromjpeg', $file);
            call_user_func('imagepng', $image, $file, 1);
            call_user_func('imagedestroy', $image);
        } elseif ($from_mime == 'image/jpeg' && $to_format == 'gif' && function_exists('imagecreatefromjpeg')) {
            $image = call_user_func('imagecreatefromjpeg', $file);
            call_user_func('imagegif', $image, $file);
            call_user_func('imagedestroy', $image);
        } elseif ($from_mime == 'image/png' && $to_format == 'webp' && function_exists('imagecreatefrompng')) {
            $image = call_user_func('imagecreatefrompng', $file);
            $width = call_user_func('imagesx', $image);
            $height = call_user_func('imagesy', $image);
            $output = call_user_func('imagecreatetruecolor', $width, $height);
            $white = call_user_func('imagecolorallocate', $output, 255, 255, 255);
            call_user_func('imagefilledrectangle', $output, 0, 0, $width, $height, $white);
            call_user_func('imagecopy', $output, $image, 0, 0, 0, 0, $width, $height);
            call_user_func('imagewebp', $output, $file, 100);
            call_user_func('imagedestroy', $image);
            call_user_func('imagedestroy', $output);
        } elseif ($from_mime == 'image/png' && ($to_format == 'jpg' || $to_format == 'jpeg') && function_exists('imagecreatefrompng')) {
            $image = call_user_func('imagecreatefrompng', $file);
            $width = call_user_func('imagesx', $image);
            $height = call_user_func('imagesy', $image);
            $output = call_user_func('imagecreatetruecolor', $width, $height);
            $white = call_user_func('imagecolorallocate', $output, 255, 255, 255);
            call_user_func('imagefilledrectangle', $output, 0, 0, $width, $height, $white);
            call_user_func('imagecopy', $output, $image, 0, 0, 0, 0, $width, $height);
            call_user_func('imagejpeg', $output, $file, 100);
            call_user_func('imagedestroy', $image);
            call_user_func('imagedestroy', $output);
        } elseif ($from_mime == 'image/png' && $to_format == 'gif' && function_exists('imagecreatefrompng')) {
            $image = call_user_func('imagecreatefrompng', $file);
            $width = call_user_func('imagesx', $image);
            $height = call_user_func('imagesy', $image);
            $output = call_user_func('imagecreatetruecolor', $width, $height);
            $white = call_user_func('imagecolorallocate', $output, 255, 255, 255);
            call_user_func('imagefilledrectangle', $output, 0, 0, $width, $height, $white);
            call_user_func('imagecopy', $output, $image, 0, 0, 0, 0, $width, $height);
            call_user_func('imagegif', $output, $file);
            call_user_func('imagedestroy', $image);
            call_user_func('imagedestroy', $output);
        } elseif ($from_mime == 'image/gif' && $to_format == 'webp' && function_exists('imagecreatefromgif')) {
            $image = call_user_func('imagecreatefromgif', $file);
            call_user_func('imagewebp', $image, $file, 100);
            call_user_func('imagedestroy', $image);
        } elseif ($from_mime == 'image/gif' && ($to_format == 'jpg' || $to_format == 'jpeg') && function_exists('imagecreatefromgif')) {
            $image = call_user_func('imagecreatefromgif', $file);
            call_user_func('imagejpeg', $image, $file, 100);
            call_user_func('imagedestroy', $image);
        } elseif ($from_mime == 'image/gif' && $to_format == 'png' && function_exists('imagecreatefromgif')) {
            $image = call_user_func('imagecreatefromgif', $file);
            call_user_func('imagepng', $image, $file, 1);
            call_user_func('imagedestroy', $image);
        }
        return true;
    }

    /**
     * Returns mime type of given file
     * @param string $file
     * @param string $extension
     * @return string|boolean
     */
    public static function getMimeType($file, $extension = null)
    {
        if (!is_file($file)) {
            return false;
        }
        $mime = null;
        if (function_exists('finfo_file') && function_exists('finfo_open') && defined('FILEINFO_MIME_TYPE')) {
            // Use the Fileinfo PECL extension (PHP 5.3+)
            $mime = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $file);
        } elseif (function_exists('mime_content_type')) {
            // Deprecated in PHP 5.3
            $mime = mime_content_type($file);
        } elseif (function_exists('exif_imagetype')) {
            $exif_imagetype = call_user_func('exif_imagetype', $file);
            if ($exif_imagetype == IMAGETYPE_PNG) {
                $mime = 'image/png';
            } elseif ($exif_imagetype == IMAGETYPE_JPEG) {
                $mime = 'image/jpeg';
            }
        }
        $mime = $mime ? Tools::strtolower($mime) : null;

        if ($mime == 'text/plain' || $mime == 'application/octet-stream') {
            $handle = fopen($file, 'r');
            $line = fread($handle, 10);
            $first_char = Tools::substr($line, 0, 1);
            fclose($handle);
            if ($first_char == '{' || $first_char == '[') {
                $mime = 'application/json';
            } elseif (Tools::strtolower(Tools::substr($line, 0, 5)) == '<?xml') {
                $mime = 'application/xml';
            }
        } elseif ($mime == 'application/cdfv2' && $extension == 'xls') {
            $mime = 'application/vnd.ms-excel';
        } elseif ($mime == 'application/zip' && $extension == 'xls') {
            $mime = 'application/vnd.ms-excel';
        } elseif ($mime == 'application/zip' && $extension == 'xlsx') {
            $mime = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        } elseif ($mime == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheetapplication/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
            $mime = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        } elseif ($mime == 'text/x-algol68') {
            $mime = 'text/csv';
        } elseif ($mime == 'text/x-fortran') {
            $mime = 'text/csv';
        }

        return $mime ? $mime : false;
    }

    /**
     * Returns file extension for the given mime type
     * @param string $mime
     * @return string|null
     */
    public static function getExtensionFromMimeType($mime)
    {
        $extension = null;
        switch ($mime) {
            case 'text/xml':
            case 'text/html':
            case 'application/xml':
            case 'application/octet-stream':
                $extension = 'xml';
                break;
            case 'text/csv':
            case 'text/plain':
            case 'message/news':
                $extension = 'csv';
                break;
            case 'application/vnd.ms-excel':
            case 'application/vnd.ms-office':
                $extension = 'xls';
                break;
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                $extension = 'xlsx';
                break;
            case 'application/vnd.oasis.opendocument.spreadsheet':
                $extension = 'ods';
                break;
            case 'application/json':
                $extension = 'json';
                break;
            default:
                break;
        }
        return $extension;
    }

    /**
     * Encodes an ISO-8859-1 string to UTF-8
     * @param string $str
     * @return string
     */
    public static function encodeUtf8($str)
    {
        $str = utf8_encode($str);

        /* Take care of some characters that do not work in UTF-8.
        https://www.php.net/manual/en/function.utf8-encode.php
        This structure encodes the difference between ISO-8859-1 and Windows-1252, as a map from the UTF-8
        encoding of some ISO-8859-1 control characters to the UTF-8 encoding of the non-control characters
        that Windows-1252 places at the equivalent code points. */
        $cp1252_map = array(
            "\xc2\x80" => "\xe2\x82\xac", // EURO SIGN
            "\xc2\x82" => "\xe2\x80\x9a", // SINGLE LOW-9 QUOTATION MARK
            "\xc2\x83" => "\xc6\x92", // LATIN SMALL LETTER F WITH HOOK
            "\xc2\x84" => "\xe2\x80\x9e", // DOUBLE LOW-9 QUOTATION MARK
            "\xc2\x85" => "\xe2\x80\xa6", // HORIZONTAL ELLIPSIS
            "\xc2\x86" => "\xe2\x80\xa0", // DAGGER
            "\xc2\x87" => "\xe2\x80\xa1", // DOUBLE DAGGER
            "\xc2\x88" => "\xcb\x86", // MODIFIER LETTER CIRCUMFLEX ACCENT
            "\xc2\x89" => "\xe2\x80\xb0", // PER MILLE SIGN
            "\xc2\x8a" => "\xc5\xa0", // LATIN CAPITAL LETTER S WITH CARON
            "\xc2\x8b" => "\xe2\x80\xb9", // SINGLE LEFT-POINTING ANGLE QUOTATION
            "\xc2\x8c" => "\xc5\x92", // LATIN CAPITAL LIGATURE OE
            "\xc2\x8e" => "\xc5\xbd", // LATIN CAPITAL LETTER Z WITH CARON
            "\xc2\x91" => "\xe2\x80\x98", // LEFT SINGLE QUOTATION MARK
            "\xc2\x92" => "\xe2\x80\x99", // RIGHT SINGLE QUOTATION MARK
            "\xc2\x93" => "\xe2\x80\x9c", // LEFT DOUBLE QUOTATION MARK
            "\xc2\x94" => "\xe2\x80\x9d", // RIGHT DOUBLE QUOTATION MARK
            "\xc2\x95" => "\xe2\x80\xa2", // BULLET
            "\xc2\x96" => "\xe2\x80\x93", // EN DASH
            "\xc2\x97" => "\xe2\x80\x94", // EM DASH
            "\xc2\x98" => "\xcb\x9c", // SMALL TILDE
            "\xc2\x99" => "\xe2\x84\xa2", // TRADE MARK SIGN
            "\xc2\x9a" => "\xc5\xa1", // LATIN SMALL LETTER S WITH CARON
            "\xc2\x9b" => "\xe2\x80\xba", // SINGLE RIGHT-POINTING ANGLE QUOTATION
            "\xc2\x9c" => "\xc5\x93", // LATIN SMALL LIGATURE OE
            "\xc2\x9e" => "\xc5\xbe", // LATIN SMALL LETTER Z WITH CARON
            "\xc2\x9f" => "\xc5\xb8", // LATIN CAPITAL LETTER Y WITH DIAERESIS
            "\0" => "",
            "\x00" => "",
        );
        $str = strtr($str, $cp1252_map);

        return $str;
    }

    /**
     * Returns temporary directory name
     * @return string
     */
    public static function getTempDir()
    {
        $filename = dirname(__FILE__) . '/../tmp';
        if (!is_dir($filename)) {
            mkdir($filename);
            chmod($filename, 0777);
        }
        if (is_dir($filename) && is_writable($filename)) {
            return $filename;
        } elseif (function_exists('sys_get_temp_dir')) {
            return sys_get_temp_dir();
        }
        return dirname(__FILE__);
    }

    /**
     * Generates a filename in tmp folder. It does not create actual file yet.
     * @param string $ext
     * @return string
     */
    public static function generateTmpFilename($ext)
    {
        $filename = Tools::passwdGen(8) . '.' . $ext;
        $file_path = self::getTempDir() . '/' . $filename;
        while (file_exists($file_path)) {
            $filename = self::generateTmpFilename($ext);
        }
        return $filename;
    }

    /**
     * Deletes given file
     * @param string $filename
     * @return boolean
     * @throws Exception
     */
    public static function deleteTmpFile($filename)
    {
        if (empty($filename)) {
            return true;
        }
        $targetFile = self::getTempDir() . '/' . $filename;

        if (file_exists($targetFile) && !@unlink($targetFile)) {
            throw new Exception("File could not be deleted.");
        }
        return true;
    }

    /**
     * Deletes given folder if it is empty. index.php and fileType files are excluded.
     * @param string $dir
     * @return boolean
     * @throws Exception
     */
    public static function deleteFolderIfEmpty($dir)
    {
        if (empty($dir) || !is_dir($dir)) {
            return;
        }

        $folder_empty = true;
        $files = scandir($dir);
        foreach ($files as $file) {
            if (($file != '.' && $file != '..' && $file != 'index.php' && $file != 'fileType')) {
                $folder_empty = false;
                break;
            }
        }

        if (!$folder_empty) {
            return;
        }

        if (Tools::substr($dir, -1) != '/') {
            $dir .= '/';
        }

        // We delete index.php and fileType before deleting the folder
        if (file_exists($dir . 'index.php')) {
            @unlink($dir . 'index.php');
        }
        if (file_exists($dir . 'fileType')) {
            @unlink($dir . 'fileType');
        }

        // Delete the folder
        @rmdir($dir);

        return true;
    }

    public static function deleteFolderRecursively($dir)
    {
        if (!is_dir($dir)) {
            return;
        }
        if (substr($dir, strlen($dir) - 1, 1) != '/') {
            $dir .= '/';
        }
        $files = glob($dir . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteFolderRecursively($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dir);
    }
}
