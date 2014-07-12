(function() {
	angular
		.module('app')
		.factory('SourceFactory', ['$http', '$upload', function($http, $upload) {
			return {

				
				get: function(id) {
					return $http
						.get('/app_dev.php/private/source/get/' + id).then(function(response) {
							return response.data;
						});
				},
				post: function(slugDataset, source) {
					console.log("Source En cours de post!");
					console.log(source);
					return $http
						.post(Routing.generate('datacity_private_api_source_save'), source).then(function(response) {
							return response.data;
						});
						
				},
				delete: function(id) {
					return $http
						.delete('/app_dev.php/private/source/delete/' + id).then(function(response) {
							return response.data;
						});
				},
				getParsedFile: function(path) {										
					return $http(
						{
							method: 'GET',
							url: 'http://localhost:4567/users/delkje555/files/' + path + '/parse',
							header: {'Content-Type': 'application/x-www-form-urlencoded;', 'Accept': 'text/html,application/json ,*/*;'}
						}).success(function(response) {
							console.log(response);
							return response.data;
							//return response.data;
						}).error(function(message) {
							console.log(message);
						});
				},
				postFile: function(file) {
					return $upload.upload(
						{
						   	url: 'http://localhost:4567/users/delkje555/files/add',
						    method: 'POST', 
							file: file,
						})
					.success(function(response) {
						return response.data;
					});
				},
				/**
				 * [getExistingData renvoi les métadonnées et le databinding lié à une source déjà existante. S'il y a plus d'une source, on prend compte de la dernière source créée en date
				 * Si on ne trouve aucune source, on renvoi 
				 * @param  {string} idDataset [récuperer les sources qui sont contenues dans le dataset : idDataset]
				 * @return {Object}           [Object.dataModel => le shéma de structure, Object.metadata => Les meta liées à la source]
				 */
				getExistingMetaData: function() {
					return $http
						.get(Routing.generate('datacity_public_api_filter_list')).then(function(response) {
							return response.data.results;
						});
				},
				getExistingLocations: function(val) {
					 return $http.get(Routing.generate('datacity_public_api_place'), {
                		ignoreLoadingBar: true,
                		params: {
                    		q: val
                		}}).then(function(res) {
                			return res.data.results.map(function(item) { return item.name });
                		});
				},
				getExistingDatasetModel: function(slugDataset) {
					return $http
						.get(Routing.generate('datacity_public_api_dataset_model', {slug: slugDataset})).then(function(response) {
							return response.data.results;
						});

				},
				getExistingDataPopulateExemple: function(idDataset, empty) {
					if (empty)
						return null;
					else
					return {
						dataModel: [{
							name: "nom",
							type: "text"
						}, {
							name: "téléphone",
							type: "text"
						}, {
							name: "age",
							type: "number"
						}],
						metadata: {
							title: 'Ma source de test',
							link: 'http://datacity.fr/fileTest.csv',
							//On charge toutes les instances de la table place mais on charge juste le champ name
							place: [{id: '1', name: 'Montpellier'},{id: '2', name: 'Lunel'}, {id: '3', name: 'Paris'}],
							//selectedPlace: {}
							dateBegin: new Date('2012'),
							dateEnd: new Date('2014'),
							// On charge toutes les instances de la table frequency mais on charge juste le champ name et id
							frequency: [{id: '1', name: 'Mensuelle'}, {id: '2', name: 'Semestrielle'}, {id: '3', name: 'Temps réel'}],
							// On charge toutes les instances de la table coverage territory mais on charge juste le champ name
							coverageTerritory: [{id: '1', name: 'Canton'}, {id: '2', name: 'Commune'}, {id: '3', name: 'Département'}],
							// On charge la couverture territoriale associée à la source
							//selectedCoverageTerritory: {id: '4', name: 'Canton'},
							// On charge toutes les instances de la table licence mais on charge juste le champ name
							licence: [{id: '1', name: 'Open Data Commons Attribution Licence'}, {id: '2', name: 'Licence Ouverte'}, {id: '3', name: 'Creative Commons Attribution'}],
							//selectedLicence: {id: '8', name: 'OpenSource'},
							// On charge toutes les instances de la table category mais on charge juste le champ name
							categories: [{id: '1', name: 'Culture'}, {id: '2', name: 'Société'}, {id: '3', name: 'Santé et Social'}]
							//selectedCategories: [{}]
						}
					};
				}
			}
		}]);
})();