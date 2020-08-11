<?php


namespace MVC\Models;


class Prod_disc extends AbstractModel
{
    public $prodId;
    public $discId;
    public $end_time;

    public static $tableName = 'prod_disc';
    public static $primaryKey= 'prodId';
    public static $tableSchema= array(
        'discId' => self::DATA_TYPE_INT,
        'end_time'  =>  self::DATA_TYPE_STR
    );
}