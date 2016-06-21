<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends MY_Controller {

	public $data = array(
		'breadcrumb' => 'Profil',
		'pesan' => 'Kelola Profil',
		'subtitle' => '',
		'main_view' => 'viewProfil',
		);
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Users_model','user',TRUE);
	}

	public function index(){
		$row = $this->user->get_by_id($this->session->userdata('user_id'));
		$this->data['name'] = array(
            'name'  => 'name',
            'id'    => 'name',
            'type'  => 'text',
            'value' => $row['name'],
        );
        $this->data['identity'] = array(
            'name'  => 'identity',
            'id'    => 'identity',
            'type'  => 'text',
            'value' => $row['username'],
        );
        $this->data['email'] = array(
            'name'  => 'email',
            'id'    => 'email',
            'type'  => 'text',
            'value' => $row['email'],
        );
        $this->data['password'] = array(
            'name'  => 'password',
            'id'    => 'password',
            'type'  => 'password',
            'value' => $this->form_validation->set_value('password'),
        );
        $this->data['password_confirm'] = array(
            'name'  => 'password_confirm',
            'id'    => 'password_confirm',
            'type'  => 'password',
            'value' => $this->form_validation->set_value('password_confirm'),
        );
		$this->load->view('template',$this->data);
	}
}
?>