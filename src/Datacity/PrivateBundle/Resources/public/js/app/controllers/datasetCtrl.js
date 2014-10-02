(function() {
	angular
		.module('app')
		.controller('datasetController', ['$scope', '$stateParams', '$state',
				'$modal', '$log', 'licenses', 'dataset', 'operation', 'DatasetFactory',
			function($scope, $stateParams, $state, $modal, $log, licenses, dataset, operation, DatasetFactory) {
				$scope.dataset = dataset;
				$scope.dataset.visibility = ['Autoriser tout le monde à voir mes publications',
									'Autoriser mes abonnés/abonnements à voir mes publications',
									'N\'autoriser personne à voir mes publications'];
				$scope.dataset.licenses = licenses;

				if (operation === 'create') {
					$scope.noDelete = true;
				}
				else if (operation === 'edit') {
					$scope.dataset = dataset;
					$scope.dataset.link = Routing.generate('datacity_public_dataviewpage') + '#/dataset/' + dataset.slug;
					$scope.dataset.license = dataset.license.name;
				}
				else if (operation === 'delete') {
					DatasetFactory.delete($stateParams.slug).then(function(response) {
						console.log(response);
					});
				}

				//Form Events
				$scope.submit = function() {
					var result = {
						license: $scope.dataset.license,
						description: $scope.dataset.description,
						title: $scope.dataset.title,
						visibility: $scope.dataset.selectedVisibility
					}
					if (operation === 'create' || operation === 'edit')
						DatasetFactory.post(result).then(function(response) {
							if (operation === 'create')
								$state.go('editDS', {slug: response.result});
						});

				}
				$scope.delete = function() {
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