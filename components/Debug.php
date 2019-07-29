<?php

class Debug{
    const START_DEBUG_BETIFIER ='<pre>';
    const END_DEBUG_BETIFIER ='</pre>';
    
    public static function Dprint($data,bool $json=false){
        if($json){
            $data = json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        echo self::START_DEBUG_BETIFIER;
        var_dump($data);
        echo self::END_DEBUG_BETIFIER;
        //return printing result  
        return true;
    }
    public static function Log($data,$file='log'){
        file_put_contents(ROOT.'/log/'.$file.'.txt', print_r($data,true),FILE_APPEND);
    }
}
