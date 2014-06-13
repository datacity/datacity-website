angular
    .module('datacity.datasets', [
        'ui.router'
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
    .controller('homeCtrl', ['$scope', '$state', 'datasets',
        function($scope, $state, $datasets) {
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
        }
    ])
    .controller('datasetCtrl', ['$scope', 'dataset',
        function($scope, $dataset) {
            $scope.dataset = $dataset;
        }
    ])
    .controller('sourceCtrl', ['$scope', 'source',
        function($scope, $source) {
            $scope.source = $source;
        }
    ]);
