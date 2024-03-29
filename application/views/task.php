	<div class="col-md-4 meta-category">
		<table class="table table-striped">
			<thead>
				<th width="50%">Categories</th>
			</thead>
			<tbody>
				<?php if(sizeof($record->categories) > 0): ?>
					<?php for($i = 0; $i < sizeof($record->categories); $i++): ?>
						<tr>
							<td><?php echo $record->categories[$i]->name; ?></td>
						</tr>
					<?php endfor; ?>
				<?php else : ?>
					<tr>
						<td>No categories associated.</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	<div class="col-md-4 meta-device">
		<table class="table table-striped">
			<thead>
				<th width="50%"><?php echo anchor(sprintf("/device/%s", $record->uuid), "Device Meta"); ?></th>
				<th width="50%"></th>
			</thead>
			<tbody>
				<tr>
					<td>RAM</td>
					<td><?php echo $this->product->get_ram($record->meta_ram); ?>GB</td>
				</tr>
				<tr>
					<td>HDD</td>
					<td><?php echo $this->product->get_hdd($record->meta_hdd); ?>GB</td>
				</tr>
				<tr>
					<td>TYPE</td>
					<td><?php echo $this->product->get_type($record->meta_type); ?></td>
				</tr>
				<tr>
					<td>OS</td>
					<td><?php echo $this->product->get_os($record->os); ?></td>
				</tr>
				<tr>
					<td>UUID</td>
					<td><?php echo $record->uuid; ?></td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="col-md-4 meta-task">
		<table class="table table-striped">
			<thead>
				<th width="50%">Task Meta</th>
				<th width="50%"></th>
			</thead>
			<tbody>
				<tr>
					<td>Assignee</td>
					<td><?php echo $this->product->getUser($record->assignee)->name; ?></td>
				</tr>
				<tr>
					<td>Created By</td>
					<td><?php echo $this->product->getUser($record->created_by)->name; ?></td>
				</tr>
				<tr>
					<td>Created On</td>
					<td><?php echo $this->product->convertMySQLDate($record->date); ?></td>
				</tr>
				<tr>
					<td>Current Status</td>
					<td><span class="status-circle floatleft btn-<?php echo $this->product->get_task_status($record->status); ?>"></span></td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="col-md-12 description">
		<h3 class="dotted">Description of Problem</h3>
		<p class="well well-lg"><?php echo nl2br($record->description); ?></p>
	</div>

	<div class="col-md-12 comment-update-history">
		<h3 class="dotted">Update History</h3>

		<table class="table table-striped">
			<thead>
				<th width="85%">Note</th>
				<th style="text-align: right;">Date</th>
			</thead>
			<tbody>
				<?php if(array_has_values($record->history)): ?>
					<?php for($i = 0; $i < sizeof($record->history); $i++): ?>
						<tr>
							<td><?php echo $record->history[$i]->value; ?></td>
							<td align="right"><?php echo $this->product->convertMySQLDate($record->history[$i]->date); ?></td>
						</tr>
					<?php endfor; ?>
				<?php else : ?>
					<tr>
						<td colspan="2">No updates or comments yet.</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

<?php if($record->can_edit == 1 || $this->hydra->isAdmin()): ?>
	<div class="col-md-12">
		<div class="form-footer">
			<button class="btn btn-primary edit">Edit Task</button>
			<button class="btn btn-link task-back">Back</button>

			<?php if($this->hydra->isAdmin()): ?>
				<button class="btn btn-default manage-task pull-left" data-toggle="modal" data-target=".manage" href="/task/manage/<?php echo $record->task_id; ?>">Manage</button>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>

<!-- Management Modal container-->
<div class="manage modal fade"></div>
