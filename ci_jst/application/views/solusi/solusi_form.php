<?php
echo!empty($h2_title) ? '<h2>' . $h2_title . '</h2>' : '';
echo!empty($message) ? '<p class="message">' . $message . '</p>' : '';

$flashmessage = $this->session->flashdata('message');
echo!empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>' : '';
?>

<form name="solusi_form" method="post" action="<?php echo $form_action; ?>">
    <p>
        <label for="kd_solusi">Kode Solusi:</label>
        <input type="text" class="form_field" name="kd_solusi" size="30" value="<?php echo set_value('kd_solusi', isset($default['kd_solusi']) ? $default['kd_solusi'] : ''); ?>" />
    </p>
    <?php echo form_error('kd_solusi', '<p class="field_error">', '</p>'); ?>

    <p>
        <label for="nm_solusi">Solusi:</label>
        <textarea class="form_field" name="nm_solusi"><?php echo set_value('nm_solusi', isset($default['nm_solusi']) ? $default['nm_solusi'] : ''); ?></textarea>

    </p>
    <?php echo form_error('nm_solusi', '<p class="field_error">', '</p>'); ?>

    <p>
        <input type="submit" name="submit" id="submit" value=" Simpan " />
    </p>
</form>

<?php
if (!empty($link)) {
    echo '<p id="bottom_link">';
    foreach ($link as $links) {
        echo $links . ' ';
    }
    echo '</p>';
}
?>