(function() {
	angular
		.module('app')
		.factory('UserFactory', ['$http', function($http) {
			return {
				getUserFromSession: function() {
					return $http
						.get('/app_dev.php/private/user/get').then(function(response) {
							return response.data;
						});
				},

				/**
				 * [addDataset en cours de construction]
				 * @param {Object} dataset
				 */
				addDataset: function(dataset) {
					return $http
						.post('/app_dev.php/private/user/save/', dataset).then(function(response) {
							return response.data;
						});
						
				},
				delete: function(id) {
					return $http
						.delete('/app_dev.php/private/user/delete/' + id).then(function(response) {
							return response.data;
						});
				},
				populate: function() {
				 	return $http
				 		.get('/ajax/popular-datasets').then(function(response) {
                            return response.data;
                        });

				},
				/**
				 * [populateDatasetTmp Cette fonction est temporaire. Elle sert simplement a associer dans l'utilisateur avec des datasets mochés
				 * Dans la prochaine étape, a partir de l'id on ira choper les dataset associés à l'utilisateur
				 * @return {Array} Tableau d'objets contenant des datasets
				 */
				populateDatasetTmp: function() {
					return [
						{
							picture : 'http://www.keenthemes.com/preview/metronic/assets/admin/pages/media/profile/logo_metronic.jpg',
							size : 4 ,
							title : 'Test1',
							description : 'Mon premier test de service publics',
							visitedNb: 35,
							usefullNb: 40
						},
						{
							picture : 'http://www.keenthemes.com/preview/metronic/assets/admin/pages/media/profile/logo_azteca.jpg',
							size :  1,
							title : 'Test2',
							description : 'Mon deuxième test de service publics',
							visitedNb: 20,
							usefullNb: 17
						},
						{
							picture : 'http://www.keenthemes.com/preview/metronic/assets/admin/pages/media/profile/logo_conquer.jpg',
							size : 8 ,
							title : 'Test3',
							description : 'Mon troisième test de service publics',
							visitedNb: 200,
							usefullNb: 20
						}
					];
				}
			}
		}]);

})();