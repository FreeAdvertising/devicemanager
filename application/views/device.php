<?php //echo "<pre>"; var_dump($device_info); echo "</pre>"; ?>

<div class="row">
	<section class="col-md-9">
		<div class="row">
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
						<?php if($checkout_date = $this->product->getCheckoutDate($device_info->uuid)): ?>
							<tr>
								<td>Checked Out</td>
								<td><?php echo $checkout_date; ?></td>
							</tr>
						<?php endif; ?>

						<?php if($checkin_date = $this->product->getCheckinDate($device_info->uuid)): ?>
							<tr>
								<td>Last Checked In</td>
								<td><?php echo $checkin_date; ?></td>
							</tr>
						<?php endif; ?>

						<?php if(sizeof($recent_owners) > 0): ?>
							<tr>
								<td>Last Owner</td>
								<td><?php echo $recent_owners[0]->username; ?></td>
							</tr>
						<?php endif; ?>

						<tr>
							<td>Location</td>
							<td><?php echo ($device_info->current_owner ? 
									$device_info->current_owner : 
									$this->product->get_location($device_info->location)
									); ?></td>
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
									<td><?php echo $device_info->apps[$i]->name; ?> 
										<?php echo $device_info->apps[$i]->version; ?></td>
								</tr>
							<?php endfor; ?>
						<?php else : ?>
							<tr>
								<td>Nothing yet.</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div> <!-- end installed apps table -->

			<div class="module col-md-12">
				<h3><?php echo anchor(sprintf("/device/%s/history#maintenance", $device_info->uuid), "Maintenance Tickets"); ?></h3>
				<table class="table table-striped">
					<thead>
						<th width="1"></th>
						<th width="60%">Task Name</th>
						<th>Created By</th>
						<th>Assigned To</th>
						<th width="1">Status</th>
					</thead>
					<tbody>
						<?php if(sizeof($tasks) > 0): ?>
							<?php for($i = 0; $i < sizeof($tasks); $i++): ?>
								<tr>
									<td><?php echo ($i+1); ?></td>
									<td><?php echo anchor(sprintf("/task/%d", $tasks[$i]->task_id), truncate($tasks[$i]->description), array("title" => "View task details")); ?></td>
									<td><?php echo $this->product->getUser($tasks[$i]->created_by)->name; ?></td>
									<td><?php echo $this->product->getUser($tasks[$i]->assignee)->name; ?></td>
									<td><?php echo $tasks[$i]->status; ?></td>
								</tr>
							<?php endfor; ?>
						<?php else : ?>
							<tr>
								<td colspan="5">No active tickets.</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div> <!-- end maintenance tickets table -->
		</div>
	</section>

	<section class="sidebar col-md-3">
		<aside class="module">
			<div class="list-group">
				<h3 class="list-group-item">Actions</h3>
				<?php if($this->hydra->isAdmin()): ?>
					<?php echo anchor(sprintf("/device/%s/edit", $device_info->uuid), "Edit", array("class" => "list-group-item")); ?>
					<?php echo anchor(sprintf("/device/%s/add_application", $device_info->uuid), "Add Application", array("class" => "list-group-item")); ?>
				<?php endif; ?>

				<?php echo anchor(sprintf("/device/%s/create_ticket", $device_info->uuid), "Create Maintenance Ticket", array("class" => "list-group-item")); ?>
				<?php echo anchor(sprintf("/device/%s/history", $device_info->uuid), "History", array("class" => "list-group-item")); ?>

				<?php if($this->product->isCheckedOutByUser($device_info->uuid)): ?>
					<?php echo anchor(sprintf("/device/%s/check_in", $device_info->uuid), "Check In", array("class" => "list-group-item checkin btn-success")); ?>
				<?php elseif($this->product->isCheckedOutByOther($device_info->uuid)): ?>
					<?php if($device_info->reserved): ?>
						<?php echo anchor(sprintf("/device/%s/cancel_reservation", $device_info->uuid), "Cancel Reservation", array("class" => "list-group-item reserved btn-danger")); ?>
					<?php else : ?>
						<?php echo anchor(sprintf("/device/%s/reserve", $device_info->uuid), "Reserve", array("class" => "list-group-item")); ?>
					<?php endif; ?>
				<?php else : ?>
					<?php if(isset($reservation_list[0]) && $this->hydra->get("id") == $reservation_list[0]->userid || sizeof($reservation_list) === 0): //unable to checkout unless you are next on reservation list ?>
						<?php echo anchor(sprintf("/device/%s/check_out", $device_info->uuid), "Check Out", array("class" => "list-group-item")); ?>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</aside>

		<!-- hidden for now until a decision is made for this section -->
		<aside class="module hidden">
			<ul class="list-group">
				<?php if(false === is_null($device_info->current_owner)): ?>
					<h3 class="list-group-item">Current Owner</h3>
					<li class="list-group-item"><?php echo $device_info->current_owner; ?></li>
				<?php endif; ?>

				<?php if(sizeof($recent_owners) > 0): ?>
					<h3 class="list-group-item"><?php echo anchor(sprintf("/device/%s/history#recent_owners", $device_info->uuid), "Recent Owners"); ?></h3>
					
					<?php for($i = 0; $i < sizeof($recent_owners); $i++): ?>
						<li class="list-group-item"><?php echo $recent_owners[$i]->username; ?></li>
					<?php endfor; ?>
				<?php endif; ?>
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
</div>