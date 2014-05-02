<?php
	defined("BASEPATH") or die;

	class Modify_device extends CI_Controller {
		public function __construct(){
			parent::__construct();

			$this->load->model("add_device_model");
		}

		public function index(){
			die("TEST");
			if(false === $this->hydra->isAdmin()){
				show_error("You do not have permission to view this page.");
			}

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

		public function edit(){
			if(false === $this->hydra->isAdmin()){
				show_error("You do not have permission to view this page.");
			}
			
			if($this->modify_device_model->modify($this->input->post())){
				//setup a success message here
				$this->session->set_flashdata("model_save_success", "Device settings were successfully modified.");
			}else {
				$this->session->set_flashdata("model_save_fail", "INTERNAL ERROR: There was a problem modifying this device.  Please try again, or contact a system administrator.");
			}

			return redirect(base_url(). sprintf("/device/%s/edit", $this->uri->segment(2)));
		}
	}

?>