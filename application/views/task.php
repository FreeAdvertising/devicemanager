<div class="row">
	<div class="col-md-4 meta-category">
		<h3 class="dotted">Category Meta</h3>
		<div class="list-group">
			<li class="list-group-item">%CATEGORY%</li>
		</div>
	</div>

	<div class="col-md-4 meta-device">
		<h3 class="dotted">Device Meta</h3>
		<div class="list-group">
			<li class="list-group-item">%DEVICE__META%</li>
			<li class="list-group-item">%DEVICE__META%</li>
			<li class="list-group-item">%DEVICE__META%</li>
		</div>
	</div>

	<div class="col-md-4 meta-task">
		<h3 class="dotted">Task Meta</h3>
		<div class="list-group">
			<li class="list-group-item">Assignee: <?php echo $this->product->getUser($record->assignee)->name; ?></li>
			<li class="list-group-item">Created By: <?php echo $this->product->getUser($record->created_by)->name; ?></li>
			<li class="list-group-item">Created on <?php echo $this->product->convertMySQLDate($record->date); ?></li>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12 description">
		<p class="well well-lg"><?php echo nl2br($record->description); ?></p>
	</div>
</div>

<div class="row">
	<div class="col-md-12 comment-update-history">
		<p>Comment/update history</p>
	</div>
</div>
