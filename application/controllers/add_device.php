<?php
	defined("BASEPATH") or die;

	class Add_device extends CI_Controller {
		public function __construct(){
			parent::__construct();

			$this->load->model("add_device_model");
		}

		public function index(){
			$data = new Generic;
			$data->set("template_path", base_url() ."application/views/global");
			$data->set("nav_path", base_url() ."index.php/");
			$data->set("page", $this->uri->segment(1));
			$data->set("subpage", $this->uri->segment(2));
			$data->set("isIPExternal", $this->hydra->isIPExternal());

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('form_add_device');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}
	}

?>