/*
*		START WITH
*/
String.prototype.startWith = function (str) {
	if(str == null || str == "" || this.length == 0 || str.length > this.length)
	  return false;
	if(this.substr(0, str.length) == str)
	  return true;
	else
	  return false;
	return true;
};

/*
*		DRAW GRAPH
*/
function drawGraph(machine, graphPourc, listDefaut, listPareto) {
	// get label
	var idLabel = $("label.active").attr("id");
	
	// if pourcentage button selected
	if(idLabel.startWith("Pourcentage")) {
		// draw pourcentage graph
		new Morris.Line({
			// ID of the element in which to draw the chart.
			element: 'pourcDefaut' + machine,
			
			// Chart data records -- each entry in this array corresponds to a point on the chart.
			data: [
				{ nbr: graphPourc.jour[0], valeur: graphPourc.pourc[0] },
				{ nbr: graphPourc.jour[1], valeur: graphPourc.pourc[1] },
				{ nbr: graphPourc.jour[2], valeur: graphPourc.pourc[2] },
				{ nbr: graphPourc.jour[3], valeur: graphPourc.pourc[3] },
				{ nbr: graphPourc.jour[4], valeur: graphPourc.pourc[4] },
				{ nbr: graphPourc.jour[5], valeur: graphPourc.pourc[5] },
				{ nbr: graphPourc.jour[6], valeur: graphPourc.pourc[6] }
			],
			
			// The name of the data record attribute that contains x-values.
			xkey: 'nbr',
			
			// A list of names of data record attributes that contain y-values.
			ykeys: ['valeur'],
			
			// Labels for the ykeys -- will be displayed when you hover over the chart.
			labels: ['Pourcentage'],
			
			pointFillColors: ['#FF530D','#81530D','#BBD20D','#FF0000','#FF009D','#6F009D','#0953B4','#09DCB4','#046351','#E16351','#4C221C'],
			parseTime: false,
			hideHover: false,
		});
	}
	
	// if not
	else if(idLabel.startWith("Pareto")) {
		// draw pareto graph
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
		});
	}
};



/*
*		AJAX
*/
function createXMLHttpRequest() {
	var xmlHttp = null;
	if (window.XMLHttpRequest) {// code for all new browsers
		xmlHttp = new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {// code for IE5 and IE6
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	return xmlHttp;
};

// Starter
function start(machine, option, graphPourc, listDefaut, listPareto){
	var xmlHttp = createXMLHttpRequest();
	var url = "ajaxStarter.php?machine=" + machine + "&option=" + option;
	xmlHttp.onreadystatechange = function(){ callbackStarter(xmlHttp, machine, graphPourc, listDefaut, listPareto, option) };
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
};

// Starter Callback
function callbackStarter(xmlHttp, machine, graphPourc, listDefaut, listPareto, option) {
	if (xmlHttp.readyState == 4 && xmlHttp.status == 200) { // 4 = "loaded" 200 = OK
		document.getElementById("graphMachine"+machine).innerHTML = xmlHttp.responseText;
		drawGraph(machine, graphPourc, listDefaut, listPareto);
		
		//setTimeout(function(){ start(machine, option, graphPourc, listDefaut, listPareto);},2000);
	}
};

// Changer
function change(machine, option, graphPourc, listDefaut, listPareto){
	var xmlHttp = createXMLHttpRequest();
	var url = "ajaxChanger.php?machine=" + machine + "&option=" + option;
	xmlHttp.onreadystatechange = function(){ callbackStarter(xmlHttp, machine, graphPourc, listDefaut, listPareto, option) };
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
};

// Changer Callback
function callbackChanger(xmlHttp, machine, graphPourc, listDefaut, listPareto, option) {
	if (xmlHttp.readyState == 4 && xmlHttp.status == 200) { // 4 = "loaded" 200 = OK
		document.getElementById("graphMachine"+machine).innerHTML = xmlHttp.responseText;
		drawGraph(machine, graphPourc, listDefaut, listPareto);
		
		//setTimeout(function(){ start(machine, option, graphPourc, listDefaut, listPareto);},2000);
	}
};