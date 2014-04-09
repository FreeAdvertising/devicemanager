<!doctype html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="<?php echo sprintf("%s/bootstrap/css/bootstrap.min.css", $template_path); ?>" />
		<link rel="stylesheet" href="<?php echo sprintf("%s/bootstrap/css/bootstrap-theme.min.css", $template_path); ?>" />
		<link rel="stylesheet" href="<?php echo sprintf("%s/bootstrap/css/bootstrap-colorpicker.min.css", $template_path); ?>" />
		<link rel="stylesheet" href="<?php echo sprintf("%s/bootstrap/css/custom.css", $template_path); ?>" />

		<title><?php echo $this->hydra->get("product_name"); ?> | Free Advertising</title>
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
							<li class="<?php echo ($page == "devices" ? 'active"' : ''); ?>"><?php echo anchor("/devices", "Check In/Out"); ?></li>
							<li class="<?php echo ($page == "tasks" ? 'active"' : ''); ?>"><?php echo anchor("/tasks", "Maintenance Tasks"); ?></li>
							<!--<li class="<?php echo ($page == "reservations" ? 'active"' : ''); ?>"><?php echo anchor("/reservations", "Reservations"); ?></li>-->

							<?php if($this->hydra->isAdmin()): ?>
								<li class="dropdown">
							 		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <b class="caret"></b></a>
							 		<ul class="dropdown-menu">
							 			<li class="<?php echo ($page == "add-device" ? 'active"' : ''); ?>"><?php echo anchor("/add_device", "Add Device"); ?></li>
							 			<li class="<?php echo ($page == "add-device" ? 'active"' : ''); ?>"><?php echo anchor("/add_application", "Add Application"); ?></li>
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
				 <h1>Free</h1>
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

							<?php case "tasks": ?>
								<?php if($subpage == ""): ?>
									<h4 class="panel-title">Maintenance Tasks</h4>
									<p class="small overview">Active tasks on any device.</p>
								<?php endif; ?>

								<?php if($subpage == "add"): ?>
									<h4 class="device-title panel-title">New Task</h4>
								<?php endif; ?>
							<?php break; ?>

							<?php case "device": ?>
								<?php if($subpage == ""): ?>
									<h4 class="device-title panel-title"><?php echo $device_info->device_name; ?> <span class="label label-default floatright">#<?php echo $device_info->device_id; ?></span> </h4>
								<?php endif; ?>

								<?php if($subpage == "history"): ?>
									<ul class="nav nav-pills faux-tabs floatleft">
										<li class="active"><a href="#" id="overview">Overview</a></li>
										<li><a href="#" id="recent_owners">Recent Owners</a></li>
										<li><a href="#" id="maintenance">Maintenance</a></li>
									</ul>
								<?php endif; ?>

								<?php if($subpage == "add_application"): ?>
									<h4 class="floatleft">Add Tracked Application</h4>
								<?php endif; ?>

								<?php if($subpage == "edit"): ?>
									<h4 class="floatleft">Edit Device UUID:<?php echo $device_info->uuid; ?></h4>
								<?php endif;?>

								
							<?php break; ?>
						<?php } ?>

						<?php if(isset($show_pagination) && $show_pagination): ?>
							<ul class="pagination nav nav-pills floatright">
								<li><?php echo anchor(sprintf("/device/%s", $this->uri->segment(2)), "&larr; Back"); ?></li>
							</ul>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<div class="panel-body">			