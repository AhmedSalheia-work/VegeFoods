<?php


namespace MVC\Controllers;


use MVC\LIB\Helper;
use MVC\LIB\InputFilter;
use MVC\Models\Data;

class CartController extends AbstractController
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

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL  => API_URL.'/'.API_VER."/cart/get",
            CURLOPT_HTTPHEADER => array(
                'Accept-Language: '.$_SESSION['lang'],
                'token: '.$_SESSION['user']->token
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SAFE_UPLOAD => true
        ));

        $response = json_decode(curl_exec($curl));


        if ($response->status == true){
            $this->_data['products'] = $response->data->products;
        }else{
            $_SESSION['msg'] = $response;
            $this->redirect('/');
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
        curl_close($curl);

        $this->_lang->load('index.header');
        $this->_lang->load('index.footer');
        $this->_lang->load('cart.get');

        $this->_data['page'] = 'cart';

        echo $this->_view();
    }

    public function addAction(){
        if (isset($this->_params[0])){
            @$id = $this->_params[0];
            @$quantity = $this->filterInt($_POST['quantity']);
            @$sizeId = $this->filterInt($_POST['size']);

            $curl = curl_init();
            $POST['product_id'] = $id;
            $POST['quantity'] = $quantity;
            $POST['size'] = $sizeId;

            curl_setopt_array($curl, array(
                CURLOPT_URL  => API_URL.'/'.API_VER."/cart/add",
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

            $_SESSION['msg'] = $response;

            $this->redirect($_SERVER['HTTP_REFERER']);
        }else{
            $errors = parse_ini_file(INI.$_SESSION['lang'].'/api/public_errors.ini');
            $out = json_encode(array('message'=>$errors['no_prod'],'status'=>false));
            $_SESSION['msg'] = json_decode($out);
            $this->redirect('/');
        }
    }

    public function deleteAction()
    {
        if (isset($this->_params[0])){
            @$id = $this->_params[0];
            @$size = $this->_params[1];

            $curl = curl_init();
            $POST['product_id'] = $id;
            $POST['size_id'] = $size;

            curl_setopt_array($curl, array(
                CURLOPT_URL  => API_URL.'/'.API_VER."/cart/delete",
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

            $_SESSION['msg'] = $response;

            $this->redirect($_SERVER['HTTP_REFERER']);
        }else{
            $errors = parse_ini_file(INI.$_SESSION['lang'].'/api/public_errors.ini');
            $out = json_encode(array('message'=>$errors['no_prod_del'],'status'=>false));
            $_SESSION['msg'] = json_decode($out);
            $this->redirect('/');
        }
    }
}