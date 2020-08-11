<?php
    namespace MVC;
    use MVC\LIB\FrontController;
    use MVC\LIB\Language;
    use MVC\LIB\Template;

    session_start();

    if (!defined('DS')){
        define('DS', DIRECTORY_SEPARATOR);
    }

    require_once 'app' . DS . 'config'.DS.'config.php';
    require_once APP_PATH.DS.'lib'.DS.'autoloader.php';
    $template_parts = require_once 'app' . DS . 'config'.DS.'templateconfig.php';

    if (!isset($_SESSION['lang'])){
        $_SESSION['lang'] = DEFAULT_LANG;
    }

    $template = new Template($template_parts);
    $lang = new Language();

    $frontController = new FrontController($template, $lang);
    $frontController->dispatch();

?>