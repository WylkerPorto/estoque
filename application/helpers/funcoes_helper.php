<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (! function_exists('DatetimeNow')) {
    /* pega dia e hora atual */
    function DatetimeNow() {
        $tz_object = new DateTimeZone('Brazil/East');
        $datetime = new DateTime();
        $datetime->setTimezone($tz_object);
        return $datetime->format('Y\-m\-d\ h:i:s');
    }
}

if (! function_exists('left_menu')) {
    /* pega os menus de acesso através das regras do usuario cadastrado */
    function left_menu() {
        $ci = & get_instance();
        $acessos = null;
        if ($acoes = $ci->acoes_model->getByGrupo($ci->session->userdata('auth')['grupo'])) {
            foreach ($acoes as $acao) {
                $acessos[$acao->acesso] = $acao->regra;
            }
        }
        $ver = $ci->regras_model->getRead();
        $left_menu = $ci->acessos_model->find();
        foreach ($acessos as $acesso => $regra) {
            if (!in_array($regra, array_column($ver, 'id'))){
                unset($left_menu[$acesso - 1]);
            }
        }
        return $left_menu;
    }
}

if (! function_exists('ver_regra')) {
    /* verifica se cliente pode fazer ação */
    function ver_regra($acesso, $crud) {
        $ci = & get_instance();
        $id = $ci->acessos_model->getByName($acesso)->id;
        $acessos = null;
        $grupo = $ci->session->userdata('auth')['grupo'];
        if ($acoes = $ci->acoes_model->getByFilter($grupo, null, $id)) {
            foreach ($acoes as $acao) {
                $acessos[$acao->acesso] = $acao->regra;
            }
        } else {
            return false;
        }

        switch ($crud) {
            case 'c':
                $ver = $ci->regras_model->getCreate();
                break;
            case 'r':
                $ver = $ci->regras_model->getRead();
                break;
            case 'u':
                $ver = $ci->regras_model->getUpdate();
                break;
            case 'd':
                $ver = $ci->regras_model->getDelete();
                break;
            default:
                $ver = null;
            break;
        }
        if (!$ver) {
            return false;
        }

        foreach ($acessos as $acesso => $regra) {
            if (!in_array($regra, array_column($ver, 'id'))){
                return false;
            }
        }
        return true;
    }
}