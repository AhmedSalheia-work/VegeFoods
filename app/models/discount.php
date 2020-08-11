<?php


namespace MVC\Models;


class Discount extends AbstractModel
{
    public $id;
    public $discount;
    public $discount_type;

    public static $tableName = 'discount';
    public static $primaryKey= 'id';
    public static $tableSchema= array(
        'discount' => self::DATA_TYPE_INT,
        'discount_type' =>  self::DATA_TYPE_STR
    );
}