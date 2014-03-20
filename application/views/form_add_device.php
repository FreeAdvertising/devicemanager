<!-- Form data -->
<?php echo form_open(sprintf("%sadd/insert", $nav_path), array("role" => "form")); ?>
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

	<?php if($page == "edit" && !$this->session->flashdata("model_save_success") && !$this->session->flashdata("model_save_fail")): ?>
		<div class="alert alert-info alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			Leave Password/Confirm Password fields blank if you don't want to change it.
		</div>
	<?php endif; ?>

	<h3>Record</h3>
	<div class="form-wrapper">
		<div class="form-group text">
			<label for="name">Client</label>
			<select class="form-control client-name" name="client_id">
				<option>Select a Client</option>
				<?php if(sizeof($clients) > 0): ?>
					<?php for($i = 0; $i < sizeof($clients); $i++): ?>
						<?php if($clients[$i]->client_id == $record[0]->client_id): ?>
							<option selected="selected" value="<?php echo $clients[$i]->client_id; ?>"><?php echo $clients[$i]->name; ?></option>
						<?php else : ?>
							<option value="<?php echo $clients[$i]->client_id; ?>"><?php echo $clients[$i]->name; ?></option>
						<?php endif; ?>
					<?php endfor; ?>
				<?php else : ?>
					<option>No clients, you must create one first.</option>
				<?php endif; ?>
			</select>
		</div>

		<div class="form-group">
			<label for="username">Username</label><input type="text" id="username" name="username" autocomplete="off" value="<?php echo (isset($record[0]->username) ? $record[0]->username : ""); ?>" class="form-control" placeholder="sample_user" />
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

		<div class="form-group">
			<label for="domain">Domain</label><input type="text" id="domain" name="domain" value="<?php echo (isset($record[0]->domain) ? $record[0]->domain : ""); ?>" class="form-control" placeholder="http://example.com" />
		</div>

		<div class="form-group">
			<label for="desc">Description</label><input type="text" id="desc" name="desc" value="<?php echo (isset($record[0]->desc) ? $record[0]->desc : ""); ?>" class="form-control" placeholder="What is this password for?" />
		</div>

		<?php if(isset($record[0])): ?>
			<div class="category-chooser form-group">
				<label>Categories</label>
				<p class="alert alert-info">To assign categories to the record, choose items (as many as you want) from the right (Unassigned) list and click the left arrow (&laquo;) button.  To unassign, choose items from the left (Assigned) list and click the right arrow (&raquo;) button.</p>
				<div class="col-md-5">
					<label for="assigned">Assigned Categories</label>
					<select class="form-control" name="assigned[]" id="assigned" multiple="multiple">
						<?php for($i = 0; $i < sizeof($assigned_categories); $i++): ?>
							<option value="<?php echo $assigned_categories[$i]->category_id; ?>"><?php echo $assigned_categories[$i]->name; ?></option>
						<?php endfor; ?>
					</select>
				</div>

				<div class="col-md-2 category-assignment">
					<button class="btn btn-default assign" title="Assign Categories">&laquo;</button>
					<button class="btn btn-default unassign" title="Unassign Categories">&raquo;</button>
				</div>

				<div class="col-md-5">
					<label for="assign">Unassigned Categories</label>
					<select class="form-control" name="assign[]" id="assign" multiple="multiple">
						<?php for($i = 0; $i < sizeof($unassigned_categories); $i++): ?>
							<option value="<?php echo $unassigned_categories[$i]->category_id; ?>"><?php echo $unassigned_categories[$i]->name; ?></option>
						<?php endfor; ?>
					</select>
				</div>
			</div>
		<?php else : ?>
			<div class="form-group">
				<label>Categories</label>
				<p>Categories can be associated to this record after it has been created.</p>
			</div>
		<?php endif; ?>

		<div class="form-group">
			<!-- <label for="host">Host</label><input type="text" id="host" name="host" value="<?php echo (isset($record[0]->host) ? $record[0]->host : ""); ?>" class="form-control" placeholder="MT | External | etc" /> -->
			<label for="host">Host</label>
			<select name="host" id="host" class="form-control">
				<option value="MT" <?php echo (isset($record[0]->host) && $record[0]->host == "MT" ? 'selected="selected"' : ''); ?>>Media Temple</option>
				<option value="ET" <?php echo (isset($record[0]->host) && $record[0]->host == "ET" ? 'selected="selected"' : ''); ?>>External</option>
				<option value="AWS" <?php echo (isset($record[0]->host) && $record[0]->host == "AWS" ? 'selected="selected"' : ''); ?>>Amazon</option>
			</select>
		</div>
	</div>

	<?php if(isset($record[0])): ?>
		<input type="hidden" name="record_id" value="<?php echo $record[0]->record_id; ?>" />
	<?php endif; ?>

	<div class="form-footer">
		<input type="submit" class="btn btn-primary" value="Save" />
		<?php if($page == "edit"): ?>
			<button class="btn btn-danger delete">Delete</button>
		<?php else : ?>
			<input type="reset" class="btn btn-link" value="Reset" />
		<?php endif; ?>
	</div>
<?php echo form_close(); ?>