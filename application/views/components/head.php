<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?= isset($titulo) ? $titulo : 'Sem titulo' ?></title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?= base_url('node_modules/adminbsb-materialdesign/plugins/bootstrap/css/bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('node_modules/adminbsb-materialdesign/plugins/bootstrap-select/css/bootstrap-select.css'); ?>">
    <?= isset($waves) ? "<link rel = 'stylesheet' href = " . base_url('node_modules/adminbsb-materialdesign/plugins/node-waves/waves.css') . " >" : null; ?>
    <?= isset($anima) ? "<link rel = 'stylesheet' href = " . base_url('node_modules/adminbsb-materialdesign/plugins/animate-css/animate.css') . " >" : null; ?>
    <?= isset($alltheme) ? "<link rel = 'stylesheet' href = " . base_url('node_modules/adminbsb-materialdesign/css/themes/all-themes.css') . " >" : null; ?>
    <?= isset($datatable) ? "<link rel = 'stylesheet' href = " . base_url('node_modules/adminbsb-materialdesign/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') . " >" : null; ?>
    <?= isset($ckeditor) ? "<link rel = 'stylesheet' href = " . base_url('node_modules/adminbsb-materialdesign/plugins/ckeditor/lang/pt-br.js') . " >" : null; ?>
    <?= isset($select2) ? "<link rel = 'stylesheet' href = " . base_url('node_modules/select2/dist/css/select2.css') . " >" : null; ?>
    <?= isset($datapicker) ? "<link rel = 'stylesheet' href = " . base_url('node_modules/adminbsb-materialdesign/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css') . " >" : null; ?>
    <?= isset($false) ? "<link rel = 'stylesheet' href = " . base_url('') . " >" : null; ?>
    <?= isset($customcss) ? "<link rel = 'stylesheet' href = " . base_url('node_modules/adminbsb-materialdesign/css/style.css') . " >" : null; ?>
    <?= isset($mycss) ? "<link rel = 'stylesheet' href = " . base_url('assets/my/mystyle.css') . " >" : null; ?>
</head>
<body class="theme-blue ls-closed" ng-app="APP">