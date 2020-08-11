<?php

if (!defined('DS')){
    define('DS', DIRECTORY_SEPARATOR);
}

define('APP_PATH', realpath(dirname(__FILE__)) .DS.'..');
define('VIEWS_PATH', APP_PATH . DS . 'views' . DS);
define('TEMPLATE_PATH', APP_PATH . DS . 'template' . DS);
define('LANG_PATH', APP_PATH . DS . 'languages' . DS);

define('CSS', '/assets/css/');
define('JS', '/assets/js/');
define('IMG', '/assets/images/');
define('INI', './app/languages/');

defined('DATABASE_HOST_NAME')? null : define('DATABASE_HOST_NAME','business29.web-hosting.com');
defined('DATABASE_DB_NAME')? null : define('DATABASE_DB_NAME','progwlfo_ vegefoods');
defined('DATABASE_USER_NAME')? null : define('DATABASE_USER_NAME','progwlfo_vegefoods');
defined('DATABASE_PASSWORD')? null : define('DATABASE_PASSWORD','whateverTheFuck');
defined('DATABASE_PORT_NUMBER')? null : define('DATABASE_PORT_NUMBER',3306);
defined('DATABASE_CONN_DRIVER')? null : define('DATABASE_CONN_DRIVER',1);

defined('DEFAULT_LANG')? null : define('DEFAULT_LANG','en');
defined('SUPPORTED_LANGS')? null : define('SUPPORTED_LANGS',array('en','ar'));
defined('SUPPORTED_LANGS_FULL')? null : define('SUPPORTED_LANGS_FULL',array('en' => 'English','ar' => 'العربية'));
defined('REQUEST_SCHEME')? null : define('REQUEST_SCHEME',array('https'));

defined('URL')? null : define('URL','https://www.ramlekaap.com/');
defined('API_URL')? null : define('API_URL',URL.'api');
defined('API_VER')? null : define('API_VER',1.0);

define('GUSER', 'ahmedsalheia.as@gmail.com');
define('GPWD', 'abu salah');