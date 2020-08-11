<?php


namespace MVC\Models;


use MVC\LIB\Helper;

class Token extends AbstractModel
{
    use Helper;

    public $pk;
    public $userId;
    public $token;

    public function __construct()
    {
        if ($this->token == '')
        {
            $this->token = $this->randText(25);
        }
    }

    public static $tableName = 'tokens';
    public static $primaryKey = 'pk';
    public static $tableSchema = array(
        'userId'    =>  self::DATA_TYPE_STR,
        'token'    =>  self::DATA_TYPE_STR,
    );
    public static $unique = 'userId';
}