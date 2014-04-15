		<!-- Filtering -->
		<div class="input-group filter-group">
			<input type="text" class="form-control search input-lg" placeholder="Filter..." />	
			<div class="input-group-btn">
				<button class="btn btn-default btn-lg dropdown-toggle" data-toggle="dropdown"><span class="filter-var">User</span> <span class="caret"></span></button>
				<ul class="dropdown-menu pull-right filter-cols"><li><a href="#">Loading...</a></li></ul>
			</div>
		</div>

		<!-- Data output -->
		<table width="100%" class="table table-striped table-hover output">
			<thead>
				<tr>
					<th width="24px"></th>
					<th width="20%" id="user" class="success">User</th>
					<th width="50%"></th>
					<th width="20%" id="valid">Secret Question Status</th>
				</tr>
			</thead>

			<?php if(sizeof($records) > 0): ?>
				<?php for($i = 0, $records = $list["users"]; $i < sizeof($records); $i++): ?>
					<tr data-id="<?php echo $records[$i]->userid; ?>">
						<td width="1%"><?php echo ($i+1); ?></td>
						<td data-col="user" width="20%">
							<?php echo anchor(sprintf("/user/edit/%d", $records[$i]->userid), $records[$i]->name, array("class" => "name")); ?>
							<p class="desc g-<?php echo $records[$i]->group_name; ?>"><?php echo $records[$i]->group_name; ?></p>
						</td>
						<td>
							<button class="btn btn-default btn-xs reset-pw">Reset Password</button>
							<button class="btn btn-default btn-xs reset-secret-question">Reset Secret Question</button>
						</td>
						<?php if($records[$i]->is_reset == 0 && $records[$i]->secret_question_answer != ""): ?>
							<td data-col="valid">
								<span class="label label-success">Good</span>
							</td>
						<?php else: ?>
							<td data-col="invalid">
								<span class="label label-warning">Warning</span>
							</td>
						<?php endif; ?>
					</tr>
				<?php endfor; ?>
			<?php else : ?>
				<tr>
					<td colspan="3">You have not added any passwords yet</td>
				</tr>
			<?php endif; ?>
		</table>

		<table width="100%" class="table table-striped table-hover quarantine">
			<thead>
				<tr>
					<th width="24px"></th>
					<th width="20%" id="user" class="success">User</th>
					<th width="50%"></th>
					<th width="20%" id="valid">Secret Question Status</th>
				</tr>
			</thead>

			<?php if(sizeof($records) > 0): ?>
				<?php for($i = 0, $records = $list["quarantined"]; $i < sizeof($records); $i++): ?>
					<tr data-id="<?php echo $records[$i]->userid; ?>">
						<td width="1%"><?php echo ($i+1); ?></td>
						<td data-col="user" width="20%">
							<?php echo anchor(sprintf("/user/qedit/%d", $records[$i]->userid), $records[$i]->name, array("class" => "name")); ?>
							<p class="desc g-<?php echo $records[$i]->group_name; ?>"><?php echo $records[$i]->group_name; ?></p>
						</td>
						<td>
							<button class="btn btn-default btn-xs reset-pw">Reset Password</button>
							<button class="btn btn-default btn-xs reset-secret-question">Reset Secret Question</button>
						</td>
						<?php if($records[$i]->is_reset == 0 && $records[$i]->secret_question_answer != ""): ?>
							<td data-col="valid">
								<span class="label label-success">Good</span>
							</td>
						<?php else: ?>
							<td data-col="invalid">
								<span class="label label-warning">Warning</span>
							</td>
						<?php endif; ?>
					</tr>
				<?php endfor; ?>
			<?php else : ?>
				<tr>
					<td colspan="3">You have not added any passwords yet</td>
				</tr>
			<?php endif; ?>
		</table>