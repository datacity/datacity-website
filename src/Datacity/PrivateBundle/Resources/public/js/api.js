var erpModel = {
	"id" 			: null,
	"nom"			: null,
	"categorie"		: null,
	"description" 	: null,
	"longitude" 	: null,
	"latitude"		: null,
	"adresse"		: null
};

var colors = ["purple", "green", "orange", "pink", "brown", "red", "blue"];
var currentColor;

var callAjax = function(jsonobject) {
	$.ajax({
		type: "GET",
		url: "http://127.0.0.1:8888/test",
		dataType: "jsonp",
		data: jsonobject,
        jsonpCallback: "_testcb",
		success: function (data) {
			console.log(data);
		},
		error : function(xhr, status, error) {
			console.log("Error: " + error.message);
		}
	});
}

$('#public-service').click(function() {
	$('.models').html(generateModel(erpModel));
});

$('body').on('click', '.modelfield', function() {
	$('.boxColored').css('background-color', $(this).css('background-color'));
	currentColor = $(this).css('background-color');
});

var generateModel = function(model) {
	var result = '';
	console.log("coucou");
	var i = 0;
	for (field in model) {
		result += '<br/><button class="btn modelfield btn-default btn-' + colors[i] + '" type="button">' + field + '</button><br/>';
		i++;
	}
	return result;
};
