					</div>
		
				<div class="panel-footer">
					&copy; <?php echo date("Y"); ?> <?php echo $this->hydra->get("company_name"); ?>
					<?php if(IS_DEV): ?>
						<span class="pull-right local-version">current: <span class="commit"><?php echo show_git_status(); ?></span></span>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<script type="text/javascript">
			var Product = function(){
				this.ajax_url = "<?php echo base_url(); ?>";

				this.init();
			};
		</script>

		<!-- EXAMPLE MODAL -->
		<div class="modal fade in show-headers-modal" id="show-headers-modal" tabindex="-1" role="dialog" aria-labelledby="show-headers-modal" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Headers for <em>{{SITE}}</em></h4>
			  </div>
			  <div class="modal-body">
				
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</body>
	<script type="text/javascript" src="<?php echo sprintf("%s/bootstrap/js/jquery.min.js", $template_path); ?>"></script>
	<script type="text/javascript" src="<?php echo sprintf("%s/bootstrap/js/bootstrap.min.js", $template_path); ?>"></script>
	<script type="text/javascript" src="<?php echo sprintf("%s/bootstrap/js/devicemanager.js", $template_path); ?>"></script>
	<script type="text/javascript" src="<?php echo sprintf("%s/bootstrap/js/custom.js", $template_path); ?>"></script>
	<script type="text/javascript" src="<?php echo sprintf("%s/bootstrap/js/bootstrap-colorpicker.min.js", $template_path); ?>"></script>
</html>