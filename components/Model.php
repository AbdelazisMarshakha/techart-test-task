<?php

/**
 *
 * @author Rmapth
 */
class Model{
    
    /**
     * @var string 
     */
    protected  $tableName = '';
   
   /**
    * available fields in table
    * @var array 
    */
    protected  $fields = array();
    
    public function __construct(string $tableName,array $fields) {
       foreach ($fields as $field){
           $this->{$field} = '';
       }
       $this->tableName = $tableName;
       $this->fields = $fields;
       
       return true;
    }
   
    public function getRecords(array $filter = null,array $order = [],int $offset = 0, $limit = 5,$whatToSelect='*'){
        if($limit=='ALL'){
            $whatToSelect = ' COUNT(DISTINCT id) as count'; 
        }
        if(is_array($whatToSelect) ){
            $whatToSelect = $this-> availableField($whatToSelect,true);
            $whatToSelect = trim(implode(',',$whatToSelect),',');
            if(empty($whatToSelect)){
                $whatToSelect = '*';
            }
        }

        $sql = "SELECT $whatToSelect FROM {$this->tableName} WHERE 1 ";                
        $filter = $this-> availableField($filter);
        $order = $this->availableField($order);
        if(!empty($filter)){
            $sql .= $this->prepareFilter($filter);
        }
        if(!empty($order)){
            $sql .= ' ORDER BY ';
            foreach ($order as $field=>$sort){
                $sql .= "$field $sort ,";
            }
            $sql = trim($sql,',');
        }
        if(is_int($limit) && is_int($offset))
        {
            $sql .= "LIMIT $limit OFFSET $offset";

        }else{
            if($limit!='ALL'){
                return false;
            }
        }
        $stmt = DB::run($sql);
        return $stmt->fetchAll();
    }
    public function prepareFilter($filter,$glue =' AND '){
        $where = '';
        foreach ($filter as $field=>$value){
            if(is_string($value)){
                $where .= $glue." $field = '$value' ";
            }elseif(is_array($value)){
                foreach ($value as $k=>$v){
                    $where .= $glue. " $field $k '$v' ";
                }
            }elseif(is_int($value)){
                $where .= $glue. " $field = $value ";
            }
        }
        return $where;
    }

    public function availableField($filter,bool $keys = false){
        $array = [];
        if(!$keys){
            $fields = array_intersect(array_keys($filter),$this->fields );
            foreach ($fields as $field){
                $array[$field] =  $filter[$field];
            }            
        }else{
            $fields = array_intersect($filter,$this->fields );
            foreach ($fields as $field){
                $array[] = $field;
            }            
        }
        unset($filter);
        return $array;
    }

}
