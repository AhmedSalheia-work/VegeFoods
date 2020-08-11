<?php

namespace MVC\Models;

use MVC\Lib\Database\DatabaseHandler;

class AbstractModel
{
    const DATA_TYPE_BOOL = \PDO::PARAM_BOOL;
    const DATA_TYPE_STR = \PDO::PARAM_STR;
    const DATA_TYPE_INT = \PDO::PARAM_INT;
    const DATA_TYPE_FLOAT = 'anything';

    private function showTableSchema(){
        $sql = '';
        foreach (static::$tableSchema as $columnName => $type){
            $sql .= $columnName . '= :' . $columnName . ',' ;
        }
        return trim($sql,',');
    }

    private function prepareValue(\PDOStatement &$stmt){

        foreach (static::$tableSchema as $columnName => $type){
            if ($type == 'anything'){
                $sanitized = filter_var($this->$columnName,FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

                $stmt->bindValue(':'.$columnName,$sanitized);
                
            }else{
                $stmt->bindValue(':'.$columnName,$this->$columnName, $type);
            }
        }
    }



// Insert To Table:

    private function create(){

        $sql = 'INSERT INTO '.static::$tableName.' SET '.$this->showTableSchema();
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $this->prepareValue($stmt);
        if ($stmt->execute()){
            $this->{static::$primaryKey} = DatabaseHandler::factory()->lastInsertId();
            return true;
        }
        return false;
    }


// Update :

    private function update(){


        $sql = 'UPDATE '.static::$tableName.' SET '.$this->showTableSchema(). ' WHERE '.static::$primaryKey.'= "'.$this->{static::$primaryKey}.'"';
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $this->prepareValue($stmt);
        return $stmt->execute();
    }


// UPDATING OR DELETING :

    public function save(){
        return ($this->{static::$primaryKey} === null)?  $this->create(): $this->update() ;
    }


// DELETE :

    public function delete(){


        $data = $this->{static::$primaryKey};
        if(strpos(strtolower(static::$primaryKey),'id') !== true){
            $data = $this->{static::$primaryKey};
        }

        $sql = 'DELETE FROM '.static::$tableName.' WHERE '.static::$primaryKey.'= "'.$data.'"';
        $stmt = DatabaseHandler::factory()->prepare($sql);
        return $stmt->execute();
    }

// SELECTING ALL :
    public static function getAll($limit_start = 0,$limit_end = 0){

        $lim = ($limit_end != 0)? 'LIMIT '.$limit_start.','.$limit_end:'';

        $sql = 'SELECT * FROM '.static::$tableName.' ORDER BY '.static::$primaryKey . ' DESC '.$lim;
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $stmt->execute();
        $results =  $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class());
        return (is_array($results) && !empty($results))?   $results:false;
    }

// SELECTING ONE ELEMENT :

    public static function getByPK($pk,$all='n',$limit_start = 0,$limit_end = 0){
        $lim = ($limit_end != 0)? 'LIMIT '.$limit_start.','.$limit_end:'';

        $sql = 'SELECT * FROM '.static::$tableName. ' WHERE '.static::$primaryKey.' = "'.$pk.'" '.$lim;
        $stmt = DatabaseHandler::factory()->prepare($sql);
        if($stmt->execute() === true){
            if (method_exists(get_called_class(),'__construct')){
                $results = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class(),array(static::$tableSchema));
            }else{
                $results = $stmt->fetchAll(\PDO::FETCH_CLASS,get_called_class());
            }
            return !empty($results)? (($all == 'n')? array_shift($results) : $results): false;
        }
        return false;
    }


    public static function getByunique($unique){

        $sql = 'SELECT * FROM '.static::$tableName. ' WHERE '.static::$unique.' = "'.$unique.'"';
        $stmt = DatabaseHandler::factory()->prepare($sql);
        if($stmt->execute() === true){
            if (method_exists(get_called_class(),'__construct')){
                $results = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class(),array(static::$tableSchema));
            }else{
                $results = $stmt->fetchAll(\PDO::FETCH_CLASS,get_called_class());
            }
            return !empty($results)? array_shift($results) : false;
        }
        return false;
    }


    public static function getBytoken($token){

        $sql = 'SELECT * FROM users WHERE token = "'.$token.'"';
        $stmt = DatabaseHandler::factory()->prepare($sql);
        if($stmt->execute() === true){
            if (method_exists(get_called_class(),'__construct')){
                $results = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class(),array(static::$tableSchema));
            }else{
                $results = $stmt->fetchAll(\PDO::FETCH_CLASS,get_called_class());
            }
            return !empty($results)? array_shift($results) : false;
        }
        return false;
    }


// FOR OTHER SQL QUERYS :

    public function get($sql,$options = array()){
        $stmt = DatabaseHandler::factory()->prepare($sql);

        if (!empty($options)){
            foreach ($options as $columnName => $type){
                if ($type[0] == 'anything'){
                    $sanitized = filter_var($type[1],FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

                    $stmt->bindValue(":{$columnName}",$sanitized);
                }else{
                    $stmt->bindValue(":{$columnName}",$type[1], $type[0]);
                }
            }
        }
        $stmt->execute();
        if (method_exists(get_called_class(),'__construct')){
            $result = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class(), array(static::$tableSchema));
        }else{
            $result = $stmt->fetchAll(\PDO::FETCH_CLASS,get_called_class());
        }
        return $result;
    }
}