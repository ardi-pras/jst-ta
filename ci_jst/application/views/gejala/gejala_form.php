<?php
echo!empty($h2_title) ? '<h2>' . $h2_title . '</h2>' : '';
echo!empty($message) ? '<p class="message">' . $message . '</p>' : '';

$flashmessage = $this->session->flashdata('message');
echo!empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>' : '';
?>

<form name="penyakit_form" method="post" action="<?php echo $form_action; ?>">
    <p>
        <label for="kd_gejala">Kode Gejala:</label>
        <input type="text" class="form_field" name="kd_gejala" size="30" value="<?php echo set_value('kd_gejala', isset($default['kd_gejala']) ? $default['kd_gejala'] : ''); ?>" />
    </p>
    <?php echo form_error('kd_gejala', '<p class="field_error">', '</p>'); ?>

    <p>
        <label for="nama_gejala">Nama Gejala:</label>
        <input type="text" class="form_field" name="nama_gejala" size="30" value="<?php echo set_value('nama_gejala', isset($default['nama_gejala']) ? $default['nama_gejala'] : ''); ?>" />

    </p>
    <?php echo form_error('nama_gejala', '<p class="field_error">', '</p>'); ?>

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