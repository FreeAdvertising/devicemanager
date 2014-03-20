<?php var_dump($device_info); ?>

<section class="col-md-9">
	<div class="row">
		<div class="col-md-12">
			<h3>Device Info: <attr title="I am a UUID, unique to my configured hardware"><?php echo $device_info->uuid; ?></attr></h3>

			<div class="module col-md-6">
				<h3>Hardware</h3>

				<ul>
					<li>RAM: <?php echo get_ram($device_info->meta_ram); ?>GB</li>
					<li>HDD: <?php echo get_hdd($device_info->meta_hdd); ?>GB</li>
					<li>Type: <?php echo get_type($device_info->meta_type); ?></li>
				</ul>
			</div>
		</div>
	</div>
</section>

<section class="sidebar col-md-3">
	<aside class="module">
		<ul class="list-group">
			<h3 class="list-group-item">Current Owner</h3>
			<li class="list-group-item"><?php echo $device_info->current_owner; ?></li>
		</ul>
	</aside>

	<aside class="module">
		<ul class="list-group">
			<h3 class="list-group-item">Reservation List</h3>
			<li class="list-group-item"><?php echo $device_info->current_owner; ?></li>
		</ul>
	</aside>
</section>