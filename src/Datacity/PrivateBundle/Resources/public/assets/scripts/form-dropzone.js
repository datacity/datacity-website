var FormDropzone = function () {

    return {
        //main function to initiate the module
        init: function (router) {

            Dropzone.options.myDropzone = {
                init: function() {
                  this.on("addedfile", function(file) {

                    var onUploadDone = function(err, data) {
                      if (err) {
                        console.warn(err);
                        return;
                      }
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

                      // Remove the file preview.
                      _this.removeFile(file);
                      
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