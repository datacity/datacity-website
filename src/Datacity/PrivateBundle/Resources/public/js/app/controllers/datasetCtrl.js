(function() {
	angular
		.module('app')
		.constant('ITEM_PER_REQUEST', 12)
		.controller('datasetListController', ['$scope', 'datasets', 'DatasetFactory', 'ITEM_PER_REQUEST',
			function($scope, datasets, DatasetFactory, ITEM_PER_REQUEST) {
				$scope.scrollDisabled = false;
				var offset = 0;
	        	$scope.datasets = datasets;
	        	$scope.addDatasets = function() {
	        		$scope.scrollDisabled = true;
	        		offset = offset + ITEM_PER_REQUEST;
	        		DatasetFactory.getAll(offset).then(function(data) {
	        			if (data.length === 0) {
	        				$scope.scrollDisabled = true;
	        				return;
	        			}
	        			$scope.scrollDisabled = data.length < ITEM_PER_REQUEST;
				    	$scope.datasets = $scope.datasets.concat(data);
	        		});
	        	}
	    }])
		.controller('datasetController', ['$scope', '$stateParams', '$state',
				'$modal', '$log', 'licenses', 'dataset', 'operation', 'DatasetFactory',
			function($scope, $stateParams, $state, $modal, $log, licenses, dataset, operation, DatasetFactory) {
				$scope.dataset = dataset;
				$scope.dataset.visibility = ['Autoriser tout le monde à voir mes publications',
									'Autoriser mes abonnés/abonnements à voir mes publications',
									'N\'autoriser personne à voir mes publications'];
				$scope.dataset.licenses = licenses;
				if (operation === 'edit') {
					$scope.dataset = dataset;
					$scope.dataset.link = Routing.generate('datacity_public_dataviewpage') + '#/dataset/' + dataset.slug;
				}
				else if (operation === 'delete') {
					DatasetFactory.delete($stateParams.slug).then(function(response) {
						console.log(response);
					});
				}

				//Form Events
				$scope.submit = function() {
					var result = {
						license: $scope.dataset.license.name,
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
 				//var confirmDeleteModal = $modal({animation: 'am-fade-and-scale', placement: 'center', scope: $scope, template: '/app_dev.php/private/modals/modal', title: 'Confirmation', content: 'Voulez vous vraiment supprimmer ce jeu de donnée? Cela entraînera la suppression de toutes les sources associées.', show: false});
  				//$scope.showModal = function() {
    			//	confirmDeleteModal.$promise.then(confirmDeleteModal.show);
  				//};
		}]);
})();