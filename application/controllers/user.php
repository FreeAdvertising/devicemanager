<?php
	defined("BASEPATH") or die;

	class User extends CI_Controller {
		public function __construct(){
			parent::__construct();

			$this->load->model("user_model");
			$this->load->helper("form");
		}

		public function index(){
			$data = new Generic;
			$data->set("template_path", base_url() ."application/views/global");
			$data->set("nav_path", base_url() ."index.php/");
			$data->set("groups", $this->user_model->getGroups());
			$data->set("page", $this->uri->segment(1));
			$data->set("isIPExternal", $this->hydra->isIPExternal());

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('form_user');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}

		public function insert(){
			if($this->user_model->insert($this->input->post())){
				//setup a success message here
				$this->session->set_flashdata("model_save_success", "User created successfully");
			}else {
				$this->session->set_flashdata("model_save_fail", "There was a problem creating the user");
			}

			return redirect(base_url(). "/user");
		}

		/*
		 * AJAX endpoint
		 */
		public function reset_secret_question($id = 0){
			$ret = array();
			$ret["message"] = "The secret question could not be reset";
			$ret["type"] = "error";

			if($this->hydra->isAuthenticated()){
				if($this->user_model->reset_secret_question($id)){
					$ret["message"] = "Secret question reset";
					$ret["type"] = "success";
				}
			}
			
			echo json_encode($ret);
		}
	}

?>