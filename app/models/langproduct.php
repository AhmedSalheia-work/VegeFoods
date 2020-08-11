<?php


namespace MVC\Models;


class Langproduct extends AbstractModel
{
    public $prodId;
    public $name;
    public $description;

    public static $tableName = '';
    public static $primaryKey = 'prodId';
    public static $tableSchema = array(
        'name' => self::DATA_TYPE_STR,
        'description' => self::DATA_TYPE_STR
    );

    public function __construct($whatever = '')
    {
        if ($whatever !== '' && self::$tableName == '')
        {
            $table = $whatever.'products';
            self::$tableName = $table;
        }
    }
}