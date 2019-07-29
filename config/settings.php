<?php
/**
 * @return array of settings
 */
return [
    'base'                  => '', //parameter is used if APP's path is not URL's root.  F.E : https://rmapth-framework.com/test/ and app is installed at folder 'test',so value of the parameter would be '/test/' or 'test'
    'autorization_coockie'  => 'default_autorization_',
    'controller_default'    => 'site',
    'database'              =>
        [
            'host'=>'localhost',
            'username'=>'techart_test_taska',
            'password'=>'',
            'database'=>'techart_test_taska',
        ]
];