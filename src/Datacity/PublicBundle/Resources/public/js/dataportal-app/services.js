(function() {
    angular
        .module('datacity.datasets')
        .factory('DatasetFactory', ['$http',
            function($http) {
                var parseDatasets = function(promise) {
                    return promise.then(function(res) {
                        var datasets = {totalCount: res.data.count, list: []};
                        angular.forEach(res.data.results, function(item) {
                            var locations = item.places.map(function(e) { return e.name });
                            var coverage_territory = null;
                            if (item.coverage_territory != undefined)
                                coverage_territory = item.coverage_territory.name;
                            datasets.list.push({
                                slug: item.slug,
                                name: item.title,
                                desc: item.description,
                                lastUpdate: item.last_modified_date,
                                user: item.creator.username,
                                locations: locations,
                                couverture: coverage_territory,
                                frequency: item.frequency,
                                categories: item.categories,
                                license: item.license.name
                            });
                        });
                        return datasets;
                    });
                };
                return {
                    getPopularDatasets: function(page) {
                        return parseDatasets($http.get(Routing.generate('datacity_public_api_search'), {
                            params: { page: page }
                        }));
                    },
                    searchDatasets: function(filters) {
                        filters.categories = filters.categories.length == 0 ? undefined : JSON.stringify(filters.categories);
                        filters.licenses = filters.licenses.length == 0 ? undefined : JSON.stringify(filters.licenses);
                        filters.frequencies = filters.frequencies.length == 0 ? undefined : JSON.stringify(filters.frequencies);
                        return parseDatasets($http.get(Routing.generate('datacity_public_api_search'), {
                            params: filters
                        }));
                    },
                    getDataset: function(slug) {
                        return $http.get(Routing.generate('datacity_public_api_dataset_show', { slug: slug })).then(function(res) {
                            var dataset;
                            var item = res.data.results;
                            var applications = [];
                            angular.forEach(item.applications, function(app) {
                                applications.push({
                                    url: Routing.generate('datacity_public_appDetail', {slug: app.slug}),
                                    name: app.name
                                });
                            });
                            dataset = {
                                slug: item.slug,
                                name: item.title,
                                desc: item.description,
                                sources: item.sources,
                                date: item.creation_date,
                                lastUpdate: item.last_modified_date,
                                user: item.creator,
                                locations: item.places,
                                frequency: item.frequency,
                                categories: item.categories,
                                license: item.license.name,
                                visited_nb: item.visited_nb,
                                undesirable_nb: item.undesirable_nb,
                                useful_nb: item.useful_nb,
                                applications: applications,
                                columns: item.columns
                            };
                            if (item.coverage_territory != undefined)
                                dataset.couverture = item.coverage_territory.name;
                            return dataset;
                        });
                    }
                }

            }
        ])

})();
