<?php defined('BASEPATH') OR exit('No direct script access allowed');

class regras_model extends CI_Model
{
    private $banco = 'regras';

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

    public function getCreate()
    {
        $this->db->select('id');
        $this->db->where('cadastrar', 1);
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getRead()
    {
        $this->db->select('id');
        $this->db->where('ler', 1);
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getUpdate()
    {
        $this->db->select('id');
        $this->db->where('atualizar', 1);
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getDelete()
    {
        $this->db->select('id');
        $this->db->where('deletar', 1);
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
}