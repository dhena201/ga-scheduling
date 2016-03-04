<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Program_studi extends CI_Controller {

	public $data = array(
		'breadcrumb' => 'Program Studi',
		'pesan' => '',
		'subtitle' => '',
		'main_view' => 'viewProdi',
		);
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Prodi_model','prodi',TRUE);
	}

	public function index(){

		$prodi = $this->prodi->select_all();
		if($prodi){
			$this->data['prodi'] = $prodi;
		}else{
			$this->data['error'] = $this->prodi->db->error();
		}
		$this->load->view('template',$this->data);
	}
}
?>