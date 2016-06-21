<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
		parent::__construct();
		$this->load->model('Dosen_model','dosen',TRUE);
		$this->load->model('Prodi_model','prodi',TRUE);
		$this->load->model('Mata_kuliah_model','matkul',TRUE);
		$this->load->model('Ruang_model','ruang',TRUE);
		$this->load->model('Kelas_model','kelas',TRUE);
		$this->load->model('Users_model','user',TRUE);
		$this->load->model('Jadwal_model','jadwal',TRUE);
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
	}

	public function index(){
		$this->data['breadcrumb'] = 'Dashboard';
		$this->data['subtitle'] = '';
		$this->data['main_view'] = 'dashboard';
		$this->data['thn_ajar'] = $this->jadwal->get_thn_ajar();
		$this->data['count_dosen'] = $this->dosen->count_all();
		$this->data['count_matkul'] = $this->matkul->count_all();
		$this->data['count_prodi'] = $this->prodi->count_all();
		$this->data['count_ruang'] = $this->ruang->count_all();
		$this->data['count_kelas'] = $this->kelas->count_all();
		$this->data['count_user'] = $this->user->count_filtered();
		$this->data['count_jadwal'] = $this->jadwal->count();
		$this->data['ruang'] = $this->ruang->get_datatables();
		$this->load->view('template',$this->data);
	}
}
?>