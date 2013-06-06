<?php
class Pembelajaran extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
	
	public function index(){
		if(!empty($_POST['gejala'])){
			error_reporting(E_ERROR);
			$this->load->library('neuralnetwork');
			
			$baca = $this->bacadata($_POST['gejala']);
			$target = $this->bacatarget($_POST['gejala']);
			$jumlah_iterasi = $_POST['jum_iterasi'];
			$this->neuralnetwork->NeuralNetwork($this->jumlahInput(), $this->jumlahhidden(), $this->jumlahhidden());
			//$target = array(1);
			
			if($_POST['status']=='Pembelajaran'){
			
			
			$this->neuralnetwork->addTestData($baca, $target);
			
			$this->neuralnetwork->setVerbose(false);
			$max = 3;
			
			while (!($success=$this->neuralnetwork->train($jumlah_iterasi, 0.01)) && $max-->0) {
				$this->neuralnetwork->initWeights();
			}
			
			if ($success) {
				$this->neuralnetwork->save("save.txt");
				$data['epochs'] = $this->neuralnetwork->getEpoch();
				$data['error'] = $this->neuralnetwork->getErrorTrainingSet();
				$data['hasil'] = $this->bacaOutput($target);
				
			}
			}else{
				$save_data = $this->loadFromDatabase();
				$this->neuralnetwork->matchLoad($save_data);
				$data['diagnosa'] = $this->neuralnetwork->calculate($baca);
				$data['hasil'] = $this->bacaOutput($target);
			}
			
		}
		
		/*Set default data*/
		$save_data = $this->loadFromDatabase();
		$data['error_control'] = $save_data['error'];
		/*Set default data*/
		
		$data['gejala'] = $this->db->get('gejala');
		$data['h2_title'] = 'Pembelajaran';
		$data['main_view'] = 'pembelajaran/index';
		$this->load->view('template', $data);
	}
	
	public function jumlahInput(){
		$gejala = $this->db->query('SELECT count(*) as jumlah FROM gejala');
		if ($gejala->num_rows() > 0){
		   foreach ($gejala->result_array() as $row)
		   {
			$hasil =  $row['jumlah'];
		   }
		} 
		return $hasil;
	}
	
	public function jumlahhidden(){
		$gejala = $this->db->query('SELECT count(*) as jumlah FROM penyakit');
		if ($gejala->num_rows() > 0){
		   foreach ($gejala->result_array() as $row)
		   {
			$hasil =  $row['jumlah'];
		   }
		} 
		return $hasil;
	}
	
	public function bacadata($in_array){
		$list = "";
		if(count($in_array)>0){
			for($i = 0; $i<count($in_array);$i++){
				$list.="'".$in_array[$i]."'";
				if($i<(count($in_array)-1)){
				$list.=",";	
				}
			}
		}
		$penyakit = $this->db->query('SELECT kd_gejala FROM gejala');
		if ($penyakit->num_rows() > 0){
			$i = 0;
			foreach ($penyakit->result_array() as $row){
				$gejala = $this->db->query('SELECT * FROM `gejala` WHERE `kd_gejala` = \''.$row['kd_gejala'].'\' AND `kd_gejala` IN ('.$list.')');
				if ($gejala->num_rows() > 0){
					$hasil[$i] = 1;
				}else{
					$hasil[$i] = 0;
				}
				$i++;
			}
		}
		return $hasil;
	}
	
	public function bacatarget($in_array){
		$list = "";
		if(count($in_array)>0){
			for($i = 0; $i<count($in_array);$i++){
				$list.="'".$in_array[$i]."'";
				if($i<(count($in_array)-1)){
				$list.=",";	
				}
			}
		}
		$penyakit = $this->db->query('SELECT kd_penyakit FROM penyakit');
		if ($penyakit->num_rows() > 0){
			$find = false;
			$i = 1;
			$max = 0;
			$posisi = 0;
			
			foreach ($penyakit->result_array() as $row){
				$gejala = $this->db->query('SELECT * FROM `gejala_penyakit` WHERE `kd_penyakit` = \''.$row['kd_penyakit'].'\' AND `kd_gejala` IN ('.$list.')');
				if ( ($gejala->num_rows() > 0) && ($gejala->num_rows()>$max) ){
					//set 0 awal
					if($find==true){
						$hasil[$posisi] = 0;
					}
				
					$max = $gejala->num_rows();
					$hasil[$i] = 1;
					$posisi = $i;
					$find = true;
				}else{
					$hasil[$i] = 0;
				}
				$i++;
			}
			return $hasil;
		}

		
	}
	
	public function bacaOutput($in_array){
		$hasil = array();
		$i = 0;
		foreach($in_array as $row){
			if($in_array[$i]==1){
				$penyakit = $this->db->query('SELECT * FROM `penyakit` LIMIT '.($i-1).',1');
				if ($penyakit->num_rows() > 0){
					foreach ($penyakit->result_array() as $row){
						$hasil[$i]['penyakit'] = $row;
					}
				}
				
				
				$penyebab = $this->db->query('SELECT * FROM `penyebab`,`penyebab_penyakit`  WHERE `kd_penyakit` = \''.$hasil[$i]['penyakit']['kd_penyakit'].'\' AND `penyebab`.`kd_penyebab` = `penyebab_penyakit`.`kd_penyebab` ');
				if ($penyebab->num_rows() > 0){
					foreach ($penyebab->result_array() as $row){
						$hasil[$i]['penyebab'] = $row;
					}
				}
				
				
				$solusi = $this->db->query('SELECT * FROM `solusi`,`solusi_penyakit`  WHERE `kd_penyakit` = \''.$hasil[$i]['penyakit']['kd_penyakit'].'\' AND `solusi`.`kd_solusi` = `solusi_penyakit`.`kd_solusi` ');
				if ($solusi->num_rows() > 0){
					foreach ($solusi->result_array() as $row){
						$hasil[$i]['solusi'] = $row;
					}
				}
			}
			$i++;
			
		}
		
		return $hasil;
	}
	
	public function getRowPenyakit($posisi){
		$p = $this->db->get('penyakit', 1, ($posisi-1));
		foreach ($p->result_array() as $row){
			$ketemu = $row['kd_penyakit'];
		}
		return $ketemu;
	}
	
	
	
	
	public function simpan(){
		$learning = parse_ini_file("save.txt");
		$data = array(
		   'tanggal' => date('Y-m-d h:i:s') ,
		   'edges' => $learning['edges'],
		   'thresholds' => $learning['thresholds'],
		   'training_data' => $learning['training_data'],
		   'control_data' => $learning['control_data'],
		   'error' => $learning['error'],
		);

		$this->db->insert('pembelajaran', $data); 
	}
	
	
	function loadFromDatabase() {
		$gejala = $this->db->query("select * from pembelajaran order by tanggal DESC LIMIT 0,1");
		if ($gejala->num_rows() > 0){
		   foreach ($gejala->result_array() as $row)
		   {
			$data =  $row;
		   }
		} 
		return $data;
	}
}

?>