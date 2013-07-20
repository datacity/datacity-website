var example = 1;

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

function generateHeaders(headers) {
	var array =	new Array();
	var json = {};

	for (field in headers) {
		json = {"sTitle" : headers[field].replace(/ /g, "_")};
		array.push(json);
	}
	return array;
}

function generateDataTables(headers, rows, tableName) {
    $('#datatable' + example).append("<div class='box-header blue-background'><div class='title'>" + tableName + "</div></div><br>");
	$('#datatable' + example).append( '<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="tableopt' + example + '"></table>' );
    $('#tableopt' + example).dataTable( {
    	"sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
		"sScrollY": "200px",
		"sScrollX": "900px",
		"oLanguage": {
			"sLengthMenu": "_MENU_ records per page"
		},
		"iDisplayLength": 30,
    	"aLengthMenu": [[30, 50, 100, 500, -1], [30, 50, 100, 500, "All"]],
        "aaData": generateRows(rows, headers.length),
        "aoColumns": generateHeaders(headers)
    } );
    example++;
}

$('#public-service').click(function() {
	$('.models').html(
		generateModel(erpModel)
		);
});

var saveOnThumbnail = function (first, second, type) {	
	$('.src').filter('.src').append('<br/><button class="btn btn-primary ' + type + '" type="button">' + $(first).text() + '</button>');
	$('.dst').filter('.dst').append('<br/><button class="btn btn-primary ' + type + '" type="button">' + $(second).text() + '</button>');
	$('.' + type).css('background-color', first.color);
	$('.' + type).css('background-color', second.color);
};

var app = {
	"select" : null,
	"merge"	: null
};

(function($) {
	$.fn.cellsSelection = function(options, callback) {
		var defaults = {
			'color' 		: 'purple',
			'rgbString' 	: 'rgb(128, 0, 128)',
			'initColor' 	: 'white',
			'onTwoClicked' 	: null,
			'globalSave'	: null,
			'checked'       : null,
			'type'			: null
		};
		var params = $.extend(defaults, options);
		if (params.checked == 'checked') {		
			if ($(this).css('background-color') == params.rgbString)
				$(this).css("background-color", params.initColor)
			else {
				this.color = params.color;
				if (params.globalSave != null) {
					params.onTwoClicked(params.globalSave, this, params.type);
					$(params.globalSave).css("background-color", params.initColor);
					callback(null, params.type);
				}
				else {
					$(this).css('background-color', params.color);
					callback(this, params.type);
				}
			}
		}
	}
})(jQuery);

var saveIt = function (element, type) {
	if (type == 'select')
		app.select = element;
	else if (type == 'merge')
		app.merge = element;
}

$('body').on('click', 'th', function() { 
	$(this).cellsSelection({
		'type'			: 'merge',
		'onTwoClicked' 	: saveOnThumbnail,
		'globalSave' 	: app.merge,
		'checked'		: $("#merge").attr('checked')
	}, saveIt);
	$(this).cellsSelection({
		'color'			: 'orange',
		'rgbString'		: 'rgb(255, 165, 0)',
		'type'			: 'select',
		'onTwoClicked' 	: saveOnThumbnail,
		'globalSave' 	: app.select,
		'checked'		: $("#selection").attr('checked')
	}, saveIt);
 });

