<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Slider Plugin -->
<script type='text/javascript' src="js/bootstrap-slider.js"></script>

<!-- Type Ahead -->
<script type='text/javascript' src="js/typeahead/bloodhound.js"></script>
<script type='text/javascript' src="js/typeahead/typeahead.bundle.js"></script>
<script type='text/javascript' src="js/typeahead/typeahead.jquery.js"></script>

<!-- Map JS -->
<script type='text/javascript' src="js/map.js"></script>

<!-- Modal Configer -->
<div class="modal fade bs-example-modal-lg" id="modalConfig" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
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
					<div class="well" style="padding: 0px 0px 5px 0px">
						<div class="row">
							<div class="col-sm-12">
								<!-- menu machine -->
								<nav class="navbar col-sm-2" style="padding: 0px; margin: 0px">
									<ul class="nav sidebar-nav navbar-collapse" style="padding: 0px">
										<?php foreach($listMachine as $machine){ ?>
														<li class="pull-left" style="width: 100%">
															<a href="#confMachinePage<?php echo $machine; ?>" id="confMachineMenu<?php echo $machine; ?>" data-toggle="tab">
																<i class="fa fa-wrench fa-fw"></i>
																<?php echo $machine; ?>
																<i class="fa fa-angle-right fa-fw pull-right"></i>
															</a>
														</li>
										<?php	} ?>
														<li class="pull-left" style="width: 100%">
															<a href="#confMachinePageAjout" id="confMachineMenuAjout" data-toggle="tab">
																<i class="fa fa-plus fa-fw"></i>
																Ajouter
																<i class="fa fa-angle-right fa-fw pull-right"></i>
															</a>
														</li>
									</ul>
								</nav>
								
								<div class="tab-content col-sm-10" style="padding: 0px">
									<!-- Conf Page machine -->
									<?php foreach($listMachineInfo as $machine => $machineInfo){ ?>
													<div role="tabpanel" class="tab-pane fade" id="confMachinePage<?php echo $machine; ?>">
														<div class="panel panel-default" style="margin: 0px">
															<div class="panel-heading">
																<h3>Machine <?php echo $machine; ?></h3>
															</div>
															<form id="formConfMachine<?php echo $machine; ?>" action="checkFormConfMachine('<?php echo $machine; ?>')">
																<!-- Nom Machine -->
																<div class="panel-body">
																	<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
																		<label class="col-sm-12">Nom</label>
																	</div>
																	<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
																    <div class="col-sm-offset-1 col-sm-7" style="padding: 0px">
																      <input id="inputNameMachine<?php echo $machine; ?>" type="text" class="form-control" placeholder="Nouveau Nom..." 
																      	value="<?php echo $machineInfo["Nom"]; ?>" disabled >
																    </div>
																    <button type="button" class="btn btn-sm btn-primary col-sm-3 pull-right" onclick="activeNameSetting('<?php echo $machine; ?>')">
																    	Modifier
																    </button>
																  </div>
																</div>
																
																<hr style="margin-top: 2px; margin-bottom: 2px">
																
																<!-- Seuil Pourc -->
																<div class="panel-body">
																	<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
																		<label class="col-sm-12">Seuil du Graph Pourcentage</label>
																	</div>
																	<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
																	  <input id="sliderSeuilPourc<?php echo $machine; ?>" type="text" data-slider-id="slider<?php echo $machine; ?>" 
																	    data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="<?php echo $machineInfo["Seuil"]; ?>" data-slider-enabled="false" />
																	  <span class="col-sm-3" id="currentSliderValLabel">Current Value: 
																	  	<span id="sliderVal<?php echo $machine; ?>" style="color: #428bca"><?php echo $machineInfo["Seuil"]; ?></span>
																	  </span>
																	  <button type="button" class="btn btn-sm btn-primary col-sm-3 pull-right" onclick="activeSeuilSetting('<?php echo $machine; ?>')">
																    	Modifier
																    </button>
																  </div>
																</div>
																
																<hr style="margin-top: 2px; margin-bottom: 2px">
																
																<!-- Type Produit -->
																<div class="panel-body">
																	<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
																		<label class="col-sm-12">Type Produit</label>
																	</div>
																	<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
																		<div class="col-sm-offset-1 col-sm-7" style="padding: 0px">
																			<select id="selectTypeProduit<?php echo $machine; ?>" class="form-control" disabled>
																				<?php 
																					foreach($listTypeProduit as $type){ 
																						if($machineInfo["TypeProduit"] == $type){
																				?>
																							<option selected><?php echo $type; ?></option>
																				<?php
																						}
																						else {
																				?>
																							<option><?php echo $type; ?></option>
																				<?php
																						}
																					}
																				?>
																			</select>
																		</div>
																		<button type="button" class="btn btn-sm btn-primary col-sm-3 pull-right" onclick="activeTypeProduitSetting('<?php echo $machine; ?>')">
																    	Modifier
																    </button>
																	</div>
																</div>
																
																<hr style="margin-top: 2px; margin-bottom: 2px">
																
																<!-- Status -->
																<div class="panel-body">
																	<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
																		<label class="col-sm-12">Machine Status</label>
																	</div>
																	<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
																		<?php if($machineInfo["Status"] == "Active"){ ?>
																						<button type="button" class="btn btn-success btn-lg col-sm-offset-1 col-sm-11" id="status<?php echo $machine; ?>" 
																							onclick="toggleMachineStatus('<?php echo $machine; ?>')">
																							Active
																						</button>
																		<?php } else { ?>
																						<button type="button" class="btn btn-danger btn-lg col-sm-offset-1 col-sm-11" id="status<?php echo $machine; ?>" 
																							onclick="toggleMachineStatus('<?php echo $machine; ?>')">
																							Disabled
																						</button>
																		<?php } ?>
																	</div>
																</div>
																
																<div class="panel-footer">
																	<input id="confMachine<?php echo $machine; ?>Enregistrer" type="submit" class="btn btn-primary" value="Enregistrer" disabled>
																	<button type="button" class="btn btn-primary" onclick="resetMachineSetting(
																																													'<?php echo $machine; ?>',
																																													'<?php echo $machineInfo["Nom"]; ?>',
																																													<?php echo $machineInfo["Seuil"]; ?>,
																																													'<?php echo $machineInfo["TypeProduit"]; ?>',
																																													'<?php echo $machineInfo["Status"]; ?>'
																																												)">
																		Annuler
																	</button>
																</div>
															</form>
														</div>
													</div>
													
													<script language="javascript">
														// create slider
														$("#sliderSeuilPourc" + <?php echo json_encode($machine); ?>).slider();
														
														$("#sliderSeuilPourc" + <?php echo json_encode($machine); ?>).on("slide", function(slideEvt) {
															$("#sliderVal" + <?php echo json_encode($machine); ?>).text(slideEvt.value);
														});
														
														// set slider width and offset
														$("div.slider#slider" + <?php echo json_encode($machine); ?>).addClass("col-sm-offset-1 col-sm-5");
													</script>
													
									<?php } ?>
									
									<!-- New Machine -->
									<div role="tabpanel" class="tab-pane fade" id="confMachinePageAjout">
										<div class="panel panel-default" style="margin: 0px">
											<div class="panel-heading">
												<h3>Ajouter une Machine</h3>
											</div>
											<form id="formNewMachine" action="javascript:void(0);">
												<!-- ID Machine -->
												<div class="panel-body">
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<label class="col-sm-12">ID</label>
													</div>
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<div class="col-sm-offset-1 col-sm-8" style="padding: 0px">
															<input id="inputIdNewMachine" type="text" class="form-control" placeholder="ID de la machine...">
														</div>
													</div>
												</div>
												
												<hr style="margin-top: 2px; margin-bottom: 2px">
												
												<!-- Nom Machine -->
												<div class="panel-body">
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<label class="col-sm-12">Nom</label>
													</div>
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<div class="col-sm-offset-1 col-sm-8" style="padding: 0px">
															<input id="inputNameNewMachine" type="text" class="form-control" placeholder="Nom de la machine...">
														</div>
													</div>
												</div>
												
												<hr style="margin-top: 2px; margin-bottom: 2px">
												
												<!-- Seuil Pourc -->
												<div class="panel-body">
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<label class="col-sm-12">Seuil du Graph Pourcentage</label>
													</div>
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<input id="sliderSeuilPourcNewMachine" type="text" data-slider-id="sliderNewMachine" 
															data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="5" />
														<span class="col-sm-3" id="currentSliderValLabel">Current Value: 
															<span id="sliderValNewMachine" style="color: #428bca">5</span>
														</span>
													</div>
												</div>
												
												<hr style="margin-top: 2px; margin-bottom: 2px">
												
												<!-- Type Produit -->
												<div class="panel-body">
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<label class="col-sm-12">Type Produit</label>
													</div>
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<div class="col-sm-offset-1 col-sm-8" style="padding: 0px">
															<select id="selectTypeProduitNewMachine" class="form-control">
																				<option value="empty">-- Choisissez le type produit --</option>
																<?php foreach($listTypeProduit as $type){ ?>
																				<option value="<?php echo $type; ?>"><?php echo $type; ?></option>
																<?php } ?>
																				<option value="NouveauType">Nouveau Type...</option>
															</select>
														</div>
													</div>
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<div class="col-sm-offset-1 col-sm-8" style="padding: 0px">
															<input id="inputNewTypeProduitNewMachine" type="text" class="form-control" placeholder="Nom du nouveau type produit..." style="display: none">
														</div>
													</div>
												</div>
												
												<hr style="margin-top: 2px; margin-bottom: 2px">
												
												<!-- Status -->
												<div class="panel-body">
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<label class="col-sm-12">Machine Status</label>
													</div>
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<button type="button" class="btn btn-success btn-lg col-sm-offset-1 col-sm-11" id="statusNewMachine" 
															onclick="toggleMachineStatus('NewMachine')">
															Active
														</button>
													</div>
												</div>
												
												<div class="panel-footer">
													<input type="submit" class="btn btn-primary" value="Enregistrer">
													<button type="button" class="btn btn-primary" onclick="resetMachineSetting('NewMachine')">Annuler</button>
												</div>
											</form>
										</div>
									</div>
									
									<script language="javascript">
										// create slider
										$("#sliderSeuilPourcNewMachine").slider();
										
										$("#sliderSeuilPourcNewMachine").on("slide", function(slideEvt){
											$("#sliderValNewMachine").text(slideEvt.value);
										});
										
										// set slider width and offset
										$("div.slider#sliderNewMachine").addClass("col-sm-offset-1 col-sm-8");
									</script>
									
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
				  	<div class="row">
				  		<div class="alert alert-info col-sm-12" style="margin: 0px">
						    <input id="sliderRefreshTime" type="text" data-slider-id="sliderRefresh" data-slider-min="8" data-slider-max="60" data-slider-step="1" data-slider-value="8" />
						    <span class="col-sm-3" id="currentRefreshTime">
						    	Refresh Time: 
						    	<span id="sliderRefreshVal">8</span>
						    	s
						    </span>
						    <input type="submit" class="btn btn-sm btn-primary col-sm-2" value="Enregistrer" />
					    </div>
				    </div>
				    
				    <script language="javascript">
				    	// create slider
				    	$("#sliderRefreshTime").slider({
				    			formatter: function(value) {
				    				return 'Current value: ' + value;
				    			}
				    	});
				    	
				    	// set slider width and offset
				    	$("div.slider#sliderRefresh").addClass("col-sm-offset-1 col-sm-5");
				    	
				    	// sliderRefresh Listener
				    	$("#sliderRefreshTime").on("slide", function(slideEvt) {
								$("#sliderRefreshVal").text(slideEvt.value);
							});
				    </script>
				    
				  </div>
				</div>
				
				<!-- DEFAUT -->
				<button type="button" class="btn btn-outline btn-primary btn-lg btn-block" data-toggle="collapse" data-target="#collapseConfigDefaut" 
					aria-expanded="false" aria-controls="collapseExample">
					Defaut
				</button>
				<div class="collapse" id="collapseConfigDefaut">
				  <div class="well" style="padding: 0px 0px 5px 0px">
				  	<!-- content -->
				    <div class="row">
							<div class="col-sm-12">
								<!-- menu defaut -->
								<nav class="navbar col-sm-2" style="padding: 0px; margin: 0px">
									<ul class="nav sidebar-nav navbar-collapse" style="padding: 0px">
										<li class="pull-left" style="width: 100%">
											<a href="#confDefautPageModif" id="confDefautMenuModif" data-toggle="tab">
												<i class="fa fa-wrench fa-fw"></i>
												Modifier
												<i class="fa fa-angle-right fa-fw pull-right"></i>
											</a>
										</li>
										<li class="pull-left" style="width: 100%">
											<a href="#confDefautPageAjout" id="confDefautMenuAjout" data-toggle="tab">
												<i class="fa fa-plus fa-fw"></i>
												Ajouter
												<i class="fa fa-angle-right fa-fw pull-right"></i>
											</a>
										</li>
									</ul>
								</nav>
								
								<!-- content defaut -->
								<div class="tab-content col-sm-10" style="padding: 0px">
									
									<!-- Conf Defaut Page Modif -->
									<div role="tabpanel" class="tab-pane fade" id="confDefautPageModif">
										<div class="panel panel-default" style="margin: 0px">
											<div class="panel-heading">
												<h3>Modifier un Defaut</h3>
											</div>
											<!-- Recherche -->
											<div class="panel-body">
												<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
													<label class="col-sm-3">
														<div class="pull-right">Recherche du Code :</div>
													</label>
													<div class="col-sm-8">
														<div class="input-group">
															<input type="text" class="typeahead" id="inputCode" class="form-control" placeholder="Saisissez le code defaut..."
																data-provide="typeahead">
															<div class="input-group-btn">
																<button id="researchCode" class="btn btn-primary">Rechercher</button>
															</div>
														</div>
													</div>
												</div>
											</div>
											
											<form id="formModifDefaut" action="#" name="formModifDefaut">
												<span id="defautInfo" style="display: none">
													<hr style="margin-top: 2px; margin-bottom: 2px">
													
													<!-- Code -->
													<div class="panel-body">
														<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
															<label class="col-sm-3">
																<div class="pull-right">Code Defaut :</div>
															</label>
															<div class="col-sm-6">
																<input id="codeDefautModif" type="text" class="form-control" placeholder="Code Defaut...">
															</div>
														</div>
													</div>
													
													<hr style="margin-top: 2px; margin-bottom: 2px">
													
													<!-- Nom -->
													<div class="panel-body">
														<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
															<label class="col-sm-3">
																<div class="pull-right">Nom Defaut :</div>
															</label>
															<div class="col-sm-6">
																<input id="nomDefautModif" type="text" class="form-control" placeholder="Nom du Defaut...">
															</div>
														</div>
													</div>
													
													<hr style="margin-top: 2px; margin-bottom: 2px">
													
													<!-- Nom Abrege -->
													<div class="panel-body">
														<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
															<label class="col-sm-3">
																<div class="pull-right">Nom Defaut Abrege :</div>
															</label>
															<div class="col-sm-6">
																<input id="nomAbregeDefautModif" type="text" class="form-control" placeholder="Nom du Defaut Abrege...">
															</div>
														</div>
													</div>
													
													<hr style="margin-top: 2px; margin-bottom: 2px">
													
													<!-- Type Produit -->
													<div class="panel-body">
														<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
															<label class="col-sm-3">
																<div class="pull-right">Type Produit :</div>
															</label>
															<div class="col-sm-6">
																<select id="typeProduitDefautModif" class="form-control">
																	<?php foreach($listTypeProduit as $type){ ?>
																					<option><?php echo $type; ?></option>
																	<?php } ?>
																</select>
															</div>
														</div>
													</div>
												</span>
												
												<!-- Panel Footer -->
												<div class="panel-footer">
													<input type="submit" id="confDefautEnregistrer" class="btn btn-primary" value="Enregistrer" disabled>
													<input type="reset" id="confDefautAnnuler" class="btn btn-primary" value="Annuler">
												</div>
											</form>
										</div>
									</div>
									
									<!-- Conf Defaut Page Ajout -->
									<div role="tabpanel" class="tab-pane fade" id="confDefautPageAjout">
										<div class="panel panel-default" style="margin: 0px">
											<div class="panel-heading">
												<h3>Ajouter un defaut</h3>
											</div>
											
											<form id="formAjoutDefaut" action="#" name="formAjoutDefaut">
												<!-- Code -->
												<div class="panel-body">
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<label class="col-sm-3">
															<div class="pull-right">Code Defaut :</div>
														</label>
														<div class="col-sm-6">
															<input id="inputIdNewDefaut" type="text" class="form-control" placeholder="Code Defaut...">
														</div>
													</div>
												</div>
												
												<hr style="margin-top: 2px; margin-bottom: 2px">
												
												<!-- Nom -->
												<div class="panel-body">
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<label class="col-sm-3">
															<div class="pull-right">Nom Defaut :</div>
														</label>
														<div class="col-sm-6">
															<input type="text" class="form-control" placeholder="Nom du Defaut...">
														</div>
													</div>
												</div>
												
												<hr style="margin-top: 2px; margin-bottom: 2px">
												
												<!-- Nom Abrege -->
												<div class="panel-body">
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<label class="col-sm-3">
															<div class="pull-right">Nom Defaut Abrege :</div>
														</label>
														<div class="col-sm-6">
															<input type="text" class="form-control" placeholder="Nom du Defaut Abrege...">
														</div>
													</div>
												</div>
												
												<hr style="margin-top: 2px; margin-bottom: 2px">
												
												<!-- Status -->
												<div class="panel-body">
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<label class="col-sm-3">
															<div class="pull-right">Status :</div>
														</label>
														<div class="col-sm-6">
															<select class="form-control">
																<?php foreach($listTypeProduit as $type){ ?>
																				<option><?php echo $type; ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>
												
												<!-- Panel Footer -->
												<div class="panel-footer">
													<button type="submit" class="btn btn-primary">Enregistrer</button>
													<button type="reset" class="btn btn-primary">Annuler</button>
												</div>
											</form>
										</div>
									</div>
								</div>
								
							</div>
						</div>
								
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

<script language="javascript">
	// activate machine name setting
	function activeNameSetting(machine){
		// activate input
		$("input#inputNameMachine" + machine).removeAttr("disabled");
		
		// activate enregistrer button
		$("input#confMachine" + machine + "Enregistrer").removeAttr("disabled");
	}
	
	// activate machine seuil setting
	function activeSeuilSetting(machine){
		// activate slider
		var divSlider = $("#slider" + machine);
		if( divSlider.hasClass("slider-disabled") ){
			$("#sliderSeuilPourc" + machine).slider("enable");
		}
		
		// activate enregistrer button
		$("input#confMachine" + machine + "Enregistrer").removeAttr("disabled");
	}
	
	// activate machine type produit setting
	function activeTypeProduitSetting(machine){
		// activate select
		$("select#selectTypeProduit" + machine).removeAttr("disabled");
		
		// activate enregistrer button
		$("input#confMachine" + machine + "Enregistrer").removeAttr("disabled");
	}
	
	// activate and disactivate machine status
	function toggleMachineStatus(machine){
		// toggle status
		var btn = $("button#status" + machine);
		if ( btn.hasClass("btn-danger") ){
			btn.removeClass("btn-danger");
			btn.addClass("btn-success");
			btn.text("Active");
		}
		else if ( btn.hasClass("btn-success") ){
			btn.removeClass("btn-success");
			btn.addClass("btn-danger");
			btn.text("Disabled");
		}
		
		// activate enregistrer button
		$("input#confMachine" + machine + "Enregistrer").removeAttr("disabled");
	}
	
	// reset current machine setting page
	function resetMachineSetting(machine, nom, seuil, typeProduit, status){
		if(machine != "NewMachine"){
			// reset name input
			$("input#inputNameMachine" + machine).val(nom);
			
			// disable name input
			$("input#inputNameMachine" + machine).attr("disabled", "disabled");
			
			// reset seuil slider
			$("#sliderSeuilPourc" + machine).slider('setValue', seuil);
			
			// disable seuil slider
			$("#sliderSeuilPourc" + machine).slider("disable");
			
			// reset value display
			$("#sliderVal" + machine).text(seuil);
			
			// reset status
			if(status == "Active"){
				$("button#status" + machine).removeClass("btn-danger");
				$("button#status" + machine).addClass("btn-success");
				$("button#status" + machine).text("Active");
			}
			else {
				$("button#status" + machine).removeClass("btn-success");
				$("button#status" + machine).addClass("btn-danger");
				$("button#status" + machine).text("Disabled");
			}
			
			// reset type produit
			var listType = $("select#selectTypeProduit" + machine).children("option");
			for(var i in listType){
				if($(listType[i]).text() == typeProduit){
					$(listType[i]).attr("selected", "selected");
				}
				else{
					$(listType[i]).removeAttr("selected");
				}
			}
			
			// disable type produit
			$("select#selectTypeProduit" + machine).attr("disabled", "disabled");
			
			// disable enregistrer button
			$("input#confMachine" + machine + "Enregistrer").attr("disabled", "disabled");
		}
		else {
			// clear ID
			$("input#inputId" + machine).val("");
			
			// clear name
			$("input#inputName" + machine).val("");
			
			// reset slider
			$("#sliderSeuilPourc" + machine).slider('setValue', 5);
			$("#sliderVal" + machine).text(5);
			
			// reset status
			$("button#status" + machine).removeClass("btn-danger");
			$("button#status" + machine).addClass("btn-success");
			$("button#status" + machine).text("Active");
			
			// reset type produit
			var listType = $("select#selectTypeProduit" + machine).children("option");
			for(var i in listType){
				if($(listType[i]).text() == "-- Choisissez le type produit --"){
					$(listType[i]).attr("selected", "selected");
				}
				else{
					$(listType[i]).removeAttr("selected");
				}
			}
			$("input#inputNewTypeProduit" + machine).css("display", "none");
			$("select#selectTypeProduitNewMachine").removeAttr("disabled");
		}
	}
	
	// search defaut info and show 
	$("button#researchCode").click(function (){
		// get code
		var code = $("input#inputCode").val();
		
		if(code == ""){
			alert("Veuillez saisir le code defaut!");
		}
		else if(getDefautInfo(code)){
			// if code existes: show info
			$("span#defautInfo").css("display","");
			
			// activate enregistrer button
			$("input#confDefautEnregistrer").removeAttr("disabled");
		}
		else{
			// if code doesn't exist: show alert
			alert("Code " + code + " n'existe pas!");
		}
	})
	
	// button Annuler of defaut conf page
	$("input#confDefautAnnuler").click(function (){
		// hide info page
		$("span#defautInfo").css("display","none");
		
		// disable enregistrer button
		$("input#confDefautEnregistrer").attr("disabled", "disabled");
	})
	
	// popover for ajout machine's ID input
	$("input#inputIdNewMachine").focus(function (){
		$("input#inputIdNewMachine")
				.popover({
					"placement": "top",
					"content": "Chaque machine a un ID unique dont la longeur est 10 caracteres max.<br/>Ex: AK",
					"html": "html",
					"template": '<div class="popover" role="tooltip" style="left: 0 !important"><div class="arrow" style="left: 10% !important"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
				})
				.blur(function () {
            $(this).popover('hide');
        });
	})
	
	// popover for ajout defaut's code input
	$("input#inputIdNewDefaut").focus(function (){
		$("input#inputIdNewDefaut")
				.popover({
					"placement": "top",
					"content": "Le code defaut est un chiffre unique pour chaque defaut.",
					"template": '<div class="popover" role="tooltip" style="left: 0 !important"><div class="arrow" style="left: 10% !important"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
				})
				.blur(function () {
            $(this).popover('hide');
        });
	})
	
	// new type produit for new machine
	$("select#selectTypeProduitNewMachine").change(function (){
		if( $(this).val() == "NouveauType" ){
			// show type produit input
			$("input#inputNewTypeProduitNewMachine").css("display", "");
			
			// disable select
			$(this).attr("disabled", "disabled");
		}
	})
</script>

<script language="javascript">
	/********************************/
	/* 				Auto Complete 				*/
	/********************************/
	// preparer list code defaut
	var listCodeDefaut = eval(<?php echo json_encode($listCodeDefaut); ?>);
  
  var codes = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.whitespace,
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  local: listCodeDefaut
	});
  
  $("input#inputCode").typeahead({
  	hint: true,
  	highlight: true,
  	minLength: 1
  },
  {
  	source: codes
  });
