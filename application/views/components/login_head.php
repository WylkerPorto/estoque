<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?= isset($titulo) ? $titulo : 'Sem titulo' ?></title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?= base_url('node_modules/adminbsb-materialdesign/plugins/bootstrap/css/bootstrap.css'); ?>">
    <?= isset($waves) ? "<link rel = 'stylesheet' href = " . base_url('node_modules/adminbsb-materialdesign/plugins/node-waves/waves.css') . " >" : null; ?>
    <?= isset($anima) ? "<link rel = 'stylesheet' href = " . base_url('node_modules/adminbsb-materialdesign/plugins/animate-css/animate.css') . " >" : null; ?>
    <?= isset($customcss) ? "<link rel = 'stylesheet' href = " . base_url('node_modules/adminbsb-materialdesign/css/style.css') . " >" : null; ?>
    <?= isset($mycss) ? "<link rel = 'stylesheet' href = " . base_url('assets/my/mystyle.css') . " >" : null; ?>
</head>
<body class="login-page ls-closed bg-cinza">