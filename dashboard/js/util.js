/****************
*		DRAW GRAPHS
****************/
function drawPourcGraph(machine, graphPourcData, graphPourc){
	var graph24h;
	var data = [
		{ nbr: graphPourcData.jour[0], valeur: graphPourcData.pourc[0] },
		{ nbr: graphPourcData.jour[1], valeur: graphPourcData.pourc[1] },
		{ nbr: graphPourcData.jour[2], valeur: graphPourcData.pourc[2] },
		{ nbr: graphPourcData.jour[3], valeur: graphPourcData.pourc[3] },
		{ nbr: graphPourcData.jour[4], valeur: graphPourcData.pourc[4] },
		{ nbr: graphPourcData.jour[5], valeur: graphPourcData.pourc[5] },
		{ nbr: graphPourcData.jour[6], valeur: graphPourcData.pourc[6] }
	];
	
	if(machine !== "All"){
		if(typeof graphPourc !== 'undefined'){
			graphPourc.setData(data);
			return graphPourc;
		}
		else{
			var graph = new Morris.Line({
					// ID of the element in which to draw the chart.
					element: 'pourcDefaut' + machine,
					
					// Chart data records -- each entry in this array corresponds to a point on the chart.
					data: data,
					
					// The name of the data record attribute that contains x-values.
					xkey: 'nbr',
					
					// A list of names of data record attributes that contain y-values.
					ykeys: ['valeur'],
					
					// Labels for the ykeys -- will be displayed when you hover over the chart.
					labels: ['Pourcentage'],
					
					pointFillColors: ['#FF530D','#81530D','#BBD20D','#FF0000','#FF009D','#6F009D','#0953B4','#09DCB4','#046351','#E16351','#4C221C'],
					parseTime: false,
					hideHover: false,
					resize: true
			}).on('click', function(i, row){
				var dateOffset = i - 6;
				
				// send data to php page via ajax
				$.ajax({
					url: "get24hData.php",
					type: "POST",
					data: {
						machine: machine,
						dateOffset: dateOffset
					},
					dataType: "text",
					success: function(data){
						var listData = data.split("AND");
						var dataGraph24h = eval("("+listData[0]+")");
						var date = listData[1];
						
						// activate 24h graph modal
						var $modal24h = $("#modal24h" + machine).modal();
						$modal24h.on('shown.bs.modal',function(){
							// draw 24h graph in modal
							graph24h = draw24hGraph(machine, dataGraph24h, graph24h);
							$(this).off('shown.bs.modal');
						});
						
						// set date for modal title
						$("#date24hGraph" + machine).text(date);
					}
				});
			});
			return graph;
		}
	}
	else {
		if(typeof graphPourc !== 'undefined'){
			graphPourc.setData(data);
			return graphPourc;
		}
		else{
			var graph = new Morris.Line({
					// ID of the element in which to draw the chart.
					element: 'pourcUsine',
					
					// Chart data records -- each entry in this array corresponds to a point on the chart.
					data: data,
					
					// The name of the data record attribute that contains x-values.
					xkey: 'nbr',
					
					// A list of names of data record attributes that contain y-values.
					ykeys: ['valeur'],
					
					// Labels for the ykeys -- will be displayed when you hover over the chart.
					labels: ['Pourcentage'],
					
					pointFillColors: ['#FF530D','#81530D','#BBD20D','#FF0000','#FF009D','#6F009D','#0953B4','#09DCB4','#046351','#E16351','#4C221C'],
					parseTime: false,
					hideHover: false,
					resize: true
			}).on('click', function(i, row){
				var dateOffset = i - 6;
				
				// send data to php page via ajax
				$.ajax({
					url: "get24hData.php",
					type: "POST",
					data: {
						machine: machine,
						dateOffset: dateOffset
					},
					dataType: "text",
					success: function(cbdata){
						var listData = cbdata.split("AND");
						var dataGraph24h = eval("("+listData[0]+")");
						var date = listData[1];
						
						// activate 24h graph modal
						var $modal24h = $("#modal24h" + machine).modal();
						$modal24h.on('shown.bs.modal',function(){
							// draw 24h graph in modal
							graph24h = draw24hGraph(machine, dataGraph24h, graph24h);
							$(this).off('shown.bs.modal');
						});
						
						// set date for modal title
						$("#date24hGraph" + machine).text(date);
					}
				});
			});
			return graph;
		}
	}
};

