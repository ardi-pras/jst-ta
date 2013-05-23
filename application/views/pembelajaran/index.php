<table width="100%" border="0" align="left">
  <form name="form1" method="post" action="">
  <tr valign="top">
    <td height="179" colspan="2">
	
	<?php
	if ($gejala->num_rows() > 0){
	   foreach ($gejala->result_array() as $row)
	   {
		  echo '<input name="gejala[]" type="checkbox" value="'.$row['Kd_Gejala'].'">'.$row['Nama_Gejala'].'<br/>';
	   }
	} 
	?>	
    
    </td>
  </tr>
  <tr valign="top">
    <td colspan="2">Banyak Iterasi <input type="text" name="jum_iterasi" /><input type="button"value="Simpan Bobot"/>
    <div align="right">
		<input name="status" type="submit"value="Belajar baru" />
		<input name="status" type="submit"value="Diagnosa"/>
	</div>	</td>
  </tr>
  </form>
  <tr valign="top">
    <td width="21%"><p>Hasil Diagnosa</p>
    <p>
      <input type="text" name="jum_iterasi2" />
</p>
    <p>Prosentasi Kebenaran</p>
    <p>
      <input type="text" name="jum_iterasi3" />
</p></td>
    <td width="79%"><p>Penyebab</p>
    <p>
      <input type="text" name="jum_iterasi22" />
    </p>
    <p>Solusi</p>
    <p><textarea name="solusi" cols="100" rows="8"></textarea></p></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
