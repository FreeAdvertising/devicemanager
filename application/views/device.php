<?php //var_dump($device_info); ?>

<div class="row">
	<section class="col-md-9">
		<div class="row">
			<div class="col-md-12">
				<h3>Device Info: <?php echo $device_info->device_name; ?> <span class="label label-default">#<?php echo $device_info->device_id; ?></span> </h3>

				<div class="module col-md-4">
					<table class="table table-striped">
						<thead>
							<th width="50%">Hardware</th>
							<th></th>
						</thead>
						<tbody>
							<tr>
								<td>RAM</td>
								<td><?php echo $this->product->get_ram($device_info->meta_ram); ?>GB</td>
							</tr>
							<tr>
								<td>HDD</td>
								<td><?php echo $this->product->get_hdd($device_info->meta_hdd); ?>GB</td>
							</tr>
							<tr>
								<td>TYPE</td>
								<td><?php echo $this->product->get_type($device_info->meta_type); ?></td>
							</tr>
							<tr>
								<td>OS</td>
								<td><?php echo $this->product->get_os($device_info->os); ?></td>
							</tr>
							<tr>
								<td>UUID</td>
								<td><?php echo $device_info->uuid; ?></td>
							</tr>
						</tbody>
					</table>
				</div> <!-- end hardware table -->

				<div class="module col-md-4">
					<table class="table table-striped">
						<thead>
							<th width="50%">Meta</th>
							<th></th>
						</thead>
						<tbody>
							<?php if($device_info->date_checkout != "0000-00-00"): //no checkout date set ?>
								<tr>
									<td>Checked Out</td>
									<td><?php echo $device_info->date_checkout; ?></td>
								</tr>
							<?php endif; ?>

							<?php if($device_info->date_checkin != "0000-00-00"): //no checkin date set ?>
								<tr>
									<td>Last Checked In</td>
									<td><?php echo $device_info->date_checkin; ?></td>
								</tr>
							<?php endif; ?>

							<?php if($device_info->last_checkedout_by > 0): ?>
								<tr>
									<td>Last Checked Out By</td>
									<td><?php echo $device_info->last_checkedout_by; ?></td>
								</tr>
							<?php endif; ?>

							<tr>
								<td>Location</td>
								<td><?php echo $this->product->get_location($device_info->location); ?></td>
							</tr>
						</tbody>
					</table>
				</div> <!-- end meta table -->

				<div class="module col-md-4">
					<table class="table table-striped">
						<thead>
							<th><?php echo anchor(sprintf("/device/%s/apps", $device_info->uuid), "Installed Applications"); ?></th>
						</thead>
						<tbody>
							<?php if(sizeof($device_info->apps) > 0): ?>
								<?php for($i = 0; $i < sizeof($device_info->apps); $i++): ?>
									<tr>
										<td><?php echo $this->product->get_ram($device_info->meta_ram); ?>GB</td>
									</tr>
								<?php endfor; ?>
							<?php else : ?>
								<tr>
									<td>No data.</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div> <!-- end installed apps table -->

				<div class="module col-md-12">
					<h3><?php echo anchor(sprintf("/device/%s/history", $device_info->uuid), "Maintenance Tickets"); ?></h3>
					<table class="table table-striped">
						<thead>
							<th>Ticket ID</th>
							<th>Assignee</th>
							<th width="10px">Status</th>
						</thead>
						<tbody>
							<tr>
								<td colspan="3">No active tickets.</td>
							</tr>
						</tbody>
					</table>
				</div> <!-- end maintenance tickets table -->
			</div>
		</div>
	</section>

	<section class="sidebar col-md-3">
		<aside class="module">
			<ul class="list-group">
				<h3 class="list-group-item">Current Owner</h3>
				<li class="list-group-item"><?php echo $device_info->current_owner; ?></li>
			</ul>
		</aside>

		<aside class="module">
			<ul class="list-group">
				<h3 class="list-group-item"><?php echo anchor(sprintf("/device/%s/history", $device_info->uuid), "Recent Owners"); ?></h3>
				<li class="list-group-item">old owner</li>
				<li class="list-group-item">old owner</li>
				<li class="list-group-item">old owner</li>
			</ul>
		</aside>

		<?php if(sizeof($reservation_list) > 0): ?>
			<aside class="module">
				<ul class="list-group">
					<h3 class="list-group-item">Reservation List</h3>
					<?php for($i = 0; $i < sizeof($reservation_list); $i++): ?>
						<li class="list-group-item"><?php echo $reservation_list[$i]->username; ?> <span class="all"><?php echo $reservation_list[$i]->date; ?></span></li>
					<?php endfor; ?>
				</ul>
			</aside>
		<?php endif; ?>
	</section>
	
	<div class=" col-md-12">
		<section class="form-footer">
			<div class="btn-group">
				<?php if($this->product->user_can("check_in", $device_info->uuid)): ?>
					<!-- if currently checked out, display.. -->
					<button class="btn btn-primary">Check In</button>
				<?php endif; ?>

				<?php if($this->product->user_can("check_out", $device_info->uuid)): ?>
					<!-- if currently checked in, display.. -->
					<button class="btn btn-primary">Check Out</button>
				<?php endif; ?>
			</div>

			<?php if($this->hydra->isAdmin()): ?>
				<div class="floatright">
					<button class="btn btn-default">Edit</button>
				</div>
			<?php endif; ?>
		</section>
	</div>
</div>