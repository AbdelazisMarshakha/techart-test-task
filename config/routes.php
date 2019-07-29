<?php
/**
 * Routes system.
 * This shows which class and method are used depending on URI
 */

return [
    '404'               =>  'site/notFound',
    'view/([0-9]+)'     => 'news/view/$1',
    'view'              => 'news/view',
    'news/([0-9]+)'     =>  'news/index/$1',
    'news'              =>  'news/index',
];  