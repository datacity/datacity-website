(function() {
	angular
		.module('app')
		.factory('UserFactory', ['$http', '$upload', function($http, $upload) {
			return {
				getUserFromSession: function() {
					return $http
						.get(Routing.generate('datacity_private_user_get')).then(function(response) {
							return response.data;

						});
				},
				updateUser: function(userinfos) {
					return $http
						.post(Routing.generate('datacity_private_usermanager_post'), userinfos).then(function(response) {
							return response.data;
						});
				},
				uploadImage: function(image) {
					console.log(image);
					return $http
						.post(Routing.generate('datacity_private_usermanager_uploadimage'), image).then(function(response) {
							return response.data;
						});
					// return $upload.upload({
					// 	   	url: Routing.generate('datacity_private_usermanager_uploadimage'),
					// 	    method: 'POST', 
					// 		file: image

					// 	}).then(function(response) {
					// 		return response.data;
					// 	});
				},
				updatePassword: function(user) {
					return $http
						.post(Routing.generate('datacity_private_usermanager_updatepassword'), user).then(function(response) {
							return response.data;
						});
				},
				delete: function(id) {
					/*return $http
						.delete('/app_dev.php/private/user/delete/' + id).then(function(response) {
							return response.data;
						});*/
				},
				populate: function() {
				 	/*return $http
				 		.get('/ajax/popular-datasets').then(function(response) {
                            return response.data;
                        });*/

				}
			}
		}]);

})();