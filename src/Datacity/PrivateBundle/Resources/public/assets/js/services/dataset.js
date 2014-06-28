(function() {
	angular
		.module('app')
		.factory('DatasetFactory', ['$http', function($http) {
			return {
				get: function(id) {
					return $http
						.get('/app_dev.php/private/dataset/get/' + id).then(function(response) {
							return response.data;
						});
				},
				post: function(dataset) {
					return $http
						.post('/app_dev.php/private/dataset/save/', dataset).then(function(response) {
							return response.data;
						});
						
				},
				delete: function(id) {
					return $http
						.delete('/app_dev.php/private/dataset/delete/' + id).then(function(response) {
							return response.data;
						});
				}
			}

		}])

})();