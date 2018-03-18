<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }


    public function adicionar($tabela, $dados)
    {
        if (isset($tabela) && is_array($dados))
        {
            return $this->db->insert($tabela, $dados);
        }
        return FALSE;
    }


    public function getById($id, $tabela)
    {
        if (isset($id) && isset($tabela))
        {
            $this->db->where('id', $id);
            $query = $this->db->get($tabela);
            if ($query->num_rows() > 0)
            {
                return $query->row_array();
            }
            return NULL;
        }
        return FALSE;
    }

    /*Todos os registros de acordo com o usuario_id*/
    public function getAll($usuario_id, $tabela)
    {
        if (isset($usuario_id) && isset($tabela))
        {
            $this->db->where('usuario_id', $usuario_id);
            $query = $this->db->get($tabela);

            if ($query->num_rows() > 0)
            {
                return $query->result_array();
            } else
            {
                return NULL;
            }
        }
        return FALSE;
    }
}