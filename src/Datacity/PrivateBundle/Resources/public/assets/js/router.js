/*	Router Object for all ajax request.
 *	@param url should contain an url such as http://domain.name:(port)
 */
var Router = function(url) {
	this.url = url;

	//En attendant le web service Php
	this.publicKey = "4561321edgjlkjd";
}
 
// Callback take 2 parameters : error and data. 
// If there is an error, only error is filled on callback.
// Otherwise, err is set to null and data contain response
Router.prototype = {

	ajaxRequest: function(callback, ajaxUrl, httpType, dataToSend, ctype, pdata) {
		var that = this;
		var contentTypeDef = 'application/x-www-form-urlencoded; charset=UTF-8';
		var processDataDef = true;

		if (ctype !== "undefined") 
			contentTypeDef = ctype;
		if (pdata !== "undefined")
			processDataDef = pdata;
		if (dataToSend === "undefined")
			dataToSend = "";
		$.ajax({
			url: ajaxUrl,
			type: httpType,
			data: dataToSend,
            contentType: contentTypeDef,
            processData: processDataDef,
			success: function(response, textStatus, jqXHR) {
				if (response.status && response.status === "success") {
					if (response.data)
						callback(null, response.data);
					if (response.message) {
						console.log(response.message);
					}
					if (!response.data && response.message)
						callback(null, response.message);
				}	
				else if (response.status && response.status === "error" && response.message)
					callback(response.message);
				else
					console.warn("Response not well formated");
			},
			error: function(err) {
				callback(err.statusText);
			}
		});	
	},
	checkParameters: function(callback, parameters, toCheck) {
		if (!toCheck || !(toCheck instanceof Array)) {
			return true;
		}
		var errorMessage = "You need to send : ";
		var errorFinded = false;
		for (var params in toCheck) {
			if (!parameters || !parameters[toCheck[params]]) {
				errorMessage += toCheck[params] + '| ';
				errorFinded = true;				
			}
		}
		if (errorFinded === true) {
			callback(errorMessage);
			return false;
		}
		else
			return true;
	},

	/**
		ROUTES
	*/

	/* -----GET-----*/
	getRemoteFiles: function(callback) {
		var url = this.url + "/user/" + this.publicKey + "/files";
		this.ajaxRequest(callback, url, "GET");
	},
	getRemoteSources: function(callback) {
		var url = this.url + "/user/" + this.publicKey + "/sources";
		this.ajaxRequest(callback, url, "GET");
	},
	getRemoteCategories: function(callback, parameters) {
		if (this.checkParameters(callback, parameters, ["category"]) === false)
			return;
		var url = this.url + "/source/" + parameters.category + "/model";
		this.ajaxRequest(callback, url, "GET");
	},
	getRemoteParsedFile: function(callback, parameters) {
		if (this.checkParameters(callback, parameters, ["path"]) === false)
			return;
		var url = this.url + "/user/" + this.publicKey + "/parse/" + parameters.path;
		this.ajaxRequest(callback, url, "GET");
	},
	getRemoteParsedSource: function(callback, parameters) {
		if (this.checkParameters(callback, parameters, ["sourceName"]) === false)
			return;
		var url = this.url + "/source/" + parameters.sourceName + "/download";
		this.ajaxRequest(callback, url, "GET");
	},

	/* -----POST-----*/
	postRemoteFiles: function(callback, parameters) {
		if (this.checkParameters(callback, parameters, ["data"]) === false)
			return;
		var url = this.url + "/user/" + this.publicKey + "/upload";
		this.ajaxRequest(callback, url, "POST", parameters.data, false, false);
	},
	postRemoteSource: function(callback, parameters) {
		//if (this.checkParameters(callback, parameters, ["category", "jsonData", "sourceName", "city", "databinding"]) === false)
			//return;
		var url = this.url + '/user/' + this.publicKey + '/source/' + parameters.category + '/' + parameters.sourceName + '/upload';
		this.ajaxRequest(callback, url, "POST", parameters);
	},
	deleteRemoteFile: function(callback, parameters) {
		if (this.checkParameters(callback, parameters, ["path"]) === false)
			return;
		var url = this.url + '/user/' + this.publicKey + '/file/' + parameters.path;
		this.ajaxRequest(callback, url, "DELETE");
	},
	setUrl: function(url) {
		this.url = url;
	}
	

}