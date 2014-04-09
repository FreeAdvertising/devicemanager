<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Add_task_category extends CI_Controller {
		public function __construct(){
			parent::__construct();
			
			$this->load->model("add_task_category_model");
		}
		
		public function index(){
			$data = new Generic;
			$data->set("template_path", base_url() ."application/views/global");
			$data->set("nav_path", base_url() ."index.php/");
			$data->set("page", $this->uri->segment(1));
			$data->set("isIPExternal", $this->hydra->isIPExternal());

			//set specific page data
						

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('form_add_task_category');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}

		public function insert(){
			if($this->add_task_category_model->insert($this->input->post())){
				//setup a success message here
				$this->session->set_flashdata("model_save_success", "New maintenance task category created");
			}else {
				$this->session->set_flashdata("model_save_fail", "INTERNAL ERROR: the category could not be created");
			}

			return redirect(base_url() ."/add_task_category");
		}
	}

?>