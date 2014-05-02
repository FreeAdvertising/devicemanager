<div class="col-md-12">
	<!-- Form data -->
	<?php echo form_open(sprintf("%smodify_device/edit", $nav_path), array("role" => "form")); ?>
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
					<option value="1" <?php echo ($device_info->meta_type == 1 ? "selected=\"selected\"" : ""); ?>>LAPTOP</option>
					<option value="2" <?php echo ($device_info->meta_type == 2 ? "selected=\"selected\"" : ""); ?>>DESKTOP</option>
					<option value="3" <?php echo ($device_info->meta_type == 3 ? "selected=\"selected\"" : ""); ?>>SERVER</option>
					<option value="4" <?php echo ($device_info->meta_type == 4 ? "selected=\"selected\"" : ""); ?>>PERIPHERAL</option>
				</select>
			</div>

			<div class="form-group">
				<label for="os">Operating System</label>
				<select name="os" id="os" class="form-control">
					<option value="0">Select an OS</option>
					<option value="1" <?php echo ($device_info->os == 1 ? "selected=\"selected\"" : ""); ?>>OSX 10.9</option>
					<option value="2" <?php echo ($device_info->os == 2 ? "selected=\"selected\"" : ""); ?>>OSX 10.8</option>
					<option value="3" <?php echo ($device_info->os == 3 ? "selected=\"selected\"" : ""); ?>>OSX 10.7</option>
					<option value="4" <?php echo ($device_info->os == 4 ? "selected=\"selected\"" : ""); ?>>OSX 10.6</option>
					<option value="5" <?php echo ($device_info->os == 5 ? "selected=\"selected\"" : ""); ?>>Windows 8</option>
					<option value="6" <?php echo ($device_info->os == 6 ? "selected=\"selected\"" : ""); ?>>Windows 7</option>
					<option value="7" <?php echo ($device_info->os == 7 ? "selected=\"selected\"" : ""); ?>>Linux (Debian)</option>
					<option value="8" <?php echo ($device_info->os == 8 ? "selected=\"selected\"" : ""); ?>>Linux (Other)</option>
				</select>
			</div>

			<div class="form-group">
				<label for="meta_ram">RAM (in GB)</label>
				<select name="meta_ram" id="meta_ram" class="form-control">
					<option value="0">Select RAM</option>
					<option value="1" <?php echo ($device_info->meta_ram == 1 ? "selected=\"selected\"" : ""); ?>>1</option>
					<option value="2" <?php echo ($device_info->meta_ram == 2 ? "selected=\"selected\"" : ""); ?>>2</option>
					<option value="3" <?php echo ($device_info->meta_ram == 3 ? "selected=\"selected\"" : ""); ?>>4</option>
					<option value="4" <?php echo ($device_info->meta_ram == 4 ? "selected=\"selected\"" : ""); ?>>8</option>
					<option value="5" <?php echo ($device_info->meta_ram == 5 ? "selected=\"selected\"" : ""); ?>>12</option>
					<option value="6" <?php echo ($device_info->meta_ram == 6 ? "selected=\"selected\"" : ""); ?>>16</option>
					<option value="7" <?php echo ($device_info->meta_ram == 7 ? "selected=\"selected\"" : ""); ?>>32</option>
					<option value="8" <?php echo ($device_info->meta_ram == 8 ? "selected=\"selected\"" : ""); ?>>Other</option>
				</select>
			</div>

			<div class="form-group">
				<label for="meta_hdd">HDD/SSD size (in GB)</label>
				<select name="meta_hdd" id="meta_hdd" class="form-control">
					<option value="0">Select size</option>
					<option value="1" <?php echo ($device_info->meta_hdd == 1 ? "selected=\"selected\"" : ""); ?>>128</option>
					<option value="2" <?php echo ($device_info->meta_hdd == 2 ? "selected=\"selected\"" : ""); ?>>256</option>
					<option value="3" <?php echo ($device_info->meta_hdd == 3 ? "selected=\"selected\"" : ""); ?>>500</option>
					<option value="4" <?php echo ($device_info->meta_hdd == 4 ? "selected=\"selected\"" : ""); ?>>512</option>
					<option value="5" <?php echo ($device_info->meta_hdd == 5 ? "selected=\"selected\"" : ""); ?>>750</option>
					<option value="6" <?php echo ($device_info->meta_hdd == 6 ? "selected=\"selected\"" : ""); ?>>1024+ (> 1TB)</option>
					<option value="7" <?php echo ($device_info->meta_hdd == 7 ? "selected=\"selected\"" : ""); ?>>Other</option>
				</select>
			</div>

			<div class="form-group">
				<label for="status">Availability</label>
				<select name="status" id="status" class="form-control">
					<option value="0">Select availability</option>
					<option value="1" <?php echo ($device_info->status == 1 ? "selected=\"selected\"" : ""); ?>>Available</option>
					<option value="2" <?php echo ($device_info->status == 2 ? "selected=\"selected\"" : ""); ?>>Checked Out</option>
					<option value="3" <?php echo ($device_info->status == 3 ? "selected=\"selected\"" : ""); ?>>Maintenance</option>
				</select>
			</div>

			<div class="form-group">
				<label for="location">Current Location</label>
				<select name="location" id="location" class="form-control">
					<option value="0">Select location</option>
					<option value="-1" <?php echo ($device_info->location == -1 ? "selected=\"selected\"" : ""); ?>>IT</option>
					<?php for($i = 0; $i < sizeof($users); $i++): ?>
						<?php if($device_info->location == $users[$i]->id): ?>
							<option value="<?php echo $users[$i]->id; ?>" selected="selected"><?php echo $users[$i]->username; ?> [<?php echo $users[$i]->group_name; ?>]</option>
						<?php else : ?>	
							<option value="<?php echo $users[$i]->id; ?>"><?php echo $users[$i]->username; ?> [<?php echo $users[$i]->group_name; ?>]</option>
						<?php endif; ?>
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
</div>