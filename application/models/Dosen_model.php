<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen_model extends CI_Model {

	public $db_tabel = 'dosen';
	public $db_fk = 'prodi';
	public function __construct(){
		parent::__construct();
	}

	public function select_all(){
		$sql = 'select dosen.nama_dosen,dosen.id_dosen,prodi.nama_prodi from dosen join prodi on dosen.id_prodi = prodi.id_prodi order by prodi.nama_prodi,dosen.nama_dosen';
		$data = $this->db->query($sql);
		return $data->result_array();
	}
}
?>