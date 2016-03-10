<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prodi_model extends CI_Model {

	var $table = 'prodi';
    var $column = array('id_prodi','nama_prodi'); //set column field database for order and search
    var $order = array('id_prodi' => 'asc'); // default order
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	private function _get_datatables_query(){
         
        $this->db->from($this->table);
 
        $i = 0;
     
        foreach ($this->column as $item) // loop column
        {
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
	function get_datatables(){
        $this->_get_datatables_query();
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
        $this->db->from($this->table);
        $this->db->where('id_prodi',$id);
        $query = $this->db->get();
 
        return $query->row();
    }
 
    public function save($data){
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
 
    public function update($data){
    	$this->db->where('id_prodi',$data['id_prodi']);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }
 
    public function delete_by_id($id){
        $this->db->where('id_prodi', $id);
        $this->db->delete($this->table);
    }
}
?>