angular.module('datacity.datasets', ['ui.router', 'ui.bootstrap', 'ui.select2',
                                    'angular-loading-bar', 'ngGrid', 'angularUtils.directives.dirPagination'])
    .constant('apiUrl', datacityParams.apiUrl)
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
        $scope.search = function(page) {
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
        $scope.urlSocialNetwork = document.location.toString().toLowerCase();
        $scope.refine_array = [{'facet':'', 'value':''}];
        $scope.exclude_array = [{'facet':'', 'value':''}];
        $scope.facetsName = [];
        $scope.value_refine = '';
        $scope.facets = [];
        var facetsUrl = '';
        for (var i = 0; i < $scope.dataset.columns.length; i++) {
            $scope.facets.push($scope.dataset.columns[i].name);
            $scope.facetsName.splice(1, 0, {'name':$scope.dataset.columns[i].name});
            facetsUrl += "&facet=" + $scope.dataset.columns[i].name;
        }
        $scope.url = "/api/search?dataset=" + dataset.slug + "&" + 'rows=10' + facetsUrl;
        $scope.addRow = function() {
            $scope.facets.push($scope.new_facet);
            $scope.facetsName.splice($scope.facetsName.length, 0, {'name': $scope.new_facet });
            $scope.new_facet = '';
        };
        $scope.deleteRow = function(item) {
            var index = $scope.facets.indexOf(item);
            $scope.facets.splice(index, 1);
            $scope.facetsName.splice(index, 1);
        };
        $scope.addFilter = function(option_refine, value_refine, type) {
            if (option_refine.value != "facettes" && value_refine) {
                if (type == "refine")
                    $scope.refine_array.splice($scope.refine_array.length, 1, {'facet':option_refine.name, 'value':value_refine.title});
                else if (type == "exclude")
                    $scope.exclude_array.splice($scope.exclude_array.length, 1, {'facet':option_refine.name, 'value':value_refine.title});
            }
            this.facet = '';
            this.value_refine.title = '';
        };
        $scope.deleteRefine = function(index) {
            $scope.refine_array.splice(index, 1);

        }
        $scope.deleteExclude = function(index) {
            $scope.exclude_array.splice(index, 1);
        };
        $scope.updateUrl = function() {
            $scope.url = "/api/search?dataset=" + dataset.slug ;
            facetsUrl = "";
            refine = "";
            exclude = "";

            if ($scope.q)
                $scope.url += "&" + "q=" + $scope.q;
            if ($scope.col_nb)
                $scope.url = $scope.url + "&" + "rows=" + $scope.col_nb;
            else if (!($scope.col_nb))
                $scope.url = $scope.url + "&" + "rows=10";
            if ($scope.first_res)
                $scope.url = $scope.url + "&" +  "start=" + $scope.first_res;
            for (var i=0; i< $scope.facets.length && $scope.facets[i] != 'undefined';i++) {
                facetsUrl += "&facet=" + $scope.facets[i];
            }
            for (var j=1;j<$scope.refine_array.length;j++) {
                refine += "&refine." + $scope.refine_array[j].facet + "=" + $scope.refine_array[j].value;
            }
            for (var k=1;k<$scope.exclude_array.length;k++) {
                exclude += "&exclude." + $scope.exclude_array[k].facet + "=" + $scope.exclude_array[k].value;
            }
            $scope.url += facetsUrl;
            $scope.url += refine;
            $scope.url += exclude;
        }
    }
]);
