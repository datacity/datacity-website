function watchDelimiter(str, delimiter) {
	for (var i = 0; i < str.length ; i++) {
		if (str.charAt(i) === delimiter)
			return true;
		else if (i > 50) 
			return false;
	}
	return false;
}

function contentFileJSON(content, name) {
	var delimiter = ";";
	if (watchDelimiter(content, ",") == true)
		delimiter = ",";
	var args = {
		"delim"	: delimiter
	}
	var jsonObject = csvjson.csv2json(content, args);
	//TODO: A terme séparer les couches parsing csv et génération de table
	createTable(jsonObject, name);
	return jsonObject;
}

function createTable(jsonObject, name) {
	var formatedHeaders = generateHeaders(jsonObject.headers, 'table' + indexTable);
	var formatedRows = generateRows(jsonObject.rows, jsonObject.headers.length);
	addNewTab();
   	createRelationFile(formatedHeaders, formatedRows, generateMap(jsonObject.headers));
	$('#tab' + indexTable).generateDataTables({
			'header' 	: {
				'name' 	: name,
				'color' : 'blue-background'
			},
			'tableId' 	: 'table',
			'data'		: formatedRows,
			'field'		: formatedHeaders
	});
}