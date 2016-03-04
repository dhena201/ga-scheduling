<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas_model extends CI_Model {

	public $db_tabel = 'kelas';
	public function __construct(){
		parent::__construct();
	}

	public function select_all(){
		$sql = 'select kelas.id_kelas,kelas.kapasitas,mata_kuliah.nama_kuliah,prodi.nama_prodi,dosen.nama_dosen from kelas join mata_kuliah on kelas.id_kuliah = mata_kuliah.id_kuliah join prodi on mata_kuliah.id_prodi = prodi.id_prodi join dosen on kelas.id_dosen = dosen.id_dosen order by prodi.nama_prodi,mata_kuliah.nama_kuliah';
		$data = $this->db->query($sql);
		return $data->result_array();
	}
}
?>