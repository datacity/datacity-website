var indexTable = 1;
var file = {};
var clickedColors = {};

Object.size = function(obj) {
 var size = 0, key;
 for (key in obj) {
 	if (obj.hasOwnProperty(key)) size++;
 }
 return size;
}

function generateRows(rows, nbfield) {
	var array = new Array()
	for (rowName in rows) {
		if (Object.size(rows[rowName]) == nbfield) {
			subArray = new Array();
			for (rowContent in rows[rowName]) {
				subArray.push(rows[rowName][rowContent]);
			}
			array.push(subArray);
		}	
	}
	return array;
}

function generateHeaders(headers, headerClass) {
	var array =	new Array();
	var json = {};

	for (field in headers) {
		json = {
			"sTitle" : headers[field].replace(/ /g, "_"),
			"sClass" : headerClass
		};
		array.push(json);
	}
	return array;
}

function generateMap(headers) {
	var map = {};
	var i = 0;
	for (field in headers) {
		var fieldName = headers[field].replace(/ /g, "_");
		map[fieldName] = i++;
	}
	return map;
}

function createRelationFile(headersDtFormat, rowsDtFormat, map) {
	file['table' + indexTable] = {};
   	file['table' + indexTable]['header'] = headersDtFormat;
   	file['table' + indexTable]['rows'] = rowsDtFormat;
   	file['table' + indexTable]['map'] = map;
   	file['table' + indexTable]['link'] = new Array();
   	file['table' + indexTable]['append'] = new Array();
   	file['table' + indexTable]['clickedColors'] = {};
}

(function($) {
	$.fn.generateDataTables = function(options) {
		var defaults = {
			'header' 	: {
				'color'	: 'blue-background',
				'name' 	: null
			},
			'tableId' 	: 'table',
			'sizeX' 	: '900px',
			'sizeY'		: '300px',
			'sortColumn': false,
			'displayLength' : 30,
			'data'		: null,
			'field'		: null
		};
		var params = $.extend(defaults, options);
		if (params.data == null || params.field == null) {
			console.log("You have to send a aaData and aoColumns of Datatable format");
			return;
		}
		$(this).append("<div class='box-header " + params.header.color + "'><div class='title'>" + params.header.name + "</div></div><br>");
		$(this).append('<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="' + params.tableId + indexTable + '"></table>');
		$('#' + params.tableId + indexTable).dataTable( {
		"sScrollY": params.sizeY,
		"sScrollX": params.sizeX,
		"bSort": params.sortColumn,
		"oLanguage": {
			"sLengthMenu": "_MENU_ records per page"
		},
		"iDisplayLength": params.displayLength,
    	"aLengthMenu": [[30, 50, 100, 500, -1], [30, 50, 100, 500, "Tous"]],
        "aaData": params.data,
        "aoColumns": params.field
    	} );
		indexTable++;
	}
})(jQuery);

var initArray = function(length) {
	var tab = new Array();
	for (var i = 0; i < length; i++) {
		tab[i] = 0;
	}
	return tab;
}

function addNewTab(name) {
	indexTable--
   	$('#tab' + indexTable).removeClass('active');
   	$('.current' + indexTable).removeClass('active');
   	indexTable++;
   	$('#mtab' + indexTable).text(name.substr(0, 10));
   	$('#tab' + indexTable).addClass('active');
   	$('.current' + indexTable).addClass('active');
}

function writeContentOnServer(content) {
	createJsonFile(content);
}

function postalCode(exp, row) {
	if (exp.length == 5) {
		if (parseInt(exp) > 10000 && parseInt(exp) < 80000) {
			row["postalCode"] = exp;
			return true;
		}
	}
	return false;
}

function roadType(exp, row) {
	var expression = new RegExp(/Place|Rue|Avenue|Quai|Boulevard|Allée|Route|Square|Esplanade|Chemin|Impasse|Enclos|Descente/);
	if (expression.test(exp) == true) {
		row["roadType"] = exp;
		return true;
	}
	return false;
}

function roadNumber(exp, row) {
	var nb = parseInt(exp);
	if (nb > 0 && nb < 10000) {
		row["roadNumber"] = nb;
		return true;
	}
	return false;

}

function town(exp, row) {
	var expression = new RegExp(/Montpellier|Nîmes|Nimes|Lunel|Paris/);
	if (expression.test(exp) == true) {
		row["town"] = exp;
		return true;
	}
	return false;
}

function extractRoadName(adressArray, i, row) {
	var j = i++;
	for (; i < adressArray.length; i++) {
		if (town(adressArray[i], row) == true || postalCode(adressArray[i], row) == true) {
				return i;
		}
		row["roadName"] == "" ? row["roadName"] += adressArray[i] : row["roadName"] += " " + adressArray[i]
	}
	return j;
}

function formatAdress(rows) {
	rows.map(function (row) {
		if (row.adress) {
			var adressArray = row.adress.split(" ");
			row.adress = {
				"roadName": "",
				"town" : "",
				"roadType" : "",
				"roadNumber" : "",
				"postalCode" : ""
			};
			for (var i = 0; i < adressArray.length; i++) {
				if (adressArray[i] != "0") {
					roadNumber(adressArray[i], row.adress);
					town(adressArray[i], row.adress);
					postalCode(adressArray[i], row.adress);
					if (roadType(adressArray[i], row.adress) == true) {
						i = extractRoadName(adressArray, i, row.adress);
					}
				}
			}
		}
	});
	console.log(rows);
}

