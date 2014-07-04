(function() {
	angular
		.module('app')
		.controller('sourceController', ['$scope', '$stateParams', '$modal', '$log', 'SourceFactory', 'operation',
			function($scope, $stateParams, $modal, $log, SourceFactory, operation) {
				
				var globalData;
			    $scope.filterOptions = {
			        filterText: '',
			
			    };

		   	    $scope.totalServerItems = 0;
			    $scope.pagingOptions = {
			        pageSizes: [20, 50, 100],
			        pageSize: 20,
			        currentPage: 1
			    };  
			    $scope.setPagingData = function(data, page, pageSize){	
			        var pagedData = data.slice((page - 1) * pageSize, page * pageSize);
			        $scope.myData = pagedData;
			        $scope.totalServerItems = data.length;
			        if (!$scope.$$phase) {
			            $scope.$apply();
			        }
			    };
			    $scope.getPagedDataAsync = function (pageSize, page, searchText) {
			    	if (!globalData)
			    		return;
			        setTimeout(function () {
			            var data;
			            if (searchText) {
			                var ft = searchText.toLowerCase();
			               	data = globalData.filter(function(item) {
			                	return JSON.stringify(item).toLowerCase().indexOf(ft) != -1;
			                });		               
			            } else {
			        		data = globalData;
			        		$scope.setPagingData(data, page, pageSize);
			            }
			        }, 100);
			    };
				
			    $scope.getPagedDataAsync($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage);
				
			    $scope.$watch('pagingOptions', function (newVal, oldVal) {
			        if (newVal !== oldVal && newVal.currentPage !== oldVal.currentPage) {
			          $scope.getPagedDataAsync($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage, $scope.filterOptions.filterText);
			        }
			    }, true);
			    $scope.$watch('filterOptions', function (newVal, oldVal) {
			        if (newVal !== oldVal) {
			          $scope.getPagedDataAsync($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage, $scope.filterOptions.filterText);
			        }
			    }, true);


			    $scope.columnsSelected = [];


			    // On charge les données depuis le serveur. Ce chargement se fait au moment où on upload 
			    // un fichier. Le serveur renvoi donc le fichier parsé. A partir de cela on extrait la première ligne du tableau 
			    // afin de définir nos colones 
			     $scope.myData = [];

                //$scope.columns1 = [{field: 'name', displayName: 'Name'}, {field:'age', displayName:'Age'}];
			    //$scope.columns2 = [{field: 'name', displayName: 'New Name'}, {field:'age', displayName:'New Age'},{field:'pin', displayName:'Pin'}];
			    //$scope.columnSelected = $scope.columns1;

			    $scope.gridOptions = { 
			        data: 'myData',
			  	    columnDefs: 'columnSelected',      
			   		filterOptions: $scope.filterOptions,
			   		i18n: 'fr',
			   		enableCellSelection: true,
        			enableRowSelection: false,
        			/*enableCellEditOnFocus: true,*/
			   		showFilter: true,
			      	enablePaging: true,
			      	jqueryUITheme: true,
			        totalServerItems:'totalServerItems',
        			pagingOptions: $scope.pagingOptions,
			        showColumnMenu: true,
			        enableColumnResize: true,
			        enableColumnReordering: true,
			        showFooter: true
			    };
			    
			    $scope.update_columns = function($event) {
			      $scope.columnsSelected = $scope.columns2;
			    }

				$scope.source = {};

      			var fileUploaded = function(response) {
      				var data = response.data.data;
      				if (data.files && data.files[0].path) {
      					$scope.path = data.files[0].path;
      				}
      			}
      			$scope.getJSON = function() {
      				SourceFactory.getParsedFile($scope.path).then(function(result) {
	      				//$scope.myData = result.data.data;
	      				
	      				//console.log(Object.key());
	      				$scope.columnSelected = [];
	      				//console.log(Object.keys(result.data.data[0]));

	      				var keys = Object.keys(result.data.data[0]);
	      				var column = [];
	      				angular.forEach(keys, function(item, index) {
	      					column.push(
	      						{
	      							field: item,
	      							displayName: item.replace('/\W/g', '_'),
	      							minWidth: 150,
	      							width: '20%',
	      							maxWidth: 350,
	      							/*enableCellEdit: true*/
	      						});
	      				});
	      				$scope.columnSelected = column;
	      				$scope.myData = result.data.data;
	      				$scope.displayTable = true;
	      				globalData = result.data.data;
	      				console.log(result.data.data.length);
	      				$scope.getPagedDataAsync($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage, $scope.filterOptions.filterText);
	      			});
      			}

				$scope.onFileSelect = function($files) {
      					var file = $files[0];
      					$scope.upload = SourceFactory.postFile(file, fileUploaded).then(fileUploaded);
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
