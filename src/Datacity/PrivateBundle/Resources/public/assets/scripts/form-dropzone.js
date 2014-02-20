var FormDropzone = function () {


    return {
        //main function to initiate the module
        init: function () {  

            Dropzone.options.myDropzone = {
                init: function() {
                    this.on("addedfile", function(file) {
                        console.log(file);
                        var formData = new FormData();
                        if (formData)
                          formData.append("files[]", file);
                        $.ajax({
                          url: "http://localhost:4567/user/4561321edgjlkjd/upload",
                          type: 'POST',
                          data: formData,
                          contentType: false,
                          processData: false,
                          success: function(data, textStatus, jqXHR) {
                            if (data.data && data.data.files && data.data.files instanceof Array)
                              data.data.files.map(function(item) {
                                console.log(item);
                                $('.uploadbody').trigger('newFileUploaded', item)      
                              });
                          },
                          error: function(err) {
                              console.error(err);
                          }
                        });                        
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