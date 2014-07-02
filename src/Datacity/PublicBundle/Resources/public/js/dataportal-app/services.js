(function() {
    angular
        .module('datacity.datasets')
        .factory('DatasetFactory', ['$http',
            function($http) {
                var parseDatasets = function(promise) {
                    return promise.then(function(res) {
                        var datasets = [];
                        angular.forEach(res.data.results, function(item) {
                            var locations = toSimpleArray('name', item.places);
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
                var toSimpleArray = function(attr, data) {
                    var array = [];
                    angular.forEach(data, function(item) {
                        array.push(item[attr]);
                    });
                    return array;
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
                    },
                    getDataset: function(slug) {
                        return $http.get(Routing.generate('datacity_public_api_dataset_show', { slug: slug })).then(function(res) {
                            var dataset;
                            var item = res.data.results;
                            var locations = toSimpleArray('name', item.places);
                            dataset = {
                                name: item.title,
                                desc: item.description,
                                did: item.did,
                                sources: item.sources,
                                date: item.creation_date,
                                lastUpdate: item.last_modified_date,
                                user: item.creator,
                                locations: locations,
                                couverture: item.coverage_territory.name,
                                frequency: item.frequency,
                                category: item.category.name,
                                license: item.license.name
                            };
                            return dataset;
                        });
                    }
                }

            }
        ])

})();
