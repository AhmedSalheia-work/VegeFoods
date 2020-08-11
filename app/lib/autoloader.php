<?php

namespace MVC\LIB;

class Autoloader
{
    public static function autoload($class)
    {
        $class = str_replace('MVC','', $class);
        $class = str_replace('\\',DS, $class);
        $class = $class . '.php';
        $class = strtolower($class);

        if (file_exists(APP_PATH . $class)){
            require_once APP_PATH . $class;
        }
    }
}
spl_autoload_register(__NAMESPACE__.'\Autoloader::autoload');