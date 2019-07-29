<?php

/**
 * Gets app settings
 *
 * @author rmapth
 */
class AppSettings {

    /**
     * @var mixed[]
     */
    protected static $data = [];
    
    protected static $config_path = ROOT.'/config';
    protected static $file_name = 'settings.php';

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    protected static function set($key, $value)
    {
        self::$data[$key] = $value;
    }

    /**        
     * @param string $key
     * @return mixed
     */
    protected static function get($key)
    {
        if($key=='base'){
            return isset(self::$data[$key]) ? trim(str_replace('\\','/',self::$data[$key]),'/') : '';
        }
        return isset(self::$data[$key]) ? self::$data[$key] : null;
    }

}
