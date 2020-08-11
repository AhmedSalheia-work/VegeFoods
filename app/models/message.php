<?php


namespace MVC\Models;


class Message extends AbstractModel
{
    public $messageId;
    public $name;
    public $email;
    public $subject;
    public $message;

    public static $tableName = 'messages';
    public static $primaryKey = 'messageId';
    public static $tableSchema = array(
        'name' => self::DATA_TYPE_STR,
        'email' => self::DATA_TYPE_STR,
        'subject' => self::DATA_TYPE_STR,
        'message' => self::DATA_TYPE_STR
    );
}