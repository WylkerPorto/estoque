<?php defined('BASEPATH') OR exit('No direct script access allowed');

class producao_model extends CI_Model
{
    private $banco = 'producao';

    function __construct()
    {
        parent::__construct();
    }

    public function update($dados)
    {
        $this->db->where('pedido', $dados['pedido']);
        $this->db->where('produto', $dados['produto']);
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            $this->db->where('pedido', $dados['pedido']);
            $this->db->where('produto', $dados['produto']);
            $this->db->update($this->banco, $dados);
            return true;
        } else {
            $this->db->insert($this->banco, $dados);
            return true;
        }
    }

    public function getByPedido($id)
    {
        $this->db->where('pedido', $id);
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function delByPedido($pedido)
    {
        $this->db->where('pedido', $pedido);
        return $this->db->delete($this->banco);
    }
}