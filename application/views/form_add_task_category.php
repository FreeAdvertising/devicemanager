<!-- Form data -->
<?php echo form_open(sprintf("%sadd_task_category/insert", $nav_path), array("role" => "form")); ?>
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
		<div class="form-group">
			<label for="name">Category Name</label><input type="text" id="name" name="name" maxlength="45" class="form-control" placeholder="Pine, Aspen, Coca Cola, ..." />
		</div>

		<div class="form-group">
			<label for="description">Description</label>
			<textarea name="description" class="form-control" rows="8" placeholder="Description of issue..." id="description"></textarea>
		</div>
	</div>

	<div class="form-footer">
		<input type="submit" class="btn btn-primary" value="Save" />
		<input type="reset" class="btn btn-link" value="Reset" />
	</div>
<?php echo form_close(); ?>