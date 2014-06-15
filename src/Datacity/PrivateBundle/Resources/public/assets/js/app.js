(function() {
var app = angular
	.module('app', ['datacity.dataset'])
	.config(function($interpolateProvider){
        $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
    });
})();