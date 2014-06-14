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
                        datasets: ['$http',
                            function($http) {
                                return $http.get('/ajax/popular-datasets')
                                    .then(function(res) {
                                        return res.data;
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
                        dataset: ['$stateParams', '$http',
                            function($stateParams, $http) {
                                return $http.get('/ajax/dataset/' + $stateParams.slug)
                                    .then(function(res) {
                                        return res.data;
                                    });
                            }
                        ]
                    },
                })
                .state('source', {
                    url: '/source/:slug',
                    templateUrl: '/partials/source',
                    controller: 'sourceCtrl',
                    resolve: {
                        source: ['$stateParams', '$http',
                            function($stateParams, $http) {
                                return $http.get('/ajax/source/' + $stateParams.slug)
                                    .then(function(res) {
                                        return res.data;
                                    });
                            }
                        ]
                    },
                })
        }
    ])
    .controller('homeCtrl', ['$scope', '$state', '$http', 'datasets',
        function($scope, $state, $http, $datasets) {
            $scope.datasets = $datasets;
            $scope.goto = function(dataset) {
                if (dataset.type == 'source')
                    $state.go('source', {
                        slug: dataset.slug
                    });
                else if (dataset.type == 'dataset')
                    $state.go('dataset', {
                        slug: dataset.slug
                    });
            }
            $scope.getLocation = function(val) {
                return $http.get('http://maps.googleapis.com/maps/api/geocode/json', {
                    params: {
                        address: val,
                        sensor: false
                    }
                }).then(function(res) {
                    var addresses = [];
                    angular.forEach(res.data.results, function(item) {
                        addresses.push(item.formatted_address);
                    });
                    return addresses;
                });
            };
        }
    ])
    .controller('datasetCtrl', ['$scope', '$state', 'dataset',
        function($scope, $state, $dataset) {
            $scope.dataset = $dataset;
            $scope.goto = function(source) {
                $state.go('source', {
                    slug: source.slug
                });
            }
        }
    ])
    .controller('sourceCtrl', ['$scope', '$state', 'source',
        function($scope, $state, $source) {
            $scope.source = $source;
            $scope.goto = function(dataset) {
                $state.go('dataset', {
                    slug: dataset.slug
                });
            }
        }
    ]);
