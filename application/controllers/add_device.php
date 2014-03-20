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

			//set specific page data
			$data->set("users", $this->add_device_model->getUsers());

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('form_add_device');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}

		public function create(){
			if($this->add_device_model->insert($this->input->post())){
				//setup a success message here
				$this->session->set_flashdata("model_save_success", "Device added to the database");
			}else {
				$this->session->set_flashdata("model_save_fail", "The device could not be added to the database");
			}

			return redirect(base_url(). "index.php/add_device");
		}
	}

?>