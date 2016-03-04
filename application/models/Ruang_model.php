<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruang_model extends CI_Model {

	public $db_tabel = 'ruang';
	public function __construct(){
		parent::__construct();
	}

	public function select_all(){
		$sql = 'select * from ruang order by nama_ruang';
		$data = $this->db->query($sql);
		return $data->result_array();
	}
}
?>