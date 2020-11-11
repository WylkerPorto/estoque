<?php defined('BASEPATH') OR exit('No direct script access allowed');

class acessos_model extends CI_Model
{
    private $banco = 'acessos';

    function __construct()
    {
        parent::__construct();
    }

    public function update($dados)
    {
        $this->db->where('id', $dados['id']);
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            $this->db->where('id', $dados['id']);
            $this->db->update($this->banco, $dados);
            return true;
        } else {
            $this->db->insert($this->banco, $dados);
            return $this->db->insert_id();
        }
    }

    public function find($id = null)
    {
        if ($id) {
            $this->db->where('id', $id);
        }
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 1) {
            return $query->result();
        } elseif ($query->num_rows() ==1) {
            return $query->result()[0];
        } else {
            return false;
        }
    }

    public function getName($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->banco);
        if ($query->num_rows() == 1) {
            return $query->result()[0]->nome;
        } else {
            return false;
        }
    }

    public function getByName($nome)
    {
        $this->db->where('nome', $nome);
        $query = $this->db->get($this->banco);
        if ($query->num_rows() == 1) {
            return $query->result()[0];
        } else {
            return false;
        }
    }
}