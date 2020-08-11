<?php


namespace MVC\Models;


class Category extends AbstractModel
{
    public $id;
    public $en_catagory;
    public $ar_catagory;

    public static $tableName = 'Categories';
    public static $primaryKey = 'id';

    public static $tableSchema = array(
        'en_catagory' => self::DATA_TYPE_STR,
        'ar_catagory' => self::DATA_TYPE_STR
    );
}