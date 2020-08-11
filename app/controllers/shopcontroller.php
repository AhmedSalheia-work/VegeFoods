<?php


namespace MVC\Controllers;


use MVC\LIB\Helper;
use MVC\LIB\InputFilter;
use MVC\Models\Category;
use MVC\Models\Data;
use MVC\Models\Products;

class ShopController extends AbstractController
{
    use InputFilter;
    use Helper;

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

        $this->_lang->load('index.header');
        $this->_lang->load('index.footer');
        $this->_lang->load('shop.default');

        $this->_lang->_dictionary['title'] = str_replace(':single','',$this->_lang->_dictionary['title']);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL  => API_URL.'/'.API_VER."/product/categories",
            CURLOPT_HTTPHEADER => array(
                'Accept-Language: '.$_SESSION['lang']
            ),
            CURLOPT_RETURNTRANSFER => true
        ));

        $response = json_decode(curl_exec($curl));

        if ($response->status == true){
            $this->_data['catagories'] = $response->data->categories;
        }

        $page = isset($_GET['page'])? $this->filterInt($_GET['page']):1;
        $cat = '';
        if (isset($this->_params[0]) && $this->_params[0] == 'cat'){
            $cat = $this->_params[1];
        }
        $this->_data['cat'] = $cat;

        curl_setopt_array($curl, array(
            CURLOPT_URL  => API_URL.'/'.API_VER."/product/get_products/$cat?page=$page",
        ));
        $response = json_decode(curl_exec($curl));

        if ($response->status == true){
            $this->_data['products'] = $response->data->products;
            $this->_data['pages_num'] = $response->data->pages_num;
            $this->_data['page_num'] = $response->data->page_num;
        }else{
            if (isset($response->data->pages_num))
            {
                $this->redirect('/shop');
            }
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

        $this->_data['page'] = 'Shop';

        echo $this->_view();
    }

    public function singleAction()
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

        $this->_lang->load('index.header');
        $this->_lang->load('index.footer');
        $this->_lang->load('shop.default');
        $this->_lang->load('shop.single');

        $this->_data['page'] = 'Shop';

        $curl = curl_init();

        $send = ['product_id' => $this->_params[0]];

        curl_setopt_array($curl, array(
            CURLOPT_URL  => API_URL.'/'.API_VER."/product/single",
            CURLOPT_HTTPHEADER => array(
                'Accept-Language: '.$_SESSION['lang']
            ),
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($send),
            CURLOPT_RETURNTRANSFER => true
        ));

        $response = json_decode(curl_exec($curl));
        if ($response->status == true) {
            $this->_data['product'] = $response->data->product;
            $this->_data['related'] = $response->data->related;
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

        $this->_lang->_dictionary['title'] = str_replace('Shop :single',$this->_data['product']->product_data->name,$this->_lang->_dictionary['title']);

        echo $this->_view();
    }
}