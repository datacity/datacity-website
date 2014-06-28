(function() {
	angular
		.module('app')
		.controller('userController', ['$scope', '$stateParams', '$modal', '$log', 'UserFactory',
			function($scope, $stateParams, $modal, $log, UserFactory) {
				$scope.user = {};
				var user = UserFactory.getUserFromSession().then(function(data) {
					$scope.user = data;
				});
		}]);
})();