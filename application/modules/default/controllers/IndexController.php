<?php

class Default_IndexController extends Zend_Controller_Action {

    public function init() {
        //Desliga a view
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction() {
        //Redireciona
        $this->redirect('/index.html');
    }

}

?>