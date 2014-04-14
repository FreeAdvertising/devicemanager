<section class="main col-md-9">
	<div class="row">
		<?php if($this->hydra->isAdmin()): ?>
			<div class="admin quicklinks">
				<h3>Admin Quick Links</h3>

				<section class="module col-md-6">
					<h3>Manage</h3>
					<ul>
						<li><?php echo anchor("/manage_devices", "Devices"); ?></li>
						<li><?php echo anchor("/users", "Users"); ?></li>
						<li><?php echo anchor("/tasks", "Maintenance Tasks"); ?></li>
					</ul>
				</section>

				<section class="module col-md-6">
					<h3><?php echo anchor("/tasks", "Maintenance Tasks"); ?></h3>
					<ul>
						<?php for($i = 0, $obj = $tasks["admin"]; $i < sizeof($obj); $i++): ?>
							<li><?php echo anchor(sprintf("/task/id/%d", $obj[$i]->task_id), truncate($obj[$i]->description)); ?> <span class="all"><?php echo $obj[$i]->date; ?></span></li>
						<?php endfor; ?>
					</ul>
				</section>
			</div>
		<?php endif; ?>
	</div>
	<div class="row">
		<div class="staff quicklinks">
			<h3>Staff Quick Links</h3>

			<section class="module col-md-6">
				<h3>View</h3>
				<ul>
					<li><a href="#">Latest Reservations</a></li>
					<li><a href="#">Latest Check In's</a></li>
					<li><a href="#">Latest Check Out's</a></li>
					<li><?php echo anchor("/devices", "Devices"); ?></li>
				</ul>
			</section>

			<section class="module col-md-6">
				<table class="table table-striped table-hover">
					<thead>
						<th width="90%">User Stats</th>
						<th></th>
					</thead>
					<tbody>
						<tr>
							<td>Freepass Records Created</td>
							<td><?php echo $user_stats->fp_records_created; ?></td>
						</tr>

						<tr>
							<td>Tasks Created</td>
							<td><?php echo $user_stats->dm_tasks_created; ?></td>
						</tr>

						<tr>
							<td>Devices You Own</td>
							<td><?php echo $user_stats->dm_devices_owned; ?></td>
						</tr>

						<tr>
							<td>Task opened/closed ratio</td>
							<td><?php echo $user_stats->dm_task_ratio; ?></td>
						</tr>
					</tbody>
				</table>
			</section>
		</div>
	</div>
</section>

<section class="sidebar col-md-3">
	<aside class="module">
		<div class="list-group">
			<h3 class="list-group-item">Information</h3>
			<li class="list-group-item">Version <?php echo $this->product->getVersion(); ?></li>
			<!-- <li class="list-group-item">Date format: <abbr title="<?php echo $this->product->getDefaultDateFormat(); ?>"><?php echo $this->product->convertMySQLDate(); ?></abbr></li> -->
		</div>

		<div class="list-group">
			<?php if(sizeof($my_devices) > 0): ?>
				<h3 class="list-group-item">My Devices</h3>
				<?php for($i = 0; $i < sizeof($my_devices); $i++): ?>
					<?php echo anchor(sprintf("/device/%s", $my_devices[$i]->uuid), $my_devices[$i]->name, array("class" => "list-group-item")); ?>
				<?php endfor; ?>
			<?php endif; ?>

			<?php if(sizeof($my_reservations) > 0): ?>
				<h3 class="list-group-item">My Reserved Devices</h3>
				<?php for($i = 0; $i < sizeof($my_reservations); $i++): ?>
					<?php echo anchor(sprintf("/device/%s", $my_reservations[$i]->uuid), sprintf("%s <span class=\"all\">%s</span>", $my_reservations[$i]->name, $my_reservations[$i]->date), array("class" => "list-group-item")); ?>
				<?php endfor; ?>
			<?php endif ;?>

			<?php if(sizeof($tasks["staff"]) > 0): ?>
				<h3 class="list-group-item">My Maintenance Tasks</h3>
				<?php for($i = 0, $obj = $tasks["staff"]; $i < sizeof($obj); $i++): ?>
					<?php echo anchor(sprintf("/task/id/%d", $obj[$i]->task_id), sprintf("%s <span class=\"all status-circle btn-%s\"></span>", truncate($obj[$i]->description, 15), $this->product->get_task_status($obj[$i]->status)), array("class" => "list-group-item")); ?>
				<?php endfor; ?>
			<?php endif ;?>		</div>
	</aside>
</section>
