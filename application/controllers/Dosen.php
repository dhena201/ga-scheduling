<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen extends MY_Controller {

	public $data = array(
		'breadcrumb' => 'Dosen',
		'pesan' => '',
		'subtitle' => '',
		'main_view' => 'viewDosen',
		);
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Dosen_model','dosen',TRUE);
		$this->load->model('Prodi_model','prodi',TRUE);
	}

	public function index(){
		$this->data['prodi'] = $this->prodi->get_datatables();
		$this->load->view('template',$this->data);
	}
	public function ajax_list()
    {
        $list = $this->dosen->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dosen) {
            $no++;
            $row = array(
            	"id_dosen" => $dosen['id_dosen'],
            	"nama_dosen" => $dosen['nama_dosen'],
            	"nama_prodi" => $dosen['nama_prodi']
            	);

                     
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->dosen->count_all(),
                        "recordsFiltered" => $this->dosen->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->dosen->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'id_dosen' => $this->input->post('id'),
                'nama_dosen' => $this->input->post('nama_dosen'),
                'id_prodi' => $this->input->post('id_prodi')
            );
        $insert = $this->dosen->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'id_dosen' => $this->input->post('id'),
                'nama_dosen' => $this->input->post('nama_dosen'),
                'id_prodi' => $this->input->post('id_prodi')
            );
        $this->dosen->update($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->dosen->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('nama_dosen') == '')
        {
            $data['inputerror'][] = 'nama_dosen';
            $data['error_string'][] = 'Nama Dosen Belum Diisi';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('id_prodi') == '')
        {
            $data['inputerror'][] = 'id_prodi';
            $data['error_string'][] = 'Program Studi Belum Dipilih';
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