var FormDropzone = function () {

    return {
        //main function to initiate the module
        init: function (router) {

            Dropzone.options.myDropzone = {
                init: function() {

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
                  
                    // Create the remove button
                    var removeButton = Dropzone.createElement("<button class='btn btn-sm btn-block'>Remove file</button>");
                    
                    // Capture the Dropzone instance as closure.
                    var _this = this;

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
        },
        initEvents: function() {

        var onLineInfoDeleted = function() {
          $('.dropzone').on('onLineInfoDeleted', function(event, file) {
              this.removeFile(file);
          });
        }();
      }
    };
}();