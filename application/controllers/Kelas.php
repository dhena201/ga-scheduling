<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends CI_Controller {

	public $data = array(
		'breadcrumb' => 'Kelas',
		'pesan' => '',
		'subtitle' => '',
		'main_view' => 'viewKelas',
		);
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Kelas_model','kelas',TRUE);
	}

	public function index(){

		$kelas = $this->kelas->select_all();
		if($kelas){
			$this->data['kelas'] = $kelas;
		}else{
			$this->data['error'] = $this->kelas->db->error();
		}
		$this->load->view('template',$this->data);
	}
}
?>