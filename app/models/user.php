<?php


namespace MVC\Models;


class User extends AbstractModel
{
    public $id;
    public $name;
    public $email;
    public $birthday;
    public $bio='Hi There, I\'m Using Vegefoods';
    public $password;
    public $role='user';
    public $verified='n';
    public $job;
    public $recording_time;

    public static $tableName = 'users';
    public static $primaryKey = 'id';
    public static $tableSchema = array(
        'name' => self::DATA_TYPE_STR,
        'email' => self::DATA_TYPE_STR,
        'birthday' => self::DATA_TYPE_STR,
        'bio' => self::DATA_TYPE_STR,
        'job' => self::DATA_TYPE_STR,
        'password' => self::DATA_TYPE_STR,
        'role' => self::DATA_TYPE_STR,
        'verified' => self::DATA_TYPE_STR,
        'recording_time' => self::DATA_TYPE_STR
    );
    public static $unique = 'email';

}