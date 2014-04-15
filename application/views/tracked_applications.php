<table class="table table-striped table-hover">
	<thead>
		<th width="1"></th>
		<th width="30%">Name</th>
		<th>Description</th>
	</thead>
	<tbody>
		<?php for($i = 0; $i < sizeof($apps); $i++): ?>
			<tr>
				<td><?php echo ($i+1); ?>.</td>
				<td><?php echo $apps[$i]->name; ?></td>
				<td><?php echo $apps[$i]->description; ?></td>
			</tr>
		<?php endfor; ?>
	</tbody>
</table>