<?php

 
class FrontController extends FrontControllerCore
{
    /*
    * module: ets_superspeed
    * date: 2021-12-30 10:00:04
    * version: 1.5.2
    */
    public function initContent()
    {
        if(Tools::isSubmit('ets_superseed_load_content'))
        {
            parent::initContent();
            Hook::exec('actionPageCacheAjax');
        }
        parent::initContent();
    }
}