<?php
echo!empty($h2_title) ? '<h2>' . $h2_title . '</h2>' : '';
echo!empty($message) ? '<p class="message">' . $message . '</p>' : '';

$flashmessage = $this->session->flashdata('message');
echo!empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>' : '';
?>

<form name="penyebab_form" method="post" action="<?php echo $form_action; ?>">
    <p>
        <label for="kd_penyebab">Kode Penyebab:</label>
        <input type="text" class="form_field" name="kd_penyebab" size="30" value="<?php echo set_value('kd_penyebab', isset($default['kd_penyebab']) ? $default['kd_penyebab'] : ''); ?>" />
    </p>
    <?php echo form_error('kd_penyebab', '<p class="field_error">', '</p>'); ?>

    <p>
        <label for="nm_penyebab">Nama Penyebab:</label>
        <input type="text" class="form_field" name="nm_penyebab" size="30" value="<?php echo set_value('nm_penyebab', isset($default['nm_penyebab']) ? $default['nm_penyebab'] : ''); ?>" />

    </p>
    <?php echo form_error('nm_penyebab', '<p class="field_error">', '</p>'); ?>

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