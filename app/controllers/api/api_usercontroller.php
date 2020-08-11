<?php


namespace MVC\Controllers\Api;


use MVC\LIB\Helper;
use MVC\LIB\InputFilter;
use MVC\Models\AbstractModel;
use MVC\Controllers\AbstractController;
use MVC\Models\Token;
use MVC\Models\User;

class Api_userController extends AbstractController
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
            $output = array( 'message' => $protocol_err.trim($supported,',').'.', 'status' => false, 'Content-Language' => $this->language);
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
        extract(parse_ini_file(INI.$this->language.'/api/user_errors.ini'));

        @$this->action = $this->_params[0];

        switch ($this->action){
            case 'add':
                @$name = $this->filterStr($_POST['name']);
                @$email = $this->filterStr($_POST['email']);
                @$pass = $this->filterStr($_POST['password']);
                @$day = $this->filterStr($_POST['day']);
                @$month = $this->filterStr($_POST['month']);
                @$year = $this->filterStr($_POST['year']);

                $birthday = $year.'-'.$month.'-'.$day;

                $user = User::getByunique($email);

                if ($name == false || $name == ''){
                    $output = array( 'message' => $name_err, 'status' => false, 'Content-Language' => $this->language);
                    goto printing;
                }
                if ($email == false || $email == ''){
                    $output = array( 'message' => $email_err, 'status' => false, 'Content-Language' => $this->language);
                    goto printing;
                }
                if ($pass == false || $pass == ''){
                    $output = array( 'message' => $pass_err, 'status' => false, 'Content-Language' => $this->language);
                    goto printing;
                }
                if ($day == false || $day == ''){
                    $output = array( 'message' => $day_err, 'status' => false, 'Content-Language' => $this->language);
                    goto printing;
                }
                if ($month == false || $month == ''){
                    $output = array( 'message' => $month_err, 'status' => false, 'Content-Language' => $this->language);
                    goto printing;
                }
                if ($year == false || $year == ''){
                    $output = array( 'message' => $year_err, 'status' => false, 'Content-Language' => $this->language);
                    goto printing;
                }

                if ($user != false){
                    $output = array('message' => $email_in_use, 'status' => false, 'Content-Language' => $this->language);
                }else{
                    $user = new User();
                    $user->name = $name;
                    $user->email = $email;
                    $user->password = $this->enc($pass);
                    $user->birthday = $birthday;

                    if ($user->save()) {

                        $token = new Token();
                        $token->userId = $user->id;
                        $token->token = $this->randText('15');
                        $user->recording_time = date('Y-m-d H:i:s');
                        $token->save();

                        $message = '<h1>Hello '.$user->name.'</h1><br/><br/><p>Your Verification Code Is : <strong>'.$token->token.'</strong> </p><p>You Can Use <a href="http://vegefoods.dev/user/verify/'.$token->token.'/'.$user->email.'">This Link</a> to Auto Verify Account</p>';

                        $to = array($email);
                        $this->smtpmailer($to, GUSER , GUSER , 'Verification Email Address' , $message);

                        if (empty($error)) {

                            $output = array('message' => $register, 'status' => true, 'Content-Language' => $this->language);

                        }else{

                            $output = array('message' => $send_err, 'status' => false, 'Content-Language' => $this->language);

                        }

                    } else {
                        $output = array('message' => $save_err, 'status' => false, 'Content-Language' => $this->language);
                    }
                }
                break;

            case 'login':
                @$email = $this->filterStr($_POST['email']);
                @$pass = $this->filterStr($_POST['pass']);

                if ($email == false || $email == ''){
                    $output = array( 'message' => $email_err, 'status' => false, 'Content-Language' => $this->language);
                    goto printing;
                }
                if ($pass == false || $pass == ''){
                    $output = array( 'message' => $pass_err, 'status' => false);
                    goto printing;
                }

                $user = User::getByunique($email);

                if ($user != false)
                {

                        if ($user->verified == 'n') {

                            $output = array('message' => $need_verify, 'status' => false, 'Content-Language' => $this->language);
                            echo json_encode($output);
                            exit();
                        }

                        if ($this->dec($user->password) == $pass) {

                            if ($user->token == ''){
                                $user->token = $this->randText(20);
                                $user->recording_time = date('Y-m-d H:i:s');
                                $user::$tableSchema = array_merge($user::$tableSchema, ['token' => AbstractModel::DATA_TYPE_STR]);
                                $user->save();
                            }

                            $output = array('message' => $login, 'status' => true, 'data' => ['user' => [
                                'name' => $user->name, 'email' => $email, 'bio' => $user->bio, 'birthdate' => $user->birthday, 'role' => $user->role, 'token' => $user->token, 'usr_img' => $user->img, 'job' => $user->job
                            ]], 'Content-Language' => $this->language);
                        } else {
                            $output = array('message' => $password_err, 'status' => false, 'Content-Language' => $this->language);
                        }
                }else{
                    $output = array('message' => $not_rigester, 'status' => false, 'Content-Language' => $this->language);
                }
                break;

            case 'verify':
                @$email = $this->filterStr($_POST['email']);
                @$token_data = $this->filterStr($_POST['token']);

                if ($email == false || $email == ''){
                    $output = array( 'message' => $email_err, 'status' => false, 'Content-Language' => $this->language);
                    goto printing;
                }
                if ($token_data == false || $token_data == ''){
                    $output = array( 'message' => $token_vr_err, 'status' => false, 'Content-Language' => $this->language);
                    goto printing;
                }

                $user = USER::getByunique($email);

                if ($user == false)
                {
                    $output = array( 'message' => $no_email, 'status' => false, 'Content-Language' => $this->language);
                    goto printing;
                }

                $token = Token::getByunique($user->id);

                if($token != false && $user->verified != 'y'){
                    if ($token->token == $token_data) {
                        $user->verified = 'y';
                        $user->recording_time = date('Y-m-d H:i:s');
                        if ($user->save()) {
                            var_dump($token->delete());
                            $output = array('message' => $Verified, 'status' => true, 'Content-Language' => $this->language);
                        } else {
                            $output = array('message' => $save_err, 'status' => false, 'Content-Language' => $this->language);
                        }
                    } else {
                        $output = array('message' => $ver_err, 'status' => false, 'Content-Language' => $this->language);
                    }
                }else{
                    $output = array('message' => $already_err, 'status' => false, 'Content-Language' => $this->language);
                }
                break;

            case 'logout':
                @$token = $this->filterStr($_SERVER['HTTP_TOKEN']);

                if ($token != '' && $token != false){

                    $user = User::getBytoken($token);

                    if ($user != false){
                        $user->token = '';
                        $user->recording_time = date('Y-m-d H:i:s');
                        $user::$tableSchema = array_merge($user::$tableSchema, ['token' => AbstractModel::DATA_TYPE_STR]);

                        if ($user->save()) {
                            $output = array('message' => $logout, 'status' => true, 'Content-Language' => $this->language);
                        } else {
                            $output = array('message' => $logout_err, 'status' => false, 'Content-Language' => $this->language);
                        }
                    }else{
                        $output = array('message' => $no_token, 'status' => false, 'Content-Language' => $this->language);
                    }
                }else{
                    $output = array('message' => $token_lg_err, 'status' => false, 'Content-Language' => $this->language);
                }
                break;

            case 'profile':
                @$token = $this->filterStr($_SERVER['HTTP_TOKEN']);

                if ($token != '' && $token != false){
                    $user = User::getBytoken($token);

                    if($user != false){
                        $user->name = (isset($_POST['name']) && $_POST['name'] != '')? $this->filterStr($_POST['name']):$user->name;
                        $birthday = (isset($_POST['date']) && $_POST['date'] != '')? $this->filterStr($_POST['date']):$user->birthday;
                        $user->birthday = implode('-',array_reverse(explode('/',$birthday)));
                        $user->bio = (isset($_POST['bio']) && $_POST['bio'] != '')? $this->filterStr($_POST['bio']):$user->bio;
                        $user->job = (isset($_POST['job']) && $_POST['job'] != '')? $this->filterStr($_POST['job']):$user->job;
                        $img = $user->img;

                        if (isset($_POST['img']) && is_array($_POST['img'])){
                            $name = $this->randText(10).'.'.$_POST['img']['postname'];

                            if (rename($_POST['img']['name'],'.'.IMG.$name)){
                                $user->img = $name;
                                $user::$tableSchema = array_merge($user::$tableSchema,['img' => AbstractModel::DATA_TYPE_STR]);
                                if ($img != 'default.img.jpg')
                                {
                                    unlink('.'.IMG.$img);
                                }
                            }
                        }elseif(isset($_FILES['img'])){
                            $name = $this->randText(10).'.'.(array_reverse(explode('.',$_FILES['img']['name']))[0]);

                            if (move_uploaded_file($_FILES['img']['tmp_name'],'.'.IMG.$name)){
                                $user->img = $name;
                                $user::$tableSchema = array_merge($user::$tableSchema,['img' => AbstractModel::DATA_TYPE_STR]);
                                unlink('.'.IMG.$img);
                            }
                        }

                        $user->password = (isset($_POST['password']) && $_POST['password'] != '')? $this->enc($this->filterStr($_POST['password'])):$user->password;
                        $user->recording_time = date('Y-m-d H:i:s');

                        if ($user->save()){
                            $output = array('message' => $edit, 'status' => true, 'data' => [
                                'user' => ['name' => $user->name,'email' => $user->email,'bio' => $user->bio,'birthdate' => $user->birthday,'role' => $user->role , 'token' => $user->token , 'usr_img' => $user->img, 'job' => $user->job]
                            ], 'Content-Language' => $this->language);
                        }else{
                            $output = array('message' => $edit_err, 'status' => false, 'Content-Language' => $this->language);
                        }
                    }else{
                        $output = array('message' => $not_rigester, 'status' => false, 'Content-Language' => $this->language);
                    }
                }else{
                    $output = array('message' => $token_lg_err, 'status' => false, 'Content-Language' => $this->language);
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