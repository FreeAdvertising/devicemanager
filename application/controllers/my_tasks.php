<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class My_tasks extends CI_Controller {
		public function __construct(){
			parent::__construct();
			
			$this->load->model("mytasks_model");
		}
		
		public function index(){
			$data = new Generic;
			$data->set("template_path", base_url() ."application/views/global");
			$data->set("nav_path", base_url() ."index.php/");
			$data->set("page", $this->uri->segment(1));
			$data->set("subpage", $this->uri->segment(2));
			$data->set("isIPExternal", $this->hydra->isIPExternal());

			//set specific page data
			$data->set("records", $this->mytasks_model->getRecords());
			$data->set("users", $this->mytasks_model->getCreatedByUsers());
			$data->set("assignee_users", $this->mytasks_model->getAssigneeUsers());
			$data->set("devices", $this->mytasks_model->getDevices());

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('tasks');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}
	}

?>