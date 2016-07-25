<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends MY_Controller {

	public $data = array(
		'breadcrumb' => 'Kelas',
		'pesan' => '',
		'subtitle' => '',
		'main_view' => 'viewKelas',
		);
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Kelas_model','kelas',TRUE);
		$this->load->model('Prodi_model','prodi',TRUE);
	}

	public function index(){
		$this->data['prodi'] = $this->prodi->get_datatables();
		$this->load->view('template',$this->data);
	}
	public function ajax_list()
    {
        $list = $this->kelas->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $kelas) {
            $no++;
            $row = array(
            	"id_kelas" => $kelas['id_kelas'],
                "kd_kuliah" => $kelas['kd_kuliah'],
            	"nama_kuliah" => $kelas['nama_kuliah'],
            	"nama_dosen" => $kelas['nama_dosen'],
            	"nama_prodi" => $kelas['nama_prodi'],
                "kelas" => $kelas['kelas'],
            	"kapasitas" => $kelas['kapasitas']
            	);

                     
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->kelas->count_all(),
                        "recordsFiltered" => $this->kelas->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->kelas->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'id_kelas' => $this->input->post('id'),
                'id_kuliah' => $this->input->post('id_kuliah'),
                'id_dosen' => $this->input->post('id_dosen'),
                'kelas' => $this->input->post('kelas'),
                'kapasitas' => $this->input->post('kapasitas')
            );
        $insert = $this->kelas->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'id_kelas' => $this->input->post('id'),
                'id_kuliah' => $this->input->post('id_kuliah'),
                'id_dosen' => $this->input->post('id_dosen'),
                'kelas' => $this->input->post('kelas'),
                'kapasitas' => $this->input->post('kapasitas')
            );
        $this->kelas->update($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->kelas->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
 	public function ajax_get_mk($id){
        $this->load->model('Mata_kuliah_model','matkul',TRUE);
 		$data=$this->matkul->get_by_prodi($id);
 		$this->output->set_content_type("application/json")->set_output(json_encode($data));
 	}

    public function ajax_get_dosen($id){
        $this->load->model('Dosen_model','dosen',TRUE);
        $data=$this->dosen->get_by_prodi($id);
        $this->output->set_content_type("application/json")->set_output(json_encode($data));
    }
    public function ajax_get_kelas($id){
        $char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $index=$this->kelas->count_by_mk($id);
        $data = $char[$index];
        $this->output->set_content_type("application/json")->set_output(json_encode($data));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('id_kuliah') == '')
        {
            $data['inputerror'][] = 'id_kuliah';
            $data['error_string'][] = 'Mata Kuliah Belum Dipilih';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('id_dosen') == '')
        {
            $data['inputerror'][] = 'id_dosen';
            $data['error_string'][] = 'Dosen Belum Dipilih';
            $data['status'] = FALSE;
        }
        if($this->input->post('kapasitas') == '')
        {
            $data['inputerror'][] = 'kapasitas';
            $data['error_string'][] = 'Kapasitas Belum Diisi';
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