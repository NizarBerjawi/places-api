<?php

define('APP_URL', config('app.url'));
define('API_VERSION', 'v1');
define('BASE_URL', APP_URL.'/api/'.API_VERSION);

define('PREV', BASE_URL.'/featureCodes?page[cursor]=eyJnZW9uYW1lX2lkIjoxNCwiX3BvaW50c1RvTmV4dEl0ZW1zIjpmYWxzZX0');
define('NEXT', BASE_URL.'/featureCodes?page[cursor]=eyJnZW9uYW1lX2lkIjoyNSwiX3BvaW50c1RvTmV4dEl0ZW1zIjp0cnVlfQ');

define('PAGE_URL', BASE_URL.'/featureCodes?page[cursor]=eyJpc28zMTY2X2FscGhhMiI6IkJEIiwiX3BvaW50c1RvTmV4dEl0ZW1zIjp0cnVlfQ');
define('PAGE_PATH', BASE_URL.'/featureCodes');
