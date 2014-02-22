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
		console.log(dataInfo);
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
		var line = new UploadLineInfo(params.id, params.name, params.type, params.uploadedDate)
		this.lineInfoTab.push(line);
		if (append === true)
			this.jqueryContainer.append(line.htmlElement);
		else if (append === false)
			this.jqueryContainer.prepend(line.htmlElement);
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
			console.log("on a bien le callback!");
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

		var onIconHover = function() {
			$('.col1').on('hover', function(e) {
				var child = $(this).children('.cont').children('.cont-col1').children('a');
				$(child).css("background-position", "0 -38px");
			});
		}();

		var onIconOut = function() {
			$('.col1').on('mouseout', function(e) {
				var child = $(this).children('.cont').children('.cont-col1').children('a');
				$(child).css("background-position", "0 0px");
			});
		}();
	}
}

var UploadLineInfo = function(id, sourceName, type, uploadedDate) {
	this.id = id;
	this.sourceName = sourceName;
	this.icon = new Icon(type);
	this.uploadedDate = new Date(uploadedDate).toDateString();
	this.htmlElement = this.buildHTMLLine();
}

UploadLineInfo.prototype = {
	buildHTMLLine: function() {
		var line = $(document.createElement('li'));
		var col1 = $(document.createElement('div')).attr('class', 'col1');
		var col2 = $(document.createElement('div')).attr('class', 'col2');
		var col1block = $(document.createElement('div')).attr('class', 'cont');
		var col1sub1 = $(document.createElement('div')).attr('class', 'cont-col1');
		var col1sub2 = $(document.createElement('div')).attr('class', 'cont-col2');
		var icon = this.icon.htmlElement;
		var desc = $(document.createElement('div')).attr('class', 'desc').append(this.sourceName);
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
			col2.append(
				col2.append(date)
				)
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