function drawParetoGraph(machine, listDefaut, listPareto){
	new Morris.Bar({
			// ID of the element in which to draw the chart.
			element: 'paretoDefaut' + machine,
			
			// Chart data records -- each entry in this array corresponds to a point on the chart.
			data: [
				{ pourcentage: listDefaut[0],  value: listPareto[0] },
				{ pourcentage: listDefaut[1],  value: listPareto[1] },
				{ pourcentage: listDefaut[2],  value: listPareto[2] },
				{ pourcentage: listDefaut[3],  value: listPareto[3] },
				{ pourcentage: listDefaut[4],  value: listPareto[4] },
				{ pourcentage: listDefaut[5],  value: listPareto[5] },
				{ pourcentage: listDefaut[6],  value: listPareto[6] },
				{ pourcentage: listDefaut[7],  value: listPareto[7] },
				{ pourcentage: listDefaut[8],  value: listPareto[8] },
				{ pourcentage: listDefaut[9],  value: listPareto[9] }
			],
			
			// The name of the data record attribute that contains x-values.
			xkey: 'pourcentage',
			
			// A list of names of data record attributes that contain y-values.
			ykeys: ['value'],
			
			// Labels for the ykeys -- will be displayed when you hover over the chart.
			labels: ['Pourcentage'],
			
			resize: true
		});
};

function draw24hGraph(machine, dataGraph24h, graph24h){
	var data = [
		{ Heure: dataGraph24h.hour[0],  valeur: dataGraph24h.pourc[0]  },
		{ Heure: dataGraph24h.hour[1],  valeur: dataGraph24h.pourc[1]  },
		{ Heure: dataGraph24h.hour[2],  valeur: dataGraph24h.pourc[2]  },
		{ Heure: dataGraph24h.hour[3],  valeur: dataGraph24h.pourc[3]  },
		{ Heure: dataGraph24h.hour[4],  valeur: dataGraph24h.pourc[4]  },
		{ Heure: dataGraph24h.hour[5],  valeur: dataGraph24h.pourc[5]  },
		{ Heure: dataGraph24h.hour[6],  valeur: dataGraph24h.pourc[6]  },
		{ Heure: dataGraph24h.hour[7],  valeur: dataGraph24h.pourc[7]  },
		{ Heure: dataGraph24h.hour[8],  valeur: dataGraph24h.pourc[8]  },
		{ Heure: dataGraph24h.hour[9],  valeur: dataGraph24h.pourc[9]  },
		{ Heure: dataGraph24h.hour[10], valeur: dataGraph24h.pourc[10] },
		{ Heure: dataGraph24h.hour[11], valeur: dataGraph24h.pourc[11] },
		{ Heure: dataGraph24h.hour[12], valeur: dataGraph24h.pourc[12] },
		{ Heure: dataGraph24h.hour[13], valeur: dataGraph24h.pourc[13] },
		{ Heure: dataGraph24h.hour[14], valeur: dataGraph24h.pourc[14] },
		{ Heure: dataGraph24h.hour[15], valeur: dataGraph24h.pourc[15] },
		{ Heure: dataGraph24h.hour[16], valeur: dataGraph24h.pourc[16] },
		{ Heure: dataGraph24h.hour[17], valeur: dataGraph24h.pourc[17] },
		{ Heure: dataGraph24h.hour[18], valeur: dataGraph24h.pourc[18] },
		{ Heure: dataGraph24h.hour[19], valeur: dataGraph24h.pourc[19] },
		{ Heure: dataGraph24h.hour[20], valeur: dataGraph24h.pourc[20] },
		{ Heure: dataGraph24h.hour[21], valeur: dataGraph24h.pourc[21] },
		{ Heure: dataGraph24h.hour[22], valeur: dataGraph24h.pourc[22] },
		{ Heure: dataGraph24h.hour[23], valeur: dataGraph24h.pourc[23] }
	];
	
	if(typeof graph24h !== 'undefined'){
		graph24h.setData(data);
		return graph24h;
	}
	else{
		var graph = new Morris.Line({
			// ID of the element in which to draw the chart.
			element: 'graph24h' + machine,
					
			// Chart data records -- each entry in this array corresponds to a point on the chart.
			data: data,
			
			// The name of the data record attribute that contains x-values.
			xkey: 'Heure',
					
			// A list of names of data record attributes that contain y-values.
			ykeys: ['valeur'],
			
			// Labels for the ykeys -- will be displayed when you hover over the chart.
			labels: ['Pourcentage'],
					
			pointFillColors: ['#FF530D','#81530D','#BBD20D','#FF0000','#FF009D','#6F009D','#0953B4','#09DCB4','#046351','#E16351','#4C221C'],
			parseTime: false,
			hideHover: false
		});
		
		return graph;
	}
}

