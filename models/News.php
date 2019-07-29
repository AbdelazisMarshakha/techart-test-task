<?php

/**
 *
 * @author Rmapth
 */
class News extends Model{
    
    public function __construct() {
        parent::__construct('news',
            [
                'id','idate','title','announce','content'
            ]
        );
    }
    
}
