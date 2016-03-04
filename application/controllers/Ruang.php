<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruang extends CI_Controller {

	public $data = array(
		'breadcrumb' => 'Ruang',
		'pesan' => '',
		'subtitle' => '',
		'main_view' => 'viewRuang',
		);
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Ruang_model','ruang',TRUE);
	}

	public function index(){

		$ruang = $this->ruang->select_all();
		if($ruang){
			$this->data['ruang'] = $ruang;
		}else{
			$this->data['error'] = $this->ruang->db->error();
		}
		$this->load->view('template',$this->data);
	}
}
?>