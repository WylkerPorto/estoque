<?php defined('BASEPATH') OR exit('No direct script access allowed');

class produtos_model extends CI_Model
{
    private $banco = 'produtos';

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

    public function getBySpec($spec)
    {
        if (isset($spec['nome'])) {
            $this->db->where('nome', $spec['nome']);
        }
        if (isset($spec['altura'])) {
            $this->db->where('altura', $spec['altura']);
        }
        if (isset($spec['largura'])) {
            $this->db->where('largura', $spec['largura']);
        }
        if (isset($spec['comprimento'])) {
            $this->db->where('comprimento', $spec['comprimento']);
        }
        if (isset($spec['comentario'])) {
            $this->db->where('comentario', $spec['comentario']);
        }
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
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

    public function relatorio($dados)
    {
        if ($dados['tipo']) {
            $this->db->where('tipo', $dados['tipo']);
        }
        if ($dados['quantidadede']) {
            $this->db->where('quantidade >=', $dados['quantidadede']);
        }
        if ($dados['quantidadeate']) {
            $this->db->where('quantidade <=', $dados['quantidadeate']);
        }
        if ($dados['alturade']) {
            $this->db->where('altura >=', $dados['alturade']);
        }
        if ($dados['alturaate']) {
            $this->db->where('altura <=', $dados['alturaate']);
        }
        if ($dados['largurade']) {
            $this->db->where('largura >=', $dados['largurade']);
        }
        if ($dados['larguraate']) {
            $this->db->where('largura <=', $dados['larguraate']);
        }
        if ($dados['comprimentode']) {
            $this->db->where('comprimento >=', $dados['comprimentode']);
        }
        if ($dados['comprimentoate']) {
            $this->db->where('comprimento <=', $dados['comprimentoate']);
        }
        if ($dados['precode']) {
            $this->db->where('preco >=', $dados['precode']);
        }
        if ($dados['precoate']) {
            $this->db->where('preco <=', $dados['precoate']);
        }
        if ($dados['zerado']) {
            $this->db->where('quantidade < ', 0)
                ->or_where('altura < ', 0)
                ->or_where('largura < ', 0)
                ->or_where('comprimento < ', 0);
        }
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
}