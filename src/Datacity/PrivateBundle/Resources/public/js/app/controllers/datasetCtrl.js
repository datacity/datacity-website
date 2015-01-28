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
				'$modal', '$log', 'licenses', 'dataset', 'operation', 'DatasetFactory', 'currentUser',
			function($scope, $stateParams, $state, $modal, $log, licenses, dataset, operation, DatasetFactory, currentUser) {
				$scope.dataset = dataset;
				$scope.dataset.visibility = [{val : 'Autoriser tout le monde à voir mes publications', id:'public'},
											{val:'N\'autoriser personne à voir mes publications', id:'private'}];
				$scope.dataset.selectedVisibility = dataset.is_public ? $scope.dataset.visibility[0].id : $scope.dataset.visibility[1].id;
				$scope.dataset.licenses = licenses;
				$scope.dataset = dataset;
				$scope.dataset.link = Routing.generate('datacity_public_dataviewpage') + '/dataset/' + dataset.slug;
				$scope.inProgress = false;

				$scope.submit = function() {
					var result = {
						license: $scope.dataset.license.name,
						description: $scope.dataset.description,
						title: $scope.dataset.title,
						visibility: $scope.dataset.selectedVisibility
					}
					$scope.inProgress = true;
					DatasetFactory.save(dataset.slug, result).then(function(response) {
						toastr.success("Dataset mis à jour !");
						$scope.inProgress = false;
					});
				}
				$scope.delete = function($hide) {
					$scope.inProgress = true;
					$hide();
					var key = {public_key: currentUser.public_key, private_key: currentUser.private_key};
					DatasetFactory.delete(key, $stateParams.slug).then(function(response) {
						$state.go('datasetList');
					});
				}

 				var confirmDeleteModal = $modal({animation: 'am-fade-and-scale',
 											placement: 'center', scope: $scope,
 											template: 'confirmDeleteDatasetModal.html',
 											show: false});
  				$scope.showModal = function() {
    				confirmDeleteModal.show();
  				};
		}]);
})();