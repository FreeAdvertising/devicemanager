<?php
	defined("BASEPATH") or die;

	class Device extends CI_Controller {
		public function __construct(){
			parent::__construct();

			$this->load->model("device_model");
		}

		/**
		 * Load the index/home page
		 * @param  string $key
		 * @return void
		 */
		public function index($key = null){
			$uuid = new UUID($key);

			if(false === $uuid->get()){
				return show_error("You must provide a valid device ID.  ". anchor("/", "Return Home."));
			}

			$data = new Generic;
			$data->set("template_path", base_url() ."application/views/global");
			$data->set("nav_path", base_url() ."");
			$data->set("page", $this->uri->segment(1));
			$data->set("subpage", $this->uri->segment(3));
			$data->set("isIPExternal", $this->hydra->isIPExternal());

			//set specific page data
			$data->set("device_info", $this->device_model->getDevice($uuid, Product::MAX_SHORT_LIST));
			$data->set("reservation_list", $this->device_model->getReservationList($uuid));
			$data->set("recent_owners", $this->device_model->getPastOwners($uuid, Product::MAX_SHORT_LIST));
			$data->set("tasks", $this->device_model->getActiveTasks($uuid, Product::MAX_SHORT_LIST));

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('device');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}

		/**
		 * Load the apps page by UUID
		 * @param  string $key
		 * @return void
		 */
		public function apps($key){
			$uuid = new UUID($key);

			if(false === $uuid->get()){
				return show_error("You must provide a valid device ID.  ". anchor("/", "Return Home."));
			}

			$data = new Generic;
			$data->set("template_path", base_url() ."application/views/global");
			$data->set("nav_path", base_url() ."");
			$data->set("page", $this->uri->segment(1));
			$data->set("subpage", $this->uri->segment(3));
			$data->set("isIPExternal", $this->hydra->isIPExternal());

			//set specific page data
			$data->set("apps", $this->device_model->getApps($this->product->getDeviceID($uuid)));
			$data->set("show_pagination", true);

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('device_apps');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}

		/**
		 * Load the history for a device (by UUID)
		 * @param  string $key
		 * @return void
		 */
		public function history($key){
			$uuid = new UUID($key);

			if(false === $uuid->get()){
				return show_error("You must provide a valid device ID.  ". anchor("/", "Return Home."));
			}

			$data = new Generic;
			$data->set("template_path", base_url() ."application/views/global");
			$data->set("nav_path", base_url() ."");
			$data->set("page", $this->uri->segment(1));
			$data->set("subpage", $this->uri->segment(3));
			$data->set("isIPExternal", $this->hydra->isIPExternal());

			//set specific page data
			$data->set("device_info", $this->device_model->getDevice($uuid));
			$data->set("show_pagination", true);

			$history = array(
				"overview" => History::get($uuid), 
				"recent_owners" => $this->device_model->getPastOwners($uuid, Product::MAX_SHORT_LIST), 
				"maintenance" => $this->device_model->getMaintenanceTasks($uuid),
				);
			$data->set("history", $history);

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('device_history');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}

		/**
		 * Loads the add application view so you can associate an app to the device
		 * @param string $key
		 * @return void
		 */
		public function add_application($key){
			$uuid = new UUID($key);

			if(false === $uuid->get()){
				return show_error("You must provide a valid device ID.  ". anchor("/", "Return Home."));
			}

			$data = new Generic;
			$data->set("template_path", base_url() ."application/views/global");
			$data->set("nav_path", base_url() ."");
			$data->set("page", $this->uri->segment(1));
			$data->set("subpage", $this->uri->segment(3));
			$data->set("isIPExternal", $this->hydra->isIPExternal());

			//set specific page data
			$data->set("device_uuid", $uuid);
			$data->set("apps", $this->device_model->getApps());
			$data->set("show_pagination", true);

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('form_add_application');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}

		/**
		 * Create a new maintenance task
		 * @param  string $key
		 * @return void
		 */
		public function add_task($key){
			$uuid = new UUID($key);

			if(false === $uuid->get()){
				return show_error("You must provide a valid device ID.  ". anchor("/", "Return Home."));
			}

			$data = new Generic;
			$data->set("template_path", base_url() ."application/views/global");
			$data->set("nav_path", base_url() ."");
			$data->set("page", $this->uri->segment(1));
			$data->set("subpage", $this->uri->segment(3));
			$data->set("isIPExternal", $this->hydra->isIPExternal());

			//set specific page data
			$data->set("device_uuid", $uuid);
			$data->set("show_pagination", true);
			$data->set("categories", $this->device_model->getTaskCategories());


			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('form_device_task_add');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}

		/**
		 * Load the edit page for a specific UUID
		 * @param  string $key
		 * @return void
		 */
		public function edit($key){
			$uuid = new UUID($key);

			if(false === $uuid->get()){
				return show_error("You must provide a valid device ID.  ". anchor("/", "Return Home."));
			}

			$data = new Generic;
			$data->set("template_path", base_url() ."application/views/global");
			$data->set("nav_path", base_url() ."");
			$data->set("page", $this->uri->segment(1));
			$data->set("subpage", $this->uri->segment(3));
			$data->set("isIPExternal", $this->hydra->isIPExternal());

			//set specific page data
			$data->set("device_info", $this->device_model->getDevice($uuid));
			$data->set("show_pagination", true);

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('form_edit_device');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}

		/**
		 * Associate an app to specific device by UUID
		 * @param  string $key
		 * @return void
		 */
		public function assoc_app_to_device($key){
			$uuid = new UUID($key);

			if(false === $uuid->get()){
				return show_error("You must provide a valid device ID.  ". anchor("/", "Return Home."));
			}

			$this->load->model("add_application_model");

			if($this->add_application_model->assoc($this->input->post(), $uuid)){
				History::record($uuid, __FUNCTION__);

				//setup a success message here
				$this->session->set_flashdata("model_save_success", "Application associated to device");
			}else {
				$this->session->set_flashdata("model_save_fail", "INTERNAL ERROR: application could not be associated to device");
			}

			return redirect(base_url(). sprintf("device/%s/add_application", $uuid));
		}

		/**
		 * Reserve a device by UUID
		 * @param  string $key
		 * @return void
		 */
		public function reserve($key){
			$uuid = new UUID($key);

			if(false === $uuid->get()){
				return show_error("You must provide a valid device ID.  ". anchor("/", "Return Home."));
			}

			if($this->device_model->reserve($uuid)){
				History::record($uuid, __FUNCTION__);

				//setup a success message here
				$this->session->set_flashdata("model_save_success", "Device reserved");
			}else {
				$this->session->set_flashdata("model_save_fail", "INTERNAL ERROR: device could not be reserved");
			}

			return redirect(base_url(). sprintf("device/%s", $uuid));
		}

		/**
		 * Cancel a reservation
		 * Note: History tracking not required here as reservations are deleted
		 * rather than flagged as deleted
		 * @param  string $key
		 * @return void
		 */
		public function cancel_reservation($key){
			$uuid = new UUID($key);

			if(false === $uuid->get()){
				return show_error("You must provide a valid device ID.  ". anchor("/", "Return Home."));
			}

			if($this->device_model->cancel_reservation($uuid)){
				//setup a success message here
				$this->session->set_flashdata("model_save_success", "Device reservation cancelled");
			}else {
				$this->session->set_flashdata("model_save_fail", "INTERNAL ERROR: reservation could not be cancelled");
			}

			return redirect(base_url(). sprintf("device/%s", $uuid));
		}

		/**
		 * Check in a specific device by UUID
		 * @param  string $key
		 * @return void
		 */
		public function check_in($key){
			$uuid = new UUID($key);

			if(false === $uuid->get()){
				return show_error("You must provide a valid device ID.  ". anchor("/", "Return Home."));
			}

			if($this->device_model->check_in($uuid)){
				History::record($uuid, __FUNCTION__);
				
				//setup a success message here
				$this->session->set_flashdata("model_save_success", "");
			}else {
				$this->session->set_flashdata("model_save_fail", "INTERNAL ERROR: device could not be checked back in");
			}

			return redirect(base_url(). sprintf("device/%s", $uuid->get()));
		}

		/**
		 * Check out a device by UUID
		 * @param  string $key
		 * @return void
		 */
		public function check_out($key){
			$uuid = new UUID($key);

			if(false === $uuid->get()){
				return show_error("You must provide a valid device ID.  ". anchor("/", "Return Home."));
			}

			if($this->device_model->check_out($uuid)){
				History::record($uuid, __FUNCTION__);

				//setup a success message here
				$this->session->set_flashdata("model_save_success", "");
			}else {
				$this->session->set_flashdata("model_save_fail", "INTERNAL ERROR: device could not be checked back in");
			}

			return redirect(base_url(). sprintf("device/%s", $uuid->get()));
		}
	}

?>