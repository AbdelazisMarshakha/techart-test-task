<?php

/**
 *
 * @author Rmapth
 */
class NewsController extends Controller {
    /**
    * 
    * @param int $page
    */
    public function actionIndex( $iPage = 1 ){
        $iPage = intval($iPage);
        if( !is_int($iPage) || $iPage<1){
            return $this->redirect('/news/1');
        }
        $iLimit = 5;
        $iOffset = $iLimit * ($iPage-1);//Offset by page
        $News = new News();                                               
        $arNews = $News->getRecords(['idate'=>['>'=>'0'], /*filtering example*/'3'=>'3'],['idate'=>'DESC'],$iOffset,$iLimit,['announce','idate','id','title']);
        $arAllNews = $News->getRecords(['idate'=>['>'=>'0']],['idate'=>'DESC'],0,'ALL',['id']);
        $iTotalPageCount = ceil($arAllNews['0']['count']/$iLimit);
        if($iPage>$iTotalPageCount){
            return $this->redirect('/news/1');
        }
        return $this->render('news',['news'=>$arNews,'totalPageCount'=>$iTotalPageCount,'page'=>$iPage]);
    }
   
    public function actionView(  $iId =  1){
        $iId = intval($iId);
        $News = new News(); 
        if(!is_int($iId) || $iId<1){
            $lastId_record = $News->getRecords(['idate'=>['>'=>'0']],['idate'=>'DESC'],0,1,['id']);
            $lastId = $lastId_record['0']['id'];
            return $this->redirect("/view/$lastId");
        }
        $arNew_records = $News->getRecords(['idate'=>['>'=>'0'],'id'=>$iId],[],0,1);
        if(empty($arNew_records['0']['id'])){
            return $this->redirect("/view/0");
        }
        return $this->render('view',['new'=>$arNew_records['0']]);
        
    }
}
