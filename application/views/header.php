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
						<span class="glyphicon glyphicon-heart"></span> <?php echo $this->hydra->get("product_name");?>
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
						 	<!--<li class="dropdown">
						 		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Lists <b class="caret"></b></a>
						 		<ul class="dropdown-menu">
						 			<li class="<?php echo ($page == "" ? 'active' : ''); ?>"><?php echo anchor("/lists/records", "Records"); ?></li>
						 			<li class="divider"></li>
						 			<li class="<?php echo ($page == "clients" ? 'active' : ''); ?>"><?php echo anchor("/lists/clients", "Clients"); ?></li>
						 			<li class="<?php echo ($page == "categories" ? 'active' : ''); ?>"><?php echo anchor("/lists/categories", "Categories"); ?></li>
						 			

						 			<?php if($this->hydra->isAdmin()): ?>
							 			<li class="divider"></li>
							 			<li class="<?php echo ($page == "users" ? 'active"' : ''); ?>"><?php echo anchor("/lists/users", "Users"); ?></li>
							 		<?php endif; ?>
						 		</ul>
						 	</li>
						 	<li class="dropdown">
						 		<a href="#" class="dropdown-toggle" data-toggle="dropdown">New <b class="caret"></b></a>
						 		<ul class="dropdown-menu">
						 			<li class="<?php echo ($page == "add" || $page == "edit" && $subpage == "id" || $page == "add" ? 'active"' : ''); ?>"><?php echo anchor("/add", "Record"); ?></li>
						 			<li class="<?php echo ($page == "edit" && $subpage == "cid" || $page == "client" ? 'active"' : ''); ?>"><?php echo anchor("/client", "Client"); ?></li>
						 			<li class="<?php echo ($page == "edit" && $subpage == "caid" || $page == "category" ? 'active"' : ''); ?>"><?php echo anchor("/category", "Category"); ?></li>

						 			<?php if($this->hydra->isAdmin()): ?>
						 				<li class="<?php echo ($page == "edit" && $subpage == "uid" ? 'active"' : ''); ?>"><?php echo anchor("/user", "User"); ?></li>
						 			<?php endif; ?>
						 		</ul>
						 	</li>-->
						 </ul>


						<ul class="nav navbar-nav navbar-right">
							<!--<li class="<?php echo ($page == "preferences" ? 'active' : ''); ?> preferences"><?php echo anchor("/preferences", "Preferences"); ?></li>-->
							<li class="<?php echo ($page == 'help' ? 'active' : ''); ?>"><?php echo anchor("/help", "Help"); ?></li>
						</ul>
					 	
					 	<?php echo anchor("/logout", "Logout", array("class" => "btn btn-default navbar-right logout navbar-btn")); ?>
					</nav>
				<?php endif; ?>
			</header>
			<div class="jumbotron">
				 <h1>Free</h1>
			</div>
		
			<div class="panel panel-free">
				<div class="panel-body">