(function() {
	angular
		.module('app')
		.controller('datasetController', ['$scope', '$stateParams', '$modal', '$log', 'DatasetFactory', 'operation',
			function($scope, $stateParams, $modal, $log, DatasetFactory, operation) {
				$scope.dataset = {};

				// Route operations
				if (operation === 'create') {
					$scope.noDelete = true;
				}
				else if (operation === 'edit') {
					DatasetFactory.get($stateParams.id).then(function(data) {
						if (data.title)
							$scope.dataset = data;
						//TODO: CHARGER LES SOURCES ASSOCIEES
						$scope.dataset.sources = DatasetFactory.populateSourcesTmp();
					});
				}
				else if (operation === 'delete') {
					DatasetFactory.delete($stateParams.id).then(function(response) {
						console.log(response);
					});
				}
				//Form Events
				$scope.submit = function() {
					console.log($scope.dataset);
					if (operation === 'create' || operation === 'edit')
						DatasetFactory.post($scope.dataset).then(function(response) {
							console.log(response);
						});
				}
				$scope.delete = function() {
					console.log($scope.dataset);
					DatasetFactory.delete($stateParams.id).then(function(response) {
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