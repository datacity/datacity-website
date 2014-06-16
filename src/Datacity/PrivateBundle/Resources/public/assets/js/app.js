(function() {
	var app = angular
		.module('app', [
			'mgcrea.ngStrap',
			'ui.router'
		])
		.config(['$interpolateProvider', '$urlRouterProvider', '$stateProvider', 
			function($interpolateProvider, $urlRouterProvider, $stateProvider) {
				$interpolateProvider.startSymbol('{[{').endSymbol('}]}');
				$stateProvider
				.state('editDS', {
					url: '/dataset/edit/:id',
					templateUrl: '/app_dev.php/private/partials/formDataSet',
					controller: 'datasetController',
					resolve: {
						operation: function() {return 'edit'}
					}
				})
				.state('addDS', {
					url: '/dataset/add',
					templateUrl: '/app_dev.php/private/partials/formDataSet',
					controller: 'datasetController',
					resolve: {
						operation: function() {return 'create'}
					}

				})
				.state('deleteDS', {
					url: '/dataset/delete/:id',
					controller: 'datasetController',
					resolve: {
						operation: function() {return 'delete'}
					}
				})
				.state('showUser', {
					url: '/user/show/:id',
					templateUrl: '/app_dev.php/private/partials/userInfo',
					controller: 'userController'
				});
	}]);
})();