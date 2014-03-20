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
					<tr>
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
		<div class="list-group user-list">
			<h3 class="list-group-item">Filter by User <a href="#" class="reset-filters label label-default hidden">Reset</a></h3>
			<?php for($i = 0; $i < sizeof($users); $i++): ?>
				<a href="#" class="list-group-item"><?php echo $users[$i]->username; ?> <span class="all badge"><?php echo $users[$i]->count; ?></span></a>
			<?php endfor; ?>
		</div>
	</aside>
</section>
