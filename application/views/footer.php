					</div>
		
				<div class="panel-footer">
					&copy; <?php echo date("Y"); ?> Free
					<?php if(IS_DEV): ?>
						<span class="pull-right local-version">current: <span class="commit"><?php echo show_git_status(); ?></span></span>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<script type="text/javascript">
			var FP = function(){
				this.ajax_url = "<?php echo base_url(); ?>";

				this.init();
			};
		</script>

		<!-- Text copied to clipboard modal -->
		<div class="modal fade in" id="copied-to-clipboard" tabindex="-1" role="dialog" aria-labelledby="copied-to-clipboard" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Copied to Clipboard</h4>
			  </div>
			  <div class="modal-body">
				Password <span class="copied-password">{PASS}</span> copied to the clipboard.
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<!-- Password generation error modal -->
		<div class="modal fade in generatepw-error" id="generatepw-error" tabindex="-1" role="dialog" aria-labelledby="generatepw-error" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Password Generation Error</h4>
			  </div>
			  <div class="modal-body">
				Sorry, the password service is unavailable right now.  Please try again, or use a different service.  Or write your own!
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<!-- Preferences modal -->
		<div class="modal fade in preferences-modal" id="preferences-modal" tabindex="-1" role="dialog" aria-labelledby="preferences-modal" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">FreePass Preferences</h4>
			  </div>
			  <div class="modal-body">
				<div class="checkbox">
					<label for="highlight_table">
						<input type="checkbox" name="highlight_table" id="highlight_table" /> Highlight selected filter column
					</label>					
				</div>
				<div class="form-group">
					<label for="default-filter">Default column filter</label>
					<select class="form-control default-filter"></select>
				</div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<!-- Status page show headers modal -->
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
	<!--<script type="text/javascript" src="<?php echo sprintf("%s/zeroclipboard/ZeroClipboard.min.js", $template_path); ?>"></script>-->
	<script type="text/javascript" src="<?php echo sprintf("%s/bootstrap/js/freepass.js", $template_path); ?>"></script>
	<script type="text/javascript" src="<?php echo sprintf("%s/bootstrap/js/custom.js", $template_path); ?>"></script>
	<script type="text/javascript" src="<?php echo sprintf("%s/bootstrap/js/bootstrap-colorpicker.min.js", $template_path); ?>"></script>
</html>