<?php


namespace MVC\Models;


class Wish_prod extends AbstractModel
{
    public $id;
    public $wishId;
    public $prodId;

    public static $tableName = 'wish_prod';
    public static $primaryKey = 'id';
    public static $tableSchema = array(
        'wishId' => self::DATA_TYPE_INT,
        'prodId' => self::DATA_TYPE_INT
    );

    public function getByWishId($wish = '')
    {
        self::$primaryKey = 'wishId';
        $wish = (isset($wish) && $wish != '')? $wish : $this->wishId;

        $wishs = self::getByPK($wish,'y');
        $wishat = ['wishId' => $wish, 'products' => []];

        if ($wishs != false){
            foreach ($wishs as $wish){
                $prod = (Products::getByPK($wish->prodId))->returnData('FullData');

                $arr = [
                    'productId'      => $prod['id'],
                    'productName'    => $prod['product_data']['name'],
                    'productDescription'    => $prod['product_data']['description'],
                    'productImage'   => $prod['img'],
                    'productPrice'   => $prod['price']
                ];

                array_push($wishat['products'],$arr);
            }
        }else{
            $wishat = false;
        }

        self::returnDefaults();
        return $wishat;
    }

    public function delProd($id){
        $prod = self::get('DELETE FROM '.self::$tableName.' WHERE wishId="'.$this->wishId.'" AND prodId="'.$id.'"');
        return ($prod == []);
    }

    function returnDefaults(){
        self::$primaryKey = 'id';
    }
}