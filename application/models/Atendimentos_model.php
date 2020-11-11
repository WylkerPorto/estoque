<?php defined('BASEPATH') OR exit('No direct script access allowed');

class atendimentos_model extends CI_Model
{
    private $banco = 'atendimentos';

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
        $this->db->order_by('id', 'desc');
        $this->db->limit(500);
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function findByData($data)
    {
        $this->db->select('count(*) as qtd, DATE_FORMAT(data, \'%d/%m\') as data')
            ->where('data >=', $data)
            ->where('data <=', DatetimeNow())
            ->group_by('DATE_FORMAT(data, \'%d/%m/%Y\')');
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getByCliente($cliente)
    {
        $this->db->where('cliente', $cliente);
        $this->db->order_by('id', 'desc');
        $this->db->limit(10);
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function relatorio($dados)
    {
        if ($dados['usuario']) {
            $this->db->where('usuario', $dados['usuario']);
        }
        if ($dados['cliente']) {
            $this->db->where('cliente', $dados['cliente']);
        }
        if ($dados['datade']) {
            $this->db->where('data >=', $dados['datade']);
        }
        if ($dados['dataate']) {
            $this->db->where('data <=', $dados['dataate']);
        }
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
}