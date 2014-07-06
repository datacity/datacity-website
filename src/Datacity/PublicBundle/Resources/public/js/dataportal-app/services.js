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
                var keepSelectedFilter = function(data) {
                    var array = [];
                    angular.forEach(data, function(item) {
                        if (item.selected)
                            array.push(item.name);
                    });
                    if (array.length === data.length)
                        return undefined;
                    return JSON.stringify(array);
                };
                return {
                    getPopularDatasets: function() {
                        return parseDatasets($http.get(Routing.generate('datacity_public_api_search')));
                    },
                    searchDatasets: function(filters) {
                        filters.categories = keepSelectedFilter(filters.categories);
                        filters.licenses = keepSelectedFilter(filters.licenses);
                        filters.frequencies = keepSelectedFilter(filters.frequencies);
                        return parseDatasets($http.get(Routing.generate('datacity_public_api_search'), {
                            params: filters
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
