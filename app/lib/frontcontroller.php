<?php

namespace MVC\LIB;

class FrontController
{
    const NOT_FOUND_ACTION = 'notFoundAction';
    const NOT_FOUND_CONTROLLER = 'MVC\Controllers\NotFoundController';

    private $_controller = 'index';
    private $_action = 'default';
    public $_params = array();

    private $_template;
    private $_lang;

    public function __construct(Template $template , Language $lang)
    {
        $this->_lang = $lang;
        $this->_template = $template;
        $this->_parseUrl();
    }

    private function _parseUrl()
    {
        $url = explode('/',trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'), 3);

        if (isset($url[0]) && $url[0] != '' && $url[0] != 'api'){
            $this->_controller = $url[0];
        }elseif (isset($url[0]) && $url[0] != '' && $url[0] == 'api'){

            //API Controllers And Actions Selector
            /*********************************************************************************************************/

            $url = explode('/',trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'), 4);

            if (isset($url[1]) && $url[1] != ''){
                $url[1] = floatval($url[1]);
                if (($url[1]*10) % 10 == 0){
                    $url[1] = floatval($url[1].'.1');
                }

                if (is_float($url[1])){
                    $url[1] = explode('.', strval($url[1]));
                    $url[1] = (isset($url[1][1]) && $url[1][1] == '1') ? $url[1][0] . '0' : implode('', $url[1]);
                    $this->_action = 'a' . $url[1];

                    if (isset($url[2]) && $url[2] != '') {
                        $this->_controller = 'Api\\' . $url[0] . '_' . $url[2];


                    } else {
                        header('Content-Type: application/json');
                        echo json_encode(array('message' => 'No Category Selected ... Please Select The Category Wanted', 'status' => false));
                        exit();
                    }
                }else{
                    header('Content-Type: application/json');
                    echo json_encode(array('message' => 'No Version Selected ... Please Select The Version Of The Api Wanted', 'status' => false));
                    exit();
                }
            }else{
                header('Content-Type: application/json');
                echo json_encode(array('message' => 'No Version Selected ... Please Select The Version Of The Api Wanted', 'status' => false));
                exit();
            }

            if (isset($url[3]) && $url[3] != ''){
                $this->_params = explode('/',$url[3]);
            }

            /*********************************************************************************************************/
        }

        if (isset($url[1]) && $url[1] != '' && $url[0] != 'api'){
            $this->_action = $url[1];
        }

        if (isset($url[2]) && $url[2] != '' && $url[0] != 'api'){
            $this->_params = explode('/',$url[2]);
        }
    }

    public function dispatch()
    {
        $controllerClassName = 'MVC\Controllers\\'.ucfirst($this->_controller).'Controller';
        $actionName = $this->_action . 'Action';

        if (!class_exists($controllerClassName)){
            $controllerClassName = self::NOT_FOUND_CONTROLLER;
        }

        $controller = new $controllerClassName;
        if (!method_exists($controller, $actionName)){
            $this->_action = $actionName = self::NOT_FOUND_ACTION;
        }

        $controller->setController($this->_controller);
        $controller->setAction($this->_action);
        $controller->setParams($this->_params);
        $controller->setTemplate($this->_template);
        $controller->setLang($this->_lang);

        $controller->$actionName();
    }
}