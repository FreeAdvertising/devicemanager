<!-- Errors -->
<?php if($this->session->flashdata("model_save_success")): ?>
	<div class="alert alert-success">
		<?php echo $this->session->flashdata("model_save_success"); ?>
	</div>
<?php endif; ?>

<?php if($this->session->flashdata("model_save_fail")): ?>
	<div class="alert alert-danger">
		<?php echo $this->session->flashdata("model_save_fail"); ?>
	</div>
<?php endif; ?>

<!-- Data output -->
<?php if(array_has_values($list["quarantined"])): ?>
	<h3 class="dotted">Users Requesting Registration</h3>
	<table width="100%" class="table table-striped quarantine">
		<thead>
			<tr>
				<th width="24px"></th>
				<th width="20%">User</th>
				<th width="50%"></th>
			</tr>
		</thead>

		<?php if(sizeof($records) > 0): ?>
			<?php for($i = 0, $records = $list["quarantined"]; $i < sizeof($records); $i++): ?>
				<tr data-id="<?php echo $records[$i]->userid; ?>">
					<td width="1%"><?php echo ($i+1); ?>. </td>
					<td data-col="user" width="20%">
						<?php echo anchor(sprintf("/user/qedit/%d", $records[$i]->userid), $records[$i]->name, array("class" => "name")); ?>
					</td>
					<td align="right">
						<div class="btn-group">
							<button class="btn btn-danger btn-md reject-user" data-quser="<?php echo $records[$i]->userid; ?>">Reject</button>
							<button class="btn btn-default btn-md approve-user" data-quser="<?php echo $records[$i]->userid; ?>">Approve</button>
						</div>
					</td>
				</tr>
			<?php endfor; ?>
		<?php else : ?>
			<tr>
				<td colspan="3">You have not added any passwords yet</td>
			</tr>
		<?php endif; ?>
	</table>
<?php endif; ?>

<h3 class="dotted">Registered Users</h3>
<table width="100%" class="table table-striped output">
	<thead>
		<tr>
			<th width="24px"></th>
			<th width="20%">User</th>
			<th width="50%"></th>
			<th width="20%">Secret Question Status</th>
		</tr>
	</thead>

	<?php if(sizeof($records) > 0): ?>
		<?php for($i = 0, $records = $list["users"]; $i < sizeof($records); $i++): ?>
			<tr data-id="<?php echo $records[$i]->userid; ?>">
				<td width="1%"><?php echo ($i+1); ?>. </td>
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