<section class="main col-md-12">
	<div class="row">
		<h4>Filters <a href="#" class="reset-filters label label-default hidden">Reset</a></h4>
		<div class="btn-group filters">
			<button type="button" class="btn btn-success success" style="width: 25%">Available</button>
			<button type="button" class="btn btn-info info" style="width: 25%">Maintenance</button>
			<button type="button" class="btn btn-danger danger" style="width: 25%">Checked Out</button>
			<button type="button" class="btn btn-warning warning " style="width: 25%">Reserved</button>
		</div>

		<table class="table list-devices">
			<thead>
				<th width="85%">Device (UUID)</th>
				<th>Status</th>
				<th>OS</th>
			</thead>
			<tbody>
				<?php for($i = 0; $i < sizeof($records); $i++): ?>
					<?php $status = $this->product->get_status($records[$i]); ?>
					<tr id="d<?php echo $records[$i]->device_id; ?>">
						<td><?php echo anchor(sprintf("/device/%s", strtoupper($records[$i]->uuid)), sprintf("%s (%s)", $records[$i]->name, $records[$i]->uuid)); ?></td>
						<td><span class="status-circle <?php echo sprintf('alert-%s %s', $status, $status); ?>"></span></td>
						<td><?php echo $this->product->get_os($records[$i]->os); ?></td>
					</tr>
				<?php endfor; ?>
			</tbody>
		</table>
	</div>
</section>