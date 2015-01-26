(function() {
	angular
		.module('app')
		.controller('userTicketController', ['$scope', 'tickets', 
			function($scope, tickets) {
	        	$scope.userTickets = tickets;
	    }])	
})();