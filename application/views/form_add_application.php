<div class="col-md-12">
	<!-- Form data -->
	<?php if(isset($device_uuid)): ?>
		<?php echo form_open(sprintf("%sdevice/%s/assoc_app_to_device", $nav_path, $device_uuid), array("role" => "form")); ?>
	<?php else: ?>
		<?php echo form_open(sprintf("%sadd_application/create", $nav_path), array("role" => "form")); ?>
	<?php endif; ?>
		<?php if($this->session->flashdata("model_save_success")): ?>
			<div class="alert alert-success">
				<?php echo $this->session->flashdata("model_save_success"); ?>
			</div>
		<?php endif; ?>

		<?php if($this->session->flashdata("model_save_fail")): ?>
			<div class="alert alert-danger">
				<?php echo $this->session->flashdata("model_save_fail"); ?>
			</div>
		<?php endif; ?>

		<div class="form-wrapper">		
			<?php if(isset($device_uuid)): ?>
				<div class="form-group">
					<label for="name">Application <?php echo anchor("/add_application", "Add New", array("class" => "label label-default")); ?></label>
					<select class="form-control" name="app_id">
						<option>Select Application</option>
						<?php for($i = 0; $i < sizeof($apps); $i++): ?>
							<option value="<?php echo $apps[$i]->app_id; ?>"><?php echo $apps[$i]->name; ?></option>
						<?php endfor; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="name">Version</label><input type="text" id="version" name="version" class="form-control" placeholder="10.1, 8, v1.8.2, ..." />
				</div>
			<?php else : ?>
				<div class="form-group">
					<label for="name">Name</label><input type="text" id="name" name="name" class="form-control" placeholder="Keynote, Word, Excel, ..." />
				</div>

				<div class="form-group">
					<label for="desc">Description</label>
					<textarea id="desc" rows="5" name="desc" class="form-control" placeholder="Short description of the application"></textarea>
				</div>
			<?php endif; ?>
		</div>

		<div class="form-footer">
			<input type="submit" class="btn btn-primary" value="Save" />
			<?php if($page == "edit"): ?>
				<button class="btn btn-danger delete">Delete</button>
			<?php else : ?>
				<input type="reset" class="btn btn-link" value="Reset" />
			<?php endif; ?>
		</div>
	<?php echo form_close(); ?>
</div>