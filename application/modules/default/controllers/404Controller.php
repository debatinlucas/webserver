<?php

class Default_404Controller extends Zend_Controller_Action {

    public function init() {
        //Desliga a view
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction() {
        echo json_encode(404);
        $this->getResponse()->setHttpResponseCode(404);
    }

}

?>