(function() {
	angular
		.module('app')
		.controller('sourceController', ['$scope', '$stateParams', '$modal', '$log', 'SourceFactory', 'operation',
			function($scope, $stateParams, $modal, $log, SourceFactory, operation) {
				$scope.source = {};
				
				   $scope.columns1 = [{field: 'name', displayName: 'Name'}, {field:'age', displayName:'Age'}];
    				$scope.columns2 = [{field: 'name', displayName: 'New Name'}, {field:'age', displayName:'New Age'},{field:'pin', displayName:'Pin'}];
  
    $scope.pagingOptions = {
        pageSizes: [3, 10, 20],
        pageSize: 3,
        totalServerItems: 0,
        currentPage: 1
    };
    
    $scope.activateFilter = function() {
    var name = $scope.filterName || null;
    var age = ($scope.filterAge) ? $scope.filterAge.toString() : null;
    if (!name && !age) name='';
    
    $scope.myData = angular.copy($scope.originalDataSet, []);
    $scope.myData = $scope.myData.filter( function(item) {
      return (item.name.indexOf(name)>-1 || item.age.toString().indexOf(age) > -1);
    });
  };


    $scope.columnsSelected = $scope.columns1;
    $scope.myData = [{name: "Moroni", age: 50},
                     {name: "Tiancum", age: 43},
                     {name: "Jacob", age: 27},
                     {name: "Nephi", age: 29},
                     {name: "Enos", age: 34}];  
    $scope.gridOptions = { 
        data: 'myData',
  	    columnDefs: 'columnsSelected',
  	    enableCellSelection: true,
        enableRowSelection: false,
        enableCellEditOnFocus: true,
        filterOptions: {filterText: '', useExternalFilter: true},
        showFilter: true,
        enablePaging: true,
        pagingOptions: $scope.pagingOptions,
        showColumnMenu: true,
        showFooter: true
      
    };
    
    $scope.update_columns = function($event) { 
      
      $scope.columnsSelected = $scope.columns2;
    }

				if (operation === 'create') {
					// Ici on check s'il existe déjà une source liée à ce dataset. Si c'est le cas, on charge les métadatas liés à ce dataset. 
					// Pas l'id par contre étant donné qu'un nouvel id sera créé par la suite 
					// On charge également le databinding de cette source ou du dataset (dans le cas où on a fait la transposition du databing dans le dataset)
					// On met ce databinding dans $scope.databinding et on attribue une couleur random dans le html

					SourceFactory.getExistingData($stateParams.datasetId).then(function(result) {
						$scope.databinding = result.databinding;
						$scope.meta = result.metadata;
					});
					
					// On a ici un formulaire multi upload qui permettra de rajouter plusieurs fichiers dans une source.
					// Cette fonctionalité aura comme prérequis que les fichiers aient éxactement la même structure d'origine que les autres fichiers
					
					// On va récupérer le formulaire de la version précédente et adapter le script pour angular. 
					// Le formulaire d'upload aura un controlleur qui lui est propre et aura  
					
					
					// L'api doit nous renvoyer un message d'erreur si ce n'est pas le cas et envoyé un rapport à l'utilisateur lui indiquant les fichiers défaillants.
					// Dans le cas où tout se passe bien, on récupère le contenu du fichier parsé directement que l'on met dans $scope.dataTableContent
					
					// Dans le cas où on implémente la fonctionalité de multi upload, il faudra que l'on puisse selectionner un fichier en particulier pour pouvoir travailler essentiellement sur celui-ci
					// Parmis les fonctionalités de la datatable, il faudra permettre de rajouter un texte pour tous les champs d'un fichier exemple:
					// Ville : Montpellier pour fichier1 et Ville : Paris pour fichier 2 qui sera une nouvelle catégorie.
					
					// On fait déjà cette opération à partir des métadatas (couverture géographique, date etc...) mais c'est dans le cas où ce sont deux sources différentes
					
				}
				else if (operation === 'edit') {
					// On va charger a partir de l'id de la source les métadonnées mais également la datatable
					// Appel à doctrine donc et a partir de cela on va rechercher le slug 
					// et faire un appel un api a partir de la route qui va choper le contenu d'une source
					// A partir du retour de l'api, on affiche le contenu dans notre table dans $scope.dataTableContent
					// Pour ce qui est du modèle, il n'est pour l'instant pas remodifiable dans cette étape donc pas d'affichage de bloc avec le modèle
					// Le formulaire d'upload du fichier ne s'affiche pas dans cette partie
				}
				else if (operation === 'delete') {

				}

				$scope.addCategory = function() {
					// Disponible dans le cas où on est sur opération create et qu'il n'y a pas de source précédemment uploadés
					
				}
				$scope.submit = function() {
					// Ajout des métadatas liés à la source
					// Lors de la validation, pour cette version on envoi l'ensemble du json à l'api avec le databinding comme dans la version master
					// Avec en + quelques méta qui nous permettront de rajouter des données dans la source. + slug source

					// Pendant l'envoi à l'api, celle-ci renvoi la route pour accéder aux données. 
					// Cette route est rajoutée aux métadonnées pendant l'envoi à doctrine
					// Une fois que la source a été envoyée à l'api et a doctrine, on switch sur le visualiseur de donnée côté client.
					SourceFactory.post($stateParams.datasetId, $scope.source).then(function(response) {
							console.log(response);
					});
				}
			}]);
})();
