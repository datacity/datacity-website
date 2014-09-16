angular.module('datacity.datasets', ['ui.router', 'ui.bootstrap', 'ui.select2',
                                    'angular-loading-bar', 'ngGrid', 'angularUtils.directives.dirPagination'])
    .constant('apiUrl', 'http://localhost:4567')
    .config(['$urlRouterProvider', '$stateProvider',
    function($urlRouterProvider, $stateProvider) {
        $urlRouterProvider.otherwise('/');
        $stateProvider.state('default', {
            url: '/',
            templateUrl: '/partials/datasetlist',
            controller: 'homeCtrl',
            resolve: {
                datasets: ['DatasetFactory',
                    function(DatasetFactory) {
                        return DatasetFactory.getPopularDatasets(1);
                    }
                ],
                filters: ['$http',
                    function($http) {
                        return $http.get(Routing.generate('datacity_public_api_filter_list')).then(function(res) {
                            var data = {};
                            angular.forEach(res.data.results, function(filter, k) {
                                data[k] = filter.map(function(e) {
                                  return e.name;
                                });
                            });
                            return data;
                        });
                    }
                ]
            },
        }).state('dataset', {
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
]).controller('homeCtrl', ['$scope', '$state', '$http', 'datasets', 'DatasetFactory', 'filters', '$timeout',
    function($scope, $state, $http, datasets, DatasetFactory, filters, $timeout) {
        $scope.datasets = datasets;
        $scope.categories = [];
        $scope.licenses = [];
        $scope.frequencies = [];
        $scope.selectCategories = {
            'multiple': true,
            'simple_tags': true,
            'tokenSeparators': [",", " "],
            'tags': filters.categories,
            'placeholder': "Catégorie(s)"
        };
        $scope.selectLicences = {
            'multiple': true,
            'simple_tags': true,
            'tags': filters.licenses,
            'placeholder': "Licence(s)"
        };
        $scope.selectFrequencies = {
            'multiple': true,
            'simple_tags': true,
            'tags': filters.frequencies,
            'placeholder': "Fréquence(s)"
        };
        var timer = false;
        $scope.$watch('text', function(a, b) {
            if (a === b) return;
            if (timer) {
                $timeout.cancel(timer)
            }
            timer = $timeout(function() {
                $scope.search();
            }, 500)
        });
        $scope.$watch('categories', searchIfModified, true);
        $scope.$watch('licenses', searchIfModified, true);
        $scope.$watch('frequencies', searchIfModified, true);
        $scope.$watch('place', searchIfModified, true);
        function searchIfModified(a, b) {
            if (a === b) return;
            $scope.search();
        }
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
                return res.data.results.map(function(item) {
                    return item.name;
                });
            });
        }
        var dirtytrickinordertonotcallsearchwiththeattributeonpagechange = false; //Because I can :)
        $scope.search = function(page) {
            if (!dirtytrickinordertonotcallsearchwiththeattributeonpagechange) {
                dirtytrickinordertonotcallsearchwiththeattributeonpagechange = true;
                return;
            }
            page = typeof page !== 'undefined' ? page : 1;
            DatasetFactory.searchDatasets({
                text: $scope.text,
                place: $scope.place,
                categories: $scope.categories,
                licenses: $scope.licenses,
                frequencies: $scope.frequencies,
                page: page
            }).then(function(data) {
                $scope.datasets = data;
            });
        }
    }
]).controller('datasetCtrl', ['$scope', '$state', 'dataset', '$http', 'apiUrl',
    function($scope, $state, dataset, $http, apiUrl) {
        $scope.dataset = dataset;
        $http.get(apiUrl + '/users/something/dataset/' + dataset.slug + '/download').then(function(res) {
            $scope.datasetData = res.data.data;
        });
        var pagingOptions = {
            pageSizes: [20, 50, 100],
            pageSize: 20,
            currentPage: 1
        };
        $scope.datasetData = [];
        $scope.gridOptions = {
            data: 'datasetData',
            i18n: 'fr',
            enableCellSelection: true,
            enableRowSelection: false,
            showFilter: true,
            enablePaging: true,
            jqueryUITheme: true,
            pagingOptions: pagingOptions,
            showColumnMenu: true,
            enableColumnResize: true,
            enableColumnReordering: true,
            showFooter: true
        };
    }
]);