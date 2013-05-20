<ul id="menu_tab">	
    <li id="tab_penyakit"><?php echo anchor('welcome', 'penyakit'); ?></li>
    <li id="tab_gejala"><?php echo anchor('gejala', 'gejala'); ?></li>
    <li id="tab_penyebab"><?php echo anchor('penyebab', 'penyebab'); ?></li>
    <li id="tab_solusi"><?php echo anchor('solusi', 'solusi'); ?></li>
    <li id="tab_penyakit_gejala"><?php echo anchor('penyakit_gejala', 'penyakit dan gejala'); ?></li>
    <li id="tab_penyakit_penyebab"><?php echo anchor('penyakit_penyebab', 'penyakit dan penyebab'); ?></li>
    <li id="tab_penyakit_solusi"><?php echo anchor('penyakit_solusi', 'penyakit dan solusi'); ?></li>
    <li id="tab_logout"><?php echo anchor('', 'logout', array('onclick' => "return confirm('Anda yakin akan logout?')")); ?></li>
</ul>