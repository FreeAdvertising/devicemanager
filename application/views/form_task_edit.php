<!-- Form data -->
<?php echo form_open(sprintf("%stask/do_edit", $nav_path), array("role" => "form")); ?>
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

	<?php if(false === $this->session->flashdata("model_save_fail") && false === $this->session->flashdata("model_save_success")): ?>
		<div class="alert alert-info">
			<p>If you don't see any devices in the list, have no fear!  You can only create tasks for devices you have checked out (unless you are an admin).</p>
		</div>
	<?php endif; ?>

	<div class="form-wrapper">
		<div class="form-group">
			<label for="device_id">Device</label>
			<select name="device_id" id="device_id" class="form-control">
				<option value="0">Select Device</option>
				<?php for($i = 0; $i < sizeof($my_devices); $i++): ?>
					<?php if($record->device_id == $my_devices[$i]->device_id): ?>
						<option value="<?php echo $my_devices[$i]->device_id; ?>" selected="selected"><?php echo $my_devices[$i]->name; ?></option>
					<?php else : ?>
						<option value="<?php echo $my_devices[$i]->device_id; ?>"><?php echo $my_devices[$i]->name; ?></option>
					<?php endif; ?>
				<?php endfor; ?>
			</select>
		</div>

		<div class="form-group">
			<label for="categories">Category</label>
			<select name="categories[]" id="categories" multiple="multiple" class="form-control">
				<?php for($i = 0; $i < sizeof($categories); $i++): ?>
					<?php if(in_array($categories[$i]->category_id, $record->category_ids)): ?>
						<option value="<?php echo $categories[$i]->category_id; ?>" selected="selected"><?php echo $categories[$i]->name; ?></option>
					<?php else : ?>
						<option value="<?php echo $categories[$i]->category_id; ?>"><?php echo $categories[$i]->name; ?></option>
					<?php endif; ?>
				<?php endfor; ?>
			</select>
		</div>

		<div class="form-group">
			<label for="desc">Description</label>
			<textarea name="desc" class="form-control" rows="8" placeholder="Description of issue..." id="desc"><?php echo $record->description; ?></textarea>
		</div>
	</div>

	<input type="hidden" name="task_id" value="<?php echo $record->task_id; ?>" />

	<div class="form-footer">
		<input type="submit" class="btn btn-primary" value="Save" />
		<input type="reset" class="btn btn-link" value="Reset" />
	</div>
<?php echo form_close(); ?>