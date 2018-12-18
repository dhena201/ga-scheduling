<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Individual.php');  //supporting individual 
require_once('Population.php');  //supporting population 
require_once('Fitness.php');    //supporting fitnesscalc 
require_once('Algorithm.php');  //supporting fitnesscalc 

class Buat_jadwal extends MY_Controller {

	public $data = array(
		'breadcrumb' => 'Buat Jadwal',
		'pesan' => '',
		'subtitle' => '',
		'main_view' => 'viewGa',
		);
	
	public function __construct(){
		parent::__construct();
        $this->load->model('Jadwal_model','jadwal',TRUE);
        $this->load->model('Kelas_model','kelas',TRUE);
        $this->load->model('Ruang_model','ruang',TRUE);
        $this->load->model('Prodi_model','prodi',TRUE);
	}

	public function index(){
        $this->data['thn_ajar'] = $this->jadwal->get_thn_ajar();
        $this->data['ruang'] = $this->ruang->get_datatables();
        $this->data['prodi'] = $this->prodi->get_datatables();
        $this->data['datakelas'] = $this->kelas->get_datatables();
		$this->load->view('template',$this->data);
	}

	public function ajax_listtmp()
    {
        $thnajar = $this->input->post('thnajar');
        $list = $this->jadwal->get_datatablestmp($thnajar);
        $data = array();
        // $no = $_POST['start'];
        foreach ($list as $jadwal) {
            // $no++;
            $row = array(
                "id_jadwal" => $jadwal['id_jadwal'],
                "thn_ajar" => $jadwal['thn_ajar'],
                "nama_kuliah" => $jadwal['nama_kuliah'],
                "kd_kuliah" => $jadwal['kd_kuliah'],
                "nama_dosen" => $jadwal['nama_dosen'],
                "nama_prodi" => $jadwal['nama_prodi'],
                "kelas" => $jadwal['kelas'],
                "kapasitas" => $jadwal['kapasitas'],
                "nama_ruang" => $jadwal['nama_ruang'],
                "hari" => $jadwal['hari'],
                "jam" => $jadwal['jam']
                );

                     
            $data[] = $row;
        }
 
        $output = array(
                        // "draw" => $_POST['draw'],
                        "recordsTotal" => $this->jadwal->count_alltmp(),
                        "recordsFiltered" => $this->jadwal->count_filteredtmp($thnajar),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
    public function ajax_savetmp($thnajar){
        $list = $this->jadwal->get_datatablestmp($thnajar);
        $data = array();
        // $no = $_POST['start'];
        foreach ($list as $jadwal) {
            // $no++;
            $row = array(
                "id_jadwal" => "",
                "thn_ajar" => $jadwal['thn_ajar'],
                "id_kuliah" => $jadwal['id_kuliah'],
                "id_dosen" => $jadwal['id_dosen'],
                "kelas" => $jadwal['kelas'],
                "kapasitas" => $jadwal['kapasitas'],
                "id_ruang" => $jadwal['id_ruang'],
                "hari" => $jadwal['hari'],
                "jam" => $jadwal['jam']
                );

                     
            $data[] = $row;
        }
        $this->jadwal->save_batch($data,$thnajar);
        echo json_encode(array("status" => TRUE));

    }
    public function ajax_edittmp($id)
    {
        $data = $this->jadwal->get_by_idtmp($id);
        echo json_encode($data);
    }
    public function ajax_updatetmp()
    {
        $this->_validate();
        $data = array(
                'id_jadwal' => $this->input->post('id'),
                'thn_ajar' => $this->input->post('thnajar'),
                'id_kelas' => $this->input->post('id_kelas'),
                'id_ruang' => $this->input->post('ruang'),
                'hari' => $this->input->post('hari'),
                'jam' => $this->input->post('jam')
            );
        $this->jadwal->updatetmp($data);
        echo json_encode(array("status" => TRUE));
    }
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('id_kelas') == '')
        {
            $data['inputerror'][] = 'id_kuliah';
            $data['error_string'][] = 'Mata Kuliah Belum Dipilih';
            $data['status'] = FALSE;
        }
        if($this->input->post('jam') == '')
        {
            $data['inputerror'][] = 'jam';
            $data['error_string'][] = 'Jam Kuliah Belum Diisi';
            $data['status'] = FALSE;
        }
 
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
 
}
?>