<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal_model extends CI_Model {

	var $table = 'jadwal';
    var $column = array('nama_kuliah','nama_dosen','nama_prodi','kelas','kapasitas','nama_ruang','hari','jam'); //set column field database for order and search
    var $order = array('nama_prodi' => 'desc'); // default order
	public function __construct(){
		parent::__construct();
	}

	private function _get_datatables_query(){
        $this->db->select('*');
        $this->db->select("DATE_FORMAT(jam,'%H:%i') as jam");
        $this->db->from($this->table);
        $this->db->join('kelas','jadwal.id_kelas=kelas.id_kelas');
        $this->db->join('mata_kuliah','kelas.id_kuliah=mata_kuliah.id_kuliah');
        $this->db->join('dosen','kelas.id_dosen=dosen.id_dosen');
 		$this->db->join('prodi','prodi.id_prodi=mata_kuliah.id_prodi');
        $this->db->join('ruang','jadwal.id_ruang=ruang.id_ruang');
        $i = 0;
     
        foreach ($this->column as $item) // loop column
        {
            if(isset($_POST['search']['value'])) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $column[$i] = $item; // set column array variable to order processing
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
     
    function get_datatables($thn_ajar){
    	$this->_get_datatables_query($thn_ajar);  
        if(isset($_POST['length']) and $_POST['length']!= -1){
            $this->db->limit($_POST['length'], $_POST['start']); 
        }
        $this->db->where('thn_ajar',$thn_ajar);	
        $query = $this->db->get();
        return $query->result_array();
    }
 
    function count_filtered(){
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all(){
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
 
    public function get_by_id($id){
        $this->_get_datatables_query();
        $this->db->where('id_jadwal',$id);
        $query = $this->db->get();
 
        return $query->row();
    }
    public function get_thn_ajar(){
        $this->db->from($this->table);
        $this->db->select('thn_ajar');
        $query = $this->db->get();
 
        return $query->result_array();
    }
 
    public function save($data){
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
 
    public function update($data){
    	$this->db->where('id_jadwal',$data['id_jadwal']);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }
 
    public function delete_by_id($id){
        $this->db->where('id_jadwal', $id);
        $this->db->delete($this->table);
    }
}
?>