var FormDropzone = function () {

    return {

        //main function to initiate the module
        init: function (router) {
          
            Dropzone.options.myDropzone = {                
                maxFilesize: 3,
                method: "POST",
                maxThumbnailFilesize: 3,
                init: function() {

                  var listFiles = new Array();


                  this.on("addedfile", function(file) {
                    var resFiles;
                    var deleteFile;
                    var onUploadDone = function(err, data) {
                      if (err) {
                        console.warn(err);
                        return;
                      }
                      resFiles = data.files;
                      $.each(data.files, function(index, value) {
                        $('.uploadbody').trigger('newFileUploaded', value);
                      });
                    };

                    var formData = new FormData();
                    if (formData)
                      formData.append("files[]", file);
                    router.postRemoteFiles(onUploadDone, {"data": formData});

                    listFiles.push(file);
                  
                    // Create the remove button
                    var removeButton = Dropzone.createElement("<button class='btn btn-sm btn-block dropzone-file'>Remove file</button>");
                    
                    // Capture the Dropzone instance as closure.
                    var _this = this;

                    // Listen to click event send by deleting a file in "upload.js" => "Dernier fichiers uploades"

                    $('.dropzone').on('onLineInfoDeleted', function(event, file) {
                        $.each(listFiles, function(index, item) {
                          if (item.name === file.name) {
                              _this.removeFile(item);
                              listFiles.splice(index, 1);
                          }
                        });
                    });

                    // Listen to the click event
                    removeButton.addEventListener("click", function(e) {
                      // Make sure the button click doesn't submit the form:
                      e.preventDefault();
                      e.stopPropagation();

                      var onDeleteDone = function(err, data) {
                        if (err) {
                          console.warn(err);
                          return;
                        }
                        $('.uploadbody').trigger('fileDelete', deleteFile);
                      };

                      // Remove the file preview.
                      _this.removeFile(file);
                      
                      $.each(resFiles, function(index, item) {
                        if (item.name === file.name) {
                          deleteFile = item;
                          router.deleteRemoteFile(onDeleteDone, {"path": item.path});
                        }
                      });

                      
                      // If you want to the delete the file on the server as well,
                      // you can do the AJAX request here.
                    });
                    // Add the button to the file preview element.
                    file.previewElement.appendChild(removeButton);
                  });
                }            
            }
        }
    };
}();