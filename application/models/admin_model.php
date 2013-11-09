<?php
// Modelo correspondiente a la parte del login.
class Admin_model extends CI_Model {
	
	function __construct()
	{
		// parent::__construct();
  //   	$this->load->helper('url');
	}

	public function verify_user($usuario, $password)
	{
		$q = $this
			->db
			->where('usuario', $usuario)
			->where('password', sha1($password))
			->limit(1)
			->get('usuarios');

		if ($q->num_rows > 0)
		{
			return $q->row(); //result if there is more than one row
			// echo "<pre>";
			// print_r($q->row());
			// echo '</pre>';

		}

		return false;
	}
}