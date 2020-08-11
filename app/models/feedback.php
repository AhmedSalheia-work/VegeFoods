<?php


namespace MVC\Models;


class Feedback extends AbstractModel
{
    public $id;
    public $userId;
    public $feedback;

    public static $tableName = 'feedbacks';
    public static $primaryKey = 'id';
    public static $tableSchema = array(
        'userId'    => self::DATA_TYPE_INT,
        'feedback'  => self::DATA_TYPE_STR
    );

    public function getData()
    {
        $user = User::getByPK($this->userId);
        $arr = array(
            'feedback'  =>  $this->feedback,
            'user'      =>  [
                'id'    =>  $user->id,
                'name'  =>  $user->name,
                'img'   =>  $user->img,
                'job'   =>  $user->job
            ]
        );
        return $arr;
    }

}