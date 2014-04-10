<section class="main col-md-9">
	<div class="row">
		<table class="table table-striped table-hover list-devices">
			<thead>
				<th width="1"></th>
				<th width="60%">Task Name</th>
				<th>Created By</th>
				<th>Assigned To</th>
				<th>Status</th>
			</thead>
			<tbody>
				<?php for($i = 0; $i < sizeof($records); $i++): ?>
					<tr data-location="<?php echo $records[$i]->created_by; ?>" data-device="<?php echo $records[$i]->device_id; ?>" data-status="<?php echo $records[$i]->status; ?>">
						<td><?php echo ($i+1); ?>.</td>
						<td><?php echo anchor(sprintf("/task/id/%d", $records[$i]->task_id), truncate($records[$i]->description), array("title" => "View task details")); ?></td>
						<td><?php echo $this->product->getUser($records[$i]->created_by)->name; ?></td>
						<td><?php echo $this->product->getUser($records[$i]->assignee)->name; ?></td>
						<td><?php echo $records[$i]->status; ?></td>
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
			<a href="#" data-type="<?php echo Product::DEVICE_MAINTENANCE; ?>" class="list-group-item">Maintenance</a>
		</div>
	</aside>

	<aside class="module">
		<div class="list-group user-list">
			<h3 class="list-group-item user-filter-header">Created By <a href="#" class="reset-filters label label-default hidden">Reset</a></h3>
			<?php for($i = 0; $i < sizeof($users); $i++): ?>
				<a href="#" data-user="<?php echo $users[$i]->userid; ?>" class="list-group-item"><?php echo $users[$i]->username; ?> <span class="all badge"><?php echo $users[$i]->count; ?></span></a>
			<?php endfor; ?>
		</div>
	</aside>

	<aside class="module">
		<div class="list-group device-list">
			<h3 class="list-group-item device-filter-header">Filter by Device <a href="#" class="reset-filters label label-default hidden">Reset</a></h3>
			<?php for($i = 0; $i < sizeof($devices); $i++): ?>
				<a href="#" data-device="<?php echo $devices[$i]->device_id; ?>" class="list-group-item"><?php echo $devices[$i]->name; ?> <span class="all badge"><?php echo $devices[$i]->count; ?></span></a>
			<?php endfor; ?>
		</div>
	</aside>
</section>
