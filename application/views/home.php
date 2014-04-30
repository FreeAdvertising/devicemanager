<section class="main col-md-9">
		<div class="admin quicklinks">
			<h3>Statistics</h3>

			<div class="row">
				<section class="module col-md-6">
					<table class="table table-striped table-hover">
						<thead>
							<th width="60%">Overall User Stats</th>
							<th></th>
						</thead>
						<tbody>
							<tr>
								<td><abbr title="Highest Completed/Created task ratio">Best Ratio</abbr></td>
								<td align="right"><?php echo $user_stats->indexOf("best_ratio"); ?></td>
							</tr>

							<tr>
								<td><abbr title="Highest Invalid/Created task ratio">Worst Ratio</abbr></td>
								<td align="right"><?php echo $user_stats->indexOf("worst_ratio"); ?></td>
							</tr>

							<tr>
								<td>Most Tickets Created</td>
								<td align="right"><?php echo $user_stats->indexOf("most_tickets"); ?></td>
							</tr>

							<tr>
								<td>Most Devices Owned</td>
								<td align="right"><?php echo $user_stats->indexOf("most_devices"); ?></td>
							</tr>
						</tbody>
					</table>
				</section>

				<section class="module col-md-6">
					<table class="table table-striped table-hover">
						<thead>
							<th width="90%">My Stats</th>
							<th></th>
						</thead>
						<tbody>
							<tr>
								<td>Tasks Created</td>
								<td><?php echo $my_stats->dm_tasks_created; ?></td>
							</tr>

							<tr>
								<td>Your Device(s)</td>
								<td><?php echo $my_stats->dm_devices_owned; ?></td>
							</tr>

							<tr>
								<td><abbr title="Lower is better">Invalid Task Ratio</abbr></td>
								<td><?php echo $my_stats->dm_invalid_task_ratio; ?></td>
							</tr>

							<tr>
								<td><abbr title="Higher is better">Completed Task Ratio</abbr></td>
								<td><?php echo $my_stats->dm_completed_task_ratio; ?></td>
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

			<?php if(sizeof($tasks) > 0): ?>
				<h3 class="list-group-item"><?php echo anchor("/my_tasks", "My Maintenance Tasks"); ?></h3>
				<?php for($i = 0, $obj = $tasks; $i < sizeof($obj); $i++): ?>
					<?php echo anchor(sprintf("/task/id/%d", $obj[$i]->task_id), sprintf("%s <span class=\"all status-circle btn-%s\"></span>", truncate($obj[$i]->description, 15), $this->product->get_task_status($obj[$i]->status)), array("class" => "list-group-item")); ?>
				<?php endfor; ?>
			<?php endif ;?>		</div>
	</aside>
</section>
