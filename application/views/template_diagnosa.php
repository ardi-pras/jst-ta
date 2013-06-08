<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="<?php echo 'Tampilan Jaringan Syaraf Tiruan'; ?>" />
        <style type="text/css">@import url("<?php echo base_url() . 'css/reset.css'; ?>");</style>
        <style type="text/css">@import url("<?php echo base_url() . 'css/style.css'; ?>");</style>

        <title><?php echo isset($title) ? $title : ''; ?></title>
    </head>
    <body id="<?php echo isset($title) ? $title : ''; ?>">
        <div id="main">
            <?php $this->load->view($main_view); ?>
        </div>

        <div id="footer">
            <?php $this->load->view('footer'); ?>
        </div>
	<center><a href="<?php echo base_url().'index.php/login/signin'; ?>">Login Admin</a></center>
    </body>
</html>
