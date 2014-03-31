<?php
	defined("BASEPATH") or die;

	class Device extends CI_Controller {
		public function __construct(){
			parent::__construct();

			$this->load->model("device_model");
		}

		public function index($key = null){
			$uuid = new UUID($key);

			if(false === $uuid){
				return show_error("You must provide a valid device ID.");
			}

			$data = new Generic;
			$data->set("template_path", base_url() ."application/views/global");
			$data->set("nav_path", base_url() ."index.php/");
			$data->set("page", $this->uri->segment(1));
			$data->set("subpage", $this->uri->segment(2));
			$data->set("isIPExternal", $this->hydra->isIPExternal());

			//set specific page data
			$data->set("device_info", $this->device_model->getDevice($uuid, Product::DEVICE_MAX_TRACKED_APPS));
			$data->set("reservation_list", $this->device_model->getReservationList($uuid));

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('device');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}

		public function apps($key){
			$uuid = new UUID($key);

			if(false === $uuid){
				return show_error("You must provide a valid device ID.");
			}

			$data = new Generic;
			$data->set("template_path", base_url() ."application/views/global");
			$data->set("nav_path", base_url() ."index.php/");
			$data->set("page", $this->uri->segment(1));
			$data->set("subpage", $this->uri->segment(2));
			$data->set("isIPExternal", $this->hydra->isIPExternal());

			//set specific page data
			$data->set("apps", $this->device_model->getApps($this->product->getDeviceID($uuid)));
			$data->set("pagination", $this->product->getPagination());

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('device_apps');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}

		public function history($key){
			$uuid = new UUID($key);

			if(false === $uuid){
				return show_error("You must provide a valid device ID.");
			}

			$data = new Generic;
			$data->set("template_path", base_url() ."application/views/global");
			$data->set("nav_path", base_url() ."index.php/");
			$data->set("page", $this->uri->segment(1));
			$data->set("subpage", $this->uri->segment(2));
			$data->set("isIPExternal", $this->hydra->isIPExternal());

			//set specific page data
			$data->set("device_info", $this->device_model->getDevice($uuid));
			$data->set("reservation_list", $this->device_model->getReservationList($uuid));
			$data->set("pagination", $this->product->getPagination());

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('device_history');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}

		public function add_application($key){
			$uuid = new UUID($key);

			if(false === $uuid){
				return show_error("You must provide a valid device ID.");
			}

			$data = new Generic;
			$data->set("template_path", base_url() ."application/views/global");
			$data->set("nav_path", base_url() ."index.php/");
			$data->set("page", $this->uri->segment(1));
			$data->set("subpage", $this->uri->segment(2));
			$data->set("isIPExternal", $this->hydra->isIPExternal());

			//set specific page data
			$data->set("device_uuid", $uuid);
			$data->set("apps", $this->device_model->getApps());
			$data->set("pagination", $this->product->getPagination());

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('form_add_application');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}

		public function assoc_app_to_device($key){
			$uuid = new UUID($key);

			if(false === $uuid){
				return show_error("You must provide a valid device ID.");
			}

			$this->load->model("add_application_model");

			if($this->add_application_model->assoc($this->input->post(), $uuid)){
				//setup a success message here
				$this->session->set_flashdata("model_save_success", "Application associated to device");
			}else {
				$this->session->set_flashdata("model_save_fail", "INTERNAL ERROR: application could not be associated to device");
			}

			return redirect(base_url(). sprintf("index.php/device/%s/add_application", $uuid));
		}
	}

?>