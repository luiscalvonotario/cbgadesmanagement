<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		session_start();
		$this->load->helper('url');
	}

	public function index()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('usuario', 'Usuario', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run() !== false)
		{
			$this->load->model('admin_model');
			$res = $this->admin_model->verify_user($this->input->post('usuario'), $this->input->post('password'));

			if ($res !== false)
			{
				//person has an account
				$_SESSION['usuario'] = $this->input->post('usuario');
				redirect('jugadores');
			}
		}

		$this->load->view('login');
	}

	public function logout()
	{
		session_destroy();
		$this->load->view('login');	
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */