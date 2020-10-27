<?php

class Default_ErrorController extends Zend_Controller_Action {

    public function init() {
        //Desliga a view
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function errorAction() {

        $errors = $this->_getParam('error_handler');

        //Variável para gravar os erros em um arquivo
        $logErro = '';

        if (!$errors) {
            $this->view->message = 'You have reached the error page';
            return;
        }

        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $priority = Zend_Log::NOTICE;
                $this->view->message = 'Page not found';
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $priority = Zend_Log::CRIT;
                $this->view->message = 'Application error';
                break;
        }

        // Log exception, if logger available
        if ($log = $this->getLog()) {
            $log->log($this->view->message, $priority, $errors->exception);
            $log->log('Request Parameters', $priority, $request->getParams());
        }

        //Grava a mensagem na variável
        $data = date('d-m-Y_H-i-s');
        $logErro .= '<p>Erro ocorrido em: ' . $data . '</p>';
        $logErro .= '<p>PROTOCOLO: ' . $_SERVER['SERVER_PROTOCOL'] . '<br/>';
        $logErro .= 'IP: ' . $_SERVER['REMOTE_ADDR'] . '<br/>';
        $logErro .= 'HOST: ' . gethostbyaddr($_SERVER['REMOTE_ADDR']) . '<br/>';
        $logErro .= 'USER AGENT: ' . $_SERVER['HTTP_USER_AGENT'] . '</p><br/><br/>';
        $logErro .= $this->view->message . '<br/><br/>';


        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;

            //Grava outras informações no log de erro
            $logErro .= '<p>Mensagem:</p> ' . $errors->exception->getMessage() . '<br/><br/>';
            $logErro .= '<p>Stack trace:</p> <pre>' . $errors->exception->getTraceAsString() . '</pre><br/><br/>';
        }

        $this->view->request = $errors->request;

        //Grava o pedido de parâmetros
        $logErro .= '<p>Pedido de Parâmetros:</p> <pre>' . var_export($errors->request->getParams(), true) . '</pre><br/><br/>';

        //Grava o log no arquivo
        $diretorio = '../app-log/error';
        file_put_contents($diretorio . '/' . $data . '.html', $logErro);

        //Limpeza dos arquivos de log
        $ponteiro = opendir($diretorio);

        while ($nome_itens = readdir($ponteiro)) {

            $file = $diretorio . "/" . $nome_itens;

            $diferenca = (time() - filectime($diretorio . "/" . $nome_itens));

            if ($diferenca >= 259200) {
                if (file_exists($diretorio . "/" . $nome_itens)) {
                    if ($file != $diretorio . "/." & $file != $diretorio . "/..") {
                        unlink($diretorio . "/" . $nome_itens);
                    }
                }
            }
        }

        $this->_redirect('/404');
    }

    public function getLog() {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }

}

?>