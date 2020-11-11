<?php defined('BASEPATH') OR exit('No direct script access allowed');

class titulos_model extends CI_Model
{
    private $banco = 'titulos';

    function __construct()
    {
        parent::__construct();
    }

    public function update($dados)
    {
        $this->db->where('id', $dados['id']);
        $this->db->where('parcela', $dados['parcela']);
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            $this->db->where('id', $dados['id']);
            $this->db->where('parcela', $dados['parcela']);
            $this->db->update($this->banco, $dados);
            return true;
        } else {
            $this->db->insert($this->banco, $dados);
            return $this->db->insert_id();
        }
    }

    public function find($titulo = null, $parcela = null)
    {
        if ($titulo) {
            $this->db->where('id', $titulo);
        }
        if ($parcela) {
            $this->db->where('parcela', $parcela);
        }
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function findBetween($first, $last)
    {
        $this->db->where("parcela BETWEEN '$first' and '$last'");
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getFatura($titulo)
    {
        $this->db->where('id', $titulo);
        $this->db->where('status', 0);
        $this->db->limit(1);
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getPagar()
    {
        $this->db->where('tipo', 2);
        $this->db->where('status', 0);
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getReceber()
    {
        $this->db->where('tipo', 1);
        $this->db->where('status', 0);
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
        if ($dados['usuario']) {
            $this->db->where('usuario', $dados['usuario']);
        }
        if ($dados['motivo']) {
            $this->db->where('motivo', $dados['motivo']);
        }
        if ($dados['titulo']) {
            $this->db->where('id', $dados['titulo']);
        }
        if ($dados['baixado']) {
            $this->db->where('status', $dados['baixado']);
        }
        if ($dados['io']) {
            $this->db->where('tipo', $dados['io']);
        }
        if ($dados['vencimentode']) {
            $this->db->where('vencimento >=', $dados['vencimentode']);
        }
        if ($dados['vencimentoate']) {
            $this->db->where('vencimento <=', $dados['vencimentoate']);
        }
        if ($dados['pagamentode']) {
            $this->db->where('data_pagamento >=', $dados['pagamentode']);
        }
        if ($dados['pagamentoate']) {
            $this->db->where('data_pagamento <=', $dados['pagamentoate']);
        }
        $query = $this->db->get($this->banco);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
}