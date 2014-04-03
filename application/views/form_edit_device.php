<!-- Form data -->
<?php echo form_open(sprintf("%sadd_device/create", $nav_path), array("role" => "form")); ?>
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
			<label for="uuid">Hardware UUID</label><input type="text" id="uuid" name="uuid" value="<?php echo $device_info->uuid; ?>" maxlength="8" class="form-control" placeholder="0F7H823D" />
		</div>

		<div class="form-group">
			<label for="name">Device Name</label><input type="text" id="name" name="name" value="<?php echo $device_info->name; ?>" maxlength="45" class="form-control" placeholder="Pine, Aspen, Coca Cola, ..." />
		</div>

		<div class="form-group">
			<label for="meta_type">Hardware Type</label>
			<select name="meta_type" id="meta_type" class="form-control">
				<option value="0">Select Hardware Type</option>
				<option value="1">LAPTOP</option>
				<option value="2">DESKTOP</option>
				<option value="3">SERVER</option>
				<option value="4">PERIPHERAL</option>
			</select>
		</div>

		<div class="form-group">
			<label for="os">Operating System</label>
			<select name="os" id="os" class="form-control">
				<option value="0">Select an OS</option>
				<option value="1">OSX 10.9</option>
				<option value="2">OSX 10.8</option>
				<option value="3">OSX 10.7</option>
				<option value="4">OSX 10.6</option>
				<option value="5">Windows 8</option>
				<option value="6">Windows 7</option>
				<option value="7">Linux (Debian)</option>
				<option value="8">Linux (Other)</option>
			</select>
		</div>

		<div class="form-group">
			<label for="meta_ram">RAM (in GB)</label>
			<select name="meta_ram" id="meta_ram" class="form-control">
				<option value="0">Select RAM</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">4</option>
				<option value="4">8</option>
				<option value="5">12</option>
				<option value="6">16</option>
				<option value="7">32</option>
				<option value="8">Other</option>
			</select>
		</div>

		<div class="form-group">
			<label for="meta_hdd">HDD/SSD size (in GB)</label>
			<select name="meta_hdd" id="meta_hdd" class="form-control">
				<option value="0">Select size</option>
				<option value="1">128</option>
				<option value="2">256</option>
				<option value="3">500</option>
				<option value="4">512</option>
				<option value="5">750</option>
				<option value="6">1024+ (> 1TB)</option>
				<option value="7">Other</option>
			</select>
		</div>

		<div class="form-group">
			<label for="status">Availability</label>
			<select name="status" id="status" class="form-control">
				<option value="0">Select availability</option>
				<option value="1">Available</option>
				<option value="2">Checked Out</option>
				<option value="3">Maintenance</option>
			</select>
		</div>

		<div class="form-group">
			<label for="location">Current Location</label>
			<select name="location" id="location" class="form-control">
				<option value="0">Select location</option>
				<option value="-1">IT</option>
				<?php for($i = 0; $i < sizeof($users); $i++): ?>
					<option value="<?php echo $users[$i]->id; ?>"><?php echo $users[$i]->username; ?> [<?php echo $users[$i]->group_name; ?>]</option>
				<?php endfor; ?>
			</select>
		</div>
	</div>

	<div class="form-footer">
		<input type="submit" class="btn btn-primary" value="Save" />
		<?php if($subpage == "edit"): ?>
			<button class="btn btn-danger delete">Delete</button>
		<?php else : ?>
			<input type="reset" class="btn btn-link" value="Reset" />
		<?php endif; ?>
	</div>
<?php echo form_close(); ?>