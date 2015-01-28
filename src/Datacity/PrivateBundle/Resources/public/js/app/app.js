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
			'ui.select2',
			'ang-drag-drop',
			'ui.keypress'
		])
        .run(['$rootScope', '$state', '$stateParams',
            function ($rootScope,   $state,   $stateParams) {
                $rootScope.$on('$stateChangeStart', function(event, toState, toParams, fromState, fromParams) {
                    $rootScope.pageTitle = toState.data.title;
                    $rootScope.pageDescription = toState.data.description;
                });
            }
        ])
        .constant('apiUrl', datacityParams.apiUrl)
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

				 	//Page ticket des users
               	.state("userTickets", {
					data: {
						title: 'Vos Tickets',
						description: 'Ajouter/Gérer vos Tickets',
					},
					ncyBreadcrumb: {
					    label: 'Tickets'
					},
                	url: "/tickets",
                	templateUrl: 'userTickets.html',
					controller: 'userTicketController',
					resolve: {
						tickets: ['TicketFactory', function(TicketFactory) {
							 return TicketFactory.getAll();
						}]
					}
               	})

 				.state("addTickets", {
					data: {
						title: 'Ajout',
						description: 'Ajouter un ticket',
					},
					ncyBreadcrumb: {
					    label: 'Ajout',
					    parent: 'userTickets'
					},
                	url: "/tickets/addTickets",
                	templateUrl: 'formAddTicket.html',
					controller: 'addTicketController'
               	})

 				.state("detailTickets", {
					data: {
						title: 'Ticket',
						description: 'Detail de votre ticket',
					},
					ncyBreadcrumb: {
					    label: 'Ticket',
					    parent: 'userTickets'
					},
                	url: "/tickets/detail/:slug",
					resolve: {
						ticket: ['$http', '$stateParams', function($http, $stateParams) {
							return $http.get(Routing.generate('datacity_private_tickets_get_userticket', {slug: $stateParams.slug}))
								.then(function(data){
									return data.data.results;
								});
						}]
					},
                	templateUrl: 'ticketDetailUser.html',
					controller: 'detailTicketController'
               	})

				//Page applications des users
               	.state("userApplications", {
					data: {
						title: 'Vos applications',
						description: 'Ajouter/Gérer vos applications',
					},
					ncyBreadcrumb: {
					    label: 'Applications'
					},
                	url: "/applications",
                	templateUrl: 'userApplications.html',
					controller: 'userApplicationsController',
					resolve: {
						applications: ['AppFactory', function(AppFactory) {
							return AppFactory.getAll();
						}]
					}
               	})

               	.state("editApplication", {
					data: {
						title: 'Edition',
						description: 'Editer vos applications',
					},
					ncyBreadcrumb: {
					    label: 'Edition'
					},
                	url: "/application/edit/:slug",
                	templateUrl: 'editApplication.html',
					controller: 'applicationController',
					resolve: {
						operation: function() {return 'edit'},
						categories: ['AppFactory', function(AppFactory) {
							return AppFactory.categories();
						}],
						cities: ['AppFactory', function(AppFactory) {
							return AppFactory.cities();
						}],
						datasets: ['AppFactory', function(AppFactory) {
							return AppFactory.datasets();
						}],
						platforms: ['AppFactory', function(AppFactory) {
							return AppFactory.platforms();
						}],
						application: ['AppFactory', '$stateParams', function(AppFactory, $stateParams) {
							return AppFactory.get($stateParams.slug);
						}]
					}
               	})
               	.state("addApplication", {
					data: {
						title: 'Ajout',
						description: 'Ajouter vos applications',
					},
					ncyBreadcrumb: {
					    label: 'Ajout'
					},
                	url: "/application/addUserApplication",
                	templateUrl: 'editApplication.html',
					controller: 'applicationController',
					resolve: {
						operation: function() {return 'add'},
						categories: ['AppFactory', function(AppFactory) {
							return AppFactory.categories();
						}],
						cities: ['AppFactory', function(AppFactory) {
							return AppFactory.cities();
						}],
						datasets: ['AppFactory', function(AppFactory) {
							return AppFactory.datasets();
						}],
						platforms: ['AppFactory', function(AppFactory) {
							return AppFactory.platforms();
						}],
						application: ['AppFactory', function(AppFactory){
							return [];
						}]
					}
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
					    }],
					    currentUser: ['UserFactory', function(UserFactory) {
							return UserFactory.getUserFromSession().then(function(data) {
				 				return data.user;
				 			});
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
						dataset: function() { return {} },
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
						wizardMode: function() { return 'dataset' },
						currentUser: ['UserFactory', function(UserFactory) {
							return UserFactory.getUserFromSession().then(function(data) {
				 				return data.user;
				 			});
						}]
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
					controller: 'datasetWizardStep2Controller',
					resolve: {
						datasetModel: function() {
							return []; //Support mode source
						}
					}
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
					controller: 'datasetWizardStep5Controller',
					resolve: {
						datasetSlug: function() {
							return []; //Support mode source
						}
					}
				})
				//Operations liées aux sources ANCIEN SYSTEME
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
				//Operations liées aux sources NOUVEAU SYSTEME
				.state('editDS.wizardS', {
					data: {
						title: 'Source',
						description: 'Ajouter une source',
					},
					ncyBreadcrumb: {
					    label: 'Ajout de source'
					},
					abstract: true,
					url: '/source/new', //COHABITATION ANCIEN SYSTEME
				    views: {
				        '@' : {
				            controller: 'datasetWizardController',
				        	templateUrl: 'datasetWizardBase.html'
				        }
				    },
					resolve: {
						wizardMode: function() { return 'source' },
						currentUser: ['UserFactory', function(UserFactory) {
							return UserFactory.getUserFromSession().then(function(data) {
				 				return data.user;
				 			});
						}]
					}
				})
				.state('editDS.wizardS.step1', {
					ncyBreadcrumb: {
					    label: 'Ajout de source'
					},
					url: '/1',
					templateUrl: 'datasetWizardStep1.html',
					controller: 'datasetWizardStep1Controller'
				})
				.state('editDS.wizardS.step2', {
					ncyBreadcrumb: {
					    label: 'Ajout de source'
					},
					url: '/2',
					templateUrl: 'datasetWizardStep2.html',
					controller: 'datasetWizardStep2Controller',
					resolve: {
						datasetModel: ['$http', 'datasetSlug', function($http, datasetSlug) {
							return $http
								.get(Routing.generate('datacity_public_api_dataset_model', //FIXME En attente de l'api, ancienne methode.
										{slug: datasetSlug})).then(function(response) {
									return response.data.results;
								});
						}]
					}
				})
				.state('editDS.wizardS.step3', {
					ncyBreadcrumb: {
					    label: 'Ajout de source'
					},
					url: '/3',
					templateUrl: 'datasetWizardStep3.html',
					controller: 'datasetWizardStep3Controller'
				})
				.state('editDS.wizardS.step4', {
					ncyBreadcrumb: {
					    label: 'Ajout de source'
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
				.state('editDS.wizardS.step5', {
					ncyBreadcrumb: {
					    label: 'Ajout de source'
					},
					url: '/5',
					templateUrl: 'datasetWizardStep5.html',
					controller: 'datasetWizardStep5Controller',
					resolve: {
						datasetSlug: ['datasetSlug', function(datasetSlug) {
							return datasetSlug;
						}]
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
                .state("profile.api", {
                	url: "/api",
                	templateUrl: 'profileSettingsApi.html',
					data: {
						title: 'Votre Profil',
						description: 'Informations api',
					},
					ncyBreadcrumb: {
				        label: 'Information api',
				        parent: 'profile.mainView'
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