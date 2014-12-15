(function() {
	var app = angular
		.module('app', [
			'mgcrea.ngStrap',
			'ui.router',
			'ngGrid',
			'ngSanitize',
			'ngAnimate',
			'angularFileUpload',
			'angular-loading-bar',
			'ncy-angular-breadcrumb',
			'infinite-scroll',
			'ngTable',
			'ngTableResizableColumns',
			'ang-drag-drop'
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
		.config(['$interpolateProvider', '$urlRouterProvider', '$stateProvider', '$breadcrumbProvider', '$modalProvider',
			function($interpolateProvider, $urlRouterProvider, $stateProvider, $breadcrumbProvider, $modalProvider) {
				angular.extend($modalProvider.defaults, {
					html: true
				});
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
						title: 'Mon compte',
						description: '',
					},
					ncyBreadcrumb: {
					    label: 'Accueil'
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
						title: 'Vos jeux de données',
						description: 'Ajouter/Gerer vos jeux de données',
					},
					ncyBreadcrumb: {
					    label: 'Jeux de données'
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
						title: 'Edition',
						description: 'Editer vos jeux de données',
					},
					ncyBreadcrumb: {
					    label: 'Edition',
					    parent: 'datasetList'
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
						}],
					    datasetSlug: ['$stateParams', function($stateParams){
					        return $stateParams.slug;
					    }]
					}
				})
				.state('addDS', {
					data: {
						title: 'Ajout',
						description: 'Ajouter un jeu de données',
					},
					ncyBreadcrumb: {
					    label: 'Ajout',
					    parent: 'datasetList'
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
				//Inutilisé
				.state('deleteDS', {
					data: {
						title: 'Suppression',
						description: 'Suppression de jeux de données',
					},
					ncyBreadcrumb: {
					    label: 'Suppression',
					    parent: 'datasetList'
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
				//Dataset Wizard
				.state('wizardDS', {
					ncyBreadcrumb: {
					    label: 'Création',
					    parent: 'datasetList'
					},
					data: {
						title: 'Nouveau jeux de donnée',
						description: '',
					},
					abstract: true,
					url: '/dataset/wizard',
					templateUrl: 'datasetWizardBase.html',
					controller: 'datasetWizardController',
					resolve: {
						wizardMode: function() { return 'dataset' }
					}
				})
				.state('wizardDS.step1', {
					ncyBreadcrumb: {
					    label: 'Création'
					},
					url: '/1',
					templateUrl: 'datasetWizardStep1.html',
					controller: 'datasetWizardStep1Controller'
				})
				.state('wizardDS.step2', {
					ncyBreadcrumb: {
					    label: 'Création'
					},
					url: '/2',
					templateUrl: 'datasetWizardStep2.html',
					controller: 'datasetWizardStep2Controller'
				})
				.state('wizardDS.step3', {
					ncyBreadcrumb: {
					    label: 'Création'
					},
					url: '/3',
					templateUrl: 'datasetWizardStep3.html',
					controller: 'datasetWizardStep3Controller'
				})
				.state('wizardDS.step4', {
					ncyBreadcrumb: {
					    label: 'Création'
					},
					url: '/4',
					templateUrl: 'datasetWizardStep4.html',
					controller: 'datasetWizardStep4Controller',
					resolve: {
						filterList: ['$http', function($http) {
							return $http.get(Routing.generate('datacity_public_api_filter_list'));
						}]
					}
				})
				.state('wizardDS.step5', {
					ncyBreadcrumb: {
					    label: 'Création'
					},
					url: '/5',
					templateUrl: 'datasetWizardStep5.html',
					controller: 'datasetWizardStep5Controller'
				})
				//Operations liées aux sources
				.state('editDS.addSource', {
					data: {
						title: 'Source',
						description: 'Ajouter une source',
					},
					ncyBreadcrumb: {
					    label: 'Ajout de source'
					},
					url: '/source/add/',
				    views: {
				        '@' : {
				            controller: 'sourceController',
				        	templateUrl: 'formSource.html'
				        }
				    },
					resolve: {
						sourceOperation: function() {return 'create'}
					}
				})
				//Inutilisé
				.state('editDS.editSource', {
					data: {
						title: 'Edition',
						description: 'Editer une source',
					},
					ncyBreadcrumb: {
					        label: 'Edition de source'
					},
					url: '/source/edit/:id',
				    views: {
				        '@' : {
				            controller: 'sourceController',
				        	templateUrl: 'formSource.html'
				        }
				    },
					resolve: {
						sourceOperation: function() {return 'edit'}
					}
				})
				//Operations liées à l'utilisateur
				.state('profile', {
					data: {
						title: 'Votre Profil',
						description: 'Changez vos informations personnelles',
					},
					ncyBreadcrumb: {
						label: 'Profil'
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
						title: 'Votre Profil',
						description: 'Informations personnelles',
					},
					ncyBreadcrumb: {
					    label: 'Profil'
					},
                })
                .state("profile.settings", {
                	url: "/settings",
                	templateUrl: 'profileSettingsIndex.html',
					data: {
						title: 'Votre Profil',
						description: 'Changez vos informations personnelles',
					},
					ncyBreadcrumb: {
				        label: 'Paramètres',
				        parent: 'profile.mainView'
					},
                })
                .state("profile.settings.profileSettings", {
                	url: "/profile",
                	templateUrl: 'profileSettingsUserTab.html',
					data: {
						title: 'Votre Profil',
						description: 'Changez vos informations personnelles',
					},
					ncyBreadcrumb: {
				        label: 'Edition',
				        parent: 'profile.mainView'
					},
                })
                .state("profile.settings.pictureSettings", {
                	url: "/picture",
                	templateUrl: 'profileSettingsPictureTab.html',
					data: {
						title: 'Votre Profil',
						description: 'Changez vos informations personnelles',
					},
					ncyBreadcrumb: {
				        label: 'Image',
				        parent: 'profile.mainView'
					},
                })
                .state("profile.settings.passwordSettings", {
                	url: "/password",
                	templateUrl: 'profileSettingsPasswordTab.html',
					data: {
						title: 'Votre Profil',
						description: 'Changez vos informations personnelles',
					},
					ncyBreadcrumb: {
				        label: 'Mot de passe',
				        parent: 'profile.mainView'
					},
                });
	    }]);
})();