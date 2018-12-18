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
        $this->load->library(array('ion_auth','form_validation'));
        $this->load->helper(array('url','language','form'));
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
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
       $this->data['old_password'] = array(
                'name' => 'old',
                'id'   => 'old',
                'type' => 'password',
        );
        $this->data['new_password'] = array(
            'name'    => 'new',
            'id'      => 'new',
            'type'    => 'password'
        );
        $this->data['new_password_confirm'] = array(
            'name'    => 'new_confirm',
            'id'      => 'new_confirm',
            'type'    => 'password'
        );
        $this->data['user_id'] = array(
            'name'  => 'user_id',
            'id'    => 'user_id',
            'type'  => 'hidden',
            'value' => $this->session->userdata['user_id'],
            );
		$this->load->view('template',$this->data);
	}
    public function change_profil(){
        $this->_validate();

        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }

        $user = $this->ion_auth->user($this->session->userdata['user_id'])->row();
        $groups=$this->ion_auth->groups()->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($this->session->userdata['user_id'])->result();

        // validate form input
        $this->form_validation->set_rules('name', $this->lang->line('edit_user_validation_name_label'), 'required');
    

        if (isset($_POST) && !empty($_POST))
        {

            if ($this->form_validation->run() === TRUE)
            {
                $data = array(
                    'name' => $this->input->post('name'),
                    'username' => $this->input->post('identity'),
                    'email' => $this->input->post('email')
                );
                
                // check to see if we are updating the user
               if($this->ion_auth->update($user->id, $data))
                {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('message', $this->ion_auth->messages() );

                }
                else
                {
                    $this->data['message'] = $this->ion_auth->errors();
                    $this->data['status'] = FALSE;
                    echo json_encode($this->data);
                    exit();
                }

            }
        }

        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
        if($this->data['message']){
            $this->data['update'] =$data;
            $this->data['status'] = TRUE;
            echo json_encode($this->data);
            exit();
        }
    }
    public function change_password(){
        $this->_validate();

        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() == false)
        {
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            if($this->data['message']){
                $this->data['status'] = FALSE;
                echo json_encode($this->data);
                exit();
            }
        }
        else
        {
            $identity = $this->session->userdata('identity');

            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change)
            {
                //if the password was successfully changed
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                $this->data['message'] =$this->ion_auth->messages();
                $this->data['status'] = TRUE;
                echo json_encode($this->data);

            }
            else
            {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                $this->data['message'] = $this->ion_auth->errors();
                $this->data['status'] = FALSE;
                echo json_encode($this->data);
                exit();
            }
        }
    }
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        if($this->input->post('method') =='profil'){
            if($this->input->post('name') == '')
            {
                $data['inputerror'][] = 'name';
                $data['error_string'][] = 'Nama User Belum Diisi';
                $data['status'] = FALSE;
            }
     
            if($this->input->post('identity') == '')
            {
                $data['inputerror'][] = 'identity';
                $data['error_string'][] = 'Username Belum Diisi';
                $data['status'] = FALSE;
            }
            if($this->input->post('email') == '')
            {
                $data['inputerror'][] = 'email';
                $data['error_string'][] = 'Email Belum Diisi';
                $data['status'] = FALSE;
            }
            // if (!$this->upload->do_upload())
            // {
            //     $data['inputerror'][] = 'userfile';
            //     $data['error_string'][] = $this->upload->display_errors();
            //     $data['status'] = FALSE;
            // }
        }
        
        if($this->input->post('method') =='password'){
            if($this->input->post('old') == '')
            {
                $data['inputerror'][] = 'old';
                $data['error_string'][] = 'Password Lama Belum Diisi';
                $data['status'] = FALSE;
            }elseif(strlen($this->input->post('old'))<8 or strlen($this->input->post('password'))>20){
                $data['inputerror'][] = 'old';
                $data['error_string'][] = 'Password Paling Sedikit 8 Karakter dan Maksimal 20 Karakter';
                $data['status'] = FALSE;
            }
            if($this->input->post('new') == '')
            {
                $data['inputerror'][] = 'new';
                $data['error_string'][] = 'Password Baru Belum Diisi';
                $data['status'] = FALSE;
            }elseif(strlen($this->input->post('new'))<8 or strlen($this->input->post('new'))>20){
                $data['inputerror'][] = 'new';
                $data['error_string'][] = 'Password Paling Sedikit 8 Karakter dan Maksimal 20 Karakter';
                $data['status'] = FALSE;
            }
            if($this->input->post('new_confirm') == '')
            {
                $data['inputerror'][] = 'new_confirm';
                $data['error_string'][] = 'Konfirmasi Password Baru Belum Diisi';
                $data['status'] = FALSE;
            }elseif(strlen($this->input->post('new_confirm'))<8 or strlen($this->input->post('password'))>20){
                $data['inputerror'][] = 'new_confirm';
                $data['error_string'][] = 'Password Paling Sedikit 8 Karakter dan Maksimal 20 Karakter';
                $data['status'] = FALSE;
            }
        }
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
}
?>