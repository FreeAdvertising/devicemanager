<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Task extends CI_Controller {
		public function __construct(){
			parent::__construct();
			
			$this->load->model("task_model");
		}
		
		public function index($id = 0){
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
	}

?>