(function() {
	angular
		.module('app')
		.controller('applicationController', ['$scope', '$state', 'operation', 'ticket', 'AppFactory', 'cities', 'categories', 'platforms', 'datasets',
			function($scope, $state, operation, application, AppFactory, cities, categories, platforms, datasets) {
	        	$scope.app = application;
	        	$scope.cities = cities;
	        	$scope.datasets = datasets;
	        	$scope.categories = categories;
	        	$scope.selectedCity = '';
	        	$scope.platforms=[];
	        	$scope.categories=[];
	        	$scope.platformsSelected=[];
	        	for (var i=0;i<platforms.length;i++)
	        		$scope.platforms.push(platforms[i].name);
	        	for (var i=0;i<categories.length;i++)
	        		$scope.categories.push(categories[i].name);
	        	$scope.selectPlatforms = {
            		'multiple': true,
            		'simple_tags': true,
            		'tokenSeparators': [",", " "],
            		'tags': $scope.platforms,
            		'placeholder': "Plates-forme(s)"
        		};
        		$scope.selectCategories = {
            		'multiple': true,
            		'simple_tags': true,
            		'tokenSeparators': [",", " "],
            		'tags': $scope.categories,
            		'placeholder': "Catégorie(s)"
        		};

        		$scope.submit = function() {
        			if (!($scope.app.downloaded))
        				$scope.app.downloaded=0;
        			/*if (operation === 'add')
        				$scope.operation = 'add';
        			else if (operation === 'edit')
        				$scope.operation = 'edit';*/
					var result = {
						app:$scope.app,
						operation:operation,
						slug:$scope.app.slug,
						name: $scope.app.name,
						description: $scope.app.description,
						downloaded: $scope.app.downloaded,
						categories: $scope.categoriesSelected,
						platforms: $scope.platformsSelected,
						city: $scope.city.name,
						dataset: $scope.dataset.title
					}
						AppFactory.post(result).then(function(response) {
							$state.go('userApplications');
						});

				}
				$scope.delete = function() {
					var result = {
						name: $scope.app.name,
						slug: $scope.app.slug
					}
						AppFactory.deleteApp(result).then(function(response) {
							$state.go('userApplications');
						});
				}
	    }])
		.controller('userApplicationsController', ['$scope', 'applications', 'AppFactory',
			function($scope, applications, AppFactory) {
	        	$scope.applications = applications;
	    }]);
})();