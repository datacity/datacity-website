(function() {
	angular
		.module('app')
		.factory('SourceFactory', ['$http', function($http) {
			return {
				get: function(id) {
					return $http
						.get('/app_dev.php/private/source/get/' + id).then(function(response) {
							return response.data;
						});
				},
				post: function(idDataset, source) {
					return $http
						.post('/app_dev.php/private/source/save/' + idDataset, source).then(function(response) {
							return response.data;
						});
						
				},
				delete: function(id) {
					return $http
						.delete('/app_dev.php/private/source/delete/' + id).then(function(response) {
							return response.data;
						});
				},
			}
		}]);
})();