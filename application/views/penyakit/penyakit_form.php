<?php
echo!empty($h2_title) ? '<h2>' . $h2_title . '</h2>' : '';
echo!empty($message) ? '<p class="message">' . $message . '</p>' : '';

$flashmessage = $this->session->flashdata('message');
echo!empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>' : '';
?>

<form name="penyakit_form" method="post" action="<?php echo $form_action; ?>">
    <p>
        <label for="kd_penyakit">Kode Penyakit:</label>
        <input type="text" class="form_field" name="kd_penyakit" size="30" value="<?php echo set_value('kd_penyakit', isset($default['kd_penyakit']) ? $default['kd_penyakit'] : ''); ?>" />
    </p>
    <?php echo form_error('kd_penyakit', '<p class="field_error">', '</p>'); ?>

    <p>
        <label for="nama_penyakit">Nama Penyakit:</label>
        <input type="text" class="form_field" name="nama_penyakit" size="30" value="<?php echo set_value('nama_penyakit', isset($default['nama_penyakit']) ? $default['nama_penyakit'] : ''); ?>" />

    </p>
    <?php echo form_error('nama_penyakit', '<p class="field_error">', '</p>'); ?>	

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