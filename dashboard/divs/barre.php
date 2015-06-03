<ul class="nav navbar-top-links navbar-right">
	<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">
			<?php
				if(isset($listeAlerte)) {
					echo '<i class="fa fa-bell fa-fw" style="background-color:red;"></i>';
				}
				else {
					echo '<i class="fa fa-bell fa-fw"></i>';
				}
			?>
			<i class="fa fa-caret-down"></i>
		</a>
		<ul class="dropdown-menu dropdown-alerts">
			<?php
				if(isset($listeAlerte)) {
					for($i = 0; $i < count($listeAlerte); $i++) {
			?>
						<li>
							<a href="#">
								<div>
									<i class="glyphicon glyphicon-warning-sign"><?php $listeAlerte[$i] ?></i>
								</div>
							</a>
						</li>
						<li class="divider"></li>
			<?php
					}
				}
				else {
					echo "<center>Aucune notification pour l'instant !</center>";
				}
			?>
		</ul>
	</li>
	<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">
			<i class="fa fa-user fa-fw"></i>
			<i class="fa fa-caret-down"></i>
		</a>
		<ul class="dropdown-menu dropdown-user">
			<li>
				<a href="../dec.php">
					<i class="fa fa-sign-out fa-fw"></i>
					Deconnexion
				</a>
			</li>
		</ul>
	</li>
</ul>