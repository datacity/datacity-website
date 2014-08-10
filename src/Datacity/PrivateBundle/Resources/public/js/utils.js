var getRandomColor = function() {
	var brightness = 0;
    //6 levels of brightness from 0 to 5, 0 being the darkest
    var rgb = [Math.random() * 256, Math.random() * 256, Math.random() * 256];
    var mix = [brightness*51, brightness*51, brightness*51]; //51 => 255/5
    var mixedrgb = [rgb[0] + mix[0], rgb[1] + mix[1], rgb[2] + mix[2]].map(function(x){ return Math.round(x/2);})
    var color = "rgb(" + mixedrgb.join(",") + ")";
    return "rgb(" + mixedrgb.join(",") + ")";
}

 var getRandomId = function () {
  // Math.random should be unique because of its seeding algorithm.
  // Convert it to base 36 (numbers + letters), and grab the first 9 characters
  // after the decimal.
  return Math.random().toString(36).substr(2, 9);
};

var deleteFromArray = function(array, property, value) {
  $.each(array, function(i){
    if (array[i][property] && array[i][property] === value) {
      array.splice(i,1);
      return false;
    }
  });
}

var displayError = function(error) {

}

/*var fileClicked = function (elem) {
    $(".uploadedFiles li").css({"background-color": "inherit"});
    $(elem).css({"background-color": "#A0B6E3"});
    var desc = $(elem).find(".desc").html();
    var file = getLineInfoFromName(desc);
    alert(file);
    /*TableEditable.filePath = path;
    TableEditable.generateTable();
}*/
 

 

