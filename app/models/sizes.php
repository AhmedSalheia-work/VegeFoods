<?php


namespace MVC\Models;


class Sizes extends AbstractModel
{
    public $id;
    public $en_size;
    public $ar_size;

    public static $tableName = 'sizes';
    public static $primaryKey = 'id';
    public static $tableSchema = array(
        'en_size' => self::DATA_TYPE_STR,
        'ar_size' => self::DATA_TYPE_STR
    );

}