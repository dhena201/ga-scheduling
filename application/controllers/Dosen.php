<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen extends CI_Controller {

	public $data = array(
		'breadcrumb' => 'Dosen',
		'pesan' => '',
		'subtitle' => '',
		'main_view' => 'viewDosen',
		);
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Dosen_model','dosen',TRUE);
	}

	public function index(){

		$dosen = $this->dosen->select_all();
		if($dosen){
			$this->data['dosen'] = $dosen;
		}else{
			$this->data['error'] = $this->dosen->db->error();
		}
		$this->load->view('template',$this->data);
	}
}
?>