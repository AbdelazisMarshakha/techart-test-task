<?php
class Controller{
    
    protected $config;
    protected $response;
    protected $errors;

    const response = 
            [
                /*
                 * THOSE ARE PERMANENT
                 */
                'success'=> true,
                /*                
                 * THOSE ARE TEMP 
                 */
                'error' => array(
                    'code' => 500, 
                    'errorMessage' => 'Internal Error'
                ),
                'data' => array()
            ];
    
    /**
     * @return boolean
     * @throws ErrorException
     */
    public function __construct() {

    }
    public function __destruct() {
        if(!empty($this->response)){
            if(DEBUG){
                Debug::Dprint($this->response);
            }else{
                echo json_encode($this->response,JSON_PRETTY_PRINT);
            }
        }
        if(!empty($this->errors)){
            if(DEBUG){
                Debug::Dprint($this->errors);
            }else{
                echo json_encode($this->errors,JSON_PRETTY_PRINT);
            }
        }
    }
    
    /**
    * 
    * @param type $value
    * @param type $success
    */   
    protected function returnData($value,$success=true,$errorMsg= 'Internal Error',$code=500,$line=0){
        $response = self::response;
        if($success){
            unset($response['error']);
            $response['success']=$success;
            $response['data'] =$value;
        }else{
            unset($response['data']);
            $response['success']=$success;
            
            $response['error']['code'] = $code;
            $response['error']['errorMessage'] = $errorMsg;
            
            if(!empty($line)){
                $response['error']['line'] = $line;
            }
        }
        return $response;
    }
 
   
    protected function redirect($url){
        $url = '/'.trim($url,'/');
        $location = '/'.App::get('base');
        if(empty(trim($location,'/'))){
            $location = $url;
        }else{
            $location = $location.$url;
        }
        header('Location: '.$location);
    }


    protected function render(string $filename,array $params = [],string $title=''){
        try{
            if($this->checkArgs($params)){
                throw new ErrorException("Params array can't contains '%service.%' keys",400);
            }        
            $context = $this->getClassName($this);
            $head = [];
            $head['service_css'] = $this->getCSS($filename, $context);
            $head['service_js'] =  $this->getJS($filename, $context);
            $head['service.base'] =  APP::$base;
            $file = ROOT.DIRECTORY_SEPARATOR .'views'.DIRECTORY_SEPARATOR.$context.DIRECTORY_SEPARATOR.strtolower($filename);
            $this->startViewer($title,$head);
            $this->prepareView($file,$params);
            return true;
        } catch (ErrorException $e){
            Debug::Dprint($e);
            return false;
        }
    }
    
    private function getClassName($context){
        return strtolower(str_replace('Controller','',get_class($context)));
    }
    
    /**
     * params array can't contains service. keys
     * @param array $params
     * @return bool
     */
    private function checkArgs($params){        
        return 
            array_key_exists('service.css', $params) 
            ||
            array_key_exists('service.js', $params) 
            ;
    }

    private function getCSS($filename,$context){
        $file = '/css'.DIRECTORY_SEPARATOR.$context.DIRECTORY_SEPARATOR.strtolower($filename).'.css';
        $filename = ROOT.$file;
        if($this->getView($filename)){
            $css = APP::$base.$file;            
            return $css;
        }else{
            return false;
        }
    }
    private function getJS($filename,$context){
        $file = '/js'.DIRECTORY_SEPARATOR.$context.DIRECTORY_SEPARATOR.strtolower($filename).'.js';
        $filename = ROOT.$file;
        if($this->getView($filename)){
            return APP::get('base').$file;
        }else{
            return false;
        }
    }
    private function getView($filename){
        if(!file_exists($filename)){
            return false;
        }
        return true;
    }

    protected function startViewer($title,$params){
        $params['title'] = $title;
        $file = ROOT.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR.'head';
        return $this->prepareView($file,$params);
    }
    protected function prepareView($file,$params){
        $filename = $file.'.php';
        if(!$this->getView($filename)){
            return false;
        }
        foreach ($params as $key=>$val){
            ${$key} = $val;
        }
        unset($params);
        include($filename);
        return true;
    }
}

