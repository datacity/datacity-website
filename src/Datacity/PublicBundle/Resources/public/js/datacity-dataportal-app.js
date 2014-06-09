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
                    templateUrl: 'TODO',
                    controller: 'default'
                })
        }
    ])
    .controller('default', ['$scope', '$http',
        function($scope, $http) {
        }
    ])
