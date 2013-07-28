var indexTable = 1;
var file = {};

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

function addNewTab() {
	indexTable--
   	$('#tab' + indexTable).removeClass('active');
   	$('.current' + indexTable).removeClass('active');
   	indexTable++;
   	$('#tab' + indexTable).addClass('active');
   	$('.current' + indexTable).addClass('active');
}

$('.final-merge').click(function() {
	var header = generateHeaders(model.fields);
	var rowArray = new Array();

	for (var subfile in file) {
		for (var rows in file[subfile].rows) {
			var rowLine = initArray(model.fields.length);
			for (var link in file[subfile].link) {
				for (var key in file[subfile].link[link]) {
					var value = file[subfile].link[link][key];
					rowLine[value] = file[subfile].rows[rows][key];
				}
			}
			rowArray.push(rowLine);
		}
	}
	addNewTab();
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

$('body').on('click', 'th', function(e) { 
	var currentTable = $(this).attr('class').split(' ')[1];
	if ($(this).css('background-color') != "rgba(0, 0, 0, 0)" 
		&& $(this).css('background-color') != 'rgb(255, 255, 255)') {
		$(this).css('background-color', 'white');
		$(this).css('color', '#656565');
		// ON DOIT POP LE TRUC QUI A ETE ENLEVE PAR RAPPORT A LA CATEGORIE
		file[currentTable]['link'].pop();
	}
	else {
		if (currentColor != null) {
			var clickedCategory = $(this).text();
			var linkMap = {};
			var indexKey = file[currentTable].map[$(this).text()];
			var valueFinalTableIndex = model.map[selectedField];
			linkMap[indexKey] = valueFinalTableIndex;
			file[currentTable]['link'].push(linkMap);
			$(this).css('background-color', currentColor);
			$(this).css('color', 'white');
			$('.boxColored').css('background-color', 'white');
			currentColor = null;
		}
	}
 });

