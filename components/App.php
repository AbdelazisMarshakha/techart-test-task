<?php

/**
 * @Folder('/components/')
 * @author Rmapth
 */
class App  extends AppSettings implements AppInterface {

    protected static $instance = null;
    
    public static $base;
    
    
    public function __construct() {}
    public function __clone() {}
    
    public function __destruct(){
         $vars = array_keys(get_defined_vars()); 
         foreach ($vars as $key=>$var)
         { 
             unset($$vars[$key]); 
         } 
         unset($vars,$key); 
    }
    public static function instance()
    {
        if (self::$instance === null)
        {
            parent::$data = include parent::$config_path.DIRECTORY_SEPARATOR.parent::$file_name;
            self::$instance  = new self();
        }
        return self::$instance;
    }
    
    public static function __callStatic($method, $args)
    {
        return call_user_func_array(array(self::instance(), $method), $args);
    }

}

