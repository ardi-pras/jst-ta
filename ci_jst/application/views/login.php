<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="<?php echo base_url() . 'images/fav_icon.png'; ?>" />
        <style type="text/css">@import url("<?php echo base_url() . 'css/reset.css'; ?>");</style>
        <style type="text/css">@import url("<?php echo base_url() . 'css/login.css'; ?>");</style>
        <title>Login</title>
    </head>
    <body>
        <div id="login_box">

            <h1>login admin</h1>

            <?php
            $attributes = array('name' => 'login_form', 'id' => 'login_form');
            echo form_open('#', $attributes);
            ?>

            <?php
            $message = $this->session->flashdata('message');
            echo $message == '' ? '' : '<p id="message">' . $message . '</p>';
            ?>

            <p>
                <label for="username">Username:</label>
                <input type="text" name="username" size="20" class="form_field" value="<?php echo set_value('username'); ?>"/>			
            </p>
            <?php echo form_error('username', '<p class="field_error">', '</p>'); ?>

            <p>
                <label for="password">Password:</label>
                <input type="password" name="password" size="20" class="form_field" value="<?php echo set_value('password'); ?>"/>			
            </p>
            <?php echo form_error('password', '<p class="field_error">', '</p>'); ?>

            <p>
                <input type="submit" name="submit" id="submit" value="Login" />
            </p>
            <?php echo form_close(); ?>
        </div>
    </body>
</html>
