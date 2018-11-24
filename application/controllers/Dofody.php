<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dofody extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->library('session');
	}
	public function index()
	{
		$this->load->view('site/land');
	}
	public function select()
	{
		$this->load->view('site/select');
	}
	public function register()
	{
		$this->load->view('register/patient/register');
	}
}

?>
