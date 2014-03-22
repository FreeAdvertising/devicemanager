<!-- Form data -->
<?php echo form_open(sprintf("%sadd_application/create", $nav_path), array("role" => "form")); ?>
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

	<h3>Add Tracked Application</h3>
	<div class="form-wrapper">
		<div class="form-group">
			<label for="name">Name</label><input type="text" id="name" name="name" class="form-control" placeholder="Keynote, Word, Excel, ..." />
		</div>

		<div class="form-group">
			<label for="desc">Description</label>
			<textarea id="desc" rows="5" name="desc" class="form-control" placeholder="Short description of the application"></textarea>
		</div>
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