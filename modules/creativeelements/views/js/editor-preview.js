/*!
 * Creative Elements - live Theme & Page Builder
 * Copyright 2019-2022 WebshopWorks.com
 */
if (!$('#elementor').length && location.search.indexOf('&force=1&') < 0) {
	// redirect to preview page when content area doesn't exist
	location.href = cePreview + '&force=1&ver=' + Date.now();
}