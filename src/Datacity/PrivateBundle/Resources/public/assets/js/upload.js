var allowedType = ["csv", "json", "xml"];

var UploadFilesBox = function() {
	this.lineInfoTab = [];
	this.init();
}

UploadFilesBox.prototype = {
	addLineInfo: function(fileName, type, uploadDate, append) {
		var line = new UploadLineInfo(fileName, type, uploadDate)
		this.lineInfoTab.push(line);
		if (append === true)
			$('.uploadedFiles').append(line.htmlElement);
		else if (append === false)
			$('.uploadedFiles').prepend(line.htmlElement);
	},
	getRemoteFiles: function(callback) {
		var publickey = "4561321edgjlkjd";
		$.ajax({
			url: "http://localhost:4567/user/" + publickey + "/files",
			type: 'GET',
			success: function(data, textStatus, jqXHR) {
				if (data.data)
					callback(data.data);
			},
			error: function(err) {
				console.error(err);
			}
		});	
	},
	init: function() {
		var that = this;
		this.getRemoteFiles(function(files) {
			for (index in files) {
				var file = files[index];
				if (file.filename && file.uploadedDate) {
					var typeTab = file.filename.split('.');
					var type = typeTab[typeTab.length - 1];
					that.addLineInfo(file.filename, type, file.uploadedDate, true);
				}			
			}
			that.initEvents();
		});
	},
	initEvents: function() {
		console.log("call init events")
		var that = this;
		$('.uploadbody').on('newFileUploaded', function(event, file) {
			//TODO: Standardiser ce qu'on envoi depuis le serveur
			if (file.filename && file.uploadedDate) {
				var typeTab = file.filename.split('.');
				var type = typeTab[typeTab.length - 1];
				that.addLineInfo(file.filename, type, file.uploadedDate, false);
			}
		});
		$('.col1').on('hover', function(e) {
			var sub = $(this).children('.cont').children('.cont-col1').children('a');
			$(sub).css("background-position", "0 -38px");
		});
		$('.col1').on('mouseout', function(e) {
			var sub = $(this).children('.cont').children('.cont-col1').children('a');
			$(sub).css("background-position", "0 0px");
		});
	}
}

var UploadLineInfo = function(fileName, type, uploadDate) {
	this.fileName = fileName;
	this.icon = new Icon(type);
	this.uploadDate = new Date(uploadDate).toDateString();
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
		var desc = $(document.createElement('div')).attr('class', 'desc').append(this.fileName);
		var date = $(document.createElement('div')).attr('class', 'date').append(this.uploadDate);
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

var uploadBox = new UploadFilesBox();
