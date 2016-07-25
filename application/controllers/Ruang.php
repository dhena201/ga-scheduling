<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruang extends MY_Controller {

	public $data = array(
		'breadcrumb' => 'Ruang',
		'pesan' => '',
		'subtitle' => '',
		'main_view' => 'viewRuang',
		);
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Ruang_model','ruang',TRUE);
	}

	public function index(){
		$this->load->view('template',$this->data);
	}
	public function ajax_list()
    {
        $list = $this->ruang->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ruang) {
            $no++;
            $row = array(
            	"id_ruang" => $ruang['id_ruang'],
            	"kapasitas" => $ruang['kapasitas_ruang'],
            	"nama_ruang" => $ruang['nama_ruang'],
            	);

                     
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->ruang->count_all(),
                        "recordsFiltered" => $this->ruang->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->ruang->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'kapasitas_ruang' => $this->input->post('kapasitas'),
                'nama_ruang' => $this->input->post('nama_ruang'),
            );
        $insert = $this->ruang->save($data);
        echo json_encode(array("status" => TRUE));
    }
    public function ajax_update()
    {
        $this->_validate('update');
        $data = array(
                'id_ruang' => $this->input->post('id'),
                'kapasitas_ruang' => $this->input->post('kapasitas'),
                'nama_ruang' => $this->input->post('nama_ruang'),
            );
        $this->ruang->update($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->ruang->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validate($method=NULL)
    {

        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        if($method!='update'){
            if($ruang = $this->ruang->get_by_name($this->input->post('nama_ruang'))){
                $data['inputerror'][] = 'nama_ruang';
                $data['error_string'][] = 'Ruangan Dengan Nama Diatas Sudah Ada';
                $data['status'] = FALSE;
            }
        }
        if($this->input->post('nama_ruang') == '')
        {
            $data['inputerror'][] = 'nama_ruang';
            $data['error_string'][] = 'Nama Ruangan Belum Diisi';
            $data['status'] = FALSE;
        }
 		if($this->input->post('kapasitas') == '')
        {
            $data['inputerror'][] = 'kapasitas';
            $data['error_string'][] = 'Kapasitas Ruangan Belum Diisi';
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