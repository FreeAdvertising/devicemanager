<!-- Form data -->
<?php echo form_open(sprintf("%stask/insert", $nav_path), array("role" => "form")); ?>
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

	<div class="alert alert-info">
		<p>If you don't see any devices in the list, have no fear!.  You can only create tasks for devices you have checked out (unless you are an admin).</p>
	</div>

	<div class="form-wrapper">
		<div class="form-group">
			<label for="device_id">Device</label>
			<select name="device_id" id="device_id" class="form-control">
				<option value="0">Select Device</option>
				<?php for($i = 0; $i < sizeof($my_devices); $i++): ?>
					<option value="<?php echo $my_devices[$i]->device_id; ?>"><?php echo $my_devices[$i]->name; ?></option>
				<?php endfor; ?>
			</select>
		</div>

		<div class="form-group">
			<label for="category">Category</label>
			<select name="category" id="category" class="form-control">
				<option value="0">Select a category</option>
				<?php for($i = 0; $i < sizeof($categories); $i++): ?>
					<option value="<?php echo $categories[$i]->category_id; ?>"><?php echo $categories[$i]->name; ?></option>
				<?php endfor; ?>
			</select>
		</div>

		<div class="form-group">
			<label for="desc">Description</label>
			<textarea name="desc" class="form-control" rows="8" placeholder="Description of issue..." id="desc"></textarea>
		</div>
	</div>

	<div class="form-footer">
		<input type="submit" class="btn btn-primary" value="Save" />
		<input type="reset" class="btn btn-link" value="Reset" />
	</div>
<?php echo form_close(); ?>