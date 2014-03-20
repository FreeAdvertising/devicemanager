<section class="main col-md-9">
	<div class="row">
		<table class="table table-striped table-hover list-devices">
			<thead>
				<th width="85%">Device UUID</th>
				<th>Apps</th>
				<th>OS</th>
			</thead>
			<tbody>
				<?php for($i = 0; $i < sizeof($records); $i++): ?>
					<tr data-location="<?php echo $records[$i]->location; ?>" data-status="<?php echo $records[$i]->status; ?>">
						<td><?php echo anchor(sprintf("/device/%s", strtoupper($records[$i]->uuid)), $records[$i]->uuid); ?></td>
						<td><?php echo anchor(sprintf("/device/%s/apps", $records[$i]->uuid), "View"); ?></td>
						<td><?php echo get_os($records[$i]->os); ?></td>
					</tr>
				<?php endfor; ?>
			</tbody>
		</table>
	</div>
</section>

<section class="sidebar col-md-3">
	<aside class="module">
		<div class="list-group type-list">
			<h3 class="list-group-item type-filter-header">Filter by Type <a href="#" class="reset-filters label label-default hidden">Reset</a></h3>
			<a href="#" data-type="<?php echo DEVICE_AVAILABLE; ?>" class="list-group-item">Available</a>
			<a href="#" data-type="<?php echo DEVICE_RESERVED; ?>" class="list-group-item">Reserved</a>
			<a href="#" data-type="<?php echo DEVICE_MAINTENANCE; ?>" class="list-group-item">Maintenance</a>
		</div>
	</aside>

	<aside class="module">
		<div class="list-group user-list">
			<h3 class="list-group-item user-filter-header">Filter by User <a href="#" class="reset-filters label label-default hidden">Reset</a></h3>
			<?php for($i = 0; $i < sizeof($users); $i++): ?>
				<a href="#" data-user="<?php echo $users[$i]->userid; ?>" class="list-group-item"><?php echo $users[$i]->username; ?> <span class="all badge"><?php echo $users[$i]->count; ?></span></a>
			<?php endfor; ?>
		</div>
	</aside>
</section>
