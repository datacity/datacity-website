(function() {
	angular
		.module('app')
		.controller('userController', ['$scope', '$stateParams', '$modal', '$log', 'UserFactory',
			function($scope, $stateParams, $modal, $log, UserFactory) {
				$scope.user = {};

				$scope.user.datasets = UserFactory.populateDatasetTmp();
				/* UserFactory.getUserFromSession().then(function(data) {
				 	$scope.user = data;
				 });*/
				/*UserFactory.populate().then(function(data) {
					console.log(data);
					$scope.user.datasets = data;
				})*/
				
		}]);
})();