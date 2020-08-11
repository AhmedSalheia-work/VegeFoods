<?php


namespace MVC\Controllers\Api;


use MVC\Controllers\AbstractController;
use MVC\LIB\Helper;
use MVC\LIB\InputFilter;
use MVC\Models\Products;
use MVC\Models\User;
use MVC\Models\Wish;
use MVC\Models\Wish_prod;

class Api_wishlistController extends AbstractController
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
        extract(parse_ini_file(INI.$this->language.'/api/wish_errors.ini'));
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
                        if ($prodId != '')
                        {
                            $prod = Products::getByPK($prodId);
                            if ($prod != false){
                                $prod->returnData('FullData');

                                $wish = Wish::getByUser($user->id);
                                if ($wish != false)
                                {
                                    $wish::$language = $this->language;
                                }else{
                                    $wish = new Wish();
                                    $wish::$language = $this->language;
                                    $wish->userId = $user->id;

                                    if(!$wish->save()){
                                        $output = array('message' => $save_err,'status' => false, 'Content-Language' => $this->language);
                                        goto printing;
                                    }
                                }

                                $wish_prod = new Wish_prod();
                                $wish_prod->wishId = $wish->id;
                                $wish_prod->prodId = $prod->id;

                                if($wish_prod->save()){
                                    $output = array('message' => str_replace(':item', $prod->name, $wish_suc),'data' => [
                                        'wishlistId' => $wish->id,
                                        'Product' => [
                                            'id' => $prod->id,
                                            'name'=> $prod->name
                                        ]
                                    ] ,'status' => true, 'Content-Language' => $this->language);
                                }else{
                                    $output = array('message' => $already, 'status' => false, 'Content-Language' => $this->language);
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
                        $wish = Wish::getByUser($user->id);

                        if($wish != false){
                            $products = new Wish_prod();
                            $data = $products->getByWishId($wish->id);
                            if ($data != false){
                                $output = array('message' => $wish_get,'data' => $data, 'status' => true, 'Content-Language' => $this->language);
                            }else{
                                $output = array('message' => $save_err, 'status' => true,'data' => ['products' => []], 'Content-Language' => $this->language);
                            }
                        }else{
                            $output = array('message' => $wish_get_err, 'status' => false, 'Content-Language' => $this->language);
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

                        if ($prodId != ''){
                            $prod = Products::getByPK($prodId);
                            if ($prod != false){

                                $wish = Wish::getByUser($user->id);
                                if ($wish != false)
                                {
                                    $wish::$language = $this->language;
                                }else {
                                        $output = array('message' => $no_wish, 'status' => false, 'Content-Language' => $this->language);
                                        goto printing;
                                }

                                    $wish_del = new Wish_prod();
                                    $wish_del->wishId = $wish->id;
                                    if($wish_del->delProd($prodId)){
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