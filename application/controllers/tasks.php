<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Tasks extends CI_Controller {
		public function __construct(){
			parent::__construct();
			
			$this->load->model("tasks_model");
		}
		
		public function index(){
			$data = new Generic;
			$data->set("template_path", base_url() ."application/views/global");
			$data->set("nav_path", base_url() ."index.php/");
			$data->set("page", $this->uri->segment(1));
			$data->set("subpage", $this->uri->segment(2));
			$data->set("isIPExternal", $this->hydra->isIPExternal());

			//set specific page data
			$data->set("records", $this->tasks_model->getRecords());

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('tasks');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}

		public function add(){
			$data = new Generic;
			$data->set("template_path", base_url() ."application/views/global");
			$data->set("nav_path", base_url() ."index.php/");
			$data->set("page", $this->uri->segment(1));
			$data->set("subpage", $this->uri->segment(2));
			$data->set("isIPExternal", $this->hydra->isIPExternal());

			//set specific page data
			$data->set("my_devices", $this->tasks_model->getMyDevices());
			$data->set("categories", $this->tasks_model->getTaskCategories());

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('form_tasks_add');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}

		public function insert(){
			if($this->tasks_model->insert($this->input->post())){
				//setup a success message here
				$this->session->set_flashdata("model_save_success", "Maintenance task successfully added to the database");
			}else {
				$this->session->set_flashdata("model_save_fail", "INTERNAL ERROR: maintenance task could not be created");
			}

			return redirect(base_url(). "/tasks/add");
		}
	}

?>