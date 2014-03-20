<section class="main col-md-9">
	<div class="row">
		<table class="table list-devices">
			<thead>
				<th width="85%">Device UUID</th>
				<th>Apps</th>
				<th>OS</th>
			</thead>
			<tbody>
				<tr>
					<td><a href="#">Test</a></td>
					<td><?php echo anchor("/device/_ID_/apps", "View"); ?></td>
					<td>{ICON}</td>
				</tr>
				<tr>
					<td><a href="#">Test</a></td>
					<td><?php echo anchor("/device/_ID_/apps", "View"); ?></td>
					<td>{ICON}</td>
				</tr>
				<tr>
					<td><a href="#">Test</a></td>
					<td><?php echo anchor("/device/_ID_/apps", "View"); ?></td>
					<td>{ICON}</td>
				</tr>
				<tr>
					<td><a href="#">Test</a></td>
					<td><?php echo anchor("/device/_ID_/apps", "View"); ?></td>
					<td>{ICON}</td>
				</tr>
				<tr>
					<td><a href="#">Test</a></td>
					<td><?php echo anchor("/device/_ID_/apps", "View"); ?></td>
					<td>{ICON}</td>
				</tr>
				<tr>
					<td><a href="#">Test</a></td>
					<td><?php echo anchor("/device/_ID_/apps", "View"); ?></td>
					<td>{ICON}</td>
				</tr>
			</tbody>
		</table>
	</div>
</section>

<section class="sidebar col-md-3">
	<aside class="module">
		<div class="list-group user-list">
			<h3 class="list-group-item">Filter by User <a href="#" class="reset-filters label label-default hidden">Reset</a></h3>
			<?php for($i = 0; $i < sizeof($users); $i++): ?>
				<a href="#" class="list-group-item"><?php echo $users[$i]->username; ?> <span class="all badge">0</span></a>
			<?php endfor; ?>
		</div>
	</aside>
</section>
