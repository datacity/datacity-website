(function() {
	angular
		.module('app')
		.factory('SourceFactory', ['$http', '$upload', function($http, $upload) {
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
				getParsedFile: function(path) {										
					return $http(
						{
							method: 'GET',
							url: 'http://localhost:4567/users/delkje555/files/' + path + '/parse',
							header: {'Content-Type': 'application/x-www-form-urlencoded;', 'Accept': 'text/html,application/json ,*/*;'}
						}).success(function(response) {
							console.log(response);
							return response.data;
							//return response.data;
						}).error(function(message) {
							console.log(message);
						});
				},
				postFile: function(file, callback) {
					return $upload.upload(
						{
						   	url: 'http://localhost:4567/users/delkje555/files/add',
						    method: 'POST', 
							file: file,
						})
					.success(function(response) {
						return response.data;
					});
				}
			}
		}]);
})();