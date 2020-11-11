<?php defined('BASEPATH') OR exit('No direct script access allowed');

class acoes_model extends CI_Model
{
    private $banco = 'acoes';

    function __construct()
    {
        parent::__construct();
    }

    public function update($dados)
    {
        $this->db->where('grupo', $dados['grupo']);
        $this->db->where('acesso', $dados['acesso']);
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            $this->db->where('grupo', $dados['grupo']);
            $this->db->where('acesso', $dados['acesso']);
            $this->db->update($this->banco, $dados);
            return true;
        } else {
            $this->db->insert($this->banco, $dados);
            return true;
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

    public function getByFilter($grupo, $regra, $acesso)
    {
        if ($grupo) {
            $this->db->where('grupo', $grupo);
        }
        if ($regra) {
            $this->db->where('regra', $regra);
        }
        if ($acesso) {
            $this->db->where('acesso', $acesso);
        }
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getByGrupo($grupo)
    {
        $this->db->where('grupo', $grupo);
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getByAcesso($acesso)
    {
        $this->db->where('acesso', $acesso);
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
}