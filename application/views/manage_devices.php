<section class="main col-md-9">
	<div class="row">
		<h3 class="dotted"><?php echo anchor("/devices", "Devices"); ?> (<?php echo Product::DEVICE_MAX_TRACKED_APPS; ?>)</h3>
		<table class="table table-striped table-hover list-devices">
			<thead>
				<th width="85%">Device Name (UUID)</th>
				<th>Apps</th>
				<th>OS</th>
			</thead>
			<tbody>
				<?php for($i = 0; $i < sizeof($records); $i++): ?>
					<?php $status = $this->product->get_status($records[$i]); ?>
					<tr data-location="<?php echo $records[$i]->current_owner; ?>" data-status="<?php echo $status; ?>">
						<td><?php echo anchor(sprintf("/device/%s", strtoupper($records[$i]->uuid)), sprintf("%s (%s)", $records[$i]->name, $records[$i]->uuid)); ?></td>
						<td><?php echo anchor(sprintf("/device/%s/apps", $records[$i]->uuid), "View"); ?></td>
						<td><span class="os <?php echo strtolower($this->product->get_os($records[$i]->os)); ?>"><?php echo $this->product->get_os($records[$i]->os); ?></span></td>
					</tr>
				<?php endfor; ?>
			</tbody>
		</table>
	</div>

	<div class="row">
		<h3 class="dotted"><?php echo anchor("/tracked_applications", "Installed Applications"); ?> (<?php echo Product::DEVICE_MAX_TRACKED_APPS; ?>)</h3>

		<table class="table table-striped table-hover">
			<thead>
				<th width="1"></th>
				<th width="15%">Name</th>
				<th>Description</th>
			</thead>
			<tbody>
				<?php for($i = 0; $i < sizeof($apps); $i++): ?>
					<tr>
						<td><?php echo ($i+1) ?>.</td>
						<td><?php echo $apps[$i]->name; ?></td>
						<td><?php echo $apps[$i]->description; ?></td>
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
			<a href="#" data-type="<?php echo Product::DEVICE_AVAILABLE; ?>" class="list-group-item">Available</a>
			<a href="#" data-type="<?php echo Product::DEVICE_CHECKED_OUT; ?>" class="list-group-item">Checked Out</a>
			<a href="#" data-type="<?php echo Product::DEVICE_RESERVED; ?>" class="list-group-item">Reserved</a>
			<a href="#" data-type="<?php echo Product::DEVICE_MAINTENANCE; ?>" class="list-group-item">Maintenance</a>
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