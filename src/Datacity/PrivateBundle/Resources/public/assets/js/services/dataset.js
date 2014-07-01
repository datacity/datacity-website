(function() {
	angular
		.module('app')
		.factory('DatasetFactory', ['$http', function($http) {
			return {
				get: function(id) {
					return $http
						.get('/app_dev.php/private/dataset/get/' + id).then(function(response) {
							return response.data;
						});
				},
				post: function(dataset) {
					return $http
						.post('/app_dev.php/private/dataset/save/', dataset).then(function(response) {
							return response.data;
						});
						
				},
				delete: function(id) {
					return $http
						.delete('/app_dev.php/private/dataset/delete/' + id).then(function(response) {
							return response.data;
						});
				},
				/**
				 * [populateSourcesTmp Cette fonction est temporaire. Elle sert simplement a associer dans le controlleur du dataset 
				 * det sources à celui-ci. Dans la prochaine étape, a partir de l'id on ira choper les sources associé au dataset récupéré.
				 * @return {Array} Tableau d'objets contenant des sources
				 */
				populateSourcesTmp: function() {
					return [
						{
							id: '45616cfkjh54',
							picture : 'http://www.consoglobe.com/wp-content/uploads/2011/02/electroculture1-300x225.jpg',
							size : 4 ,
							title : 'Test1',
							description : 'Mon premier test de sources',
							downloadNb: 20,
							usefullNb: 40
						},
						{
							id: 'ff654ddds',
							picture : 'http://www.regioncentre.fr/files/live/sites/regioncentre/files/contributed/images/artisanat-industries/main-euros-440x250.jpg',
							size :  3,
							title : 'Test2',
							description : 'Mon deuxième test de sources',
							downloadNb: 8,
							usefullNb: 10
						},
						{
							id: '15698ddd',
							picture : 'http://www.keenthemes.com/preview/metronic/assets/admin/pages/media/profile/logo_conquer.jpg',
							size : 8 ,
							title : 'Test3',
							description : 'Mon troisième test de sources',
							downloadNb: 15,
							usefullNb: 70
						}
					];
				}
			}

		}])

})();