var allowedType = ["csv", "json", "xml"];

var UploadDataBox = function(uploadType, jqueryContainer, router) {
	this.lineInfoTab = [];
	this.uploadType = uploadType;
	this.jqueryContainer = jqueryContainer;
	this.router = router;
	this.init();
}

UploadDataBox.prototype = {
	addLineInfo: function(dataInfo, append) {
		//TODO: Standardiser ce qu'on envoi depuis le serveur
		if (dataInfo.name && dataInfo.uploadedDate) {
			var typeTab = dataInfo.name.split('.');
			dataInfo.type = typeTab[typeTab.length - 1];
			if (allowedType.indexOf(dataInfo.type) === -1)
				dataInfo.type = "json";
		}
		var defaults = {
			"id": getRandomId(),
			"name": "Undefined file",
			"type": "json",
			"uploadedDate": new Date()
		};
		var params = $.extend(defaults, dataInfo);
		var line = new UploadLineInfo(params.path, params.name, params.type, params.uploadedDate)
		this.lineInfoTab.push(line);
		if (append === true)
			this.jqueryContainer.append(line.htmlElement);
		else if (append === false)
			this.jqueryContainer.prepend(line.htmlElement);
	},
	deleteLineInfo: function(dataInfo) {
		var line = this.getLineInfoFromName(dataInfo.name);
		if (line !== false) {
			$(line.htmlElement).remove();
			var index = this.getIndexInfoFromName(dataInfo.name);
			if (index !== -1)
				this.lineInfoTab.splice( index, 1 );
		}
	},
	getLineInfoFromName: function(name) {
		for (var index in this.lineInfoTab) {
			if (this.lineInfoTab[index].name === name)
				return this.lineInfoTab[index];
		}
		return false;
	},
	getIndexInfoFromName: function(name) {
		var i = 0;
		for (var index in this.lineInfoTab) {
			if (this.lineInfoTab[index].name === name)
				return i;
			i++;
		}
		return -1;
	},
	getRemoteData: function(callback) {
		if (this.uploadType === "files")
			this.router.getRemoteFiles(callback);
		else if (this.uploadType === "sources")
			this.router.getRemoteSources(callback);
		else
			callback("you have to specifiy the uploadType on the constructor");
	},
	init: function() {
		var that = this;
		this.getRemoteData(function(err, data) {
			if (err) {
				console.warn(err);
				that.initEvents();
				return;
			}
			for (index in data) {
				that.addLineInfo(data[index], true);
			}
			that.initEvents();
		});
	},
	initEvents: function() {

		var that = this;
		var onFileUploaded = function() {
			$('.uploadbody').on('newFileUploaded', function(event, file) {
				that.addLineInfo(file, false);
			});
		}();

		var onFileDeleted = function() {
			$('.uploadbody').on('fileDelete', function(event, file) {
				that.deleteLineInfo(file);
			});
			$('.uploadedFiles').on('click', '.line-info-btn', function(event) {
				event.stopPropagation();
				var file = that.getLineInfoFromName($(this).parent().parent().children('.col1').children('.cont').children('.cont-col2').children('.desc').text());
				that.router.deleteRemoteFile(function(err, data) {
					if (err) {
                        console.warn(err);
                         return;
					}
					that.deleteLineInfo(file);
					console.log(file);
					$('.dropzone').trigger('onLineInfoDeleted', file);
				}, {"path": file.path});
				
			});
		}();

		var onIconHover = function() {
			$('.uploadedFiles').on('hover', ".col1", function(e) {
				var child = $(this).children('.cont').children('.cont-col1').children('a');
				$(child).css("background-position", "0 -38px");
			});
		}();

		var onIconOut = function() {
			$('.uploadedFiles').on('mouseout', '.col1', function(e) {
				var child = $(this).children('.cont').children('.cont-col1').children('a');
				$(child).css("background-position", "0 0px");
			});
		}();

	  	var onClicked = function() {
	  		$(".uploadedFiles").on("click", "li", function(){
	  			$(".uploadedFiles li").css({"background-color": "inherit"});
	  			$(this).css({"background-color": "#C1CBD0"});

	  			var desc = $(this).find(".desc").html();
	  			var file = that.getLineInfoFromName(desc);
	  			var path = file.path;
	  			$('#sample_editable_1').trigger('destroyTable');
	  			var et = new TableEditable("files", {"filePath":path, "router": that.router});
	  		});
		}();

	}
}

var UploadLineInfo = function(path, name, type, uploadedDate) {
	this.path = path;
	this.name = name;
	this.icon = new Icon(type);
	this.uploadedDate = new Date(uploadedDate).toDateString();
	this.htmlElement = this.buildHTMLLine();
}

UploadLineInfo.prototype = {
	buildHTMLLine: function() {
		var line = $(document.createElement('li'));
		var col1 = $(document.createElement('div')).attr('class', 'col1');
		var col2 = $(document.createElement('div')).attr('class', 'col2');
		var col3 = $(document.createElement('div')).attr('class', 'col3');
		var col1block = $(document.createElement('div')).attr('class', 'cont');
		var col1sub1 = $(document.createElement('div')).attr('class', 'cont-col1');
		var col1sub2 = $(document.createElement('div')).attr('class', 'cont-col2');
		var icon = this.icon.htmlElement;
		var desc = $(document.createElement('div')).attr('class', 'desc').append(this.name);
		var delButton = $(document.createElement('button')).attr('class', 'btn btn-sm btn-block line-info-btn').append(document.createTextNode("Remove file"));
		var date = $(document.createElement('div')).attr('class', 'date').append(this.uploadedDate);
		var htmlLine = line.append(
			col1.append(
				col1block.append(
					col1sub1.append(icon)
					).append(
					col1sub2.append(desc)
					)
				)
			)
		.append(
			col2.append(date)
		)
		.append(
			col3.append(delButton)
		)
		return htmlLine;
	}
}

var Icon = function(type) {
	if (allowedType.indexOf(type) == -1)
		type = "default";
	this.type = type;
	this.htmlElement = $(document.createElement('a')).attr('href', '#').attr('class', 'iconfile social-icon ' + this.type);
}
