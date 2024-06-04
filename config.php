<?php
// HTTP
$host = $_SERVER['HTTP_HOST'];
define('HTTP_SERVER', 'https://' . $host. '/');

// HTTPS
define('HTTPS_SERVER', 'https://' . $host. '/');

// DIR
$dir = dirname(__FILE__);
define('DIR_APPLICATION', $dir . '/catalog/');
define('DIR_SYSTEM', $dir . '/system/');
define('DIR_IMAGE', $dir . '/image/');
define('DIR_STORAGE', '/home/sochinen/start-site.com.ua/storage_resserve/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'view/theme/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');
define('DIR_CACHE', DIR_STORAGE . 'cache/');
define('DIR_DOWNLOAD', DIR_STORAGE . 'download/');
define('DIR_LOGS', DIR_STORAGE . 'logs/');
define('DIR_MODIFICATION', DIR_STORAGE . 'modification/');
define('DIR_SESSION', DIR_STORAGE . 'session/');
define('DIR_UPLOAD', DIR_STORAGE . 'upload/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'sochinen.mysql.tools');
define('DB_USERNAME', 'sochinen_resserve');
define('DB_PASSWORD', '4hjP&%h59Z');
define('DB_DATABASE', 'sochinen_resserve');
define('DB_PORT', '3306');
define('DB_PREFIX', 'oc_');