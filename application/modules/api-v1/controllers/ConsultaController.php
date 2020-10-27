<?php

class ApiV1_ConsultaController extends Zend_Rest_Controller {

    public function init() {
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function deleteAction() {
        //Recupera os parâmetros
        $param = $this->_request->getParams();
        $con = new Application_Model_DbTable_Consulta();
        $retorno = $con->del($param ['id']);
        echo json_encode($retorno);
    }

    public function indexAction() {
        $this->getAction();
    }

    public function postAction() {
        //Request Payload
        $body = $this->getRequest()->getRawBody();
        $data = (array) json_decode($body);

        $con = new Application_Model_DbTable_Consulta();
        $retorno = $con->add($data);
        echo json_encode($retorno);
    }

    public function putAction() {
        //Request Payload
        $body = $this->getRequest()->getRawBody();
        $data = (array) json_decode($body);

        //Recupera os parâmetros
        $param = $this->_request->getParams();

        $con = new Application_Model_DbTable_Consulta();
        $retorno = $con->edit($param ['id'], $data);
        echo json_encode($retorno);
    }

    public function getAction() {
        //Recupera os parâmetros
        $param = $this->_request->getParams();
        $con = new Application_Model_DbTable_Consulta();

        if (isset($param ['id'])) {
            $retorno = $con->getConsulta($param ['id']);
        } else {
            $retorno = $con->all($param ['pagina'], $param ['numreg']);
        }

        echo json_encode($retorno);
    }

    public function headAction() {
        
    }

}

?>