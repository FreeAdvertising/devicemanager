<?php
	defined("BASEPATH") or die;

	class User extends CI_Controller {
		public function __construct(){
			parent::__construct();

			$this->load->model("user_model");
			$this->load->helper("form");
		}

		public function do_insert(){
			if(false === $this->hydra->isAdmin()){
				show_error("You do not have permission to view this page.");
			}

			if($this->user_model->insert($this->input->post())){
				//setup a success message here
				$this->session->set_flashdata("model_save_success", "User created successfully");
			}else {
				$this->session->set_flashdata("model_save_fail", "There was a problem creating the user");
			}

			return redirect(base_url(). "/users");
		}

		public function do_edit($id){
			if(false === $this->hydra->isAdmin()){
				show_error("You do not have permission to view this page.");
			}

			if($this->user_model->modify($this->input->post(), $id)){
				//setup a success message here
				$this->session->set_flashdata("model_save_success", "User modified");
			}else {
				$this->session->set_flashdata("model_save_fail", "There was a problem editing this user");
			}

			return redirect(base_url() ."/users");
		}

		public function edit($id){
			if(false === $this->hydra->isAdmin()){
				show_error("You do not have permission to view this page.");
			}

			$data = new Generic;
			$data->set("template_path", base_url() ."application/views/global");
			$data->set("nav_path", base_url() ."index.php/");
			$data->set("groups", $this->user_model->getGroups());
			$data->set("page", $this->uri->segment(1));
			$data->set("subpage", $this->uri->segment(2));
			$data->set("isIPExternal", $this->hydra->isIPExternal());

			//set page specific data
			$data->set("record", $this->user_model->getUser($id));

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('form_user');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}

		public function qedit($id){
			if(false === $this->hydra->isAdmin()){
				show_error("You do not have permission to view this page.");
			}

			$data = new Generic;
			$data->set("template_path", base_url() ."application/views/global");
			$data->set("nav_path", base_url() ."index.php/");
			$data->set("groups", $this->user_model->getGroups());
			$data->set("page", $this->uri->segment(1));
			$data->set("subpage", $this->uri->segment(2));
			$data->set("isIPExternal", $this->hydra->isIPExternal());

			//set page specific data
			$data->set("record", $this->user_model->getQuarantinedUser($id));

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('form_user_qedit');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}

		/*
		 * AJAX endpoint
		 */
		public function reset_secret_question($id = 0){
			$ret = array();
			$ret["message"] = "The secret question could not be reset";
			$ret["type"] = "error";

			if($this->hydra->isAuthenticated() && $this->hydra->isAdmin()){
				if($this->user_model->reset_secret_question($id)){
					$ret["message"] = "Secret question reset";
					$ret["type"] = "success";
				}
			}
			
			echo json_encode($ret);
		}

		/*
		 * AJAX endpoint
		 */
		public function do_approve($id){
			$return = false;

			if($this->user_model->approve($id) && $this->hydra->isAuthenticated() && $this->hydra->isAdmin()){
				$return = true;
			}

			$this->output->set_content_type("application/json")->set_output(json_encode($return));
		}

		/*
		 * AJAX endpoint
		 */
		public function do_reject($id){
			$return = false;

			if($this->user_model->reject($id) && $this->hydra->isAuthenticated() && $this->hydra->isAdmin()){
				$return = true;
			}

			$this->output->set_content_type("application/json")->set_output(json_encode($return));
		}
	}

?>