function drawGraph(machine, graphPourc, listDefaut, listPareto){
	// get all active label
	var listLabel = $("label.active");
	
	// for each label
	for(var index in listLabel){
		// get label
		var label = listLabel[index];
		
		// get label id
		var idLabel = label.id;
		
		// check option
		if(idLabel == "Pourcentage"+machine){
			// draw pourcentage graph
			drawPourcGraph(machine, graphPourc);
		}
		else if(idLabel == "Pareto"+machine){
			// draw pareto graph
			drawParetoGraph(machine, listDefaut, listPareto);
		}
	}
};


/******************
*		AJAX STARTER
******************/
function start(machine, option, graphPourc, listDefaut, listPareto){
	$.ajax({
		url: "ajaxStarter.php",
		type: "GET",
		data: {
			"machine": machine,
			"option": option
		},
		dataType: "text",
		success: function(response){
			document.getElementById("graphMachine"+machine).innerHTML = response;
			if(option == "both"){
				drawPourcGraph(machine, graphPourc);
				drawParetoGraph(machine, listDefaut, listPareto);
			}
			else{
				drawGraph(machine, graphPourc, listDefaut, listPareto);
			}
		}
	});
};


/*************************************
*		AJAX CHANGER POURCENTAGE GRAPH
*************************************/
function changeToGraphPourc(machine, graphPourc){
	$.ajax({
		dataType: "text",
		success: function(){
			// prepare graph data
			graphPourc = eval("("+graphPourc+")");
			
			// clear corresponding graph on the page
			var element = document.getElementById("pourcDefaut"+machine);
			if(element){
				element.innerHTML = "";
			}
			else{
				element = document.getElementById("paretoDefaut"+machine);
				if(element){
					element.innerHTML = "";
				}
			}
			
			// change element id in order to draw graph
			element.setAttribute("id","pourcDefaut"+machine);
			
			// draw new graph
			start(machine, "pourc", graphPourc, null, null);
		}
	});
};


/********************************
*		AJAX CHANGER PARETO GRAPH
********************************/
function changeToGraphPareto(machine, graphPareto){
	$.ajax({
		dataType: "text",
		success: function(){
			// get graph data
			graphPareto = eval("("+graphPareto+")");
			
			// get listDefaut
			var listDefaut = [];
	    for (var defaut in graphPareto){
	      listDefaut.push(defaut);
	    }
			
			// get listPareto
			var listPareto = [];
	    for (var defaut in graphPareto){
	      listPareto.push(graphPareto[defaut]);
	    }
			
			// clear corresponding graph on the page
			var element = document.getElementById("pourcDefaut"+machine);
			if(element){
				element.innerHTML = "";
			}
			else{
				element = document.getElementById("paretoDefaut"+machine);
				if(element){
					element.innerHTML = "";
				}
			}
			
			// change element id in order to draw graph
			element.setAttribute("id","paretoDefaut"+machine);
			
			// draw new graph
			start(machine, "pareto", null, listDefaut, listPareto);
		}
	});
};


