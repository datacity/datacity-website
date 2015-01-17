(function() {
	angular
		.module('app')
		.factory('AppFactory', ['$http', function($http) {
			return {
				get: function(slug) {
					return $http
						.get(Routing.generate('datacity_private_applications_get_application', {slug: slug})).then(function(response) {
							return response.data.results;
						});
				},
				cities: function() {
					return $http
						.get(Routing.generate('datacity_private_applications_get_app_data')).then(function(response) {
							return response.data.results.cities;
						});

				},
				categories: function() {
					return $http
						.get(Routing.generate('datacity_private_applications_get_app_data')).then(function(response) {
							return response.data.results.categories;
						});

				},
				platforms: function() {
					return $http
						.get(Routing.generate('datacity_private_applications_get_app_data')).then(function(response) {
							return response.data.results.platforms;
						});

				},
				datasets: function() {
					return $http
						.get(Routing.generate('datacity_private_applications_get_app_data')).then(function(response) {
							return response.data.results.datasets;
						});

				},
				post: function(app) {
					return $http
						.post(Routing.generate('datacity_private_applications_post_user_app'), app).then(function(response) {
							return response.data;
						});

				},
				deleteApp: function(name) {
					return $http
						.post(Routing.generate('datacity_private_applications_delete_user_app'), name).then(function(response) {
							return response.data;
						});
				},
				getAll: function() {
					return $http
						.get(Routing.generate('datacity_private_applications_get_userapplications')).then(function(response) {
							return response.data.results;
						});
				}
			}

		}])

})();