<table width="100%" border="0" align="left">
  <form name="form1" method="post" action="<?php echo base_url().'index.php/pembelajaran/index'; ?>">
  <tr valign="top">
    <td height="179" colspan="2">
	
	<?php
	if ($gejala->num_rows() > 0){
	   foreach ($gejala->result_array() as $row)
	   {
		  echo '<input name="gejala[]" type="checkbox" value="'.$row['kd_gejala'].'">'.$row['nm_gejala'].'<br/>';
	   }
	} 
	?>	
	<br/>
	Banyak Iterasi <input type="text" name="jum_iterasi" value="1000" />
	<input type="hidden" name="diagnosa" value="true" />
    </td>
  </tr>
  <tr valign="top">
    <td colspan="2">
    <div align="right">
		<input name="status" type="submit"value="Diagnosa"/>
	</div>	</td>
  </tr>
  </form>
  <tr valign="top">
    <td width="21%"><p>Hasil Diagnosa</p>
    <p>
    <?php
    $diagnosa = "";
    if(isset($hasil)){
	foreach($hasil as $row){
		$diagnosa =  $row['penyakit']['nm_penyakit'];
	}
    }
    ?>
      <input type="text" name="diagnosa" value="<?php echo ($diagnosa!="")?$diagnosa:""; ?>" />
</p>
    <p>Prosentasi Kebenaran</p>
    <p>
      <input type="text" name="presentase" value="<?php echo isset($error)?number_format((100-$error),6):""; ?>" />
      Error: <?php echo substr($error_control,2,8); ?>
      <?php
	if(isset($error)){
		echo '<br/>Error Learning: '.number_format($error,6);
	}
      ?>
</p></td>
    <td width="79%"><p>Penyebab</p>
    <p>
    <textarea name="penyebab" cols="100" rows="8">
    <?php 
    if(isset($hasil)){
	foreach($hasil as $row){
		echo $row['penyebab']['nm_penyebab'];
	}
    }
    ?>
    </textarea>
    </p>
    <p>Solusi</p>
    <p>
    <textarea name="solusi" cols="100" rows="8">
    <?php 
    if(isset($hasil)){
	foreach($hasil as $row){
		echo $row['solusi']['nm_solusi'];
	}
    }
    ?>
    </textarea>
    </p>
    </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
