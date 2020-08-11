<?php

namespace MVC\Controllers;

use MVC\LIB\Helper;
use MVC\LIB\InputFilter;
use MVC\Models\Data;

class IndexController extends AbstractController
{
    use Helper;
    use InputFilter;

    public function defaultAction()
    {
        if (isset($_SESSION['msg'])){
            echo '<div class="bg-info offset-3 w-50 text-center text-white fixed-bottom row noti" style="transition: bottom 0.5s"><span class="col-11">'.$_SESSION['msg']->message.'</span><span class="text-right col-1" style="cursor: pointer" onclick="this.parentNode.style.bottom = \'-5vh\'">X</span></div>';
            unset($_SESSION['msg']);
        }
        $data = Data::getAll();
        foreach ($data as $datum)
        {
            $name = $datum->id;
            $this->_data[$name] = $datum->data;
        }

        $this->_data['msg'] = '';
        $this->_data['status'] = '';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL  => API_URL.'/'.API_VER."/feedbacks/get",
            CURLOPT_HTTPHEADER => array(
                'Accept-Language: '.$_SESSION['lang']
            ),
            CURLOPT_RETURNTRANSFER => true
        ));

        $response = json_decode(curl_exec($curl));

        $this->_data['feedbacks'] = [];
        if ($response->status == true)
        {
            $this->_data['feedbacks'] = $response->data->feedbacks;
        }

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

        curl_setopt_array($curl, array(
            CURLOPT_URL  => API_URL.'/'.API_VER."/product/get_products",
            CURLOPT_HTTPHEADER => array(
                'Accept-Language: '.$_SESSION['lang']
            ),
            CURLOPT_RETURNTRANSFER => true
        ));
        $response = json_decode(curl_exec($curl));

        $this->_data['products'] = [];
        if ($response->status == true){
            $this->_data['products'] = $response->data->products;
        }

        curl_close($curl);

        $this->_lang->load('index.header');
        $this->_lang->load('index.footer');
        $this->_lang->load('index.default');
        $this->_lang->load('index.testimony');

        $this->_data['page'] = 'Home';

        $this->_view();
    }

    public function aboutAction()
    {
        if (isset($_SESSION['msg'])){
            echo '<div class="bg-info offset-3 w-50 text-center text-white fixed-bottom row noti" style="transition: bottom 0.5s"><span class="col-11">'.$_SESSION['msg']->message.'</span><span class="text-right col-1" style="cursor: pointer" onclick="this.parentNode.style.bottom = \'-5vh\'">X</span></div>';
            unset($_SESSION['msg']);
        }

        $data = Data::getAll();
        foreach ($data as $datum)
        {
            $name = $datum->id;
            $this->_data[$name] = $datum->data;
        }

        $this->_data['msg'] = '';
        $this->_data['status'] = '';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL  => API_URL.'/'.API_VER."/feedbacks/get",
            CURLOPT_HTTPHEADER => array(
                'Accept-Language: '.$_SESSION['lang']
            ),
            CURLOPT_RETURNTRANSFER => true
        ));

        $response = json_decode(curl_exec($curl));

        $this->_data['feedbacks'] = [];
        if ($response->status == true)
        {
            $this->_data['feedbacks'] = $response->data->feedbacks;
        }

        curl_setopt_array($curl, array(
            CURLOPT_URL  => API_URL.'/'.API_VER."/data/numbers"
        ));
        $response = json_decode(curl_exec($curl));

        $this->_data['numbers'] = $response->data->Numbers;
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
        $this->_lang->load('index.about');
        $this->_lang->load('index.about_p');
        $this->_lang->load('index.testimony');
        $this->_lang->load('index.footer');

        $this->_data['page'] = 'about';

        $this->_view();
    }

    public function contactAction()
    {
        $data = Data::getAll();
        foreach ($data as $datum)
        {
            $name = $datum->id;
            $this->_data[$name] = $datum->data;
        }

        $this->_data['usr_name'] = '';
        $this->_data['usr_email'] = '';
        if (isset($_SESSION['user']))
        {
            $this->_data['usr_name'] = $_SESSION['user']->name;
            $this->_data['usr_email'] = $_SESSION['user']->email;
        }

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
            $_POST['message'] = html_entity_decode($this->filterStr($_POST['message']),ENT_QUOTES);

            curl_setopt_array($curl, array(
                CURLOPT_URL  => API_URL.'/'.API_VER."/contact/add",
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($_POST),
                CURLOPT_HTTPHEADER => array(
                    'Accept-Language: '.$_SESSION['lang']
                ),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SAFE_UPLOAD => true
            ));

            $response = json_decode(curl_exec($curl));
            curl_close($curl);

            $_SESSION['msg'] = $response;

            $this->redirect('/index/contact');
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

        $this->_lang->load('all.form');
        $this->_lang->load('index.header');
        $this->_lang->load('index.footer');
        $this->_lang->load('index.contact');

        $this->_data['page'] = 'contact';

        $this->_view();
    }

    public function feedbackAction()
    {
        $data = Data::getAll();
        foreach ($data as $datum)
        {
            $name = $datum->id;
            $this->_data[$name] = $datum->data;
        }

        $this->_data['usr_name'] = '';
        $this->_data['usr_email'] = '';
        if (isset($_SESSION['user']))
        {
            $this->_data['usr_name'] = $_SESSION['user']->name;
            $this->_data['usr_email'] = $_SESSION['user']->email;
        }

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
                CURLOPT_URL  => API_URL.'/'.API_VER."/feedbacks/add",
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($_POST),
                CURLOPT_HTTPHEADER => array(
                    'Accept-Language: '.$_SESSION['lang'],
                    'token: '.$_SESSION['user']->token
                ),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SAFE_UPLOAD => true
            ));

            $response = json_decode(curl_exec($curl));
            curl_close($curl);

            $_SESSION['msg'] = $response;

            $this->redirect('/index/feedback');
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

        $this->_lang->load('all.form');
        $this->_lang->load('index.header');
        $this->_lang->load('index.footer');
        $this->_lang->load('index.feedback');

        $this->_data['page'] = 'contact';

        $this->_view();
    }
}