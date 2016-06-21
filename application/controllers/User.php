<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	
	public function __construct(){
		parent::__construct();
		$this->load->model('Users_model','user',TRUE);
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language','form'));
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');
	}

	public function index()
	{

		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else
		{
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			

            ////////Config Halaman////////
            $this->data['breadcrumb'] = 'Operator';
            $this->data['subtitle'] = 'List';
			$this->data['main_view'] = 'auth/index';
			$this->data['name'] = array(
                'name'  => 'name',
                'id'    => 'name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('name'),
            );
            $this->data['identity'] = array(
                'name'  => 'identity',
                'id'    => 'identity',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['email'] = array(
                'name'  => 'email',
                'id'    => 'email',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('email'),
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
            
			$this->load->view('template', $this->data, FALSE);
		}
	}
	public function ajax_list()
    {
        //list the users
		$list = $this->user->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $user) {
            $no++;
            $row = array(
            	"id" => $user['id'],
            	"username" => $user['username'],
            	"name" => $user['name'],
            	"email" => $user['email'],
            	);
           
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->ion_auth->count_all(),
                        "recordsFiltered" => $this->ion_auth->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
    function ajax_update($id)
	{
        $this->_validate();

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
		{
			redirect('auth/login', 'refresh');
		}

		$user = $this->ion_auth->user($id)->row();
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();

		// validate form input
		$this->form_validation->set_rules('name', $this->lang->line('edit_user_validation_name_label'), 'required');
		

		if (isset($_POST) && !empty($_POST))
		{
			

			// update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$data = array(
					'name' => $this->input->post('name'),
                    'username' => $this->input->post('identity'),
                    'email' => $this->input->post('email')
				);

				// update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}

				
			// check to see if we are updating the user
			   if($this->ion_auth->update($user->id, $data))
			    {
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->messages() );

			    }
			    else
			    {
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->data['message'] = $this->ion_auth->errors();
				    $this->data['status'] = FALSE;
		            echo json_encode($this->data);
		            exit();
			    }

			}
		}
		// display the edit user form
		
		// if(validation_errors()){
  //       	$this->data['message'] = validation_errors();
  //       }else{
  //       	if($this->ion_auth->errors){
  //       		$this->data['message'] = $this->ion_auth->errors();
  //       		$this->data['status'] = FALSE;
	 //            echo json_encode($this->data);
	 //            exit();
  //       	}else{
  //       		$this->data['message'] = $this->session->flashdata('message');
  //       		$this->data['status'] = TRUE;
	 //            echo json_encode($this->data);
  //       	}
  //       }

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		if($this->data['message']){
			$this->data['status'] = TRUE;
	 		echo json_encode($this->data);
	 		exit();
		}

		
	}
    public function ajax_edit($id)
    {

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
		{
			redirect('auth/login', 'refresh');
		}
        $data = $this->user->get_by_id($id);
        echo json_encode($data);
    }
    
    function ajax_add()
    {
    	$this->_validate();
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('auth/login', 'refresh');
        }
        
        $tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        $this->form_validation->set_rules('name', $this->lang->line('create_user_validation_name_label'), 'required');
        if($identity_column!=='email')
        {
            $this->form_validation->set_rules('identity',$this->lang->line('create_user_validation_identity_label'),'required|is_unique['.$tables['users'].'.'.$identity_column.']');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
        }
        else
        {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
        
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == true)
        {
            $email    = strtolower($this->input->post('email'));
            $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');

            $additional_data = array(
                'name' => $this->input->post('name')
            );
        }
        if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data))
        {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            
            $this->data['status'] = TRUE;
            echo json_encode($this->data);
        }
        else
        {
            // display the create user form
            // set the flash data error message if there is one
            // if(validation_errors()){
            // 	$this->data['message'] = validation_errors();
            // }else{
            // 	if($this->ion_auth->errors){
            // 		$this->data['message'] = $this->ion_auth->errors();
            // 		$this->data['status'] = FALSE;
		          //   echo json_encode($this->data);
		          //   exit();
            // 	}else{
            // 		$this->data['message'] = $this->session->flashdata('message');
            // 		$this->data['status'] = TRUE;
		          //   echo json_encode($this->data);
		          //   exit();
            // 	}
            // }
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            if($this->data['message']){
            	$this->data['status'] = FALSE;
            	echo json_encode($this->data);
            	exit();
            }
            ////////Config Halaman////////
        }
    }
    public function ajax_delete($id)
    {
        $this->user->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
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
        if($this->input->post('method') =='add'){
            if($this->input->post('password') == '')
            {
                $data['inputerror'][] = 'password';
                $data['error_string'][] = 'Password Belum Diisi';
                $data['status'] = FALSE;
            }elseif(strlen($this->input->post('password'))<8 or strlen($this->input->post('password'))>20){
                $data['inputerror'][] = 'password';
                $data['error_string'][] = 'Password Paling Sedikit 8 Karakter dan Maksimal 20 Karakter';
                $data['status'] = FALSE;
            }
            if($this->input->post('password_confirm') == '')
            {
                $data['inputerror'][] = 'password_confirm';
                $data['error_string'][] = 'Konfirmasi Password Belum Diisi';
                $data['status'] = FALSE;
            }elseif(strlen($this->input->post('password_confirm'))<8 or strlen($this->input->post('password'))>20){
                $data['inputerror'][] = 'password_confirm';
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