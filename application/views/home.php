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
							<li><?php echo anchor(sprintf("/task/id/%d", $obj[$i]->task_id), truncate($obj[$i]->description)); ?> <span class="all"><?php echo $obj[$i]->date; ?></span></li>
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
						<li><?php echo anchor(sprintf("/task/id/%d", $obj[$i]->task_id), truncate($obj[$i]->description)); ?> <span class="all"><?php echo $obj[$i]->date; ?></span></li>
					<?php endfor; ?>
					<li><?php echo anchor("/task/add", "Create New Task"); ?></li>
				</ul>
			</section>
		</div>
	</div>
</section>

<section class="sidebar col-md-3">
	<aside class="module">
		<div class="list-group">
			<h3 class="list-group-item">Information</h3>
			<li class="list-group-item">Date format: <abbr title="<?php echo $this->product->getDefaultDateFormat(); ?>">Year - Month - Day</abbr></li>
			<li class="list-group-item">Version <?php echo $this->product->getVersion(); ?></li>
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
					<?php echo anchor(sprintf("/task/id/%d", $obj[$i]->task_id), sprintf("%s <span class=\"all\">%s</span>", truncate($obj[$i]->description, 10), $obj[$i]->date), array("class" => "list-group-item")); ?>
				<?php endfor; ?>
			<?php endif ;?>		</div>
	</aside>
</section>
