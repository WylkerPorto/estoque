<?php defined('BASEPATH') OR exit('No direct script access allowed');

class clientes_model extends CI_Model
{
    private $banco = 'clientes';

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
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getClient($id = null)
    {
        if ($id) {
            $this->db->where('id', $id);
        }
        $this->db->where('status', 1);
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function delete($id, $nome)
    {
        $this->db->where('id', $id);
        $this->db->where('nome', $nome);
        return $this->db->delete($this->banco);
    }

    public function getByCNPJ($cnpj)
    {
        $this->db->where('cnpj', $cnpj);
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result()[0];
        } else {
            return false;
        }
    }

    public function getByCPF($cpf)
    {
        $this->db->where('cpf', $cpf);
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result()[0];
        } else {
            return false;
        }
    }

    public function relatorio($dados)
    {
        if ($dados['tipo']) {
            $this->db->where('tipo', $dados['tipo']);
        }
        if ($dados['nome']) {
            $this->db->like('nome', $dados['nome']);
        }
        if ($dados['cep']) {
            $this->db->where('cep', $dados['cep']);
        }
        if ($dados['nascimentode']) {
            $this->db->where('nascimento >=', $dados['nascimentode']);
        }
        if ($dados['nascimentoate']) {
            $this->db->where('nascimento <=', $dados['nascimentoate']);
        }
        if ($dados['status'] !== "") {
            $this->db->where('status', $dados['status']);
        }
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
}