/********************************
*		AJAX MACHINE ALL REFRESHER
********************************/
function refreshMachineAllGraph(jsonOptionMachine, time){
	$.ajax({
		url: "ajaxMachineAllRefresher.php",
		type: "GET",
		data: {"jsonOptionMachine": jsonOptionMachine},
		dataType: "text",
		success: function(cbdata){
			// get infos
			var jsonListInfo = cbdata.split("AND");
			var listInfo = {};
			for(var index in jsonListInfo){
				listInfo[index] = eval("("+jsonListInfo[index]+")");
			}
			
			// get listMachine
			var listMachine = listInfo[0];
			
			// get optionMachine
			var optionMachine = listInfo[1];
			
			// get listMachineGraph
			var listMachineGraph = listInfo[2];
			
			// for each machine
			for(var index in listMachine){
				// get machine
				var machine = listMachine[index];
				
				// get option
				var option = optionMachine[machine];
				
				// get graph
				var graph = listMachineGraph[machine];
				
				// check option
				if(option == "pourc"){
					// draw
					start(machine, option, graph, null, null);
				}
				else if(option == "pareto"){
					// get listDefaut
					var listDefaut = [];
			    for (var defaut in graph){
			      listDefaut.push(defaut);
			    }
					
					// get listPareto
					var listPareto = [];
			    for (var defaut in graph){
			      listPareto.push(graph[defaut]);
			    }
					
					// draw
					start(machine, option, null, listDefaut, listPareto);
				}
			}
				
			// wait and refresh
			setTimeout(function(){
				refreshMachineAllGraph(jsonOptionMachine, time);
			},time);
		}
	});
};


/******************************
*		AJAX INDEX REFRESHER
******************************/
function refreshIndex(graphPourc, time){
	$.ajax({
		url: "ajaxIndexRefresher.php",
		type: "GET",
		dataType: "text",
		success: function(cbdata){
			// get graph
			var jsonGraph = cbdata;
			var graphData = eval("("+jsonGraph+")");
			
			// draw graph
			graphPourc = drawPourcGraph("All", graphData, graphPourc);
			
			// wait and refresh
			setTimeout(function(){
				refreshIndex(graphPourc, time);
			},time);
		}
	});
}


/******************************
*		AJAX MACHINE REFRESHER
******************************/
function refreshMachine(machine){
	$.ajax({
		url: "ajaxMachineRefresher.php",
		type: "GET",
		data: {"machine": machine},
		dataType: "text",
		success: function(cbdata){
			// get infos
			var jsonListInfo = cbdata.split("AND");
			var listInfo = {};
			for(var index in jsonListInfo){
				listInfo[index] = eval("("+jsonListInfo[index]+")");
			}
			
			// get graphPourc
			var graphPourc = listInfo[0];
			
			// get listDefaut
			var listDefaut = listInfo[1];
			
			// get listPareto
			var listPareto = listInfo[2];
			
			// draw graphs
			start(machine, "both", graphPourc, listDefaut, listPareto);
		}
	});
};


/******************************
*				PAGE DETECTION
*						 AND
*				MENU TAB FOCUS
******************************/
function focusMenuTab(){
	// get url
	var url = window.location.href;
	
	// get page
	var strs = url.split("/");
	var page = strs[strs.length - 1];
	
	// check if query exists
	strs = page.split("?");
	if (strs.length == 1){ // index OR machineAll
		// no query
		if (strs[0] == "index.php") {
			// focus tab
			$("#menuIndex").addClass("active");
		}
		else if (strs[0] == "machineAll.php") {
			// focus tab
			$("#menuMachineAll").addClass("active");
		}
	}
	else if (strs.length == 2) { // machine
		// get machine name
		strs = strs[strs.length - 1].split("=");
		var machine = strs[strs.length - 1];
		
		// generate id
		var id = "menu" + machine;
		
		// focus tab
		$("#" + id).addClass("active");
	}
};


/*********************************
*						GET DATE
*							FOR
*					 24H GRAPH
*********************************/
function get24hGraphDate(dateOffset){
	var today = new Date();
	if(today.getDate() <= 6){
		
	}
	else{
		return today.toDateString();
	}
};