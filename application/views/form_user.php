<div class="col-md-12">
	<!-- Form data -->
	<?php if($page == "user" && $subpage != "edit"): ?>
		<?php echo form_open(sprintf("%suser/do_insert", $nav_path), array("role" => "form")); ?>
	<?php else : ?>
		<?php echo form_open(sprintf("%suser/do_edit/%d", $nav_path, $this->uri->segment(3)), array("role" => "form")); ?>
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
			<div class="form-group text">
				<label for="name">Name</label><input type="text" id="name" name="name" value="<?php echo (isset($record[0]->username) ? $record[0]->username : ""); ?>" class="client-name form-control" placeholder="Chris Bolivar" />
			</div>

			<div class="form-group text">
				<?php if(false === isset($record)): ?>
					<label for="name">User Group</label>
						<select class="form-control" name="group_id">
							<option>Select a Group</option>
							<?php if(sizeof($groups) > 0): ?>
								<?php for($i = 0; $i < sizeof($groups); $i++): ?>
									<option value="<?php echo $groups[$i]->group_id; ?>"><?php echo $groups[$i]->name; ?></option>
								<?php endfor; ?>
							<?php else : ?>
								<option>No groups, you must create one first.</option>
							<?php endif; ?>
						</select>
				<?php else : ?>
					<?php if($record[0]->userid == 1): ?>
						<label for="name">User Group</label> <em>(cannot change this user's group)</em>
						<input type="text" disabled="disabled" readonly="readonly" value="administrator" class="form-control" />
					<?php else : ?>
						<label for="name">User Group</label>
						<select class="form-control" name="group_id">
							<option>Select a Group</option>
							<?php if(sizeof($groups) > 0): ?>
								<?php for($i = 0; $i < sizeof($groups); $i++): ?>
									<?php if($groups[$i]->group_id == $record[0]->group_id): ?>
										<option selected="selected" value="<?php echo $groups[$i]->group_id; ?>"><?php echo $groups[$i]->name; ?></option>
									<?php else : ?>
										<option value="<?php echo $groups[$i]->group_id; ?>"><?php echo $groups[$i]->name; ?></option>
									<?php endif; ?>
								<?php endfor; ?>
							<?php else : ?>
								<option>No groups, you must create one first.</option>
							<?php endif; ?>
						</select>
					<?php endif; ?>
				<?php endif; ?>
			</div>

			<div class="form-group">
				<div class="input-group">
					<label for="password">Password</label><input type="password" id="password" value="" autocomplete="off" name="password" class="form-control" />

					<span class="input-group-btn">
						<a class="btn btn-default btn-group generatepw" data-toggle="tooltip" title="Generate a password for me"><span class="glyphicon glyphicon-gift"></span></a>
					</span>
				</div>
			</div>

			<div class="form-group">
				<label for="conf-password">Confirm Password</label><input type="password" value="" autocomplete="off" name="conf-password" id="conf-password" class="form-control" />
			</div>

			<div class="alert alert-info">
				The secret question is in your head, just put the answer below.  It is required when logging in from outside the office, so don't forget it!  It can include any character, spaces or numbers.
			</div>
			<div class="form-group">
				<label for="secret_question_answer">Secret Question Answer</label><input type="text" id="secret_question_answer" name="secret_question_answer" value="<?php echo (isset($record[0]->secret_question_answer) ? $record[0]->secret_question_answer : ""); ?>" class="form-control" placeholder="My favourite pet was Sidney" />
			</div>
		</div>

		<div class="form-footer">
			<input type="submit" class="btn btn-primary" value="Save" />
			<?php if($page == "edit"): ?>
				<?php if($record[0]->userid > 1): ?>
					<button class="btn btn-danger delete">Delete</button>
				<?php else :?>
					<button class="btn btn-danger pull-right" disabled="disabled">Delete</button>
				<?php endif; ?>
			<?php else : ?>
				<input type="reset" class="btn btn-link" value="Reset" />
			<?php endif; ?>
		</div>
	<?php echo form_close(); ?>
</div>