<?php
echo!empty($h2_title) ? '<h2>' . $h2_title . '</h2>' : '';
echo!empty($message) ? '<p class="message">' . $message . '</p>' : '';

$flashmessage = $this->session->flashdata('message');
echo!empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>' : '';
?>

<form name="penyakit_form" method="post" action="<?php echo $form_action; ?>">
    <p>
        <label for="nm_penyakit">Nama Penyakit:</label>
        <input type="text" class="form_field" name="nm_penyakit" size="30" value="<?php echo set_value('nm_penyakit', isset($default['nm_penyakit']) ? $default['nm_penyakit'] : ''); ?>" />
    </p>
    <?php echo form_error('nm_penyakit', '<p class="field_error">', '</p>'); ?>

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