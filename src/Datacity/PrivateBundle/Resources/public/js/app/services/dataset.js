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
				getLicences: function() {
					return $http
						.get(Routing.generate('datacity_public_api_filter_list')).then(function(response) {
							return response.data.results;
						})
				},
				post: function(dataset) {
					return $http
						.post(Routing.generate('datacity_private_dataset_save'), dataset).then(function(response) {
							return response.data;
						});
				},
				delete: function(id) {
					return $http
						.delete(Routing.generate('datacity_private_dataset_delete', {id: id})).then(function(response) {
							return response.data;
						});
				}
			}

		}])

})();