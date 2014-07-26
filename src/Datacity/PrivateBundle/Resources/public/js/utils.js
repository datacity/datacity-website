function getRandomColor(){
	var brightness = 0;
    //6 levels of brightness from 0 to 5, 0 being the darkest
    var rgb = [Math.random() * 256, Math.random() * 256, Math.random() * 256];
    var mix = [brightness*51, brightness*51, brightness*51]; //51 => 255/5
    var mixedrgb = [rgb[0] + mix[0], rgb[1] + mix[1], rgb[2] + mix[2]].map(function(x){ return Math.round(x/2);})
    var color = "rgb(" + mixedrgb.join(",") + ")";
    return "rgb(" + mixedrgb.join(",") + ")";
  }

function removeFromArray(from, to) {
 	var rest = this.slice((to || from) + 1 || this.length);
  	this.length = from < 0 ? this.length + from : from;
  	return this.push.apply(this, rest);	
}