<?php


namespace MVC\Controllers\Api;


use MVC\LIB\Helper;
use MVC\LIB\InputFilter;
use MVC\Models\AbstractModel;
use MVC\Models\Feedback;
use MVC\Models\User;

class Api_feedbacksController extends \MVC\Controllers\AbstractController
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
        extract(parse_ini_file(INI.$this->language.'/api/feed_errors.ini'));
        extract(parse_ini_file(INI.$this->language.'/api/public_errors.ini'));

        @$this->action = $this->_params[0];

        switch ($this->action)
        {
            case 'add':
                @$token = $this->filterStr($_SERVER['HTTP_TOKEN']);

                if ($token != '' && $token != false){
                    $user = User::getBytoken($token);

                    if($user != false){
                        $feedback = new Feedback();
                        $feedback->userId = $user->id;
                        $feedback->feedback = $this->filterStr($_POST['feedback']);

                        if($feedback->save()){
                            $output = array('message' => $feed_add ,'data' => ['feedbacks' => ['id' => $feedback->id]], 'status' => true, 'Content-Language' => $this->language);
                        }else{
                            $output = array('message' => $save_err, 'status' => false, 'Content-Language' => $this->language);
                        }
                    }else{
                        $output = array('message' => $not_rigester, 'status' => false, 'Content-Language' => $this->language);
                    }
                }else{
                    $output = array('message' => $token_lg_err, 'status' => false, 'Content-Language' => $this->language);
                }
                break;
            case 'get':
                $feedbacks = Feedback::getAll();
                $feeds = [];
                if ($feedbacks != false){
                    foreach ($feedbacks as $feedback)
                    {
                        array_push($feeds,$feedback->getData());
                    }

                }

                $output = array('message' => $feed,'data' => ['feedbacks' => $feeds], 'status' => true, 'Content-Language' => $this->language);

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