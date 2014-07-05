(function() {
	var app = angular
		.module('app', [
			'mgcrea.ngStrap',
			'ui.router',
			'ngGrid',
			'ngSanitize',
			'angularFileUpload'
		])
		.config(['$interpolateProvider', '$urlRouterProvider', '$stateProvider', 
			function($interpolateProvider, $urlRouterProvider, $stateProvider) {
				//$interpolateProvider.startSymbol('{[{').endSymbol('}]}');
				$stateProvider
				.state('default', {
                    url: '/',
                    template: '<div>Page default</div>'
                })
                //Operations liées aux dataset.
				.state('editDS', {
					url: '/dataset/edit/:slug',
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
				//Operations liées aux sources
				.state('addSource', {
					url: '/source/add',
					templateUrl: '/app_dev.php/private/partials/formSource',
					controller: 'sourceController',
					resolve: {
						operation: function() {return 'create'}
					}
				})
				.state('editSource', {
					url: '/source/edit/:id',
					templateUrl: '/app_dev.php/private/partials/formSource',
					controller: 'sourceController',
					resolve: {
						operation: function() {return 'edit'}
					}
				})
				//Operations liées à l'utilisateur
				.state('showUser', {
					url: '/user/show',
					templateUrl: '/app_dev.php/private/partials/userInfo',
					controller: 'userController'
				});
	}]);
})();