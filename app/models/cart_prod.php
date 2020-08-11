<?php


namespace MVC\Models;


class Cart_prod extends AbstractModel
{
    public $id;
    public $cartId;
    public $prodId;
    public $sizeId = 1;
    public $quantity = 1;
    public static $language;

    public static $tableName = 'cart_prod';
    public static $primaryKey = 'id';
    public static $tableSchema = array(
        'cartId'    =>  self::DATA_TYPE_INT,
        'prodId'    =>  self::DATA_TYPE_INT,
        'sizeId'    =>  self::DATA_TYPE_INT,
        'quantity'    =>  self::DATA_TYPE_INT
    );

    public function getCartId()
    {
        return $this->cartId;
    }

    public function getByProdId($prod = '',$size = ''){
        self::$primaryKey = 'prodId';
        $prod = (isset($prod) && $prod != '')? $prod:$this->prodId;
        $size = (isset($size) && $size != '')? $size:$this->sizeId;

        $prodin = false;
        $prods = self::getByPK($prod,'y');
        if ($prods != false)
        {
            foreach ($prods as $prod){
                if ($prod->sizeId != $size){
                    $prodin = false;
                }else{
                    $prodin = $prod;
                    break;
                }
            }
        }

        $this->returnDefaults();
        return $prodin;
    }

    public function getByCartId($cart = '')
    {
        self::$primaryKey = 'cartId';
        $cart = (isset($cart) && $cart != '')? $cart : $this->cartId;

        $carts = self::getByPK($cart,'y');
        $cartat = ['cartId' => $cart, 'products' => []];
        if ($carts != false){
            foreach ($carts as $cart){
                $prod = (Products::getByPK($cart->prodId))->returnData('FullData,Discount');
                $size = Sizes::getByPK($cart->sizeId);
                $name = self::$language.'_size';

                if (count($prod['discounts']) != 0){

                    if ($prod['discounts'][0]['type'] == '%'){

                        $price = round(floatval($prod['price']) - ($prod['price'] * floatval($prod['discounts'][0]['amount'])/100), 2 ,PHP_ROUND_HALF_UP);

                    }elseif($prod['discounts'][0]['type'] == '$'){

                        $price = round(floatval($prod['price']) - floatval($prod['discounts'][0]['amount']), 2 ,PHP_ROUND_HALF_UP);

                    }

                }else{

                    $price = round(floatval($prod['price']), 2 ,PHP_ROUND_HALF_UP);

                }

                $arr = [
                    'productId'      => $prod['id'],
                    'productName'    => $prod['product_data']['name'],
                    'productImage'   => $prod['img'],
                    'productSize'    => [
                        'id'         => $size->id,
                        'size'       => $size->$name
                    ],
                    'productPrice'   => $price,
                    'quantity'       => intval($cart->quantity),
                    'total'          => $price * intval($cart->quantity)
                ];

                array_push($cartat['products'],$arr);
            }
        }else{
            $cartat = false;
        }

        self::returnDefaults();
        return $cartat;
    }

    public function delProd($id){
        $prod = self::get('DELETE FROM '.self::$tableName.' WHERE cartId="'.$this->cartId.'" AND prodId="'.$id.'" AND sizeId="'.$this->sizeId.'"');
        return ($prod == []);
    }

    function returnDefaults(){
        self::$primaryKey = 'id';
    }


}