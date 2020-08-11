<?php


namespace MVC\Controllers\Api;


use \MVC\Models\Message;
use MVC\LIB\Helper;
use MVC\LIB\InputFilter;

class Api_contactController extends \MVC\Controllers\AbstractController
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

    public function a10Action(){
        extract(parse_ini_file(INI.$this->language.'/api/cont_errors.ini'));
        extract(parse_ini_file(INI.$this->language.'/api/public_errors.ini'));

        @$this->action = $this->_params[0];

        switch ($this->action)
        {
            case 'add':
                @$email = $this->filterStr($_POST['email']);
                @$name = $this->filterStr($_POST['name']);
                @$subject = $this->filterStr($_POST['subject']);
                @$message_text = $this->filterStr($_POST['message']);

                if ($name == false || $name == ''){
                    $output = array( 'message' => $name_err, 'status' => false, 'Content-Language' => $this->language);
                    goto printing;
                }
                if ($email == false || $email == ''){
                    $output = array( 'message' => $email_err, 'status' => false, 'Content-Language' => $this->language);
                    goto printing;
                }
                if ($subject == false || $subject == ''){
                    $output = array( 'message' => $subject_err, 'status' => false, 'Content-Language' => $this->language);
                    goto printing;
                }
                if ($message_text == false || $message_text == ''){
                    $output = array( 'message' => $message_err, 'status' => false, 'Content-Language' => $this->language);
                    goto printing;
                }

                $message = new Message();
                $message->name = $name;
                $message->email = $email;
                $message->subject = $subject;
                $message->message = $message_text;

                if($message->save()){
                    $output = array( 'message' => $cont_add, 'status' => true,'data' => [
                        'message' => [
                            'id' => $message->messageId, 'name' => $message->name, 'email' => $message->email, 'subject' => $message->subject, 'message-content' => $message->message
                        ]
                    ],'Content-Language' => $this->language);
                }else{
                    $output = array( 'message' => $save_err, 'status' => false, 'Content-Language' => $this->language);
                }
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