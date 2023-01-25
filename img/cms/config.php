<?php
/**
 * Creative Elements - live Theme & Page Builder
 *
 * @author    WebshopWorks
 * @copyright 2019-2022 WebshopWorks.com
 * @license   One domain support license
 */

defined('_PS_VERSION_') or die;

if (Tools::getValue('field_id') !== '3' && basename($_SERVER['SCRIPT_NAME']) === 'dialog.php') {
	return;
}

$ext_img[] = 'webp';
$mime_img[] = 'image/webp';
$mime_img[] = 'image/svg+xml';

$ext[] = 'webp';
$mime[] = 'image/webp';
$mime[] = 'image/svg+xml';

if (in_array(Tools::getValue('action'), ['rename_file', 'duplicate_file', 'delete_file'])) {
	${'_POST'}['path'] = Tools::substr(${'_POST'}['path_thumb'], Tools::strlen($thumbs_base_path));
}

if (isset($_FILES['file']['name'])) {
	if (!strcasecmp('svg', pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION))) {
		$svg = file_get_contents($_FILES['file']['tmp_name']);

		if (!preg_match('/^<\?xml version="1\.\d+"(\s+encoding="[^"]+")?\s+\?\>/', $svg)) {
			// SVG upload compatibility fix
			file_put_contents($_FILES['file']['tmp_name'], '<?xml version="1.0" encoding="UTF-8"?>' . $svg);
		}
	}

	register_shutdown_function(function () {
		$error = error_get_last();

	    if ($error && stripos($error['message'], '.webp is missing or invalid') !== false) {
	    	// Ignore WEBP thumbnail generation error
	    	http_response_code(200);
	    }
	});
}
