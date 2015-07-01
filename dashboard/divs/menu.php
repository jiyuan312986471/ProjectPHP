<div class="navbar-default sidebar" role="navigation">
	<div class="sidebar-nav navbar-collapse">
		<ul class="nav" id="side-menu">
			<li>
				<a href="index.php" id="menuIndex">
					<i class="fa fa-dashboard fa-fw"></i>
					Accueil
				</a>
			</li>
			<li>
				<a href="machineAll.php" id="menuMachineAll">
					<i class="fa fa-table fa-fw" ></i>
					Machines
				</a>
				<ul class="nav nav-second-level">
					<li>
						<?php foreach($listMachineInfo as $machine => $machineInfo){ ?>
										<li>
											<a href="machine.php?machine=<?php echo $machine; ?>" id="menu<?php echo $machine; ?>"><?php echo $machineInfo["Nom"]; ?></a>
										</li>
						<?php } ?>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</div>

<script language="javascript">
	focusMenuTab();	
</script>