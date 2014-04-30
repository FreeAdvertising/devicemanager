<section class="main col-md-9">
	<table class="table table-striped table-hover list-devices list-tasks">
		<thead>
			<th width="1"></th>
			<th width="60%">Task Name</th>
			<th></th>
			<th>Created By</th>
			<th>Assigned To</th>
			<th>Status</th>
		</thead>
		<tbody>
			<?php if(sizeof($records) > 0): ?>
				<?php for($i = 0; $i < sizeof($records); $i++): ?>
					<tr data-location="<?php echo $records[$i]->created_by; ?>" data-assignee="<?php echo $records[$i]->assignee; ?>" data-device="<?php echo $records[$i]->device_id; ?>" data-status="<?php echo $records[$i]->status; ?>" data-createdby="<?php echo $records[$i]->created_by; ?>">
						<td><?php echo ($i+1); ?>.</td>
						<td><?php echo anchor(sprintf("/task/id/%d", $records[$i]->task_id), truncate($records[$i]->description), array("title" => "View task details")); ?></td>
						<td>
							<?php if($records[$i]->created_by == $this->hydra->get("id") 
									|| $records[$i]->assignee == $this->hydra->get("id")): ?>
								<span class="glyphicon glyphicon-star"></span>
							<?php endif; ?>
						</td>
						<td><?php echo $this->product->getUser($records[$i]->created_by)->name; ?></td>
						<td><?php echo $this->product->getUser($records[$i]->assignee)->name; ?></td>
						<td><span class="status-circle btn-<?php echo $this->product->get_task_status($records[$i]->status); ?>"></span></td>
					</tr>
				<?php endfor; ?>
			<?php else : ?>
				<tr>
					<td colspan="5">There are no maintenance tasks yet.  <?php echo anchor("/task/add", "Add one now"); ?>.</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
</section>

<section class="sidebar col-md-3">
	<aside class="module">
		<div class="list-group type-list">
			<h3 class="list-group-item type-filter-header">Legend <a href="#" class="reset-filters label label-default hidden">Reset</a></h3>
			<div class="list-group-item">Mine <span class="floatright glyphicon glyphicon-star"></span></div>
			<a href="#" data-type="<?php echo Product::TASK_STATUS_AVAILABLE; ?>" class="list-group-item">Available <span class="floatright status-circle btn-success"></span></a>
			<a href="#" data-type="<?php echo Product::TASK_STATUS_UNAVAILABLE; ?>" class="list-group-item">Servicing (external) <span class="floatright status-circle btn-danger"></span></a>
			<a href="#" data-type="<?php echo Product::TASK_STATUS_MAINTENANCE; ?>" class="list-group-item">Servicing (internal) <span class="floatright status-circle btn-warning"></span></a>
			<a href="#" data-type="<?php echo Product::TASK_STATUS_INVALID; ?>" class="list-group-item">Won't Fix <span class="floatright status-circle btn-invalid"></span></a>
			<a href="#" data-type="<?php echo Product::TASK_STATUS_COMPLETE; ?>" class="list-group-item">Maintenance <span class="floatright status-circle btn-info"></span></a>
		</div>
	</aside>

	<aside class="module">
		<div class="list-group user-list">
			<?php if(array_has_values($users) > 0): ?>
				<h3 class="list-group-item user-filter-header">Created By <a href="#" class="reset-filters label label-default hidden">Reset</a></h3>
				<?php for($i = 0; $i < sizeof($users); $i++): ?>
					<a href="#" data-user="<?php echo $users[$i]->userid; ?>" class="list-group-item user-createdby-list"><?php echo $users[$i]->username; ?> <span class="all badge"><?php echo $users[$i]->count; ?></span></a>
				<?php endfor; ?>
			<?php endif; ?>
			
			<?php if(array_has_values($assignee_users)): ?>
				<h3 class="list-group-item user-assignee-filter-header">Assignee <a href="#" class="reset-filters label label-default hidden">Reset</a></h3>
				<?php for($i = 0; $i < sizeof($assignee_users); $i++): ?>
					<a href="#" data-user="<?php echo $assignee_users[$i]->userid; ?>" class="list-group-item user-assignee-list"><?php echo $assignee_users[$i]->username; ?> <span class="all badge"><?php echo $assignee_users[$i]->count; ?></span></a>
				<?php endfor; ?>
			<?php endif; ?>

			<?php if(array_has_values($devices)): ?>
				<h3 class="list-group-item device-filter-header">Filter by Device <a href="#" class="reset-filters label label-default hidden">Reset</a></h3>
				<?php for($i = 0; $i < sizeof($devices); $i++): ?>
					<a href="#" data-device="<?php echo $devices[$i]->device_id; ?>" class="list-group-item devices-list"><?php echo $devices[$i]->name; ?> <span class="all badge"><?php echo $devices[$i]->count; ?></span></a>
				<?php endfor; ?>
			<?php endif; ?>
		</div>
	</aside>
</section>
