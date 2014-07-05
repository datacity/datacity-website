angular
    .module('datacity.datasets', [
        'ui.router',
        'ui.bootstrap',
        'multi-select',
        'angular-loading-bar'
    ])
    .config(['$urlRouterProvider', '$stateProvider',
        function($urlRouterProvider, $stateProvider) {
            $urlRouterProvider.otherwise('/');

            $stateProvider
                .state('default', {
                    url: '/',
                    templateUrl: '/partials/datasetlist',
                    controller: 'homeCtrl',
                    resolve: {
                        datasets: ['DatasetFactory',
                            function(DatasetFactory) {
                                return DatasetFactory.getPopularDatasets();
                            }
                        ],
                        filters: ['$http',
                            function($http) {
                                return $http.get(Routing.generate('datacity_public_api_search_list')).then(function(res) {
                                    angular.forEach(res.data.results, function(item) {
                                        angular.forEach(item, function(data) {
                                            data.selected = true;
                                        });
                                    });
                                    return res.data.results;
                                });
                            }
                        ]
                    },
                })
                .state('dataset', {
                    url: '/dataset/:slug',
                    templateUrl: '/partials/dataset',
                    controller: 'datasetCtrl',
                    resolve: {
                        dataset: ['$stateParams', 'DatasetFactory',
                            function($stateParams, DatasetFactory) {
                                return DatasetFactory.getDataset($stateParams.slug);
                            }
                        ]
                    },
                });
        }
    ])
    .controller('homeCtrl', ['$scope', '$state', '$http', 'datasets', 'DatasetFactory', 'filters', '$timeout',
        function($scope, $state, $http, datasets, DatasetFactory, filters, $timeout) {
            $scope.datasets = datasets;
            $scope.categories = filters.categories;
            $scope.licenses = filters.licenses;
            $scope.frequencies = filters.frequencies;
            var timer = false;
            $scope.$watch('searchText', function(){
                if (timer) {
                    $timeout.cancel(timer)
                }  
                timer = $timeout(function() {
                    $scope.search();
                }, 500)
            });
            $scope.$watch('categories', function() {
                $scope.search();
            }, true);
            $scope.$watch('licenses', function() {
                $scope.search();
            }, true);
            $scope.$watch('frequencies', function() {
                $scope.search();
            }, true);
            $scope.$watch('searchPlace', function() {
                $scope.search();
            });
            $scope.goto = function(dataset) {
                $state.go('dataset', {
                    slug: dataset.slug
                });
            }
            $scope.getLocation = function(val) {
                return $http.get(Routing.generate('datacity_public_api_place'), {
                    params: {
                        q: val
                    }
                }).then(function(res) {
                    var places = [];
                    angular.forEach(res.data.results, function(item) {
                        places.push(item.name);
                    });
                    return places;
                });
            };
            $scope.search = function() {
                if (!$scope.searchText && !$scope.searchPlace) {
                    $scope.datasets = datasets;
                    return;
                }
                DatasetFactory.searchDatasets({
                    text: $scope.searchText,
                    place: $scope.searchPlace,
                    categories: $scope.categories,
                    licenses: $scope.licenses,
                    frequencies: $scope.frequencies
                }).then(function(data) {
                    $scope.datasets = data;
                });
            }
        }
    ])
    .controller('datasetCtrl', ['$scope', '$state', 'dataset',
        function($scope, $state, dataset) {
            $scope.dataset = dataset;
        }
    ])
    .controller('visualizatorCtrl', ['$scope',
        function($scope) {

        }
    ]);
