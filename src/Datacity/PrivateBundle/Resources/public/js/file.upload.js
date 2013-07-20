var limitUpload = 3;
var currentUpload;

function readFilesAsText(files) {
	for (var i = 0, f; f = files[i]; i++) {
		var reader = new FileReader();
      	reader.onloadend = (function(theFile) {
      		return function(e) {
            var contents = e.target.result;
            contentFile(contents, theFile.name);
      		}
	  	})(f);
	reader.readAsText(f, "Iso-8859-1");
	}
}

function handleFileSelect(evt) {
	if (window.File && window.FileReader && window.FileList) {
    var files = evt.target[0].files;
    readFilesAsText(files);
  }
  else
    console.log('The File APIs are not fully supported in this browser.');
}	

$('#target').submit(function(evt) {
	handleFileSelect(evt);
	return false;
});

function handleFileSelectDragAndDrop(evt) {
    if (window.File && window.FileReader && window.FileList) {
      evt.stopPropagation();
      evt.preventDefault();
      var files = evt.dataTransfer.files; 
      readFilesAsText(files);
    }
    else
      console.log('The File APIs are not fully supported in this browser.');
  }

  function handleDragOver(evt) {
    evt.stopPropagation();
    evt.preventDefault();
    evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
  }

 var dropZone = document.getElementById('drop_zone');
 dropZone.addEventListener('dragover', handleDragOver, false);
 dropZone.addEventListener('drop', handleFileSelectDragAndDrop, false);