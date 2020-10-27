<?php

class Default_ForbiddenController extends Zend_Controller_Action {

    public function init() {
        //Desliga a view
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction() {
        echo json_encode("SEM PERMISSÃO");
        $this->getResponse()->setHttpResponseCode(403);
    }

}

?>