function escapeMultiRows(rows) {
	rows.sort(function(a, b) {
		if (!a.name || !b.name)
			return -1;
		return (a.name > b.name) ? 1 : -1;
	});
	var newMap = {};
	$.extend(true, rows, newMap);
	for (var row in newMap) {
		if (newMap[row].name && newMap[row].name instanceof String)
			newMap[row].name = newMap[row].name.toLowerCase().replace(/ /g, '');
		if (newMap[row + 1]) {
			if (newMap[row + 1].name && newMap[row].name)
				if (newMap[row + 1].name === newMap[row].name) {
					console.log("doublon !!!");
					console.log(newMap[row]);
					console.log(newMap[row + 1]);
			}
		}
	}
}

$('.final-merge').click(function() {
	var header = generateHeaders(modelApi.fields);
	var rowArray = new Array();
	addNewTab("Final Table");
	for (var subfile in file) {
		for (var rows in file[subfile].rows) {
			var rowLine = initArray(model.fields.length);
			
			// CHAMPS CONCATENES
			for (var colors in file[subfile]['append']) {
				if (file[subfile].rows[rows][file[subfile]['append'][colors][0]] == "0")
					file[subfile].rows[rows][file[subfile]['append'][colors][0]] = "";
				for (var index in file[subfile]['append'][colors]) {
					if (index > 0 && file[subfile].rows[rows][file[subfile]['append'][colors][index]] != "0")
						file[subfile].rows[rows][file[subfile]['append'][colors][0]] = file[subfile].rows[rows][file[subfile]['append'][colors][0]].toString() + " " + file[subfile].rows[rows][file[subfile]['append'][colors][index]];						
				}
			}

			// CHAMPS NORMAUX
			for (var link in file[subfile].link) {
				for (var key in file[subfile].link[link]) {
					var value = file[subfile].link[link][key];
					rowLine[value] = file[subfile].rows[rows][key];
				}
			}
			rowArray.push(rowLine);
		}
	}
	var objectArray = new Array();
	for (var row in rowArray) {
		var objectJson = {};
		for (var subrow in rowArray[row]) {
			objectJson[header[subrow].sTitle] = rowArray[row][subrow];
		}
		objectArray.push(objectJson);
	}
	formatAdress(objectArray);
	//escapeMultiRows(objectArray);
	writeContentOnServer({
		"status" : "ok",
		"response"	 : objectArray
	});
	
	//TODO : eviter de regénérer les headers
	header = generateHeaders(model.fields, "final-table");
	$('#tab' + indexTable).generateDataTables({
			'header' 	: {
				'name' 	: 'Table fusionnée',
				'color' : 'green-background'
			},
			'tableId' 	: 'table',
			'data'		: rowArray,
			'field'		: header
	});
});

$('body').on('click', '.final-table', function(e) {
	alert('on a cliqué sur la final table ! ');
});

function sameColor(clickedColors, comparator) {
	for (keys in clickedColors) {
		if (keys == comparator)
			return true;
	}
	return false;
}

$('body').on('click', 'th', function(e) { 
	var currentTable = $(this).attr('class').split(' ')[1];
	var clickedCategory = $(this).text();
	var linkMap = {};
	var indexKey;

	if ($(this).css('background-color') != "rgba(0, 0, 0, 0)" 
		&& $(this).css('background-color') != 'rgb(255, 255, 255)') {
			$(this).css('background-color', 'white');
			$(this).css('color', '#656565');
			indexKey = file[currentTable].map[clickedCategory];
			for (link in file[currentTable]['link']) {
				if (file[currentTable]['link'][link][indexKey] !== "undefined") {
					delete file[currentTable]['link'][link];
					break;
				}	
			}
		}
	else {
		if (currentColor != null) {
			indexKey = file[currentTable].map[clickedCategory];
			if (file[currentTable]['append'][currentColor]) {
				file[currentTable]['append'][currentColor].push(indexKey);
				console.log("ajout d'un nouvelle instance a la suite du tableau de correspondance");
			}
			else if (file[currentTable].clickedColors[currentColor] && sameColor(file[currentTable].clickedColors, currentColor) == true) {
				file[currentTable]['append'][currentColor] = [];
				file[currentTable]['append'][currentColor].push(file[currentTable].clickedColors[currentColor], indexKey);
				console.log("ajout d'une nouvelle coleur dans le tableau de correspondance");
			}
			else {
				file[currentTable].clickedColors[currentColor] = indexKey;
				var valueFinalTableIndex = model.map[selectedField];
				linkMap[indexKey] = valueFinalTableIndex;
				file[currentTable]['link'].push(linkMap);
			}	
			$(this).css('background-color', currentColor);
			$(this).css('color', 'white');
			$('.boxColored').css('background-color', 'white');
			currentColor = null;
		}
	}
 });

