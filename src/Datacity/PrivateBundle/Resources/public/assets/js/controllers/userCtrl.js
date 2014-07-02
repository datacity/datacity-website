(function() {
	angular
		.module('app')
		.controller('userController', ['$scope', '$stateParams', '$modal', '$log', 'UserFactory',
			function($scope, $stateParams, $modal, $log, UserFactory) {
				$scope.user = {};
				
				 UserFactory.getUserFromSession().then(function(data) {
				 	$scope.user = data;
				 });
				 $scope.user.datasets = UserFactory.populateDatasetTmp();
				/*UserFactory.populate().then(function(data) {
					console.log(data);
					$scope.user.datasets = data;
				})*/
				
				$scope.updateUser = function () {
			        var userUpdated = $scope.user;

			        UserFactory.updateUser(userUpdated).then(function(data) {
				 		console.log(data);
				 	});
			    };
		}]);
})();