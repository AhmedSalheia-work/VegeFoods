<?php


namespace MVC\Controllers\Api;


use MVC\LIB\Helper;
use MVC\LIB\InputFilter;

class Api_datacontroller extends \MVC\Controllers\AbstractController
{
    use InputFilter;
    use Helper;

    public $language;
    public $action;

    public function __construct()
    {
        header('Content-Type: application/json');

        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && array_search(strtolower(explode('-',$_SERVER['HTTP_ACCEPT_LANGUAGE'])[0]), SUPPORTED_LANGS) !== false){
            $this->language = strtolower(explode('-',$_SERVER['HTTP_ACCEPT_LANGUAGE'])[0]);
        }else{
            $output = array( 'message' => 'Please Send A Supported Language with the header of the request', 'status' => false, 'Content-Language' => 'en');
            goto printing;
        }

        extract(parse_ini_file(INI.$this->language.'/api/public_errors.ini'));

        if (!isset($_SERVER['REQUEST_SCHEME']) || array_search($_SERVER['REQUEST_SCHEME'] , REQUEST_SCHEME) === false){
            $supported = '';
            foreach (REQUEST_SCHEME as $item) {
                $supported .= ','.$item;
            }
            $output = array( 'message' => $err['protocol_err'].trim($supported,',').'.', 'status' => false, 'Content-Language' => $this->language);
            goto printing;
        }

        printing:
        if (isset($output))
        {
            echo json_encode($output);
            exit();
        }
    }

    public function a10Action()
    {
        extract(parse_ini_file(INI.$this->language.'/api/public_errors.ini'));

        @$this->action = $this->_params[0];

        switch ($this->action)
        {
            case 'numbers':
                extract(parse_ini_file(INI.'/ini/numbers.ini'));
                $HAPPY_CUSTOMERS = rand($HAPPY_CUSTOMERS+1,$HAPPY_CUSTOMERS+15);
                $BRANCHES = rand($BRANCHES+1,$BRANCHES+5);
                $PARTNER = rand($PARTNER,$PARTNER+5);
                $AWARDS = rand($AWARDS,$AWARDS+5);

                $fp = fopen(INI.'/ini/numbers.ini','w');
                $content = "HAPPY_CUSTOMERS\t=\t$HAPPY_CUSTOMERS\nBRANCHES\t=\t$BRANCHES\nPARTNER\t=\t$PARTNER\nAWARDS\t=\t$AWARDS";
                fwrite($fp,$content);
                fclose($fp);

                $output = array('message' => 'Success','data' => [
                    'Numbers' => [
                        'HAPPY_CUSTOMERS' => $HAPPY_CUSTOMERS,
                        'BRANCHES' => $BRANCHES,
                        'PARTNER' => $PARTNER,
                        'AWARDS' => $AWARDS
                ]], 'status' => true, 'Content-Language' => $this->language);
                break;
            default:
                $output = array('message' => $action_err, 'status' => false, 'Content-Language' => $this->language);
                break;
        }

        printing:
        echo json_encode($output);
        exit();
    }
}