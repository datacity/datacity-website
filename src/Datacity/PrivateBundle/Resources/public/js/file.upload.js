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
	var files = evt.target[0].files;
	readFilesAsText(files);
}	

$('#target').submit(function(evt) {
	handleFileSelect(evt);
	return false;
});

function handleFileSelectDragAndDrop(evt) {
    evt.stopPropagation();
    evt.preventDefault();

    var files = evt.dataTransfer.files; 
   	readFilesAsText(files);
  }

  function handleDragOver(evt) {
    evt.stopPropagation();
    evt.preventDefault();
    evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
  }

 var dropZone = document.getElementById('drop_zone');
 dropZone.addEventListener('dragover', handleDragOver, false);
 dropZone.addEventListener('drop', handleFileSelectDragAndDrop, false);