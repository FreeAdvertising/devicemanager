<section class="main col-md-8">
	<div class="row">
		<?php if($this->hydra->isAdmin()): ?>
			<div class="admin quicklinks col-md-12">
				<h3>Admin Quick Links</h3>

				<section class="module col-md-6">
					<h3>Manage</h3>
					<ul>
						<li><a href="#">Devices</a></li>
						<li><a href="#">Users</a></li>
						<li><a href="#">Maintenance Tasks</a></li>
					</ul>
				</section>

				<section class="module col-md-6">
					<h3>Maintenance Tasks <a href="#" class="all">View All</a></h3>
					<ul>
						<li><a href="#">XXXXXXXX</a> - Task#XX - March 10th, 2014</li>
						<li><a href="#">XXXXXXXX</a> - Task#XX - March 11th, 2014</li>
					</ul>
				</section>
			</div>
		<?php endif; ?>

		<div class="staff quicklinks col-md-12">
			<h3>Staff Quick Links</h3>

			<section class="module col-md-6">
				<h3>View</h3>
				<ul>
					<li><a href="#">Latest Reservations</a></li>
					<li><a href="#">Latest Check In's</a></li>
					<li><a href="#">Latest Check Out's</a></li>
				</ul>
			</section>

			<section class="module col-md-6">
				<h3>Maintenance Tickets <a href="#" class="all">View All</a></h3>
				<ul>
					<li><a href="#">Create New Ticket</a></li>
				</ul>
			</section>
		</div>
	</div>
</section>

<section class="sidebar col-md-4">
	<aside class="module">
		<div class="list-group">
			<h3 class="list-group-item">My Devices</h3>
			<a href="#" class="list-group-item">XXXXXXXX <span class="all">March 11th, 2014</span></a>

			<h3 class="list-group-item">My Reserved Devices</h3>
			<a href="#" class="list-group-item">XXXXXXXX <span class="all">March 18th, 2014</span></a>
			<a href="#" class="list-group-item">XXXXXXXX <span class="all">March 12th, 2014</span></a>
			<a href="#" class="list-group-item">XXXXXXXX <span class="all">March 8th, 2014</span></a>

			<h3 class="list-group-item">My Maintenance Tickets</h3>
			<a href="#" class="list-group-item">XXXXXXXX - Task#XX <span class="all">March 10th, 2014</span></a>
			<a href="#" class="list-group-item">XXXXXXXX - Task#XX <span class="all">March 11th, 2014</span></a>
		</div>
	</aside>
</section>
