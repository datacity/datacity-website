(function() {
	angular
		.module('app')
		.controller('datasetController', ['$scope', '$stateParams', '$state', '$modal', '$log', 'DatasetFactory', 'operation',
			function($scope, $stateParams, $state, $modal, $log, DatasetFactory, operation) {
				$scope.dataset = {};

				if (operation === 'create') {
					$scope.noDelete = true;
				}
				else if (operation === 'edit') {
					DatasetFactory.get($stateParams.slug).then(function(data) {
						console.log(data);
						$scope.dataset = data;
						//TODO: CHARGER LES SOURCES ASSOCIEES
					});
				}
				else if (operation === 'delete') {
					DatasetFactory.delete($stateParams.slug).then(function(response) {
						console.log(response);
					});
				}

				$scope.dataset.visibility = ['Autoriser tout le monde à voir mes publications',
									'Autoriser mes abonnés/abonnements à voir mes publications',
									'N\'autoriser personne à voir mes publications'];

				// Route operations
				DatasetFactory.getLicences().then(function(data) {
					$scope.dataset.licenses = data.licenses;
				});
				//Form Events
				$scope.submit = function() {
					var result = {
						license: $scope.dataset.license,
						description: $scope.dataset.description,
						title: $scope.dataset.title,
						visibility: $scope.dataset.selectedVisibility
					}
					console.log(result);
					if (operation === 'create' || operation === 'edit')
						DatasetFactory.post(result).then(function(response) {
							console.log(response);
							if (operation === 'create')
								$state.go('editDS', {slug: response.result});
						});

				}
				$scope.delete = function() {
					console.log($scope.dataset);
					DatasetFactory.delete($stateParams.slug).then(function(response) {
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