(function() {
    angular
        .module('datacity.datasets')
        .factory('DatasetFactory', ['$http',
            function($http) {
                var parseDatasets = function(promise) {
                    return promise.then(function(res) {
                        var datasets = [];
                        angular.forEach(res.data.results, function(item) {
                            var locations = [];
                            angular.forEach(item.places, function(place) {
                                locations.push(place.name);
                            });
                            datasets.push({
                                slug: item.slug,
                                name: item.title,
                                desc: item.description,
                                lastUpdate: item.last_modified_date,
                                user: item.creator.username,
                                locations: locations,
                                couverture: item.coverage_territory.name,
                                frequency: item.frequency,
                                category: item.category.name,
                                license: item.license.name
                            });
                        });
                        return datasets;
                    });
                };
                return {
                    getPopularDatasets: function() {
                        return parseDatasets($http.get(Routing.generate('datacity_public_api_search_popular')));
                    },
                    searchDatasets: function(searchText, searchPlace) {
                        return parseDatasets($http.get(Routing.generate('datacity_public_api_search'), {
                            params: {
                                text: searchText,
                                place: searchPlace
                            }
                        }));
                    }
                }

            }
        ])

})();
