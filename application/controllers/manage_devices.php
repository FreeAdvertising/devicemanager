<?php

	defined("BASEPATH") or die;

	class Manage_devices extends CI_Controller {
		public function __construct(){
			parent::__construct();

			$this->load->model("manage_devices_model");
			$this->load->model("devices_model");
		}

		public function index(){
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
			$data->set("users", $this->devices_model->getUsers());
			$data->set("records", $this->devices_model->getRecords());
			$data->set("apps", $this->manage_devices_model->getApps());

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('manage_devices');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}
	}

?>