<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Task extends CI_Controller {
		public function __construct(){
			parent::__construct();
			
			$this->load->model("task_model");
		}
		
		public function id($id = 0){
			if(false === is_numeric($id) || $id == 0){
				show_error("Invalid task ID");
			}

			$data = new Generic;
			$data->set("template_path", base_url() ."application/views/global");
			$data->set("nav_path", base_url() ."index.php/");
			$data->set("page", $this->uri->segment(1));
			$data->set("subpage", $this->uri->segment(2));
			$data->set("isIPExternal", $this->hydra->isIPExternal());

			//set specific page data
			$data->set("record", $this->task_model->getRecord($id));

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('task');
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
			$data->set("my_devices", $this->task_model->getMyDevices());
			$data->set("categories", $this->task_model->getTaskCategories());

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('form_task_add');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}

		public function insert(){
			if($this->task_model->insert($this->input->post())){
				//setup a success message here
				$this->session->set_flashdata("model_save_success", "Maintenance task successfully added to the database");
			}else {
				$this->session->set_flashdata("model_save_fail", "INTERNAL ERROR: maintenance task could not be created");
			}

			//if the item was inserted from the device/add_task form, redirect
			//back to that form - else redirect to the regular task/add form
			$redirect = base_url() . "task/add";
			$pData = $this->input->post();

			if(isset($pData["uuid"])){
				$redirect = base_url() . sprintf("device/%s/add_task", $pData["uuid"]);
			}

			return redirect($redirect);
		}
	}

?>