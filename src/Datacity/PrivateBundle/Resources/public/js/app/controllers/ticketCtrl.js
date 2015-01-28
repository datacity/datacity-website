(function() {
	angular
		.module('app')
		.controller('userTicketController', ['$scope', 'tickets',
			function($scope, tickets) {
	        	$scope.userTickets = tickets;
	    }])
		.controller('addTicketController', ['$scope', '$http', '$state',
			function($scope, $http, $state) {
	        	$scope.submit = function() {
	        		$http.post(Routing.generate('datacity_private_tickets_create_usertickets'), $scope.ticket).then(function() {
	        			$state.go('userTickets');
	        		});
	        	};
	    }])
		.controller('detailTicketController', ['$scope', '$http', 'ticket', '$stateParams',
			function($scope, $http, ticket, $stateParams) {
				$scope.ticket = ticket;
	        	$scope.submit = function() {
	        		$http.post(Routing.generate('datacity_private_tickets_reply_usertickets', {slug: $stateParams.slug}),
	        					$scope.replyticket).then(function() {
	        			$scope.replyticket = {};
	        			$http.get(Routing.generate('datacity_private_tickets_get_userticket', {slug: $stateParams.slug}))
							.then(function(data){
								$scope.ticket = data.data.results;
							});
	        		});
	        	};
	    }])
})();