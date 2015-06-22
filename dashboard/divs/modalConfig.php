<!-- Modal Configer -->
<div class="modal fade bs-example-modal-lg" id="modalConfig" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<!-- Modal Header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Configuration</h4>
			</div>
			
			<!-- Modal Body -->
			<div class="modal-body">
				<!-- MACHINE -->
				<button type="button" class="btn btn-outline btn-primary btn-lg btn-block" data-toggle="collapse" data-target="#collapseConfigMachine" 
					aria-expanded="false" aria-controls="collapseExample">
					Machine
				</button>
				<div class="collapse" id="collapseConfigMachine">
					<div class="panel panel-default well" style="padding: 5px 0px 5px 0px">
						<div class="panel-body" style="padding: 0px">
							<div class="row">
								<div class="col-sm-12">
									<!-- menu machine -->
									<nav class="navbar col-sm-3" style="padding: 0px; margin: 0px">
											<ul class="nav sidebar-nav navbar-collapse" style="padding: 0px" id="side-menu">
												<?php foreach($listMachine as $machine){ ?>
																<li class="pull-left" style="width: 100%">
																	<a href="#confMachinePage<?php echo $machine; ?>" id="confMachineMenu<?php echo $machine; ?>" data-toggle="tab">
																		<i class="fa fa-wrench fa-fw"></i>
																		<?php echo $machine; ?>
																		<i class="fa fa-angle-right fa-fw pull-right"></i>
																	</a>
																</li>
												<?php	} ?>
											</ul>
									</nav>
									<!-- Conf Page machine -->
									<div class="tab-content col-sm-9" style="padding: 0px; height: 100%">
										<?php foreach($listMachine as $machine){ ?>
														<div role="tabpanel" class="tab-pane" id="confMachinePage<?php echo $machine; ?>">
															<?php echo $machine; ?>
														</div>
										<?php } ?>
								  </div>
					  
					  		</div>
					  	</div>
					  </div>
					</div>
				</div>
				
				<!-- REFRESH FREQUENCY -->
				<button type="button" class="btn btn-outline btn-primary btn-lg btn-block" data-toggle="collapse" data-target="#collapseConfigFrequence" 
					aria-expanded="false" aria-controls="collapseExample">
					Frequence d'actualisation
				</button>
				<div class="collapse" id="collapseConfigFrequence">
				  <div class="well">
				  	<!-- content -->
				    collapseConfigFrequence
				  </div>
				</div>
				
				<!-- DEFAUT -->
				<button type="button" class="btn btn-outline btn-primary btn-lg btn-block" data-toggle="collapse" data-target="#collapseConfigDefaut" 
					aria-expanded="false" aria-controls="collapseExample">
					Defaut
				</button>
				<div class="collapse" id="collapseConfigDefaut">
				  <div class="well">
				  	<!-- content -->
				    collapseConfigDefaut
				  </div>
				</div>
				
			</div>
			
			<!-- Modal Footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-primary">Valider</button>
			</div>
		</div>
	</div>
</div>