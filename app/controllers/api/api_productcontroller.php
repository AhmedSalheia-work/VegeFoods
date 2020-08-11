<?php


namespace MVC\Controllers\Api;


use MVC\LIB\Helper;
use MVC\LIB\InputFilter;
use MVC\Models\Category;
use MVC\Models\Prod_cat;
use MVC\Models\Products;

class Api_productController extends \MVC\Controllers\AbstractController
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
        extract(parse_ini_file(INI.$this->language.'/api/product_errors.ini'));

        @$this->action = $this->_params[0];

        switch ($this->action)
        {
            case 'categories':
                $categories_all = Category::getAll();

                if ($categories_all != false){
                    $categories = [];
                    foreach ($categories_all as $item){
                        $cat_name = $this->language.'_catagory';
                        $cati = ['id' => $item->id,'category' => $item->$cat_name];
                        array_push($categories,$cati);
                    }

                    $output = array('message' => $cat, 'status' => true,'data' => [
                        'categories'    =>  $categories
                        ], 'Content-Language' => $this->language);

                }else{
                    $output = array('message' => $no_cat, 'status' => false, 'Content-Language' => $this->language);
                }
                break;

            case 'get_products':
                $page = (isset($_GET['page']))? intval($_GET['page']) : 1;
                $cate = (isset($this->_params[1]))? $this->_params[1] : 0;

                $count = ($cate == 0)? count(Products::getAll()) : count(Products::getByCategory($cate));
                $pages = $count/12;
                $pages = intval(is_float($pages)? $pages+1 : $pages);

                if ($page > $pages)
                {
                    $output = array('message' => $pages_err, 'status' => false,'data' => [
                        'page_num'       =>  $page,
                        'pages_num'       =>  $pages
                    ], 'Content-Language' => $this->language);
                    goto printing;
                }

                if ($cate == 0){
                    $prod = Products::getAll(($page-1)*12,($page*12));
                }else{
                    $prod = Products::getByCategory($cate,($page-1)*12,($page*12));
                }

                if ($prod != false)
                {
                    $products = [];
                    foreach ($prod as $item){
                        $item->wanted_language = $this->language;
                        array_push($products,$item->returnData('FullData,Category,Discount'));
                    }

                    $output = array('message' => $prod_succ, 'status' => true,'data' => [
                        'products'    =>  $products,
                        'page_num'       =>  $page,
                        'pages_num'       =>  $pages
                    ], 'Content-Language' => $this->language);
                }else{
                    $output = array('message' => $no_prod, 'status' => false, 'Content-Language' => $this->language);
                }

                break;

            case 'single':
                @$product = Products::getByPK($this->filterInt($_POST['product_id']));
                if ($product != false){
                    $rels = $product->returnData('Category');
                    $rela = [];
                    foreach ($rels['categories'] as $rel)
                    {
                        $prods = Prod_cat::getByCateId($rel['id'],0,4);
                        foreach ($prods as $prod){
                            $bool = 'y';
                            if (!empty($rela)){
                                foreach ($rela as $reld){
                                    if ($prod->prodId == $reld['id']) {
                                        $bool = 'n';
                                        break;
                                    }else{
                                        continue;
                                    }
                                }
                            }
                            $prod = Products::getByPK($prod->prodId);
                            if ($prod->id == $product->id){continue;}
                            if (count($rela) < 4){
                                if ($bool != 'n' || empty($rela)){
                                    array_push($rela,$prod->returnData('FullData,Discount'));
                                }else{
                                    continue;
                                }
                            }else{
                                break;
                            }
                        }
                    }
                    $output = array('message' => $prod_succ, 'status' => true, 'data' => [
                        'product' => $product->returnData('FullData,Sizes,Discount'),
                        'related' => $rela
                    ], 'Content-Language' => $this->language);
                }else{
                    $output = array('message' => $no_prod, 'status' => false, 'Content-Language' => $this->language);
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