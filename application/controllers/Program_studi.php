<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Program_studi extends MY_Controller {

	public $data = array(
		'breadcrumb' => 'Program Studi',
		'pesan' => '',
		'subtitle' => '',
		'main_view' => 'viewProdi',
		);
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Prodi_model','prodi',TRUE);
	}

	public function index(){
		$this->load->view('template',$this->data);
	}
	public function ajax_list()
    {
        $list = $this->prodi->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $prodi) {
            $no++;
            $row = array(
            'id' => $prodi['id_prodi'],
            'nama_prodi' => $prodi['nama_prodi']
            	);
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->prodi->count_all(),
                        "recordsFiltered" => $this->prodi->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->prodi->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'id_prodi' => '',
                'nama_prodi' => $this->input->post('nama_prodi'),
            );
        $insert = $this->prodi->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update(){
        $this->_validate('update');
        $data = array(
	                'id_prodi' => $this->input->post('id'),
	                'nama_prodi' => $this->input->post('nama_prodi'),
                );
        $this->prodi->update($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->prodi->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validate($method=NULL)
    {
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($method!='update'){
            if($prodi = $this->prodi->get_by_name($this->input->post('nama_prodi'))){
                $data['inputerror'][] = 'nama_prodi';
                $data['error_string'][] = 'Program Studi Diatas Sudah Ada';
                $data['status'] = FALSE;
            }
        }
 
        if($this->input->post('nama_prodi') == '')
        {
            $data['inputerror'][] = 'nama_prodi';
            $data['error_string'][] = 'Nama Program Studi Belum Diisi';
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