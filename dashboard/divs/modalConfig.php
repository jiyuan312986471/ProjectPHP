<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Slider Plugin -->
<script type='text/javascript' src="js/bootstrap-slider1.js"></script>

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
								<!-- Conf Page machine -->
								<div class="tab-content col-sm-10" style="padding: 0px">
									<?php foreach($listMachine as $machine){ ?>
													<div role="tabpanel" class="tab-pane fade" id="confMachinePage<?php echo $machine; ?>">
														<div class="panel panel-default" style="margin: 0px">
															<div class="panel-heading">
																<h3>Machine <?php echo $machine; ?></h3>
															</div>
															<form>
																<!-- Nom Machine -->
																<div class="panel-body">
																	<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
																		<label class="col-sm-12">Nom</label>
																	</div>
																	<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
																    <div class="col-sm-offset-1 col-sm-7" style="padding: 0px">
																      fdafdasfsadfasdfadsf
																    </div>
																    <button type="button" class="btn btn-sm btn-primary col-sm-3 pull-right" onclick="activeNameSetting('<?php echo $machine; ?>')">
																    	Modifier
																    </button>
																  </div>
																  <div class="row" id="nameSetting<?php echo $machine; ?>" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px; display: none">
																  	<div class="alert alert-info col-sm-offset-1 col-sm-11">
																	  	<input type="text" class="form-control col-sm-8" style="padding-left: 15px; padding-right: 15px" placeholder="Nouveau Nom...">
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
																	  <input id="sliderSeuilPourc<?php echo $machine; ?>" type="text" data-slider-id="slider<?php echo $machine; ?>" 
																	    data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="5" data-slider-enabled="false" />
																	  <span class="col-sm-3" id="currentSliderValLabel">Current Value: 
																	  	<span id="sliderVal<?php echo $machine; ?>" style="color: #428bca">5</span>
																	  </span>
																	  <button type="button" class="btn btn-sm btn-primary col-sm-3 pull-right" onclick="activeSeuilSetting('<?php echo $machine; ?>')">
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
																		<button type="button" class="btn btn-success btn-lg col-sm-offset-1 col-sm-11" id="status<?php echo $machine; ?>" 
																			onclick="toggleMachineStatus('<?php echo $machine; ?>')">
																			Active
																		</button>
																	</div>
																</div>
																
																<div class="panel-footer">
																	<button type="submit" class="btn btn-primary">Enregistrer</button>
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
														$("div.slider").addClass("col-sm-offset-1 col-sm-5");
													</script>
													
									<?php } ?>
									
									<!-- New Machine -->
									<div role="tabpanel" class="tab-pane fade" id="confMachinePage<?php echo $machine; ?>">
										
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
																<input type="text" class="form-control" placeholder="Code Defaut...">
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
																<select multiple class="form-control">
																	<option>K</option>
																	<option>D12</option>
																	<option>D3</option>
																</select>
															</div>
														</div>
													</div>
												</span>
												
												<!-- Panel Footer -->
												<div class="panel-footer">
													<input type="submit" class="btn btn-primary" value="Enregistrer">
													<input type="reset" id="confDefautCancel" class="btn btn-primary" value="Annuler">
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
															<input type="text" class="form-control" placeholder="Code Defaut...">
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
															<select multiple class="form-control">
																<option>K</option>
																<option>D12</option>
																<option>D3</option>
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
	function activeNameSetting(machine){
		$("div#nameSetting" + machine).css("display","");
	}
	
	function activeSeuilSetting(machine){
		var divSlider = $("#slider" + machine);
		if( divSlider.hasClass("slider-disabled") ){
			$("#sliderSeuilPourc" + machine).slider("enable");
		}
	}
	
	function toggleMachineStatus(machine){
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
	}
	
	$("button#researchCode").click(function (){
		$("span#defautInfo").css("display","");
	})
	
	$("input#confDefautCancel").click(function (){
		$("span#defautInfo").css("display","none");
	})
</script>

<script language="javascript">
	/********************************/
	/* 				Auto Complete 				*/
	/********************************/
	// get data
	var data = eval(<?php echo json_encode($listDefautConfig); ?>);
	
	// preparer list code defaut
	var listCodeDefaut = [];
  for (var codeDefaut in data){
    listCodeDefaut.push(codeDefaut);
  }
  
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
		// get data
		var data = eval(<?php echo json_encode($listDefautConfig); ?>);
		
		// get info
		var defautInfo = data[codeDefaut];
	}	
</script>