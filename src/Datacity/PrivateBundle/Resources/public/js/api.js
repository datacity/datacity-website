/**
 * Par la suite, les modèles seront générés dynamiquement depuis l'api. En envoyant en paramètre 
 * dans une requête GET la sous catégorie que nous désirons, nous récupèrerons un JSON
 * de ce type dans une variable model.
 */

var model = {
	"fields": [
		"id",
		"nom",			
		"categorie",	
		"description",	
		"longitude",	
		"latitude",	
		"adresse"]
};
var colors = ["purple", "green", "orange", "pink", "brown", "red", "blue"];
var currentColor;
var selectedField;

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
	$('.models').html(generateModel(model));
});

$('body').on('click', '.modelfield', function() {
	$('.boxColored').css('background-color', $(this).css('background-color'));
	currentColor = $(this).css('background-color');
	selectedField = $(this).text();
});

var generateModel = function(model) {
	var result = '';
	var i = 0;
	model.map = {};
	for (var field in model.fields) {
		model.map[model.fields[field]] = i;
		result += '<br/><button class="btn modelfield btn-default btn-' + colors[i] + '" type="button">' + model.fields[field] + '</button><br/>';
		i++;
	}
	return result;
};
