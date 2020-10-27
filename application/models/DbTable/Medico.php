<?php

class Application_Model_DbTable_Medico extends Zend_Db_Table_Abstract {

    protected $_name = 'medico';

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

    public function getMedico($id) {
        $id = (int) $id;
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {
            return false;
        }
        return $row->toArray();
    }

    public function all($pagina, $numreg = 15) {
        $resultado = $this->select()
                ->from(array('m' => $this->_name))
                ->limitPage($pagina, $numreg)
                ->order('nome ASC')
                ->query()
                ->fetchAll();
        return $resultado;
    }
}

?>