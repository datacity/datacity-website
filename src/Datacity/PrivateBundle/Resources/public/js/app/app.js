(function() {
	var app = angular
		.module('app', [
			'mgcrea.ngStrap',
			'ui.router',
			'ngGrid',
			'ngSanitize',
			'angularFileUpload',
			'angular-loading-bar',
			'ncy-angular-breadcrumb',
			'infinite-scroll'
		])
        .run(['$rootScope', '$state', '$stateParams',
            function ($rootScope,   $state,   $stateParams) {
                $rootScope.$on('$stateChangeStart', function(event, toState, toParams, fromState, fromParams) {
                    $rootScope.pageTitle = toState.data.title;
                    $rootScope.pageDescription = toState.data.description;
                });
            }
        ])
		.factory('$templateCache', ['$cacheFactory', '$http', '$injector', function($cacheFactory, $http, $injector) {
		  var cache = $cacheFactory('templates');
		  var allTplPromise;

		  return {
		    get: function(url) {
		      var fromCache = cache.get(url);

		      if (fromCache) {
		        return fromCache;
		      }

		      if (!allTplPromise) {
		        allTplPromise = $http.get(Routing.generate('datacity_private_partials')).then(function(response) {
		          $injector.get('$compile')(response.data);
		          return response;
		        });
		      }

		      return allTplPromise.then(function(response) {
		        return {
		          status: response.status,
		          config: { ignoreLoadingBar: false }, //trick for the loading bar
		          data: cache.get(url)
		        };
		      });
		    },

		    put: function(key, value) {
		      cache.put(key, value);
		    }
		  };
		}])
		.config(['$interpolateProvider', '$urlRouterProvider', '$stateProvider', '$breadcrumbProvider',
			function($interpolateProvider, $urlRouterProvider, $stateProvider, $breadcrumbProvider) {
				//$interpolateProvider.startSymbol('{[{').endSymbol('}]}');
				$urlRouterProvider.otherwise('/');
				$breadcrumbProvider.setOptions({
				      prefixStateName: 'homeUser',
				      templateUrl: 'breadcrumb.html'
				});
				$stateProvider
				//Page d'accueil utilisateur
				.state('homeUser', {
					data: {
						ncyBreadcrumbLabel: 'Accueil',
						title: 'Mon compte',
						description: '',
					},
					url: "/",
					templateUrl: 'index.html',
					controller: ['$scope', '$state', function($scope, $state) {
			        	$scope.$state = $state;
			     	}]
				})
                //Operations liées aux dataset.
				.state("datasetList", {
					data: {
						ncyBreadcrumbLabel: 'Jeux de données',
						title: 'Vos jeux de données',
						description: 'Ajouter/Gerer vos jeux de données',
					},
                	url: "/datasets",
                	templateUrl: 'datasets.html',
					controller: 'datasetListController',
					resolve: {
						datasets: ['DatasetFactory', function(DatasetFactory) {
							return DatasetFactory.getAll();
						}]
					}
               	})
				.state('editDS', {
					data: {
						ncyBreadcrumbLabel: 'Edition',
						ncyBreadcrumbParent: 'datasetList',
						title: 'Edition',
						description: 'Editer vos jeux de données',
					},
					url: '/dataset/edit/:slug',
					templateUrl: 'formDataSet.html',
					controller: 'datasetController',
					resolve: {
						operation: function() {return 'edit'},
						licenses: ['DatasetFactory', function(DatasetFactory) {
							return DatasetFactory.getLicences();
						}],
						dataset: ['DatasetFactory', '$stateParams', function(DatasetFactory, $stateParams) {
							return DatasetFactory.get($stateParams.slug);
						}]
					}
				})
				.state('addDS', {
					data: {
						ncyBreadcrumbLabel: 'Ajout',
						ncyBreadcrumbParent: 'datasetList',
						title: 'Ajout',
						description: 'Ajouter un jeu de données',
					},
					url: '/dataset/add',
					templateUrl: 'formDataSet.html',
					controller: 'datasetController',
					resolve: {
						operation: function() {return 'create'},
						licenses: ['DatasetFactory', function(DatasetFactory) {
							return DatasetFactory.getLicences();
						}],
						dataset: function() { return {} }
					}
				})
				.state('deleteDS', {
					data: {
						ncyBreadcrumbLabel: 'Suppression',
						ncyBreadcrumbParent: 'datasetList',
						title: 'Suppression',
						description: 'Suppression de jeux de données',
					},
					url: '/dataset/delete/:slugDataset',
					controller: 'datasetController',
					resolve: {
						operation: function() {return 'delete' },
						licenses: ['DatasetFactory', function(DatasetFactory) {
							return DatasetFactory.getLicences();
						}],
						dataset: function() { return {} }
					}
				})
				//Operations liées aux sources
				.state('addSource', {
					data: {
						ncyBreadcrumbLabel: 'Ajout de source',
						ncyBreadcrumbParent: 'datasetList', //https://github.com/ncuillery/angular-breadcrumb/issues/32#event-155972344
						title: 'Source',
						description: 'Ajouter une source',
					},
					url: '/source/add/:slugDataset',
					templateUrl: 'formSource.html',
					controller: 'sourceController',
					resolve: {
						operation: function() {return 'create'}
					}
				})
				.state('editSource', {
					data: {
						ncyBreadcrumbLabel: 'Edition de source',
						ncyBreadcrumbParent: 'datasetList', //https://github.com/ncuillery/angular-breadcrumb/issues/32#event-155972344
						title: 'Edition',
						description: 'Editer une source',
					},
					url: '/source/edit/:slugDataset/:id',
					templateUrl: 'formSource.html',
					controller: 'sourceController',
					resolve: {
						operation: function() {return 'edit'}
					}
				})
				//Operations liées à l'utilisateur
				.state('profile', {
					data: {
						ncyBreadcrumbLabel: 'Profil',
						title: 'Votre Profil',
						description: 'Changez vos informations personnelles',
					},
					abstract: true,
					url: '/profile',
					templateUrl: 'profile.html',
					controller: 'userController',
					resolve: {
						currentUser: ['UserFactory', function(UserFactory) {
							return UserFactory.getUserFromSession().then(function(data) {
				 				return data.user;
				 			});
						}]
					}
				})
                .state("profile.mainView", {
                	url: "/mainView",
                	templateUrl: 'profileOverviewIndex.html',
					data: {
						ncyBreadcrumbLabel: "Profil",
						title: 'Votre Profil',
						description: 'Informations personnelles',
					},
                })
                .state("profile.settings", {
                	url: "/settings",
                	templateUrl: 'profileSettingsIndex.html',
					data: {
						ncyBreadcrumbLabel: 'Paramètres',
						ncyBreadcrumbParent: 'profile.mainView',
						title: 'Votre Profil',
						description: 'Changez vos informations personnelles',
					},
                })
                .state("profile.settings.profileSettings", {
                	url: "/profile",
                	templateUrl: 'profileSettingsUserTab.html',
					data: {
						ncyBreadcrumbLabel: 'Edition',
						ncyBreadcrumbParent: 'profile.mainView',
						title: 'Votre Profil',
						description: 'Changez vos informations personnelles',
					},
                })
                .state("profile.settings.pictureSettings", {
                	url: "/picture",
                	templateUrl: 'profileSettingsPictureTab.html',
					data: {
						ncyBreadcrumbLabel: 'Image',
						ncyBreadcrumbParent: 'profile.mainView',
						title: 'Votre Profil',
						description: 'Changez vos informations personnelles',
					},
                })
                .state("profile.settings.passwordSettings", {
                	url: "/password",
                	templateUrl: 'profileSettingsPasswordTab.html',
					data: {
						ncyBreadcrumbLabel: 'Mot de passe',
						ncyBreadcrumbParent: 'profile.mainView',
						title: 'Votre Profil',
						description: 'Changez vos informations personnelles',
					},
                });
	    }]);
})();