<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    public function init() {
        
    }
    
    protected function _initAutoloader() {
        
    }
    
    protected function _initRequest() {
        //Permite acesso de qualquer host
        header('Access-Control-Allow-Origin: *');
        //Padrão de retorno
        header('Content-Type: application/json;charset=utf-8');
    }

}

?>