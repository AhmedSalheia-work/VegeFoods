<?php


namespace MVC\Models;


class Prod_cat extends AbstractModel
{
    public $prodId;
    public $cateId;

    public static $tableName = 'prod_cat';
    public static $primaryKey = 'prodId';
    public static $tableSchema = array(
        'cateId' => self::DATA_TYPE_INT
    );

    public static function  getByCateId($cateId,$limit_start = 0, $limit_end = 0){
        $data = new Prod_cat();
        $data::$primaryKey = 'cateId';
        $data::$tableSchema = ['prodId' => $data::DATA_TYPE_INT];

        $data = ($limit_end == 0)? $data::getByPK($cateId,'y') : $data::getByPK($cateId,'y',$limit_start,$limit_end);
        self::returnDefaults();
        return $data;
    }

    function returnDefaults(){
        self::$primaryKey = 'prodId';
        self::$tableSchema = array(
            'cateId' => self::DATA_TYPE_INT
        );
    }

}