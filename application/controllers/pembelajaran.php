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
			print_r($baca);
			echo '<br/>';
			print_r($target);
			
			$this->neuralnetwork->NeuralNetwork($this->jumlahInput(), $this->jumlahhidden(), 1);
			//$this->neuralnetwork->addTestData($baca, 1);
			
			
			//$this->neuralnetwork->NeuralNetwork(3, 4, 1);
			$this->neuralnetwork->addTestData(array (-1, -1, 1), array (-1));
			$this->neuralnetwork->addTestData(array (-1,  1, 1), array ( 1));
			$this->neuralnetwork->addTestData(array ( 1, -1, 1), array ( 1));
			$this->neuralnetwork->addTestData(array ( 1,  1, 1), array (-1));
			$this->neuralnetwork->setVerbose(false);
			$max = 3;
			
			while (!($success=$this->neuralnetwork->train(1000, 0.01)) && $max-->0) {
				$this->neuralnetwork->initWeights();
				//$this->neuralnetwork->load("save.txt");
			}
			if ($success) {
				$this->neuralnetwork->save("save.txt");
				$epochs = $this->neuralnetwork->getEpoch();
				echo 'sukses pada:'.$epochs;
				for ($i = 0; $i < count($this->neuralnetwork->trainInputs); $i ++) {
				$output = $this->neuralnetwork->calculate($this->neuralnetwork->trainInputs[$i]);
				print "<br />Testset $i; ";
				print "expected output = (".implode(", ", $this->neuralnetwork->trainOutput[$i]).") ";
				print "output from neural network = (".implode(", ", $output).")\n";
				Print("error".$this->neuralnetwork->getErrorControlSet());
				Print("<br/>");
				//print_r($n->getWeight());
				print_r($this->neuralnetwork->trainDataID);
				Print("<br/>");
				
}
			}
		}
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
		$penyakit = $this->db->query('SELECT Kd_Gejala FROM gejala');
		if ($penyakit->num_rows() > 0){
			$i = 0;
			foreach ($penyakit->result_array() as $row){
				$gejala = $this->db->query('SELECT * FROM `gejala` WHERE `Kd_Gejala` = \''.$row['Kd_Gejala'].'\' AND `Kd_Gejala` IN ('.$list.')');
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
		$penyakit = $this->db->query('SELECT Kd_Penyakit FROM penyakit');
		if ($penyakit->num_rows() > 0){
			$i = 1;
			$max = 0;
			$posisi = 0;
			
			foreach ($penyakit->result_array() as $row){
				$gejala = $this->db->query('SELECT * FROM `gejala_penyakit` WHERE `Kd_Penyakit` = \''.$row['Kd_Penyakit'].'\' AND `Kd_Gejala` IN ('.$list.')');
				if ( ($gejala->num_rows() > 0) && ($gejala->num_rows()>$max) ){
					$max = $gejala->num_rows();
					$hasil[$i] = 1;
					$posisi = $i;
				}else{
					$hasil[$i] = 0;
				}
				$i++;
			}
			$return[] = $posisi;
			return $return;
		}
		
	}
	
	public function getRowPenyakit($posisi){
		$p = $this->db->get('penyakit', 1, ($posisi-1));
		foreach ($p->result_array() as $row){
			$ketemu = $row['Kd_Penyakit'];
		}
		return $ketemu;
	}
	
}

?>