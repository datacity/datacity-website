/**
 * Require :
 * 	- utils.js (fichier présent dans privateBundle/js/utils.js)
 */
(function() {
	angular
		.module('app')
		.controller('sourceController', ['$scope', '$state', '$stateParams', '$modal', '$log', 'SourceFactory', 'sourceOperation', 'datasetSlug',
			function($scope, $state, $stateParams, $modal, $log, SourceFactory, sourceOperation, datasetSlug) {

				// VARIABLES COMMUNES A TOUTES LES OPERATIONS (edit, create, delete)
				// ----------------------------------------
				$scope.databinding = [];
				$scope.metaSelected = {};
				$scope.slugDataset = datasetSlug;
				$scope.dataModel = [];
				//$scope.template = {};
				//$scope.template.sourceManager = Routing.generate('datacity_private_partials', {pageName: 'sourceManager'});
				//$scope.template.sourceMeta = Routing.generate('datacity_private_partials', {pageName: 'sourceMeta'});

				var globalData;
			    $scope.filterOptions = {
			        filterText: '',
			        useExternalFilter: true
			    };
		   	    $scope.totalServerItems = 0;
			    $scope.pagingOptions = {
			        pageSizes: [20, 50, 100],
			        pageSize: 20,
			        currentPage: 1
			    };
			    $scope.columnsSelected = [];
 				$scope.myData = [];
 				$scope.gridOptions = {
			        data: 'myData',
			  	    columnDefs: 'columnSelected',
			   		filterOptions: $scope.filterOptions,
			   		i18n: 'fr',
			   		enableCellSelection: true,
        			enableRowSelection: false,
        			//TODO: CORRIGER LE BUG SUR L'EDITION
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
				$scope.source = {};
				//-----------------------------------------


				//Template HEADER

				var myHeaderCellTemplate =
				"<div class=\"ngHeaderSortColumn {{col.headerClass}}\" ng-style=\"{'cursor': col.cursor, 'background-color': col.backgroundColor, 'color': col.color}\" ng-class=\"{ 'ngSorted': !col.noSortVisible() }\">\r" +
		    "\n" +
		    "    <div ng-click=\"col.sort($event); bindModelToCol(col)\" ng-class=\"'colt' + col.index\" class=\"ngHeaderText\">{{col.displayName}}</div>\r" +
		    "\n" +
		    "    <div class=\"ngSortButtonDown\" ng-click=\"col.sort($event)\" ng-show=\"col.showSortButtonDown()\"></div>\r" +
		    "\n" +
		    "    <div class=\"ngSortButtonUp\" ng-click=\"col.sort($event)\" ng-show=\"col.showSortButtonUp()\"></div>\r" +
		    "\n" +
		    "    <div class=\"ngSortPriority\">{{col.sortPriority}}</div>\r" +
		    "\n" +
		    "    <div ng-class=\"{ ngPinnedIcon: col.pinned, ngUnPinnedIcon: !col.pinned }\" ng-click=\"togglePin(col)\" ng-show=\"col.pinnable\"></div>\r" +
		    "\n" +
		    	"</div>\r" +
		    "\n" +
		    	"<div ng-show=\"col.resizable\" class=\"ngHeaderGrip\" ng-click=\"col.gripClick($event)\" ng-mousedown=\"col.gripOnMouseDown($event)\"></div>\r" +
		    "\n"

		    	// Fonction appelée à chaques fois que lon clique sur une colone de la datatable
		    	$scope.bindModelToCol = function(col) {
		    		if (col.backgroundColor === $scope.selectedColor) {
		    			col.backgroundColor = "#DDDDDD";
		    			col.color = "#444444";
		    			$scope.databinding.remove(col.field);
		    		}
		    		else {
		    			col.backgroundColor = $scope.selectedColor;
		    			col.color = 'white';
		    			$scope.databinding.push({
		    				from: col.field,
		    				to: $scope.selectedName
		    			});
		    		}
	    		}
				$scope.databinding.remove = function(column) {
					angular.forEach($scope.databinding, function(data, index) {
						if (data.from === column) {
							$scope.databinding.splice(index, 1);
						}
					});
				}

				//GESTION DE LA PAGINATION
				//-----------------------------------------------------
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
			        		$scope.setPagingData(data, page, pageSize);
			            } else {
			        		data = globalData;
			        		$scope.setPagingData(data, page, pageSize);
			            }
			        }, 100);
			    };

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
			    //---------------------------------------------------------


			    $scope.update_columns = function($event) {
			    	//TODO: Ajouter l'implémentation du rajout de colone de façon dynamique
			    }


			    //  Le serveur renvoi le fichier parsé à partir de path ($scope.path) que l'on a conservé. A partir de cela on extrait la première ligne du tableau
			    // afin de définir nos colones dans la ng-table. Pour être sur que nos colones sont bien formatées on remplace
			    // les caractères non lettre (_ exclu) par un _ pour plus de lisibilité et une compatibilité du module ng-grid
      			$scope.getJSON = function() {
      				SourceFactory.getParsedFile($scope.path).then(function(result) {
	      				$scope.columnSelected = [];

	      				var keys = Object.keys(result.data.data[0]);
	      				var column = [];
	      				angular.forEach(keys, function(item, index) {
	      					column.push(
	      						{
	      							field: item,
	      							displayName: item.replace('/\W/g', '_'),
	      							width: 120,
	      							headerCellTemplate: myHeaderCellTemplate
	      							/*enableCellEdit: true*/
	      						});
	      				});
	      				$scope.columnSelected = column;
	      				$scope.myData = result.data.data;
	      				$scope.displayTable = true;
	      				globalData = result.data.data;
	      				$scope.getPagedDataAsync($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage, $scope.filterOptions.filterText);
	      			});
      			}

      			// On enregistre ici le path renvoyé pour l'api afin de conserver la trace du fichier
      			// côté serveur
      			var fileUploaded = function(response) {
      				var data = response.data.data;
      				if (data.files && data.files[0].path) {
      					$scope.path = data.files[0].path;
      				}
      			};

      			//Gestionnaire d'upload. On appelle ensuite le callback pour récupérer le retour de l'api
				$scope.onFileSelect = function($files) {
      					var file = $files[0];
      					$scope.upload = SourceFactory.postFile(file).then(fileUploaded);
			    };

			    //Appellé pour remplir le carré de couleur avec la couleur sélectionnée
			    $scope.categorySelected = function(column) {
			    	if ($scope.selectedColor === column.color) {
			    		$scope.selectedColor = "white";
			    		$scope.selectedName = column.name;
			    	}
			    	else {
			    		$scope.selectedColor = column.color;
			    		$scope.selectedName = column.name;
			    	}
			    }

			    var removeIt = function(array, from, to) {
  					var rest = array.slice((to || from) + 1 || array.length);
  					array.length = from < 0 ? array.length + from : from;
  					return array.push.apply(array, rest);
			    }

				//Supression d'une colone sur la partie databinding
			    $scope.deleteColumn = function(column) {
			    	angular.forEach($scope.dataModel, function(item, index) {
			    		if (item.name === column.name) {
			    			removeIt($scope.dataModel, index);
			    		}
			    	});
			    }

			    $scope.getLocation = function(val) {
			    	if (!val)
			    		return null;
			    	var res = SourceFactory.getExistingLocations(val).then(function(results) {
			    		return results;
			    	});
			    	return res;
			    }
				SourceFactory.getProducers().then(function(results) {
			    		$scope.producers = results.producers;
			    	});
			    /*$scope.getProducers = function() {
			    	var res = SourceFactory.getProducers().then(function(results) {
			    		$scope.producers = results;
			    		console.log(results);
			    		//return results;
			    	});
			    		console.log(res);

			    	//return res;
			    }*/

				// Appellé a chaque fois que l'on veut rajouter une catégorie dans le modèle.
				// inputModel je pense que je n'ai pas besoin d'expliquer ^^
			    $scope.addCategoryModel = function(inputModel) {
			    	$scope.dataModel.push(
			    		{
			    			name: inputModel,
			    			type: 'Texte',
			    			color: getRandomColor()
			    		}
			    	);
			    }

				if (sourceOperation === 'create') {
					//TODO:
					//---------------------------------------------------------------------------------------------------------
					// On a ici un formulaire multi upload qui permettra de rajouter plusieurs fichiers dans une source.
					// Cette fonctionalité aura comme prérequis que les fichiers aient éxactement la même structure d'origine que les autres fichiers

					// On va récupérer le formulaire de la version précédente et adapter le script pour angular.
					// Le formulaire d'upload aura un controlleur qui lui est propre.
					// L'api doit nous renvoyer un message d'erreur si ce n'est pas le cas et envoyé un rapport à l'utilisateur lui indiquant les fichiers défaillants.
					// Dans le cas où tout se passe bien, on récupère le contenu du fichier parsé directement que l'on met dans $scope.dataTableContent

					// Dans le cas où on implémente la fonctionalité de multi upload, il faudra que l'on puisse selectionner un fichier en particulier pour pouvoir travailler essentiellement sur celui-ci
					// Parmis les fonctionalités de la datatable, il faudra permettre de rajouter un texte pour tous les champs d'un fichier exemple:
					// Ville : Montpellier pour fichier1 et Ville : Paris pour fichier 2 qui sera une nouvelle catégorie.

					// On fait déjà cette opération à partir des métadatas (couverture géographique, date etc...) mais c'est dans le cas où ce sont deux sources différentes
					// -----------------------------------------------------------------------------------------------------------


					//------------------------------------------------------------------------------------------------------
					// Ici on check s'il existe déjà une source liée à ce dataset. Si c'est le cas, on charge les métadatas liés à ce dataset.
					// Pas l'id par contre étant donné qu'un nouvel id sera créé par la suite
					// On charge également le databinding de cette source ou du dataset (dans le cas où on a fait la transposition du databing dans le dataset)
					// On met ce databinding dans $scope.databinding et on attribue une couleur random dans le html

					SourceFactory.getExistingMetaData().then(function(results) {
						if (results)
							$scope.meta = results;
					});

					SourceFactory.getExistingDatasetModel(datasetSlug).then(function(results) {
						if (!results || results.length === 0) {
							$scope.noDataModel = true;
							return false;
						}
						$scope.noDataModel = false;
						$scope.dataModel = results;
						angular.forEach($scope.dataModel, function(item, index) {
							$scope.dataModel[index].color = getRandomColor();
						})
					});
					//--------------------------------------------------------------------------------------------------------------

				}
				else if (sourceOperation === 'edit') {
					// On va charger a partir de l'id de la source les métadonnées mais également la datatable
					// Appel à doctrine donc et a partir de cela on va rechercher le slug
					// et faire un appel un api a partir de la route qui va choper le contenu d'une source
					// A partir du retour de l'api, on affiche le contenu dans notre table dans $scope.dataTableContent
					// Pour ce qui est du modèle, il n'est pour l'instant pas remodifiable dans cette étape donc pas d'affichage de bloc avec le modèle
					// Le formulaire d'upload du fichier ne s'affiche pas dans cette partie
				}
				else if (sourceOperation === 'delete') {

				}
				$scope.submitSource = function() {

					/* 	Lors de la validation, pour cette version on envoi l'ensemble du json à l'api avec le databinding comme dans la version master
						Avec en + quelques méta qui nous permettront de rajouter des données dans la source. + slug source
						ON envoi les reste des metas à symfony pour la BDD
						Pendant l'envoi à l'api, celle-ci renvoi la route pour accéder aux données.
						Cette route est rajoutée aux métadonnées pendant l'envoi à doctrine
					 	Une fois que la source a été envoyée à l'api et a doctrine, on switch sur le visualiseur de donnée côté client.*/
					var resultMeta = {};
					resultMeta.metadata = $scope.metaSelected;
					if ($scope.noDataModel) {
						resultMeta.dataModel = $scope.dataModel;
					}
					var resultApi = {
						databinding: $scope.databinding,
						jsonData: globalData
					}

					SourceFactory.post(datasetSlug, resultMeta, resultApi).then(function(response) {
							$state.go('editDS', {slug: datasetSlug}, {reload: true});
					});
				}
			}]);
})();