</script>

<script language="javascript">
	/********************************/
	/* 			Code Defaut Search 			*/
	/********************************/	
	function getDefautInfo(codeDefaut){
		// get defaut
		var defauts = eval(<?php echo json_encode($listDefautConfig); ?>);
		var defautInfo = defauts[codeDefaut];
		
		if(typeof(defautInfo)=="undefined"){
			return false;
		}
		else{
			// get infos
			var nom 				= defautInfo["Nom"];
			var nomAbrege 	= defautInfo["NomAbrege"];
			var typeProduit = defautInfo["TypeProduit"];
			
			// display info on defaut modif page
			$("input#codeDefautModif").val(codeDefaut);
			$("input#nomDefautModif").val(nom);
			$("input#nomAbregeDefautModif").val(nomAbrege);
			
			// display type produit
			var listType = $("select#typeProduitDefautModif").children("option");
			for(var i in listType){
				if($(listType[i]).text() == typeProduit){
					$(listType[i]).attr("selected", "selected");
				}
				else{
					$(listType[i]).removeAttr("selected");
				}
			}
			return true;
		}
	}	
</script>

<script language="javascript">
	/********************************/
	/* 					FORM CHECK					*/
	/********************************/
	// Conf Machine
	function checkFormConfMachine(machine){
		
	};
	
	// Ajout Machine
	$("form#formNewMachine").submit(function (){
		// get infos
		var idMachine = $.trim($(this).find("input#inputIdNewMachine").val());
		var nomMachine = $.trim($(this).find("input#inputNameNewMachine").val());
		var seuilMachine = $.trim($(this).find("span#sliderValNewMachine").text());
		var selectValTypeProduit = $(this).find("select#selectTypeProduitNewMachine").val();
		if(selectValTypeProduit == "NouveauType"){
			var typeProduitMachine = $.trim($(this).find("input#inputNewTypeProduitNewMachine").val());
		}
		else{
			var typeProduitMachine = $.trim(selectValTypeProduit);
		}
		var statusMachine = $.trim($(this).find("button#statusNewMachine").text());
		
		// empty check
		if(idMachine == ""){
			alert("Veuillez saisir ID!");
			return;
		}
		if(nomMachine == ""){
			alert("Veuillez saisir le nom!");
			return;
		}
		if(typeProduitMachine == "empty"){
			alert("Veuillez choisir le type produit!");
			return;
		}
		if(typeProduitMachine == ""){
			alert("Veuillez saisir le type produit!");
			return;
		}
		
		// ID check
		if(idMachine.length > 10){
			alert("La longueur max de l'ID est 10 caracteres!");
			return;
		}

		// nom check
		if(nomMachine.length > 50){
			alert("La longueur max du nom est 50 caracteres!");
			return;
		}
		
		// seuil convert(to integer)
		seuilMachine = ~~seuilMachine;
		
		// type produit check(if new type needed to add)
		if(selectValTypeProduit == "NouveauType"){
			if(typeProduitMachine.length > 10){
				alert("La longueur max du type produit est 10 caracteres!");
				return;
			}
			var listTypeProduit = eval(<?php echo json_encode($listTypeProduit); ?>);
			for(i in listTypeProduit){
				if(typeProduitMachine == listTypeProduit[i]){
					alert("Le type " + typeProduitMachine + " existe deja!");
					return;
				}
			}
		}
		
		// send data to php page via ajax
		$.ajax({
			url: "ajax/addMachine.php",
			type: "POST",
			data: {
				id: idMachine,
				nom: nomMachine,
				seuil: seuilMachine,
				typeProduit: typeProduitMachine,
				status: statusMachine
			},
			dataType: "text",
			success: function(data){
				// show result
				alert(data);
				
				// if sth failed: return
				if(data.indexOf("Failed") >= 0){
					return;
				}
				// if all goes right: to index page
				else{
					location.href = "index.php";
				}
			}
		});
		
	});
	
	// Conf Defaut
	$("form#formModifDefaut").submit(function (){
		
	});
	
	// Ajout Defaut
	$("form#formAjoutDefaut").submit(function (){
		
	});
</script>