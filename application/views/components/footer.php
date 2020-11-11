</body>
<script src="<?= base_url('node_modules/adminbsb-materialdesign/plugins/jquery/jquery.js'); ?>"></script>
<script src="<?= base_url('node_modules/adminbsb-materialdesign/plugins/bootstrap/js/bootstrap.js'); ?>"></script>
<script src="<?= base_url('node_modules/adminbsb-materialdesign/plugins/bootstrap-select/js/bootstrap-select.js'); ?>"></script>
<?= isset($waves) ? "<script src=" . base_url('node_modules/adminbsb-materialdesign/plugins/node-waves/waves.js') . "></script>" : null; ?>
<?= isset($validation) ? "<script src=" . base_url('node_modules/adminbsb-materialdesign/plugins/jquery-validation/jquery.validate.js') . "></script>" : null; ?>
<?= isset($autosize) ? "<script src=" . base_url('node_modules/adminbsb-materialdesign/plugins/autosize/autosize.js') . "></script>" : null; ?>
<?= isset($form) ? "<script src=" . base_url('node_modules/adminbsb-materialdesign/js/pages/forms/basic-form-elements.js') . "></script>" : null; ?>
<?= isset($datatable) ? "<script src=" . base_url('node_modules/adminbsb-materialdesign/plugins/jquery-datatable/jquery.dataTables.js') . "></script>" : null; ?>
<?= isset($datatable) ? "<script src=" . base_url('node_modules/adminbsb-materialdesign/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') . "></script>" : null; ?>
<?= isset($ckeditor) ? "<script src=" . base_url('node_modules/adminbsb-materialdesign/plugins/ckeditor/ckeditor.js') . "></script>" : null; ?>
<?= isset($select2) ? "<script src=" . base_url('node_modules/select2/dist/js/select2.js') . "></script>" : null; ?>
<?= isset($tooltip) ? "<script src=" . base_url('node_modules/adminbsb-materialdesign/js/pages/ui/tooltips-popovers.js') . "></script>" : null; ?>
<?= isset($mask) ? "<script src=" . base_url('node_modules/adminbsb-materialdesign/plugins/jquery-inputmask/jquery.inputmask.bundle.js') . "></script>" : null; ?>
<?= isset($datapicker) ? "<script src=" . base_url('node_modules/adminbsb-materialdesign/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') . "></script>" : null; ?>
<?= isset($datapicker) ? "<script src=" . base_url('node_modules/adminbsb-materialdesign/plugins/momentjs/moment.js') . "></script>" : null; ?>
<?= isset($count) ? "<script src=" . base_url('node_modules/adminbsb-materialdesign/plugins/jquery-countto/jquery.countTo.js') . "></script>" : null; ?>
<?= isset($chart) ? "<script src=" . base_url('node_modules/adminbsb-materialdesign/plugins/chartjs/Chart.js') . "></script>" : null; ?>
<?= isset($false) ? "<script src=" . base_url('') . "></script>" : null; ?>
<?= isset($customjs) ? "<script src=" . base_url('node_modules/adminbsb-materialdesign/js/admin.js') . "></script>" : null; ?>
<?= isset($sign_in) ? "<script src=" . base_url('node_modules/adminbsb-materialdesign/js/pages/examples/sign-in.js') . "></script>" : null; ?>
<?= isset($angular) ? "<script src=" . base_url('node_modules/angular/angular.js') . "></script>" : null; ?>
<?= isset($myjs) ? "<script src=" . base_url('assets/my/myscript.js') . "></script>" : null; ?>
</html>