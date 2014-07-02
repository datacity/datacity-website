angular
    .module('datacity.datasets', [
        'ui.router',
        'ui.bootstrap'
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
    .controller('homeCtrl', ['$scope', '$state', '$http', 'datasets', 'DatasetFactory',
        function($scope, $state, $http, datasets, DatasetFactory) {
            $scope.datasets = datasets;
            $scope.$watch('searchPlace', function() {
                if ($scope.searchPlace != undefined)
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
                DatasetFactory.searchDatasets($scope.searchText, $scope.searchPlace).then(function(data) {
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
