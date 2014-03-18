<?php echo form_open("login", array("role" => "form")); ?>
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

	<?php if($isIPExternal): ?>
		<div class="alert alert-info">
			<p>Hello stranger!  You're visiting this site from an unknown location, so please fill out the answer to your secret question as well as your username and password.</p>
			<p>All fields are case sensitive.</p>
		</div>
	<?php endif; ?>
	
	<div class="form-group">
		<label for="username">Username</label><input class="form-control" type="text" name="username" id="username" autocomplete="off" />
	</div>

	<div class="form-group">
		<label for="password">Password</label><input class="form-control" type="password" name="password" id="password" autocomplete="off" />
	</div>

	<?php if($isIPExternal): ?>
		<div class="form-group">
			<label for="secret_question">Secret Question Answer</label><input class="form-control" type="text" name="secret_question" id="secret_question" autocomplete="off" />
		</div>
	<?php endif; ?>

	<div class="form-footer">
		<input class="btn btn-primary" type="submit" value="Login" />
	</div>
<?php echo form_close(); ?>