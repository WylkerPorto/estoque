</body>
<script src="<?= base_url('node_modules/adminbsb-materialdesign/plugins/jquery/jquery.js'); ?>"></script>
<script src="<?= base_url('node_modules/adminbsb-materialdesign/plugins/bootstrap/js/bootstrap.js'); ?>"></script>
<?= isset($waves) ? "<script src=" . base_url('node_modules/adminbsb-materialdesign/plugins/node-waves/waves.js') . "></script>" : null; ?>
<?= isset($validation) ? "<script src=" . base_url('node_modules/adminbsb-materialdesign/plugins/jquery-validation/jquery.validate.js') . "></script>" : null; ?>
<?= isset($customjs) ? "<script src=" . base_url('node_modules/adminbsb-materialdesign/js/admin.js') . "></script>" : null; ?>
<?= isset($sign_in) ? "<script src=" . base_url('node_modules/adminbsb-materialdesign/js/pages/examples/sign-in.js') . "></script>" : null; ?>
<?= isset($myjs) ? "<script src=" . base_url('assets/my/myscript.js') . "></script>" : null; ?>
</html>