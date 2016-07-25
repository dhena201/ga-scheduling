<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mata_kuliah extends MY_Controller {

	public $data = array(
		'breadcrumb' => 'Mata Kuliah',
		'pesan' => '',
		'subtitle' => '',
		'main_view' => 'viewMatkul',
		);
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Mata_kuliah_model','matkul',TRUE);
		$this->load->model('Prodi_model','prodi',TRUE);
	}

	public function index(){
        $this->data['prodi'] = $this->prodi->get_datatables();
		$this->load->view('template',$this->data);
	}
	public function ajax_list()
    {
        $list = $this->matkul->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $matkul) {
            $no++;
            $row = array(
            'id' => $matkul['id_kuliah'],
            'kd_kuliah' => $matkul['kd_kuliah'],
            'nama_kuliah' => $matkul['nama_kuliah'],
            'sks' => $matkul['sks'],
            'semester' => $matkul['semester'],
            'nama_prodi' => $matkul['nama_prodi']
            	);
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->matkul->count_all(),
                        "recordsFiltered" => $this->matkul->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->matkul->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'id_kuliah' => '',
                'kd_kuliah' => $this->input->post('kd_kuliah'),
                'nama_kuliah' => $this->input->post('nama_kuliah'),
                'sks' => $this->input->post('sks'),
                'semester' => $this->input->post('semester'),
                'id_prodi' => $this->input->post('id_prodi')
            );
        $insert = $this->matkul->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update(){
        $this->_validate();
        $data = array(
	            'id_kuliah' => $this->input->post('id'),
                'kd_kuliah' => $this->input->post('kd_kuliah'),
                'nama_kuliah' => $this->input->post('nama_kuliah'),
                'sks' => $this->input->post('sks'),
                'semester' => $this->input->post('semester'),
                'id_prodi' => $this->input->post('id_prodi')
                );
        $this->matkul->update($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->matkul->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('nama_kuliah') == '')
        {
            $data['inputerror'][] = 'nama_kuliah';
            $data['error_string'][] = 'Nama Mata Kuliah Belum Diisi';
            $data['status'] = FALSE;
        }
        if($this->input->post('sks') == '')
        {
            $data['inputerror'][] = 'sks';
            $data['error_string'][] = 'Jumlah SKS Belum Dipilih';
            $data['status'] = FALSE;
        }
        if($this->input->post('semester') == '')
        {
            $data['inputerror'][] = 'semester';
            $data['error_string'][] = 'Semester Belum Dipilih';
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