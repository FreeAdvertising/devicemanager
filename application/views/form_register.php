<div class="col-md-12">
	<div class="row">
		<?php echo form_open(sprintf("%sregister/do_register", $nav_path), array("role" => "form")); ?>
			<h3 class="dotted">Create an Account</h3>

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

			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" name="username" class="form-control" id="username" />
			</div>

			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" name="password" class="form-control" id="password" />
			</div>

			<div class="form-group">
				<label for="conf-password">Confirm Password</label>
				<input type="password" name="conf-password" class="form-control" id="conf-password" />
			</div>

			<div class="form-group">
				<label for="email">Email Address</label>
				<input type="email" name="email" class="form-control" id="email" />
			</div>			

			<div class="form-footer">
				<input type="submit" class="btn btn-primary" value="Register" />
				<input type="reset" class="btn btn-link" value="Reset" />
			</div>
		<?php echo form_close(); ?>
	</div>
</div>