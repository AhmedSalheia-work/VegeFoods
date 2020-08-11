<?php


namespace MVC\Models;


class Data extends AbstractModel
{
    public $id;
    public $data;

    public static $tableName = 'data';
    public static $primaryKey = 'id';
    public static $tableSchema = array(
        'data' => self::DATA_TYPE_STR,
    );
}