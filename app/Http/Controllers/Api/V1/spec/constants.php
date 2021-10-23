<?php

define('APP_URL', config('app.url'));
define('API_VERSION', 'v1');
define('BASE_URL', APP_URL.'/api/'.API_VERSION);

// Pagination related constants used in response.php
define('FIRST', BASE_URL.'/featureCodes?page[number]=1');
define('LAST', BASE_URL.'/featureCodes?page[number]=68');
define('PREV', BASE_URL.'/featureCodes?page[number]=2');
define('NEXT', BASE_URL.'/featureCodes?page[number]=4');

define('PAGE_URL', BASE_URL.'/featureCodes?page[number]=10');
define('PAGE_PATH', BASE_URL.'/featureCodes');
