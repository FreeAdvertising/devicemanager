<?php
	defined("BASEPATH") or die;

	class Modify_device extends CI_Controller {
		public function __construct(){
			parent::__construct();

			$this->load->model("modify_device_model");
		}

		public function edit(){
			if(false === $this->hydra->isAdmin()){
				show_error("You do not have permission to view this page.");
			}
			
			if($this->modify_device_model->modify($this->input->post())){
				//setup a success message here
				$this->session->set_flashdata("model_save_success", "Device settings were successfully modified.");
			}else {
				$this->session->set_flashdata("model_save_fail", "INTERNAL ERROR: There was a problem modifying this device.  Please try again, or contact a system administrator.");
			}

			$return_uuid = $this->modify_device_model->getUUID();

			return redirect(base_url(). sprintf("/device/%s/edit", $return_uuid->get()));
		}
	}

?>