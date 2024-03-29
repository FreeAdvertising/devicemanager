<!doctype html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="<?php echo sprintf("%s/bootstrap/css/bootstrap.min.css", $template_path); ?>" />
		<link rel="stylesheet" href="<?php echo sprintf("%s/bootstrap/css/bootstrap-theme.min.css", $template_path); ?>" />
		<link rel="stylesheet" href="<?php echo sprintf("%s/bootstrap/css/bootstrap-colorpicker.min.css", $template_path); ?>" />
		<link rel="stylesheet" href="<?php echo sprintf("%s/bootstrap/css/custom.css", $template_path); ?>" />

		<title><?php echo $this->hydra->get("product_name"); ?> | <?php echo $this->hydra->get("company_name"); ?></title>
	</head>
	<body>
		<div class="container">
			<?php if(false === IS_DEV): ?>
				<header class="navbar navbar-default navbar-fixed-top" role="navigation">
			<?php else : ?>
				<header class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<?php endif; ?>
				<div class="navbar-header">
					<a class="navbar-brand" href="<?php echo base_url(); ?>">
						<span class="glyphicon glyphicon-heart"></span> <?php echo $this->hydra->get("product_name");?> <span class="label label-danger" style="margin-left: 5px;">Beta</span>
					</a>
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>

				<?php if($this->hydra->isAuthenticated()): ?>
					<nav class="collapse navbar-collapse" id="main-nav">
						<ul class="nav navbar-nav">
							<li class="<?php echo ($page == "" ? 'active"' : ''); ?>"><?php echo anchor("/", "Dashboard"); ?></li>

							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Devices & Apps <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li class="<?php echo ($page == "devices" ? 'active"' : ''); ?>"><?php echo anchor("/devices", "View Devices"); ?></li>
									<li class="<?php echo ($page == "tracked_applications" ? 'active"' : ''); ?>"><?php echo anchor("/tracked_applications", "View Tracked Apps"); ?></li>
								</ul>
							</li>

							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Tasks <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li class="<?php echo ($page == "tasks" ? 'active"' : ''); ?>"><?php echo anchor("/tasks", "View Tasks"); ?></li>
									<li class="<?php echo ($page == "my_tasks" ? 'active"' : ''); ?>"><?php echo anchor("/my_tasks", "My Tasks"); ?></li>
									<li class="divider"></li>
									<li class="<?php echo ($page == "task" && $subpage == "add" ? 'active"' : ''); ?>"><?php echo anchor("/task/add", "Add New"); ?></li>
								</ul>
							</li>
							<!--<li class="<?php echo ($page == "reservations" ? 'active"' : ''); ?>"><?php echo anchor("/reservations", "Reservations"); ?></li>-->

							<?php if($this->hydra->isAdmin()): ?>
								<li class="dropdown">
							 		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Administration <b class="caret"></b></a>
							 		<ul class="dropdown-menu">
							 			<li class="<?php echo ($page == "add_device" ? 'active"' : ''); ?>"><?php echo anchor("/add_device", "Add Device"); ?></li>
							 			<li class="<?php echo ($page == "add_application" ? 'active"' : ''); ?>"><?php echo anchor("/add_application", "Add Application"); ?></li>
							 			<li class="<?php echo ($page == "add_task_category" ? 'active"' : ''); ?>"><?php echo anchor("/add_task_category", "Add Task Category"); ?></li>
							 			<li class="divider"></li>
							 			<li class="<?php echo ($page == "manage_devices" ? 'active"' : ''); ?>"><?php echo anchor("/manage_devices", "Manage Devices"); ?></li>
							 			<li class="<?php echo ($page == "users" ? 'active"' : ''); ?>"><?php echo anchor("/users", "Manage Users"); ?></li>
							 		</ul>
								</li>
							<?php endif; ?>
						</ul>

						<ul class="nav navbar-nav navbar-right">
							<li class="<?php echo ($page == 'help' ? 'active' : ''); ?>"><?php echo anchor("/help", "Help"); ?></li>
							<?php if(false === $this->hydra->isAdmin()): ?>
								<li><a href="mailto:ryan@wearefree.ca?Subject=Feedback">Feedback</a></li>
							<?php endif; ?>
						</ul>
					 	
					 	<?php echo anchor("/logout", "Logout", array("class" => "btn btn-default navbar-right logout navbar-btn")); ?>
					</nav>
				<?php endif; ?>
			</header>
			<div class="jumbotron">
				 <h1><?php echo $this->hydra->get("company_name"); ?></h1>
			</div>

			<div class="panel panel-default">
				<?php if($this->hydra->isAuthenticated()): ?>
					<div class="panel-heading clearfix">
						<?php switch($page){
								case "": ?>
								<h3 class="panel-title">Welcome back, <span class="user"><?php echo $this->hydra->get("name"); ?></span></h3>
								<p class="small overview">There are currently <abbr title="(# active checkouts)"><?php echo $data[0]; ?></abbr> user(s) using <abbr title="(# checked out devices)"><?php echo $data[1]; ?></abbr> device(s) and <abbr title="(# people on reservation list)"><?php echo $data[2]; ?></abbr> waiting.</p>
								
							<?php break; ?>

							<?php case "devices": ?>
								<h4 class="panel-title">Check In or Out</h4>
								<p class="small overview">Sign out a new device or return one you already have.</p>
							<?php break; ?>

							<?php case "reservations": ?>
								<h4 class="panel-title">Reserve a Device</h4>
								<p class="small overview">Is someone else using a device you need?  Reserve it so they know who to pass it on to.</p>
							<?php break; ?>

							<?php case "add_device": ?>
								<h4 class="panel-title">Add New Device</h4>
								<p class="small overview">Add a new device to the database.</p>
							<?php break; ?>

							<?php case "add_application": ?>
								<h4 class="panel-title">Add Application</h4>
								<p class="small overview">Add to the list of tracked applications users can choose from when associating applications to devices.</p>
							<?php break; ?>

							<?php case "manage_devices": ?>
								<h4 class="panel-title">Manage Devices</h4>
								<p class="small overview">View and modify information about all devices and applications tracked by the system.</p>
							<?php break; ?>

							<?php case "tracked_applications": ?>
								<h4 class="panel-title">Tracked Applications</h4>
								<p class="small overview">All apps tracked by the system.</p>
							<?php break; ?>

							<?php case "user": ?>
								<?php if($subpage == "edit"): ?>
									<h4 class="panel-title">User Information</h4>
									<p class="small overview">Edit user details.</p>
								<?php endif; ?>
							<?php break; ?>

							<?php case "users": ?>
								<h4 class="panel-title">User Information</h4>
								<p class="small overview">Choose a user from the list to modify them or click the appropriate button to reset their password/secret question answer.</p>
							<?php break; ?>

							<?php case "tasks": ?>
								<?php if($subpage == ""): ?>
									<h4 class="panel-title">Maintenance Tasks</h4>
									<p class="small overview">Active tasks on any device.</p>
								<?php endif; ?>
							<?php break; ?>

							<?php case "my_tasks": ?>
								<?php if($subpage == ""): ?>
									<h4 class="panel-title">My Maintenance Tasks</h4>
									<p class="small overview">Maintenance tasks which you have created, or tasks that have been assigned to you.</p>
								<?php endif; ?>
							<?php break; ?>

							<?php case "task": ?>
								<?php if($subpage == "add"): ?>
									<h4 class="device-title panel-title">New Task</h4>
								<?php endif; ?>

								<?php if($subpage == "id"): ?>
									<h4 class="device-title panel-title">View Task <span class="label label-default floatright">#<?php echo $this->uri->segment(3); ?></span> </h4>
								<?php endif; ?>

								<?php if($subpage == "edit"): ?>
									<h4 class="device-title panel-title">Edit Task <span class="label label-default floatright">#<?php echo $this->uri->segment(3); ?></span> </h4>
								<?php endif; ?>
							<?php break; ?>

							<?php case "add_task_category" : ?>
								<h4 class="device-title panel-title">New Task Category</h4>
								<p class="small overview">Create categories which can be used to organize and filter tasks.</p>
							<?php break; ?>

							<?php case "device": ?>
								<?php if($subpage == ""): ?>
									<h4 class="device-title panel-title"><?php echo $device_info->device_name; ?> <span class="label label-default floatright">#<?php echo $device_info->device_id; ?></span> </h4>
								<?php endif; ?>

								<?php if($subpage == "history"): ?>
									<ul class="nav nav-pills faux-tabs pull-left">
										<li class="active"><a href="#overview" id="overview">Overview</a></li>
										<li><a href="#recent_owners" id="recent_owners">Recent Owners</a></li>
										<li><a href="#maintenance" id="maintenance">Maintenance</a></li>
									</ul>
								<?php endif; ?>

								<?php if($subpage == "add_application"): ?>
									<h4 class="floatleft">Add Tracked Application</h4>
								<?php endif; ?>

								<?php if($subpage == "edit"): ?>
									<h4 class="floatleft">Edit Device UUID:<?php echo $device_info->uuid; ?></h4>
								<?php endif;?>

								<?php if($subpage == "apps"): ?>
									<div class="pull-left">
										<h4 class="device-title panel-title">Installed Applications on UUID:<?php echo $this->uri->segment(2); ?></h4>
										<p class="small overview">Note: this does not include ALL applications, only those in the <?php echo anchor("/tracked_applications", "tracked applications", array("target" => "_blank")); ?> list.</p>
									</div>
								<?php endif;?>

								<?php if($subpage == "add_task"): ?>
									<h4 class="floatleft">Add Task to Device UUID:<?php echo $device_uuid; ?></h4>
								<?php endif;?>								
							<?php break; ?>
						<?php } ?>

						<?php if(isset($show_pagination) && $show_pagination): ?>
							<ul class="pagination nav nav-pills pull-right">
								<li><?php echo anchor(sprintf("/device/%s", $this->uri->segment(2)), "&larr; Back"); ?></li>
							</ul>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<div class="panel-body">			