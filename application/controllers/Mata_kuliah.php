<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mata_kuliah extends CI_Controller {

	public $data = array(
		'breadcrumb' => 'Mata Kuliah',
		'pesan' => '',
		'subtitle' => '',
		'main_view' => 'viewMatkul',
		);
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Mata_kuliah_model','matkul',TRUE);
	}

	public function index(){

		$matakuliah = $this->matkul->select_all();
		if($matakuliah){
			$this->data['matakuliah'] = $matakuliah;
		}else{
			$this->data['error'] = $this->matkul->db->error();
		}
		$this->load->view('template',$this->data);
	}
}
?>