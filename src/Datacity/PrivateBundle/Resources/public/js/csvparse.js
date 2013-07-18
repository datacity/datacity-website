function watchDelimiter(str, delimiter) {
	for (var i = 0; i < str.length ; i++) {
		if (str.charAt(i) === delimiter)
			return true;
		else if (i > 50) 
			return false;
	}
	return false;
}

function contentFile(content, name) {
	var delimiter = ";";
	if (watchDelimiter(content, ",") == true)
		delimiter = ",";
	var args = {
		"delim"	: delimiter
	}
	var jsonObject = csvjson.csv2json(content, args);
	generateDataTables(jsonObject.headers, jsonObject.rows, name);
}