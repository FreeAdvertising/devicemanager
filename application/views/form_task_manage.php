<div class="col-md-12">
	<?php echo form_open(sprintf("%stask/do_manage_task", $nav_path), array("role" => "form")); ?>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Manage Task</h4>
				</div>
				
				<div class="modal-body">
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

					<div class="form-group">
						<label for="assignee">Assignee [# of tasks currently assigned]</label>
						<select name="assignee" id="assignee" class="form-control">
							<?php for($i = 0; $i < sizeof($users); $i++): ?>
								<?php if($record->assignee == $users[$i]->userid): ?>
									<option value="<?php echo $users[$i]->userid; ?>" selected="selected"><?php echo sprintf("%s [%d]", $users[$i]->username, $users[$i]->count); ?></option>
								<?php else : ?>
									<option value="<?php echo $users[$i]->userid; ?>"><?php echo sprintf("%s [%d]", $users[$i]->username, $users[$i]->count); ?></option>
								<?php endif; ?>
							<?php endfor; ?>
						</select>
					</div>

					<div class="form-group">
						<label for="status">Status</label>
						<select name="status" id="status" class="form-control">
							<option 
								value="<?php echo Product::TASK_STATUS_AVAILABLE; ?>"
								<?php echo ($record->status == Product::TASK_STATUS_AVAILABLE ? 'selected="selected"' : ''); ?>>
								Available
							</option>

							<option 
								value="<?php echo Product::TASK_STATUS_UNAVAILABLE; ?>" 
								<?php echo ($record->status == Product::TASK_STATUS_UNAVAILABLE ? 'selected="selected"' : ''); ?>>
								Unavailable
							</option>

							<option 
								value="<?php echo Product::TASK_STATUS_MAINTENANCE; ?>" 
								<?php echo ($record->status == Product::TASK_STATUS_MAINTENANCE ? 'selected="selected"' : ''); ?>>
								Servicing
							</option>

							<option 
								value="<?php echo Product::TASK_STATUS_INVALID; ?>" 
								<?php echo ($record->status == Product::TASK_STATUS_INVALID ? 'selected="selected"' : ''); ?>>
								Invalid
							</option>

							<option 
								value="<?php echo Product::TASK_STATUS_COMPLETE; ?>" 
								<?php echo ($record->status == Product::TASK_STATUS_COMPLETE ? 'selected="selected"' : ''); ?>>
								Complete
							</option>
						</select>
					</div>

					<input type="hidden" name="task_id" value="<?php echo $record->task_id; ?>" />
					<input type="hidden" name="uuid" value="<?php echo $record->uuid; ?>" />
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<input type="submit" value="Save Changes" class="btn btn-primary" />
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	<?php echo form_close(); ?>
</div>