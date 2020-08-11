<?php


namespace MVC\Models;


class Prod_size extends AbstractModel
{
    public $prodId;
    public $sizeId;

    public static $tableName = 'prod_size';
    public static $primaryKey = 'prodId';
    public static $tableSchema = array(
        'sizeId' => self::DATA_TYPE_INT
    );
}