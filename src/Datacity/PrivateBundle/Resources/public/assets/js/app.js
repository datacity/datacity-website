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
				$urlRouterProvider.otherwise('/user/show/mainView');
				$stateProvider
                //Operations liées aux dataset.
				.state('editDS', {
                    title: 'Edition',
                    description: 'Editer vos jeux de données',
					url: '/dataset/edit/:slug',
					templateUrl: Routing.generate('datacity_private_partials', {pageName: 'formDataSet'}),
					controller: 'datasetController',
					resolve: {
						operation: function() {return 'edit'}
					}
				})
				.state('addDS', {
                    title: 'Ajout',
                    description: 'Ajouter un jeu de données',
					url: '/dataset/add',
					templateUrl: Routing.generate('datacity_private_partials', {pageName: 'formDataSet'}),
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
					templateUrl: Routing.generate('datacity_private_partials', {pageName: 'formSource'}),
					controller: 'sourceController',
					resolve: {
						operation: function() {return 'create'}
					}
				})
				.state('editSource', {
                    title: 'Edition',
                    description: 'Editer vos sources',
					url: '/source/edit/:slugDataset/:id',
					templateUrl: Routing.generate('datacity_private_partials', {pageName: 'formSource'}),
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
					templateUrl: Routing.generate('datacity_private_partials', {pageName: 'userInfo'}),
					controller: 'userController'
				})
                .state("showUser.mainView", { 
                	url: "/mainView",
                	templateUrl: Routing.generate('datacity_private_partials', {pageName: 'userOverviewTab'}),
                    title: 'Votre Profil', 
                    description: 'Changez vos informations personnelles'
                })
                .state("showUser.settings", { url: "/settings", templateUrl: Routing.generate('datacity_private_partials', {pageName: 'userAccount'}),
                        title: 'Votre Profil', description: 'Changez vos informations personnelles'})
                .state("showUser.publications", { url: "/publications", templateUrl: Routing.generate('datacity_private_partials', {pageName: 'userPublications'}),
                        title: 'Votre Profil', description: 'Changez vos informations personnelles'})
                    .state("showUser.settings.profileSettings", { url: "/profile", templateUrl: Routing.generate('datacity_private_partials', {pageName: 'profileTab'}),
                        title: 'Votre Profil', description: 'Changez vos informations personnelles'})
                    .state("showUser.settings.pictureSettings", { url: "/picture", templateUrl: Routing.generate('datacity_private_partials', {pageName: 'pictureTab'}),
                        title: 'Votre Profil', description: 'Changez vos informations personnelles'})
                    .state("showUser.settings.passwordSettings", { url: "/password", templateUrl: Routing.generate('datacity_private_partials', {pageName: 'passwordTab'}),
                        title: 'Votre Profil', description: 'Changez vos informations personnelles'});
	    }]);
})();