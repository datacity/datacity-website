(function() {
	angular
		.module('app')
		.factory('DatasetFactory', ['$http', function($http) {
			return {
				get: function(slug) {
					return $http
						.get(Routing.generate('datacity_public_api_dataset_show', {slug: slug})).then(function(response) {
							return response.data.results;
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