<?php

class ApiV1_MedicoController extends Zend_Rest_Controller {

    public function init() {
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function deleteAction() {
        //Recupera os parâmetros
        $param = $this->_request->getParams();
        $med = new Application_Model_DbTable_Medico();
        $retorno = $med->del($param ['id']);
        echo json_encode($retorno);
    }

    public function indexAction() {
        $this->getAction();
    }

    public function postAction() {
        //Request Payload
        $body = $this->getRequest()->getRawBody();
        $data = (array) json_decode($body);

        $med = new Application_Model_DbTable_Medico();
        $retorno = $med->add($data);
        echo json_encode($retorno);
    }

    public function putAction() {
        //Request Payload
        $body = $this->getRequest()->getRawBody();
        $data = (array) json_decode($body);

        //Recupera os parâmetros
        $param = $this->_request->getParams();

        $med = new Application_Model_DbTable_Medico();
        $retorno = $med->edit($param ['id'], $data);
        echo json_encode($retorno);
    }

    public function getAction() {
        //Recupera os parâmetros
        $param = $this->_request->getParams();
        $med = new Application_Model_DbTable_Medico();

        if (isset($param ['id'])) {
            $retorno = $med->getMedico($param ['id']);
        } else {
            $retorno = $med->all($param ['pagina'], $param ['numreg']);
        }

        echo json_encode($retorno);
    }

    public function headAction() {
        
    }

}

?>