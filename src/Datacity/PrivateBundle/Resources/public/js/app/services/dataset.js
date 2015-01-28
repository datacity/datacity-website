(function() {
	angular
		.module('app')
		.factory('DatasetFactory', ['$http', 'apiUrl', function($http, apiUrl) {
			return {
				get: function(slug) {
					return $http
						.get(Routing.generate('datacity_public_api_dataset_show', {slug: slug})).then(function(response) {
							return response.data.results;
						});
				},
				getAll: function(offset) {
					offset = typeof offset !== 'undefined' ? offset : 0;
					return $http
						.get(Routing.generate('datacity_private_dataset_get', {offset: offset})).then(function(response) {
							return response.data.results;
						});
				},
				getLicences: function() {
					return $http
						.get(Routing.generate('datacity_public_api_filter_list')).then(function(response) {
							return response.data.results.licenses;
						})
				},
				post: function(dataset) {
					return $http
						.post(Routing.generate('datacity_private_dataset_add'), dataset).then(function(response) {
							return response.data;
						});
				},
				save: function(slug, data) {
					return $http
						.put(Routing.generate('datacity_private_dataset_save', {slug: slug}), data).then(function(response) {
							return response.data;
						});
				},
				delete: function(key, slug) {
					return $http
						.delete(Routing.generate('datacity_private_dataset_delete', {slug: slug})).then(function(response) {
							return $http({
								method: 'DELETE',
								headers: {
									'public_key': key.public_key,
									'private_key': key.private_key
								},
								url: apiUrl + '/' + slug
							}).then(function(idontcare) {
								return response.data;
							});
						});
				}
			}

		}])

})();