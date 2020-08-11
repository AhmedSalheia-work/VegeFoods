<?php


namespace MVC\Models;


class Wish extends AbstractModel
{
    public $id;
    public $userId;
    public static $language;

    public static $tableName = 'wishlist';
    public static $primaryKey = 'id';
    public static $tableSchema = array(
        'userId' => self::DATA_TYPE_INT
    );

    public static function getByUser($userId){
        self::$primaryKey = 'userId';
        self::$tableSchema = array(
            'wishId'    =>  self::DATA_TYPE_INT
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