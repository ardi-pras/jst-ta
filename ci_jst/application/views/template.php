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
        <div id="masthead">
            <?php $this->load->view('masthead'); ?>
        </div>

        <div id="navigation">
            <?php $this->load->view('navigation'); ?>
        </div>

        <div id="main">
            <?php $this->load->view($main_view); ?>
        </div>

        <div id="footer">
            <?php $this->load->view('footer'); ?>
        </div>
    </body>
</html>
