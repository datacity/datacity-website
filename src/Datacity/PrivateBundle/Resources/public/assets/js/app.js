(function() {
	var app = angular
		.module('app', [
			'mgcrea.ngStrap',
			'ui.router',
			'ngGrid',
			'ngSanitize',
			'angularFileUpload'
		])
        .run(['$rootScope', '$state', '$stateParams',
            function ($rootScope,   $state,   $stateParams) {
                $rootScope.$on('$stateChangeStart', function(event, toState, toParams, fromState, fromParams) {
                    if (toState.title && toState.description) {
                        $rootScope.pageTitle = toState.title;
                        $rootScope.pageDescription = toState.description;
                        $rootScope.pageUrl = toState.url;
                    }
                });
            }
        ])
		.config(['$interpolateProvider', '$urlRouterProvider', '$stateProvider', 
			function($interpolateProvider, $urlRouterProvider, $stateProvider) {
				//$interpolateProvider.startSymbol('{[{').endSymbol('}]}');
				$stateProvider
				.state('default', {
                    title: 'Espace utilisateur',
                    description: 'Accedez à vos informations et aux outils DataCity',
                    url: '/',
                    template: '<div>Page default</div>'
                })
                //Operations liées aux dataset.
				.state('editDS', {
                    title: 'Edition',
                    description: 'Editer vos jeux de données',
					url: '/dataset/edit/:slug',
					templateUrl: '/app_dev.php/private/partials/formDataSet',
					controller: 'datasetController',
					resolve: {
						operation: function() {return 'edit'}
					}
				})
				.state('addDS', {
                    title: 'Ajout',
                    description: 'Ajouter un jeu de données',
					url: '/dataset/add',
					templateUrl: '/app_dev.php/private/partials/formDataSet',
					controller: 'datasetController',
					resolve: {
						operation: function() {return 'create'}
					}

				})
				.state('deleteDS', {
                    title: 'Suppression',
                    description: 'Suppression de jeux de données',
					url: '/dataset/delete/:slugDataset',
					controller: 'datasetController',
					resolve: {
						operation: function() {return 'delete'}
					}
				})
				//Operations liées aux sources
				.state('addSource', {
                    title: 'Ajout',
                    description: 'Ajouter une source',
					url: '/source/add/:slugDataset',
					templateUrl: '/app_dev.php/private/partials/formSource',
					controller: 'sourceController',
					resolve: {
						operation: function() {return 'create'}
					}
				})
				.state('editSource', {
                    title: 'Edition',
                    description: 'Editer vos sources',
					url: '/source/edit/:slugDataset/:id',
					templateUrl: '/app_dev.php/private/partials/formSource',
					controller: 'sourceController',
					resolve: {
						operation: function() {return 'edit'}
					}
				})
				//Operations liées à l'utilisateur
				.state('showUser', {
                    title: 'Votre Profil',
                    description: 'Changez vos informations personnelles',
					url: '/user/show',
					templateUrl: '/app_dev.php/private/partials/userInfo',
					controller: 'userController'
				});
	    }]);
})();