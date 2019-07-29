<?php 
/**
 * @author Rmapth
 */
class Router
{
    private $routes;
    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }

    /**
     * 
     * @return string requested URL
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            $url = $_SERVER['REQUEST_URI'];
            if(!empty(App::get('base'))){
                $url = trim($url,App::get('base'));
            }
            $url = trim($url, '/');
            $url = explode('?', $url)[0];
            return $url;
        }
        return '';
    }

    public function run()
    {
        ini_set('error_reporting', 0);
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        set_error_handler(function($errno, $errstr, $errfile, $errline, array $errcontext) {   
            if (0 === error_reporting()) {
                return false;
            }
            throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
        });
        
        register_shutdown_function(function () {
            $err = error_get_last();
            if (! is_null($err)) {
                App::action500($err);
            }
        });

        $uri = $this->getURI();
        $SiteController = new SiteController();// MainController 
        
        $routes = array_filter(array_keys($this->routes),function($uriPattern) use($uri){
            return preg_match("~$uriPattern~", $uri); 
        });
        if (!empty($routes)) {            
            $routes = [ array_values($routes)[0] => $this->routes[array_values($routes)[0]]];
            foreach ($routes as $uriPattern => $path) {
                // Get the inner path from the outer according to the rule.
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                // Define controller, action, parameters
                $segments = explode('/', $internalRoute);
                unset($internalRoute);
                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName);
                $actionName = 'action' . ucfirst(array_shift($segments));
                $parameters = $segments;
                $controllerFile = ROOT . '/controllers/' .
                $controllerName . '.php';
                try{
                    $controllerObject = new $controllerName;
                } catch (ErrorException $e){
                    return $SiteController->action404();
                }
                if(!method_exists ($controllerObject ,$actionName)){
                    return $SiteController->action404();
                }
                try{
                    $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                    break;
                } catch (ErrorException $e){
                    return $SiteController->action500($e);
                    break;
                } finally {
                 
                }
            }
        }else{
            $segments = explode('/', $uri);
            $controllerName = array_shift($segments) ;
            if(empty($controllerName)){
                $controllerName = empty(App::get('controller_default'))?'site':App::get('controller_default');
            }
            $controllerName .=   'Controller';
            $controllerName = ucfirst($controllerName);
            $actionName = array_shift($segments);
            if(empty($actionName)){
                $actionName = 'index';
            }
            $actionName = 'action' . ucfirst($actionName);
            $parameters = $segments;
            $controllerFile = ROOT . '/controllers/' .
            $controllerName . '.php';
            try{
            $controllerObject = new $controllerName;
            } catch (ErrorException $e){
                return $SiteController->action404($e);
            }
            if(!method_exists ($controllerObject ,$actionName)){
                return $SiteController->action404();
            }
            try{
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
            } catch (ErrorException $e){
                return $SiteController->action500($e);
            } finally {}
        }
        return true;
    }
}
