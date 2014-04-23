var TableEditable = function (uploadType, options) {
    var defaults = {
        "filePath": "fd4dec3bccba3020eb6375b6c4fedb93",
        "jqueryTable": $('#sample_editable_1'),
        "jqueryNewButton": $('#sample_editable_1_new'),
        "sourceName": "",
        "router": null
    };
    var params = $.extend(defaults, options);
    this.uploadType = uploadType;
    this.filePath = params.filePath;
    this.sourceName = params.sourceName;
    this.jqueryTable = params.jqueryTable;
    this.jqueryNewButton = params.jqueryNewButton;

    //TODO: FAIRE UNE GESTION DERREUR DANS LE CAS OU ON OUBLIE LE ROUTER
    this.router = params.router;
    this.oTable = null;
    this.nEditing = null;

    this.isEditable = true;
    this.isTableModified = false;

    this.bindingArray = [];
    this.rows = null;
    this.init();
};

TableEditable.prototype = {
    restoreRow: function(oTable, nRow) {
        var aData = oTable.fnGetData(nRow);
        var jqTds = $('>td', nRow);

        for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
            oTable.fnUpdate(aData[i], nRow, i, false);
        }
        oTable.fnDraw();
    },
    editRow: function(oTable, nRow) {
        var aData = oTable.fnGetData(nRow);
        var jqTds = $('>td', nRow);
        var i;
        for (i = 0; i < jqTds.length ; i++)
        {
            jqTds[i].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[i] + '">';
        }
        /*jqTds[0].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[0] + '">';
        jqTds[1].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[1] + '">';
        jqTds[2].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[2] + '">';
        jqTds[3].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[3] + '">';*/
        // jqTds[i].innerHTML = '<a class="edit" href="">Save</a>';
        // jqTds[i+1].innerHTML = '<a class="cancel" href="">Cancel</a>';
    },
    saveRow: function(oTable, nRow) {
        var jqInputs = $('input', nRow);
        var i;
        for (i = 0; i < jqInputs.length ; i++)
        {
            oTable.fnUpdate(jqInputs[i].value, nRow, i, false);
        }
        /*oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
        oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
        oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
        oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);*/
        // oTable.fnUpdate('<a class="edit" href="">Edit</a>', nRow, i, false);
        // oTable.fnUpdate('<a class="delete" href="">Delete</a>', nRow, i+1, false);
        oTable.fnDraw();
    },
    cancelEditRow: function(oTable, nRow) {
        var jqInputs = $('input', nRow);
        var i;
        for (i = 0; i < jqInputs.length ; i++)
        {
            oTable.fnUpdate(jqInputs[i].value, nRow, i, false);
        }
        // oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
        // oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
        // oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
        // oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
        // oTable.fnUpdate('<a class="edit" href="">Edit</a>', nRow, i, false);
        oTable.fnDraw();
    },
    requestRows: function(callback) {
        if (this.uploadType === "files")
            this.router.getRemoteParsedFile(callback, {"path": this.filePath});
        else if (this.uploadType === "sources")
            this.router.getRemoteParsedSource(callback, {"sourceName": this.sourceName});
    },
    generateHeaders: function(headers, headerClass) {
        var array = new Array();
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
    },
    generateRows: function(rows, nbfield) {
        var array = new Array();
        for (rowName in rows) {
            //TODO: VERIFICATION DU FICHIER
            subArray = new Array();
            var object;
            if (this.uploadType === "sources")
                object = rows[rowName]._source;
            else
                object = rows[rowName];
            for (rowContent in object) {
                subArray.push(object[rowContent]);
            }
            array.push(subArray);
        }
        return array;
    },
    generateTable: function(rows) {
        var header;
         this.rows = rows;
        if (this.uploadType === "sources")
            header = this.generateHeaders(rows[0]._source, "test");
        else
            header = this.generateHeaders(rows[0], "test");
        var row = this.generateRows(rows, header.length);
        this.oTable = this.jqueryTable.dataTable({
            "aLengthMenu": [[7, 15, 20, 100],[7, 15, 20, 100]],
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
        });
        this.initCSS();
    },
    getTableColumns: function() {

    },
    tableToJson: function(oTable) {
        var data = [];

        var headers = oTable.dataTableSettings[0].aoColumns;
        var oRows = oTable.fnGetNodes();

        for (var i=0; i<oRows.length; i++) {

            var oTableRow = oRows[i];
            var rowData = {};

            $.each(headers, function(i,header) { 
                rowData[ header.sTitle ] = oTableRow.cells[i].innerHTML;
            });

            data.push(rowData);
        }
        return data;
    },
    initEvents: function() {
        var that = this;

        var onNewRowAction = function() {
            that.jqueryNewButton.on('click', function (e) {
                e.preventDefault();
                var aiNew = oTable.fnAddData(['', '', '', '',
                    '<a class="edit" href="">Edit</a>', '<a class="cancel" data-mode="new" href="">Cancel</a>'
                    ]);
                var nRow = oTable.fnGetNodes(aiNew[0]);
                editRow(oTable, nRow);
                nEditing = nRow;
            });
        }();
        
        var onDeleteAction = function () {
            that.jqueryTable.on('click', 'a.delete' , function (e) {
                e.preventDefault();

                if (confirm("Are you sure to delete this row ?") == false) {
                    return;
                }

                var nRow = $(this).parents('tr')[0];
                oTable.fnDeleteRow(nRow);
                alert("Deleted! Do not forget to do some ajax to sync with backend :)");
            });
        }();
        
        var onCancelAction = function() {
            that.jqueryTable.on('click', 'a.cancel' , function (e) {
                e.preventDefault();
                if ($(this).attr("data-mode") == "new") {
                    var nRow = $(this).parents('tr')[0];
                    oTable.fnDeleteRow(nRow);
                } else {
                    restoreRow(oTable, nEditing);
                    nEditing = null;
                }
            });
        }();
        
        var onEditAction = function() {
            that.jqueryTable.on('click', 'tr' , function (e) {
                e.preventDefault();



                    var nRow = $(this)[0];

                    if (that.nEditing !== null && that.nEditing != nRow && that.isEditable == false) {
                        /* Currently editing - but not this row - restore the old before continuing to edit mode */
                        that.restoreRow(that.oTable, that.nEditing);
                        that.editRow(that.oTable, nRow);
                        that.nEditing = nRow;
                    } else if (that.isEditable == true) {
                        /* No edit in progress - let's start one */
                        that.isEditable = false;
                        that.editRow(that.oTable, nRow);
                        that.nEditing = nRow;
                    }
                    $("td").keyup(function (e) {
                        if (e.keyCode == 13 && that.nEditing == nRow) {
                            that.saveRow(that.oTable, that.nEditing);
                            that.nEditing = null;
                            that.isTableModified = true;
                            that.isEditable = true;
                        }
                    });
            });
        }();

        var onCategorySetColor = function() {
            that.jqueryTable.on('click', 'th', function (e) {
                var color = $('.boxColored').css('background-color');
                if (color === "rgb(255, 255, 255)" || color === "rgba(0, 0, 0, 0)") {
                    $(this).css('color', 'black');
                    deleteFromArray(that.bindingArray, "color", $(this).css('background-color'))
                }
                else {
                    $(this).css('color', 'white');
                    var textBindedCategory = null;
                    $('.btnmodel').each(function(index) {
                        if ($(this).css("background-color") === color)
                            textBindedCategory = $(this).text().toLowerCase();
                    });
                    if (textBindedCategory) {
                        var bindedColumn = new BindedColumn(color, $(this).text(), textBindedCategory);
                        that.bindingArray.push(bindedColumn);
                    }
                }
                $(this).css('background-color', $('.boxColored').css('background-color'));
            });
        }();

        var onUploadSource = function() {
            $('.uploadSource').on('click', function() {
                var sourcename = $(".sourcename").val();
                var categoryname = $(".categoryname").val();

                if (!sourcename || !categoryname) {
                   console.warn("Enter a sourcename and a category name please");
                   return;
                }
                var jsonData = (that.isTableModified ? that.tableToJson(that.oTable) : that.rows);

                var dataJSON = {
                    "jsonData": jsonData,
                    "sourceName": sourcename,
                    "category": categoryname,
                    "city": "montpellier",
                    "databiding": that.bindingArray
                }
                
                that.router.postRemoteSource(function(err, data) {
                    if (err)
                        console.warn(err);
                    var router = that.router;
                    that.oTable.fnDestroy();
                    that.jqueryTable.empty();
                    that.jqueryTable.unbind();
                    $('.uploadSource').unbind();
                    $('.editablebody').remove();
                    $('.uploadEditable').remove();
                    that = new TableEditable("sources", {"sourceName":sourcename, "router": router});
                }, dataJSON);
            });
        }();
    
        var onDestroy = function() {
            that.jqueryTable.on('destroyTable', function() {
            if (that.oTable)
              that.oTable.fnDestroy();
              that.jqueryTable.empty();
              that.jqueryTable.unbind();
              $('.uploadSource').unbind();
              delete that;
            });
        }();
    },

    initCSS: function() {
        $('.table-scrollable').css('overflow-y', 'scroll').css('height', '300px');
        jQuery('#sample_editable_1_wrapper .dataTables_filter input').addClass("form-control input-medium"); // modify table search input
        jQuery('#sample_editable_1_wrapper .dataTables_length select').addClass("form-control input-small"); // modify table per page dropdown
        jQuery('#sample_editable_1_wrapper .dataTables_length select').select2({
            showSearchInput : false //hide search box with special css class
        });  
    },
    init: function () {
        //TODO: VIRER CETTE VARIABLE
        var nEditing = null;
        var that = this;
        this.requestRows(function(err, rows) {
            if (err) {
                console.warn(err);
                return;
            }
            that.generateTable(rows);
            that.initEvents();
        });       
    }
};



var BindedColumn = function(color, text, textBiding) {
    this[text] = textBiding;
    this.color = color;
}

BindedColumn.prototype = {

};

