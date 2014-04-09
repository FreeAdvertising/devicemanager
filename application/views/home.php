<section class="main col-md-9">
	<div class="row">
		<?php if($this->hydra->isAdmin()): ?>
			<div class="admin quicklinks col-md-12">
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
							<li><?php echo anchor(sprintf("/device/%s", $obj[$i]->uuid), $obj[$i]->uuid); ?></a> - #<?php echo $obj[$i]->task_id; ?> - <?php echo $obj[$i]->date; ?></li>
						<?php endfor; ?>
					</ul>
				</section>
			</div>
		<?php endif; ?>
	</div>
	<div class="row">
		<div class="staff quicklinks col-md-12">
			<h3>Staff Quick Links</h3>

			<section class="module col-md-6">
				<h3>View</h3>
				<ul>
					<li><a href="#">Latest Reservations</a></li>
					<li><a href="#">Latest Check In's</a></li>
					<li><a href="#">Latest Check Out's</a></li>
				</ul>
			</section>

			<section class="module col-md-6">
				<h3><?php echo anchor("/tasks", "Maintenance Tasks"); ?></h3>
				<ul>
					<?php for($i = 0, $obj = $tasks["staff"]; $i < sizeof($obj); $i++): ?>
						<li><?php echo anchor(sprintf("/device/%s", $obj[$i]->uuid), $obj[$i]->uuid); ?></a> - #<?php echo $obj[$i]->task_id; ?> - <?php echo $obj[$i]->date; ?></li>
					<?php endfor; ?>
					<li><?php echo anchor("/tasks/add", "Create New Task"); ?></li>
				</ul>
			</section>
		</div>
	</div>
</section>

<section class="sidebar col-md-3">
	<aside class="module">
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

			<h3 class="list-group-item">My Maintenance Tickets</h3>
			<a href="#" class="list-group-item">Task#XX</a>
			<a href="#" class="list-group-item">Task#XX</a>
		</div>
	</aside>
</section>
