<?php
/**
 * @Folder()
 * @author Rmapth
 */
class Autoloader
{
    /**
     * @var         Autoloader instance
     */
    protected static $instance;

    /**
     * @var array standart mapping
     */
    protected static $paths = [
        '/models/',
        '/components/',
        '/components/interfaces/',
        '/controllers/',
    ];
    /**
     * @var array namespace mapping
     */
    protected static $ns_paths = [
        'App\Models'        => [
            '/models/',
        ],
        'App\Components'        => [
            '/components/',
        ],
        'App'        => [
            '/components/interfaces/',
        ],
        'App\Controllers'        => [
            '/controllers/',
        ],
    ];
    
    
    protected function __construct(){
        spl_autoload_register(function ($class) {
            $class = explode('\\', $class);
            $classname = array_pop($class);
            if(is_array($class) && !empty($class)){
                $class_namespace = implode('\\', $class);
                if(!empty($class_namespace)){
                    if(!empty(self::$ns_paths[$class_namespace])){
                        $paths = self::$ns_paths[$class_namespace];
                        foreach ($paths as $path){
                            $path = ROOT.  $path . $classname.'.php';
                            if (is_file($path))
                            {
                               include_once $path;  
                               return true; 
                            }
                        }
                    }
                }
            }
            unset($class);
            
            foreach (self::$paths as $path){
                $path = ROOT.  $path . $classname.'.php';
                if (is_file($path))
                {
                   include_once $path;  
                   return true; 
                }
            }
            return false;
        });
    }

    
    /**
     * Get loader instance
     */
    public static function getInstance(){
        if(null === self::$instance){
            self::$instance = new self;
        }

        return self::$instance;
    }

    private function __clone(){}
    private function __wakeup(){}
}

return Autoloader::getInstance();