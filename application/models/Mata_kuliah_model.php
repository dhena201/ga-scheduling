<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mata_kuliah_model extends CI_Model {

	public $db_tabel = 'matak_kuliah';
	public function __construct(){
		parent::__construct();
	}

	public function select_all(){
		$sql = 'select mata_kuliah.*,prodi.nama_prodi from mata_kuliah join prodi on mata_kuliah.id_prodi = prodi.id_prodi order by prodi.nama_prodi,mata_kuliah.nama_kuliah';
		$data = $this->db->query($sql);
		return $data->result_array();
	}
}
?>