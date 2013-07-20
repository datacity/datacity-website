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

