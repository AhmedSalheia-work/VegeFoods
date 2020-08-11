<?php


namespace MVC\Controllers\Api;


use MVC\LIB\Helper;
use MVC\LIB\InputFilter;
use MVC\Models\Cart;
use MVC\Models\Cart_prod;
use MVC\Models\Products;
use MVC\Models\Sizes;
use MVC\Models\User;

class Api_cartController extends \MVC\Controllers\AbstractController
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
        extract(parse_ini_file(INI.$this->language.'/api/cart_errors.ini'));
        extract(parse_ini_file(INI.$this->language.'/api/public_errors.ini'));

        @$this->action = $this->_params[0];

        switch ($this->action)
        {
            case 'add':
                @$token = $this->filterStr($_SERVER['HTTP_TOKEN']);

                if ($token != '' && $token != false){
                    $user = User::getBytoken($token);

                    if($user != false){
                        @$prodId = $this->filterInt($_POST['product_id']);
                        @$quantity = $this->filterInt($_POST['quantity']);
                        @$size = $this->filterInt($_POST['size']);
                        if ($prodId != '')
                        {
                            $prod = Products::getByPK($prodId);
                            if ($prod != false){
                                $prod->returnData('FullData');

                                $cart = Cart::getByUser($user->id);
                                if ($cart == false){
                                    $cart = new Cart();
                                    $cart::$language = $this->language;
                                    $cart->userId = $user->id;

                                    if(!$cart->save()){
                                        $output = array('message' => $save_err.' cart','status' => false, 'Content-Language' => $this->language);
                                        goto printing;
                                    }
                                }else{
                                    $cart::$language = $this->language;
                                }

                                $prod_added = new Cart_prod();
                                $prod_added->cartId = $cart->id;
                                $prod_added->prodId = $prodId;
                                if ($quantity != ''){
                                    $prod_added->quantity = $quantity;
                                }

                                if ($size != ''){
                                    $prod_added->sizeId = $size;
                                }else{
                                    $size = 1;
                                }

                                $prod_added_d = $prod_added->getByProdId();
                                if ($prod_added_d != false){
                                    $prod_added->id = $prod_added_d->id;

                                    if ($prod_added_d->quantity <= 15 && (intval($prod_added->quantity) + $prod_added_d->quantity) <= 15){

                                        $prod_added->quantity = (intval($prod_added->quantity) + $prod_added_d->quantity);

                                    }else{

                                        $prod_added->quantity = 15;

                                    }
                                }

                                $size_O = Sizes::getByPK($size);
                                $name = $this->language.'_size';

                                if ($prod_added->save()) {

                                    $message = (($prod_added->quantity == 15)?$more_than:str_replace(':item', $prod->name, $cart_suc));
                                    $output = array('message' => $message,'data' => [
                                        'cartId' => $cart->id,
                                        'Product' => [
                                            'id' => $prod->id,
                                            'name'=> $prod->name
                                        ],
                                        'quantity'=>$prod_added->quantity,
                                        'size'=> [
                                            'id' => $prod_added->sizeId,
                                            'name' => $size_O->$name
                                        ]
                                    ] ,'status' => true, 'Content-Language' => $this->language);

                                } else {
                                    $output = array('message' => $save_err, 'status' => false, 'Content-Language' => $this->language);
                                }
                            }else{
                                $output = array('message'=>$no_prod, 'status'=>false, 'Content-Language' => $this->language);
                            }
                        }else{
                            $output = array('message'=>$no_prod, 'status'=>false, 'Content-Language' => $this->language);
                        }
                    }else{
                        $output = array('message' => $not_rigester, 'status' => false, 'Content-Language' => $this->language);
                    }
                }else{
                    $output = array('message' => $token_lg_err, 'status' => false, 'Content-Language' => $this->language);
                }
                break;


            case 'get':
                @$token = $this->filterStr($_SERVER['HTTP_TOKEN']);

                if ($token != '' && $token != false){
                    $user = User::getBytoken($token);

                    if($user != false){
                        Cart::$language = $this->language;
                        Cart_prod::$language = $this->language;
                        $cart = Cart::getByUser($user->id);
                        if ($cart != false){
                            $products = new Cart_prod();
                            $data = $products->getByCartId($cart->id);
                            if ($data != false){
                                $output = array('message' => $cart_get,'data' => $data, 'status' => true, 'Content-Language' => $this->language);
                            }else{
                                $output = array('message' => $cart_get,'data' => ['products' => []], 'status' => true, 'Content-Language' => $this->language);
                            }
                        }else{
                            $output = array('message' => $cart_get_err, 'status' => false, 'Content-Language' => $this->language);
                        }
                    }else{
                        $output = array('message' => $not_rigester, 'status' => false, 'Content-Language' => $this->language);
                    }
                }else{
                    $output = array('message' => $token_lg_err, 'status' => false, 'Content-Language' => $this->language);
                }
                break;


            case 'delete':
                @$token = $this->filterStr($_SERVER['HTTP_TOKEN']);

                if ($token != '' && $token != false){
                    $user = User::getBytoken($token);

                    if($user != false){
                        @$prodId = $this->filterInt($_POST['product_id']);
                        @$sizeId = $this->filterInt($_POST['size_id']);

                        if ($prodId != ''){
                            $prod = Products::getByPK($prodId);
                            if ($prod != false){

                                $cart = Cart::getByUser($user->id);
                                if ($cart != false)
                                {
                                    $cart::$language = $this->language;
                                }else {
                                    $output = array('message' => $no_cart, 'status' => false, 'Content-Language' => $this->language);
                                    goto printing;
                                }

                                $cart_del = new Cart_prod();
                                $cart_del->cartId = $cart->id;
                                $cart_del->sizeId = $sizeId;
                                if($cart_del->delProd($prodId)){
                                    $output = array('message'=>$suc_del, 'status'=>true, 'Content-Language' => $this->language);
                                }else{
                                    $output = array('message'=>$save_err, 'status'=>false, 'Content-Language' => $this->language);
                                }
                            }else{
                                $output = array('message'=>$no_prod, 'status'=>false, 'Content-Language' => $this->language);
                            }
                        }else{
                            $output = array('message'=>$no_prod, 'status'=>false, 'Content-Language' => $this->language);
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