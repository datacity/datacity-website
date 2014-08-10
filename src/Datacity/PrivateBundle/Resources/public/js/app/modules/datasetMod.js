(function() {
	var app = angular
		.module('app', [
			'mgcrea.ngStrap',
			'ui.router'
		])
		.config(['$urlRouterProvider', '$stateProvider', 
			function($urlRouterProvider, $stateProvider) {
				$stateProvider
				.state('editDS', {
					url: '/dataset/edit/:id',
					templateUrl: 'formDataSet',
					controller: 'datasetController',
					resolve: {
    					//data: ['User', function(User) { return User.new(); }],
    					operation: 'edit'
  					}
				})
				.state('addDS', {
					url: '/dataset/add',
					templateUrl: 'formDataSet',
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