<?php

/**
 * Контроллер SiteController
 */
class SiteController extends Controller
{


    public function actionIndex()
    {
        //self::isAuthorized();
        return $this->redirect('/news/1');
    }
    public static function actionNotFound()
    {
        return parent::render('404',[],'Не найдено');
    }
    
    public function action404()
    {
        return parent::render('404',[],'Не найдено');
    }
    
    public function action500( $ErrorExcepton = null)
    {
        return parent::render('500',['error'=>$ErrorExcepton],'Внутренняя ошибка');
    }
     
    public function redirect($url) {
        parent::redirect($url);
    }

    public static function isAuthorized(){
        if(empty($_COOKIE[App::get('autorization_coockie')])){
            return $this->redirect('login');
        }
        return true;
    }
}
