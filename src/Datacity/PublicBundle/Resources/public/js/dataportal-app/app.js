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
            $scope.$watch('text', function(a, b) {
                if (a === b)
                    return;
                if (timer) {
                    $timeout.cancel(timer)
                }  
                timer = $timeout(function() {
                    $scope.search();
                }, 500)
            });
            $scope.$watch('categories', function(a, b) {
                if (a === b)
                    return;
                $scope.search();
            }, true);
            $scope.$watch('licenses', function(a, b) {
                if (a === b)
                    return;
                $scope.search();
            }, true);
            $scope.$watch('frequencies', function(a, b) {
                if (a === b)
                    return;
                $scope.search();
            }, true);
            $scope.$watch('place', function(a, b) {
                if (a === b)
                    return;
                $scope.search();
            });
            $scope.goto = function(dataset) {
                $state.go('dataset', {
                    slug: dataset.slug
                });
            }
            $scope.getLocation = function(val) {
                return $http.get(Routing.generate('datacity_public_api_place'), {
                    ignoreLoadingBar: true,
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
                DatasetFactory.searchDatasets({
                    text: $scope.text,
                    place: $scope.place,
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
