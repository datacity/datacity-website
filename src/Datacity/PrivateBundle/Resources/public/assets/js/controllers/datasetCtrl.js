(function() {
	angular
		.module('app')
		.controller('datasetController', ['$scope', '$stateParams', '$modal', '$log', 'Dataset', 'operation',
			function($scope, $stateParams, $modal, $log, Dataset, operation) {
				$scope.dataset = {};

				// Route operations
				if (operation === 'create') {
					$scope.noDelete = true;
				}
				else if (operation === 'edit') {
					Dataset.get($stateParams.id).then(function(data) {
						if (data.title)
							$scope.dataset = data;
					});
				}
				else if (operation === 'delete') {
					Dataset.delete($stateParams.id).then(function(response) {
						console.log(response);
					});
				}
				//Form Events
				$scope.submit = function() {
					console.log($scope.dataset);
					if (operation === 'create' || operation === 'edit')
						Dataset.post($scope.dataset).then(function(response) {
							console.log(response);
						});
				}
				$scope.delete = function() {
					console.log($scope.dataset);
					Dataset.delete($stateParams.id).then(function(response) {
						console.log(response);
					});
				}

				// Custom Modal
				$scope.confirm = $scope.delete;
 				var confirmDeleteModal = $modal({animation: 'am-fade-and-scale', placement: 'center', scope: $scope, template: '/app_dev.php/private/modals/modal', title: 'Confirmation', content: 'Voulez vous vraiment supprimmer ce jeu de donnée? Cela entraînera la suppression de toutes les sources associées.', show: false});
  				$scope.showModal = function() {
    				confirmDeleteModal.$promise.then(confirmDeleteModal.show);
  				};

		}]);
})();