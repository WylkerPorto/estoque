<?php defined('BASEPATH') OR exit('No direct script access allowed');

class pedidos_model extends CI_Model
{
    private $banco = 'pedidos';

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

    public function detalhe($id)
    {
        $this->db->select('pedidos.*, producao.*, produtos.nome')
            ->join('producao', 'pedidos.id = producao.pedido', 'left')
            ->join('produtos', 'producao.produto = produtos.id', 'right')
            ->where('pedidos.id', $id);
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function findByStatus($id)
    {
        $this->db->where('status', $id);
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function findPedido()
    {
        $this->db->where('status >', 1);
        $this->db->where('status <', 4);
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function findOrcamento($data = null)
    {
        if ($data) {
            $this->db->where('data_pedido >=', $data);
            $this->db->where('data_pedido <=', DatetimeNow());
        }
        $this->db->where('status', 1);
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getOpen()
    {
        $this->db->where('status <', 4);
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function findFatura()
    {
        $faturas = $this->db->get('titulos');
        $faturas = $faturas->result();
        $titulos = [];
        foreach ($faturas as $fatura) {
            if ($fatura->pedido) {
                $titulos[] = $fatura->pedido;
            }
        }
        $this->db->where('status >', 1)
            ->where('status <', 4);
        if ($titulos) {
            $this->db->where_not_in('id', $titulos);
        }
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function relatorio($dados)
    {
        if ($dados['cliente']) {
            $this->db->where('cliente', $dados['cliente']);
        }
        if ($dados['status']) {
            $this->db->where('status', $dados['status']);
        }
        if ($dados['data_finalizadode']) {
            $this->db->where('data_finalizado >=', $dados['data_finalizadode']);
        }
        if ($dados['data_finalizadoate']) {
            $this->db->where('data_finalizado <=', $dados['data_finalizadoate']);
        }
        if ($dados['data_entregade']) {
            $this->db->where('data_entrega >=', $dados['data_entregade']);
        }
        if ($dados['data_entregaate']) {
            $this->db->where('data_entrega <=', $dados['data_entregaate']);
        }
        if ($dados['data_pedidode']) {
            $this->db->where('data_pedido >=', $dados['data_pedidode']);
        }
        if ($dados['data_pedidoate']) {
            $this->db->where('data_pedido <=', $dados['data_pedidoate']);
        }
        if ($dados['precode']) {
            $this->db->where('preco >=', $dados['precode']);
        }
        if ($dados['precoate']) {
            $this->db->where('preco <=', $dados['precoate']);
        }
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
}