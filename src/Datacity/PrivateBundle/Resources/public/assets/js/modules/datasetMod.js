(function() {
	var app = angular
		.module('datacity.dataset', [
			'mgcrea.ngStrap', 
			'ui.router'
		])
		.config(['$urlRouterProvider', '$stateProvider', 
			function($urlRouterProvider, $stateProvider) {
				$stateProvider
				.state('editDS', {
					url: '/dataset/edit/:id',
					templateUrl: '/app_dev.php/private/partials/formDataSet',
					controller: 'datasetController',
					resolve: {
    					//data: ['User', function(User) { return User.new(); }],
    					operation: 'edit'
  					}
				})
				.state('addDS', {
					url: '/dataset/add',
					templateUrl: '/app_dev.php/private/partials/formDataSet',
					controler: 'datasetController',
					resolve: {
    					operation: 'create'
  					}
				})
				.state('deleteDS', {
					url: '/dataset/delete/:id',
					controler: 'datasetController',
					resolve: {
    					operation: 'delete'
  					}
				})
	}]);
})();