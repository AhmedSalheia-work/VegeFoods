<?php


namespace MVC\Models;


class Cart extends AbstractModel
{
    public $id;
    public $userId;
    public static $language = 'en';

    public static $tableName = 'cart';
    public static $primaryKey = 'id';
    public static $tableSchema = array(
        'userId'    =>  self::DATA_TYPE_INT
    );

    public function getUserId()
    {
        return $this->userId;
    }

    public static function getByUser($userId){
        self::$primaryKey = 'userId';
        self::$tableSchema = array(
            'userId'    =>  self::DATA_TYPE_INT
        );

        $user = self::getByPK($userId);

        self::returnDefaults();
        return $user;
    }

    function returnDefaults(){
        self::$primaryKey = 'id';
        self::$tableSchema = array(
            'userId'    =>  self::DATA_TYPE_INT
        );
    }
}