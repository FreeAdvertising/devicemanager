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

			if(is_null($data->record)){
				show_error("Invalid task ID");
			}

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

		public function edit($id){
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
			$data->set("my_devices", $this->task_model->getMyDevices());
			$data->set("categories", $this->task_model->getTaskCategories());

			if(is_null($data->record)){
				show_error("Invalid task ID");
			}

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('form_task_edit');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}

		public function manage($id){
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
			$data->set("users", $this->task_model->getUsers());

			if(is_null($data->record)){
				show_error("Invalid task ID");
			}

			//load the relevant views
			$this->load->view('ajax_header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('form_task_manage');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('ajax_footer', $data);
		}

		public function do_insert(){
			$pData = $this->input->post();

			if($this->task_model->insert($pData)){
				//setup a success message here
				$this->session->set_flashdata("model_save_success", "Maintenance task successfully added to the database");
			}else {
				$this->session->set_flashdata("model_save_fail", "INTERNAL ERROR: maintenance task could not be created");
			}

			//if the item was inserted from the device/add_task form, redirect
			//back to that form - else redirect to the regular task/add form
			$redirect = base_url() . "task/add";

			if(isset($pData["uuid"])){
				$redirect = base_url() . sprintf("device/%s/add_task", $pData["uuid"]);
			}

			return redirect($redirect);
		}

		public function do_edit(){
			$post = $this->input->post();

			if($this->task_model->edit($post)){
				//setup a success message here
				$this->session->set_flashdata("model_save_success", "Maintenance task edited");
			}else {
				$this->session->set_flashdata("model_save_fail", "INTERNAL ERROR: maintenance task could not be edited");
			}

			//return redirect(base_url() . sprintf("task/id/%d", $post["task_id"]));
			return redirect(base_url() . sprintf("task/edit/%d", $post["task_id"]));
		}

		public function do_manage_task(){
			$post = $this->input->post();

			if($this->task_model->manage_task($post)){
				//setup a success message here
				$this->session->set_flashdata("model_save_success", "Status/Assignee updated successfully");
			}else {
				$this->session->set_flashdata("model_save_fail", "INTERNAL ERROR: This waterfall is too dry!  Quick, someone pee in the river!");
			}

			return redirect(base_url() . sprintf("task/id/%d", $post["task_id"]));
		}
	}

?>