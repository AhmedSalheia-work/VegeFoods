<?php


namespace MVC\Controllers;


use MVC\LIB\Helper;

class LanguageController extends AbstractController
{
    use Helper;
    public function defaultAction(){
        $_SESSION['lang'] = 'ar';

        $this->redirect($_SERVER['HTTP_REFERER']);
    }

    public function changeAction()
    {
        $_SESSION['lang'] = $this->_params[0];

        $this->redirect($_SERVER['HTTP_REFERER']);
    }
}