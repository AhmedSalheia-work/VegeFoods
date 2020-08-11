<?php


namespace MVC\Controllers;


use MVC\LIB\Helper;
use MVC\LIB\InputFilter;
use MVC\Models\Data;

class UserController extends AbstractController
{
    use Helper;
    use InputFilter;

    public function defaultAction(){
        $this->redirect('/user/login');
    }

    public function registerAction()
    {
        $this->_data['msg'] = '';
        $this->_data['status'] = '';

        if (isset($_SESSION['msg']))
        {
            $this->_data['msg'] = $_SESSION['msg']->message;
            $this->_data['status'] = $_SESSION['msg']->status;

            unset($_SESSION['msg']);
        }

        if (isset($_POST['sub']))
        {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL  => API_URL.'/'.API_VER."/user/add/",
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($_POST),
                CURLOPT_HTTPHEADER => array(
                    'Accept-Language: '.$_SESSION['lang']
                ),
                CURLOPT_RETURNTRANSFER => true
            ));

            $response = json_decode(curl_exec($curl));

            curl_close($curl);

            $_SESSION['msg'] = $response;

            $this->redirect('/user/verify');
        }

        $data = Data::getAll();
        foreach ($data as $datum)
        {
            $name = $datum->id;
            $this->_data[$name] = $datum->data;
        }

        $this->_data['page'] = 'register';

        $this->_lang->load('index.header');
        $this->_lang->load('index.footer');
        $this->_lang->load('index.register');
        $this->_lang->load('all.form');


        $this->_view();
    }

    public function loginAction()
    {
        $this->_data['msg'] = '';
        $this->_data['status'] = '';

        if (isset($_SESSION['msg']))
        {
            $this->_data['msg'] = $_SESSION['msg']->message;
            $this->_data['status'] = $_SESSION['msg']->status;

            unset($_SESSION['msg']);
        }

        if (isset($_SESSION['user'])){
            $this->redirect('/index/default');
        }

        if (isset($_POST['sub']))
        {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL  => API_URL.'/'.API_VER."/user/login/",
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($_POST),
                CURLOPT_HTTPHEADER => array(
                    'Accept-Language: '.$_SESSION['lang']
                ),
                CURLOPT_RETURNTRANSFER => true
            ));

            $response = json_decode(curl_exec($curl));

            curl_close($curl);

            if ($response->status == true)
            {
                $_SESSION['user'] = $response->data->user;
                $_SESSION['usr_img'] = $response->data->user->usr_img;
            }

            $_SESSION['msg'] = $response;

            if ($response->status == true)
            {
                $this->redirect('/index');
            }else{
                $this->redirect('/user');
            }
        }

        $data = Data::getAll();
        foreach ($data as $datum)
        {
            $name = $datum->id;
            $this->_data[$name] = $datum->data;
        }

        $this->_lang->load('index.header');
        $this->_lang->load('index.footer');
        $this->_lang->load('all.form');
        $this->_lang->load('index.login');

        $this->_data['page'] = 'LogIn';

        $this->_view();
    }

    public function verifyAction(){
        $this->_data['msg'] = '';
        $this->_data['status'] = '';
        $token = isset($this->_params[0])? $this->_params[0]:(isset($_POST['token'])? $this->filterStr($_POST['token']): '');
        $email = isset($this->_params[1])? $this->_params[1]:(isset($_POST['email'])? $this->filterStr($_POST['email']): '');

        if ($token != '' && $email != '')
        {
            $_POST['token'] = $token;
            $_POST['email'] = $email;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL  => API_URL.'/'.API_VER."/user/verify/",
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($_POST),
                CURLOPT_HTTPHEADER => array(
                    'Accept-Language: '.$_SESSION['lang']
                ),
                CURLOPT_RETURNTRANSFER => true
            ));

            $response = json_decode(curl_exec($curl));
            $_SESSION['msg'] = $response;

            curl_close($curl);
        }

        if (isset($_SESSION['msg']))
        {
            $this->_data['msg'] = $_SESSION['msg']->message;
            $this->_data['status'] = $_SESSION['msg']->status;

            unset($_SESSION['msg']);
        }

        $data = Data::getAll();
        foreach ($data as $datum)
        {
            $name = $datum->id;
            $this->_data[$name] = $datum->data;
        }

        $this->_lang->load('index.header');
        $this->_lang->load('index.footer');
        $this->_lang->load('all.form');
        $this->_lang->load('index.verify');

        $this->_data['page'] = 'Verify';

        $this->_view();
    }

    public function logoutAction(){
        $token = (isset($this->_params[0]))? $this->_params[0]:((isset($_POST['token']))? $_POST['token'] : false);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL  => API_URL.'/'.API_VER."/user/logout",
            CURLOPT_HTTPHEADER => array(
                'Accept-Language: '.$_SESSION['lang'],
                'token: '.$token
            ),
            CURLOPT_RETURNTRANSFER => true
        ));

        $response = json_decode(curl_exec($curl));

        curl_close($curl);

        if ($response->status == true){
            unset($_SESSION['user']);
            unset($_SESSION['user_img']);
        }

        $_SESSION['msg'] = $response;

        $this->redirect('/');
    }

    public function profileAction(){

        $data = Data::getAll();
        foreach ($data as $datum)
        {
            $name = $datum->id;
            $this->_data[$name] = $datum->data;
        }

        $this->_data['msg'] = '';
        $this->_data['status'] = '';

        if (isset($_SESSION['msg']))
        {
            $this->_data['msg'] = $_SESSION['msg']->message;
            $this->_data['status'] = $_SESSION['msg']->status;

            unset($_SESSION['msg']);
        }

        if (isset($_SESSION['user']) && $_SESSION['user'] != '')
        {

            if (isset($_POST['sub'])){
                $POST['name'] = $this->filterStr($_POST['name']);
                $POST['date'] = $this->filterStr($_POST['date']);
                $POST['password'] = $this->filterStr($_POST['pass']);
                $POST['job'] = $this->filterStr($_POST['job']);
                $POST['bio']  = html_entity_decode($this->filterStr($_POST['bio']),ENT_QUOTES);
                $POST['img']  = $_SESSION['usr_img'];

                if (!empty($_FILES)){
                    $img  = $_FILES['userImg']['tmp_name'];
                    $img_ext = strtolower(array_reverse(explode('.',$_FILES['userImg']['name']))[0]);
                    $img_mime = $_FILES['userImg']['type'];

                    if ($img_ext == 'jpg' || $img_ext == 'jpeg' || $img_ext == 'png' || $img_ext == 'svg')
                    {
                        $POST['img'] = new \CURLFile($img,$img_mime,$img_ext);
                    }
                }


                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL  => API_URL.'/'.API_VER."/user/profile/",
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => http_build_query($POST),
                    CURLOPT_HTTPHEADER => array(
                        'Accept-Language: '.$_SESSION['lang'],
                        'token: '.$_SESSION['user']->token
                    ),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SAFE_UPLOAD => true
                ));

                $response = json_decode(curl_exec($curl));
                curl_close($curl);

                if ($response->status == true)
                {
                    unset($_SESSION['user']);
                    unset($_SESSION['usr_img']);

                    $_SESSION['user'] = $response->data->user;
                    $_SESSION['usr_img'] = $response->data->user->usr_img;
                }

                $_SESSION['msg'] = $response;

                $this->redirect('/user/profile');
            }

            $curl = curl_init();

            if (isset($_SESSION['user']) && $_SESSION['user'] != '')
            {
                curl_setopt_array($curl, array(
                    CURLOPT_URL  => API_URL.'/'.API_VER."/cart/get",
                    CURLOPT_HTTPHEADER => array(
                        'Accept-Language: '.$_SESSION['lang'],
                        'token: '.$_SESSION['user']->token
                    ),
                    CURLOPT_RETURNTRANSFER => true
                ));

                $response = json_decode(curl_exec($curl));
                if ($response->status == true){
                    $this->_data['cart'] = count($response->data->products);
                }else{
                    $this->_data['cart'];
                }

                curl_setopt_array($curl, array(
                    CURLOPT_URL  => API_URL.'/'.API_VER."/wishlist/get",
                    CURLOPT_HTTPHEADER => array(
                        'Accept-Language: '.$_SESSION['lang'],
                        'token: '.$_SESSION['user']->token
                    ),
                    CURLOPT_RETURNTRANSFER => true
                ));

                $response = json_decode(curl_exec($curl));
                if ($response->status == true){
                    $this->_data['wishlist'] = count($response->data->products);
                }else{
                    $this->_data['wishlist'];
                }
            }
            curl_close($curl);
            $this->_lang->load('index.header');
            $this->_lang->load('index.footer');
            $this->_lang->load('all.form');
            $this->_lang->load('user.profile');

            $this->_data['page'] = 'Profile';

            $this->_view();
        }else{
            $this->redirect('user/login');
        }

    }
}