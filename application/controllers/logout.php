<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends Admin_Controller {

	public function index()
	{
		$this->session->sess_destroy();
		redirect('login');
	}

}

/* End of file logout.php */
/* Location: ./application/controllers/admin/logout.php */