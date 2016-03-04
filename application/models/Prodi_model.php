<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prodi_model extends CI_Model {

	public $db_tabel = 'prodi';
	public function __construct(){
		parent::__construct();
	}

	public function select_all(){
		$sql = 'select * from prodi order by prodi.nama_prodi';
		$data = $this->db->query($sql);
		return $data->result_array();
	}
}
?>