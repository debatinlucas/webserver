<?php

class ApiV1_PacienteController extends Zend_Rest_Controller {

    public function init() {
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function deleteAction() {
        //Recupera os parâmetros
        $param = $this->_request->getParams();
        $pac = new Application_Model_DbTable_Paciente();
        $retorno = $pac->del($param ['id']);
        echo json_encode($retorno);
    }

    public function indexAction() {
        $this->getAction();
    }

    public function postAction() {
        //Request Payload
        $body = $this->getRequest()->getRawBody();
        $data = (array) json_decode($body);

        $pac = new Application_Model_DbTable_Paciente();
        $retorno = $pac->add($data);
        echo json_encode($retorno);
    }

    public function putAction() {
        //Request Payload
        $body = $this->getRequest()->getRawBody();
        $data = (array) json_decode($body);

        //Recupera os parâmetros
        $param = $this->_request->getParams();

        $pac = new Application_Model_DbTable_Paciente();
        $retorno = $pac->edit($param ['id'], $data);
        echo json_encode($retorno);
    }

    public function getAction() {
        //Recupera os parâmetros
        $param = $this->_request->getParams();
        $pac = new Application_Model_DbTable_Paciente();

        if (isset($param ['id'])) {
            $retorno = $pac->getPaciente($param ['id']);
        } else {
            $retorno = $pac->all($param ['pagina'], $param ['numreg']);
        }

        echo json_encode($retorno);
    }

    public function headAction() {
        
    }

}

?>