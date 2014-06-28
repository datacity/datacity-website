(function() {
	angular
		.module('app')
		.factory('UserFactory', ['$http', function($http) {
			return {
				getUserFromSession: function() {
					return $http
						.get('/app_dev.php/private/user/get').then(function(response) {
							return response.data;
						});
				},

				/**
				 * [addDataset en cours de construction]
				 * @param {Object} dataset
				 */
				addDataset: function(dataset) {
					return $http
						.post('/app_dev.php/private/user/save/', dataset).then(function(response) {
							return response.data;
						});
						
				},

				delete: function(id) {
					return $http
						.delete('/app_dev.php/private/user/delete/' + id).then(function(response) {
							return response.data;
						});
				}
			}

		}])

})();