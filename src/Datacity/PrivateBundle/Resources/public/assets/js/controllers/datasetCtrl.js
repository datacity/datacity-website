(function() {
	angular
		.module('app')
		.controller('datasetController', ['$scope', '$stateParams', 'Dataset', 'operation'
			function($scope, $stateParams, Dataset, operation) {
				this.dataset = {};
				var that = this;
				if (operation === 'create') {
					this.dataset = {
						title: 'test',
						description: 'coucou les amis'
					};
				}
				else if (operation === 'edit') {
					Dataset.get($stateParams.id).then(function(data) {
						that.dataset = data;
					});
				}
				this.save = function(dataset) {
					Dataset.post(dataset);
				}

				else if (operation === 'delete') {
					// DO DELETE ACTIONS
				}
		}]);
})();