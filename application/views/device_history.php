<div class="col-md-12">
	<div class="tab_content tab_overview">
		<h3>Overview</h3>
		<p class="alert alert-info">Information in this table is sorted by date descending so the latest updates are always at the top.  It is limited to 100 results by default.</p>

		<table class="table table-striped table-hover">
			<thead>
				<th width="1"></th>
				<th width="33%">Action</th>
				<th width="53%">Performed By</th>
				<th width="13%">Date</th>
			</thead>
			<tbody>
				<?php 
					$history["overview"]->loop(function($parent, $oos){
						$ci = $oos->indexOf(0);
						
						$parent->data->loop(function($item, $oos){
							?>
						<tr>
							<td><?php echo 1; ?></td>
							<td><?php echo $item->data->action; ?></td>
							<td><?php echo $item->data->username; ?></td>
							<td><?php echo $ci->product->convertMySQLDate($item->data->date); ?></td>
						</tr>
						<?php //$c++; ?>
					<?php }, array($ci)); ?>
				<?php }, array($this)); ?>
			</tbody>
		</table>
	</div>

	<div class="tab_content tab_recent_owners">
		<h3>Recent Owners</h3>

		<table class="table table-striped table-hover">
			<thead>
				<th width="33%">User</th>
				<th>Date</th>
			</thead>
			<tbody>
				<?php for($i = 0; $i < sizeof($history["recent_owners"]); $i++): ?>
					<tr>
						<td><?php echo $history["recent_owners"][$i]->username; ?></td>
						<td><?php echo $this->product->convertMySQLDate($history["recent_owners"][$i]->date); ?></td>
					</tr>
				<?php endfor; ?>
			</tbody>
		</table>
	</div>

	<div class="tab_content tab_maintenance">
		<h3>Maintenance</h3>

		<table class="table table-striped table-hover">
			<thead>
				<th width="1"></th>
				<th width="60%">Task Name</th>
				<th>Created By</th>
				<th>Assigned To</th>
				<th>Status</th>
			</thead>
			<tbody>
				<?php for($i = 0; $i < sizeof($history["maintenance"]); $i++): ?>
					<tr data-location="<?php echo $history["maintenance"][$i]->created_by; ?>" data-status="<?php echo $history["maintenance"][$i]->status; ?>">
						<td><?php echo ($i+1); ?></td>
						<td><?php echo anchor(sprintf("/task/id/%d", $history["maintenance"][$i]->task_id), truncate($history["maintenance"][$i]->description), array("title" => "View task details")); ?></td>
						<td><?php echo $this->product->getUser($history["maintenance"][$i]->created_by)->name; ?></td>
						<td><?php echo $this->product->getUser($history["maintenance"][$i]->assignee)->name; ?></td>
						<td><span class="status-circle btn-<?php echo $this->product->get_task_status($history["maintenance"][$i]->status); ?>"></span></td>
					</tr>
				<?php endfor; ?>
			</tbody>
		</table>
	</div>
</div>