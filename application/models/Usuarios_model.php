<?php defined('BASEPATH') OR exit('No direct script access allowed');

class usuarios_model extends CI_Model
{
    private $banco = 'usuarios';

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
            return $query->result();
        } else {
            return false;
        }
    }

    public function getByName($nome)
    {
        if ($nome) {
            $this->db->where('nome', $nome);
        }
        $query = $this->db->get($this->banco);
        if ($query->num_rows() ==1) {
            return $query->result()[0];
        } else {
            return false;
        }
    }

    public function getByEmail($email)
    {
        if ($email) {
            $this->db->where('email', $email);
        }
        $query = $this->db->get($this->banco);
        if ($query->num_rows() ==1) {
            return $query->result()[0];
        } else {
            return false;
        }
    }

    public function getByUser($usuario)
    {
        if ($usuario) {
            $this->db->where('usuario', $usuario);
        }
        $query = $this->db->get($this->banco);
        if ($query->num_rows() ==1) {
            return $query->result()[0];
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
}