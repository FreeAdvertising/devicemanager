<div class="col-md-12">
	<table class="table table-striped table-hover">
		<thead>
			<th>Name</th>
			<th>Version</th>
			<th>ID</th>
		</thead>
		<tbody>
			<?php for($i = 0; $i < sizeof($apps); $i++): ?>
				<tr>
					<td><?php echo $apps[$i]->name; ?></td>
					<td><?php echo $apps[$i]->version; ?></td>
					<td><?php echo $apps[$i]->app_id; ?></td>
				</tr>
			<?php endfor; ?>
		</tbody>
	</table>
</div>