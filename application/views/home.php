		<!-- Category meta data -->
		<?php if(isset($category)): ?>
			<div class="category-meta alert alert-info">
				<?php if(false === is_null($category->name)): ?>
					<h2 class="title"><?php echo $category->name; ?></h2>
				<?php endif; ?>
				<?php if(false === is_null($category->desc)): ?>
					<p class="description"><?php echo $category->desc; ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		
		<!-- Filtering -->
		<div class="input-group filter-group">
			<input type="text" class="form-control search input-lg" placeholder="Filter..." />	
			<div class="input-group-btn">
				<button class="btn btn-default btn-lg dropdown-toggle" data-toggle="dropdown"><span class="filter-var">Client</span> <span class="caret"></span></button>
				<ul class="dropdown-menu pull-right filter-cols"><li><a href="#">Loading...</a></li></ul>
			</div>
		</div>

		<!-- Data output -->
		<table width="100%" class="table table-striped table-hover output">
			<thead>
				<tr>
					<th width="24px"></th>
					<th width="20%" id="client" class="success">Client / Vendor</th>
					<th width="20%" id="username">Username</th>
					<th width="30%">Password</th>
					<th class="hidden-xs" width="20%" id="domain">Domain</th>
					<th class="hidden-xs" width="1%" id="host">Host</th>
				</tr>
			</thead>

			<?php if(sizeof($records) > 0): ?>
				<?php for($i = 0; $i < sizeof($records); $i++): ?>
					<tr class="<?php echo (isset($records[$i]->colour) ? 'has-colour' : 'no-colour'); ?>" data-colour="<?php echo (isset($records[$i]->colour) ? $records[$i]->colour : '#ffffff'); ?>">
						<td width="1%"><?php echo ($i+1); ?></td>
						<td data-col="client" width="20%">
							<?php echo anchor(sprintf("/edit/id/%d", $records[$i]->record_id), $records[$i]->name, array("class" => "name")); ?>
							<?php if($records[$i]->desc): ?>
								<p class="desc"><?php echo $records[$i]->desc; ?></p>
							<?php endif; ?>
						</td>
						<td data-col="username" width="20%"><?php echo truncate($records[$i]->username); ?></td>
						<td width="30%"><input type="text" class="password form-control" disabled="disabled" value="<?php echo $records[$i]->password; ?>" /> <div class="btn-group actions"><a class="btn btn-primary btn-xs view"><span class="glyphicon glyphicon-refresh"></span></a><a class="btn btn-primary btn-xs clipboard" data-toggle="modal" data-target="#copied-to-clipboard"><span class="glyphicon glyphicon-tower"></span></a></div></td>
						<td class="hidden-xs" data-col="domain" width="20%"><?php echo make_external_link($records[$i]->domain); ?></td>
						<td class="hidden-xs" data-col="host" width="1%"><?php echo $records[$i]->host; ?></td>
					</tr>
				<?php endfor; ?>
			<?php else : ?>
				<tr>
					<td colspan="6">You have not added any passwords yet</td>
				</tr>
			<?php endif; ?>
		</table>