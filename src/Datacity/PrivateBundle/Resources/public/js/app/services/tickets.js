(function() {
	angular
		.module('app')
		.factory('TicketFactory', ['$http', function($http) {

			return { 
				getAll: function() {
					return $http
						.get(Routing.generate('datacity_private_tickets_get_allusertickets')).then(function(response) {
						return response.data.results;
						});
				}
			}

		}])

})();