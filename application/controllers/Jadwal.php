<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal extends MY_Controller {

	public $data = array(
		'breadcrumb' => 'Jadwal',
		'pesan' => '',
		'subtitle' => '',
		'main_view' => 'viewJadwal',
		);
	
	public function __construct(){
		parent::__construct();
        $this->load->model('Jadwal_model','jadwal',TRUE);
        $this->load->model('Ruang_model','ruang',TRUE);
        $this->load->model('Prodi_model','prodi',TRUE);
	}

	public function index(){
        $this->data['prodi'] = $this->prodi->get_datatables();
        $this->data['thn_ajar'] = $this->jadwal->get_thn_ajar();
        $this->data['ruang'] = $this->ruang->get_datatables();
		$this->load->view('template',$this->data);
	}
	public function ajax_list()
    {
        $thnajar = $this->input->get('thnajar');
        $list = $this->jadwal->get_datatables($thnajar);
        $data = array();
        // $no = $_POST['start'];
        foreach ($list as $jadwal) {
            // $no++;
            $row = array(
                "id_jadwal" => $jadwal['id_jadwal'],
            	"thn_ajar" => $jadwal['thn_ajar'],
                "kd_kuliah" => $jadwal['kd_kuliah'],
            	"nama_kuliah" => $jadwal['nama_kuliah'],
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
                        "recordsTotal" => $this->jadwal->count_all(),
                        "recordsFiltered" => $this->jadwal->count_filtered($thnajar),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
    
 
    public function ajax_edit($id)
    {
        $data = $this->jadwal->get_by_id($id);
        echo json_encode($data);
    }
    
    public function ajax_add($thnajar,$id_kelas,$id_ruang,$hari,$jam)
    {
        $data = array(
                'thn_ajar' => $thnajar,
                'id_kelas' => $id_kelas,
                'id_ruang' => $id_ruang,
                'hari' => $hari,
                'jam' => $jam
            );
        $insert = $this->jadwal->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
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
        $this->jadwal->update($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->jadwal->delete_by_id($id);
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