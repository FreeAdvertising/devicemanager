<div class="tab_content tab_overview">
	<h3>Device History - Overview</h3>
	<p class="alert alert-info">Information in this table is sorted by date descending so the latest updates are always at the top.  It is limited to 100 results by default.</p>

	<table class="table table-striped table-hover">
		<thead>
			<th width="33%">Action</th>
			<th width="53%">Performed By</th>
			<th width="13%">Date</th>
		</thead>
		<tbody>
			<?php for($i = 0; $i < sizeof($history["overview"]); $i++): ?>
				<tr>
					<td><?php echo $history["overview"][$i]->action; ?></td>
					<td><?php echo $history["overview"][$i]->username; ?></td>
					<td><?php echo $history["overview"][$i]->date; ?></td>
				</tr>
			<?php endfor; ?>
		</tbody>
	</table>
</div>

<div class="tab_content tab_recent_owners">
	<h3>Device History - Recent Owners</h3>

	<table class="table table-striped table-hover">
		<thead>
			<th width="33%">User</th>
			<th>Date</th>
		</thead>
		<tbody>
			<?php for($i = 0; $i < sizeof($history["recent_owners"]); $i++): ?>
				<tr>
					<td><?php echo $history["recent_owners"][$i]->username; ?></td>
					<td><?php echo $history["recent_owners"][$i]->date; ?></td>
				</tr>
			<?php endfor; ?>
		</tbody>
	</table>
</div>

<div class="tab_content tab_maintenance">
	<h3>Device History - Maintenance</h3>

	<table class="table table-striped table-hover">
		<thead>
			<th width="33%">Action</th>
			<th width="53%">Performed By</th>
			<th width="13%">Date</th>
		</thead>
		<tbody>
			<?php for($i = 0; $i < sizeof($history["maintenance"]); $i++): ?>
				<tr>
					<td><?php echo $history["maintenance"][$i]->action; ?></td>
					<td><?php echo $history["maintenance"][$i]->user->name; ?></td>
					<td><?php echo $history["maintenance"][$i]->record->date; ?></td>
				</tr>
			<?php endfor; ?>
		</tbody>
	</table>
</div>