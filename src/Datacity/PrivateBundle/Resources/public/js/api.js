var erpModel = {
	"id" 			: null,
	"nom"			: null,
	"titre"			: null,
	"description" 	: null,
	"longitude" 	: null,
	"latitude"		: null
};

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

var generateModel = function(model) {
	var result = '';
	for (field in model) {
		result += '<br/><button class="btn btn-default" type="button">' + field + '</button><br/>';
	}
	return result;
}
