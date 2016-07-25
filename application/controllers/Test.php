<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Ruang_model','ruang',TRUE);
		$this->load->model('Kelas_model','kelas',TRUE);
	}
	public function index(){
		$list = $this->kelas->get_by_prodi("1");
        $kelas = array();
        foreach ($list as $data) {
        	$nama = $data['nama_kuliah'];
        	$kelas = $data['kelas'];
        	$prodi = $data['nama_prodi'];
        	echo "$nama_kuliah $kelas $prodi<br>";
        }
		echo "test berhasil";
	}
}
?>