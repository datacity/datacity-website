var TableEditable = function () {

    return {

        //main function to initiate the module
        init: function () {
            var oTable;
            var nEditing = null;
            function restoreRow(oTable, nRow) {
                var aData = oTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);

                for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                    oTable.fnUpdate(aData[i], nRow, i, false);
                }

                oTable.fnDraw();
            }

            function editRow(oTable, nRow) {
                var aData = oTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);
                jqTds[0].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[0] + '">';
                //jqTds[1].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[1] + '">';
                jqTds[2].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[2] + '">';
                jqTds[3].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[3] + '">';
                jqTds[4].innerHTML = '<a class="edit" href="">Save</a>';
                jqTds[5].innerHTML = '<a class="cancel" href="">Cancel</a>';
            }

            function saveRow(oTable, nRow) {
                var jqInputs = $('input', nRow);
                oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                //oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
                oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
                oTable.fnUpdate('<a class="edit" href="">Edit</a>', nRow, 4, false);
                oTable.fnUpdate('<a class="delete" href="">Delete</a>', nRow, 5, false);
                oTable.fnDraw();
            }

            function cancelEditRow(oTable, nRow) {
                var jqInputs = $('input', nRow);
                oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                //oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
                oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
                oTable.fnUpdate('<a class="edit" href="">Edit</a>', nRow, 4, false);
                oTable.fnDraw();
            }


            function requestRows(callback) {
                $.ajax({
                    url: 'http://localhost:4567/user/4561321edgjlkjd/parse/9115b0a5c76f679f456e3772bd3c0b7a',
                    type: 'GET',
                    success: function(response, status, jqXHR) {
                        if (response.data)
                            callback(response.data);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                })
            }

            function generateHeaders(headers, headerClass) {
                var array = new Array();
                console.log(headers);
                var json = {};
                var keys = Object.keys(headers);
                for (index in keys) {                    
                    json = {
                        "sTitle" : keys[index].replace(/ /g, "_"),
                        "sClass" : headerClass
                    };
                    array.push(json);
                }
                return array;
            }

            function generateRows(rows, nbfield) {
                var array = new Array();
                for (rowName in rows) {
                    //TODO: VERIFICATION DU FICHIER
                    subArray = new Array();
                    for (rowContent in rows[rowName]) {
                        subArray.push(rows[rowName][rowContent]);
                    }
                    array.push(subArray);  
                }
                return array;
            }

            function generateTable(rows) {
                var header = generateHeaders(rows[0], "test");
                var row = generateRows(rows, header.length);
                oTable = $('#sample_editable_1').dataTable({
                "aLengthMenu": [
                    [7, 15, 20, 100],
                    [7, 15, 20, 100] // change per page values here
                ],
                // set the initial value
                 
                "iDisplayLength": 7,  
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aaData": row,
                "aoColumns": header
                /*"aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ],*/
                });
                $('.table-scrollable').css('overflow-y', 'scroll').css('height', '300px');
                jQuery('#sample_editable_1_wrapper .dataTables_filter input').addClass("form-control input-medium"); // modify table search input
                jQuery('#sample_editable_1_wrapper .dataTables_length select').addClass("form-control input-small"); // modify table per page dropdown
                jQuery('#sample_editable_1_wrapper .dataTables_length select').select2({
                    showSearchInput : false //hide search box with special css class
                }); // initialize select2 dropdown

                $('#sample_editable_1_new').click(function (e) {
                e.preventDefault();
                var aiNew = oTable.fnAddData(['', '', '', '',
                        '<a class="edit" href="">Edit</a>', '<a class="cancel" data-mode="new" href="">Cancel</a>'
                ]);
                var nRow = oTable.fnGetNodes(aiNew[0]);
                editRow(oTable, nRow);
                nEditing = nRow;
            });

            $('#sample_editable_1 a.delete').live('click', function (e) {
                e.preventDefault();

                if (confirm("Are you sure to delete this row ?") == false) {
                    return;
                }

                var nRow = $(this).parents('tr')[0];
                oTable.fnDeleteRow(nRow);
                alert("Deleted! Do not forget to do some ajax to sync with backend :)");
            });

            $('#sample_editable_1 a.cancel').live('click', function (e) {
                e.preventDefault();
                if ($(this).attr("data-mode") == "new") {
                    var nRow = $(this).parents('tr')[0];
                    oTable.fnDeleteRow(nRow);
                } else {
                    restoreRow(oTable, nEditing);
                    nEditing = null;
                }
            });

            $('#sample_editable_1 a.edit').live('click', function (e) {
                e.preventDefault();

                /* Get the row as a parent of the link that was clicked on */
                var nRow = $(this).parents('tr')[0];

                if (nEditing !== null && nEditing != nRow) {
                    /* Currently editing - but not this row - restore the old before continuing to edit mode */
                    restoreRow(oTable, nEditing);
                    editRow(oTable, nRow);
                    nEditing = nRow;
                } else if (nEditing == nRow && this.innerHTML == "Save") {
                    /* Editing this row and want to save it */
                    saveRow(oTable, nEditing);
                    nEditing = null;
                    alert("Updated! Do not forget to do some ajax to sync with backend :)");
                } else {
                    /* No edit in progress - let's start one */
                    editRow(oTable, nRow);
                    nEditing = nRow;
                }
            });
            }

            
            requestRows(generateTable);

            

            
        }

    };

}();