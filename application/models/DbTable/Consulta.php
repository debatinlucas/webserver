<?php

class Application_Model_DbTable_Consulta extends Zend_Db_Table_Abstract {

    protected $_name = 'consulta';

    public function add($data) {
        $this->insert($data);

        return $this->getAdapter()->lastInsertId();
    }

    public function edit($id, $data) {
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        $this->update($data, $where);
        return true;
    }

    public function del($id) {
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        $this->delete($where);
        return true;
    }

    public function getConsulta($id) {
        $id = (int) $id;
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {
            return false;
        }
        return $row->toArray();
    }

    public function all($pagina, $numreg = 15) {
        $resultado = $this->select()
                ->from(array('p' => $this->_name))
                ->limitPage($pagina, $numreg)
                ->order('data_hora_inicio ASC')
                ->query()
                ->fetchAll();
        return $resultado;
    }
}

?>