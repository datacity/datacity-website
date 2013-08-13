/**
 * Par la suite, les modèles seront générés dynamiquement depuis l'api. En envoyant en paramètre 
 * dans une requête GET la sous catégorie que nous désirons, nous récupèrerons un JSON
 * de ce type dans une variable model.
 */

var model = {
	"fields": [
		"nom",		
		"catégorie(s)",
		"tags",
		"description",	
		"longitude",	
		"latitude",	
		"adresse",
		"horaires",
		"téléphone",
		"site web",
		"e-mail"]
};

var modelApi = {
	"fields": [
		"name",		
		"categorie",
		"tags",
		"description",	
		"longitude",	
		"latitude",	
		"adress",
		"schedules",
		"phone",
		"website",
		"email"]
};
var colors = ["purple", "green", "orange", "pink", "brown", "red", "blue", "yellow"];
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

var createJsonFile = function(jsonObject) {
	$.ajax({
		type: "POST",
		url: "http://datacity.fr:8888/test",
        crossDomain: true,
        //contentType: "application/json; charset=utf-8",
		dataType: "json",
		data: jsonObject,
		success: function (data) {
			console.log("success" + data);
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
		result += '<br/><button class="btn modelfield btn-default" type="button" style="color: #FFF;background-color: ' + getRandomColor() + '">' + model.fields[field] + '</button><br/>';
		i++;
	}
	return result;
};
