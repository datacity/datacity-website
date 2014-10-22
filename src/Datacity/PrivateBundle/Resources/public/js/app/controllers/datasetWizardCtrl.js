(function() {
	angular
		.module('app')
		.controller('datasetWizardController' , ['$scope',
			function($scope) {
				$scope.continueButton = null;
				$scope.backButton = null;
				$scope.endButton = null;
				$scope.canContinue = function(){return false};
				$scope.sourceData = null;
			}])
		.controller('datasetWizardStep1Controller', ['$scope', '$upload', '$http', '$timeout', '$q', '$state', '$modal', '$filter', 'ngTableParams',
			function($scope, $upload, $http, $timeout, $q, $state, $modal, $filter, ngTableParams) {
				$scope.fileUp = [];
				$scope.filesData = [];
				$scope.combinedColumns = [];
				$scope.$parent.wizardProgress = 15;
				$scope.$parent.step = '1';
				$scope.$parent.backButton = null;

				$scope.bytesToSize = function(bytes) {
				   if (bytes == 0) return '0 Octet';
				   var k = 1000;
				   var sizes = ['Octets', 'Kio', 'Mio', 'Gio'];
				   var i = Math.floor(Math.log(bytes) / Math.log(k));
				   return { value:(bytes / Math.pow(k, i)).toPrecision(3), m:sizes[i] };
				}

				function alreadyExist(fileName) {
					for(var i = 0, len = $scope.fileUp.length; i < len; i++) {
					    if ($scope.fileUp[i].data.name === fileName) {
					        return true;
					    }
					}
					return false;
				}

				function uploadFile(file) {
					$upload.upload({
						url: 'http://localhost:4567/users/delkje555/files/add',
						method: 'POST',
						file: file.data,
						ignoreLoadingBar: true,
						timeout: file.canceller.promise
					}).success(function(data, status, headers, config) {
						//CE TIMEOUT/GET EST TEMPORAIRE, POUR FONCTIONNER AVEC LA VERSION COURANTE DE L'API
						$timeout(function() {
							$http(
							{
								method: 'GET',
								ignoreLoadingBar: true,
								url: 'http://localhost:4567/users/delkje555/files/' + data.data.files[0].path + '/parse'
							}).success(function(response) {
								regroupAndAddFileData(response.data, file);
								file.status = -1;
							}).error(function(data, status, headers, config) {
								file.status = status;
							});
						}, 500);

					}).error(function(data, status, headers, config) {
						file.status = status;
					}).progress(function(evt) {
						file.progress = parseInt(100.0 * evt.loaded / evt.total);
					});
				}

				function addTwoFileCombi(combinedColumn, currentCol, fileNameNew, fileNameOld) {
					combinedColumn.push({fileName: fileNameNew, column: currentCol});
					for(var i = 0, len = combinedColumn.length; i < len; i++) {
						if (combinedColumn[i].fileName === fileNameOld)
							return;
					}
					combinedColumn.push({fileName: fileNameOld, column: currentCol});
				}

				function addNewCombiToCurrentCombi(currentCol, fileNameNew, fileNameOld) {
					for(var k = 0, len = $scope.combinedColumns.length; k < len; k++) {
						for(var p = 0, leni = $scope.combinedColumns[k].length; p < leni; p++) {
							if ($scope.combinedColumns[k][p].column === currentCol) {
								addTwoFileCombi($scope.combinedColumns[k], currentCol, fileNameNew, fileNameOld);
								return true;
							}
						}
					}
					return false;
				}

				function regroupAndAddFileData(data, file) {
					var currColumns = Object.keys(data[0]);
					for (var i = 0, len = $scope.filesData.length; i < len; i++) {
						var combi = $scope.filesData[i].columns.filter(function (val) {
							for(var j = 0, leni = currColumns.length; j < leni; j++) {
							    if (currColumns[j] === val) {
							        return true;
							    }
							    return false;
							}
						});
						for(var j = 0, lene = combi.length; j < lene; j++) {
							if (addNewCombiToCurrentCombi(combi[j], file.data.name, $scope.filesData[i].fileName))
								break;
							$scope.combinedColumns.push([{fileName: file.data.name, column: combi[j]},
														{fileName: $scope.filesData[i].fileName, column: combi[j]}]);
						}
					}
					$scope.filesData.push({
						fileName: file.data.name,
						columns: currColumns,
						datas: data
					});
				}

				$scope.onFileSelect = function($files) {
				    for (var i = 0; i < $files.length; i++) {
				    	if (alreadyExist($files[i].name))
				    		break;
						var file = {data: $files[i], progress: 0, status: -2, canceller: $q.defer()};
						$scope.fileUp.push(file);
						uploadFile(file);
					}
				};

				$scope.dragOverClass = function($event) {
					var items = $event.dataTransfer.items;
					var hasFile = false;
					if (items != null) {
						for (var i = 0 ; i < items.length; i++) {
							if (items[i].kind == 'file') {
								hasFile = true;
								break;
							}
						}
					} else {
						hasFile = true;
					}
					return hasFile ? "dragover" : "dragover-err";
				};

				$scope.removeFile = function($index) {
					for(var i = 0, len = $scope.filesData.length; i < len; i++) {
					    if ($scope.filesData[i].fileName === $scope.fileUp[$index].data.name) {
					        $scope.filesData.splice(i, 1);
					        break;
					    }
					}
					$scope.combinedColumns = $scope.combinedColumns.filter(function (item) {
						item = item.filter(function (val) {
							return val.fileName !== $scope.fileUp[$index].data.name;
						});
						return item.length !== 1;
					});
					$scope.fileUp.splice($index, 1);
				};

				$scope.abortUpload = function($index) {
					$scope.fileUp[$index].canceller.resolve();
					$scope.fileUp.splice($index, 1);
				};

				$scope.removeAllFile = function() {
					$scope.fileUp.map(function (item) { item.canceller.resolve() });
					$scope.fileUp = [];
					$scope.combinedColumns = [];
					$scope.filesData = [];
				};

				function checkIfAllCombined() {
					var fileList = [];
					for (var i = 0, len = $scope.combinedColumns.length; i < len; i++) {
						for (var j = 0, lenn = $scope.combinedColumns[i].length; j < lenn; j++) {
							if (fileList.indexOf($scope.combinedColumns[i][j].fileName) === -1) {
						        fileList.push($scope.combinedColumns[i][j].fileName);
						    }
						}
					}
					if (fileList.length !== $scope.filesData.length) {
						var str = "";
						for (var i = fileList.length === 0 ? 1 : 0, len = $scope.filesData.length; i < len; i++) {
							if (fileList.indexOf($scope.filesData[i].fileName) === -1) {
								str += '<li>' + $scope.filesData[i].fileName +'</li>';
							}
						}
						$modal({content: str,
								template: 'datasetWizardConfirmStep1Modal.html',
								placement: 'center',
								scope: $scope,
								animation: 'am-fade-and-scale',
								show: true});
						return false;
					}
					return true;
				}

				function combineFilesAndShow() {
					$scope.$parent.canContinue = function(){return false};
					if ($scope.combinedColumns.length === 0) {
						takeFirstFileAndGo();
						return;
					}
					for (var i = 0, len = $scope.combinedColumns.length; i < len; i++) {

					}
					$scope.$parent.wizardProgress = 25;
					$scope.$parent.sourceData = $scope.filesData[0]; //TMP
					$scope.$parent.canContinue = function() { return $scope.filesData.length > 0; };
					$scope.$parent.backButton = function() {
						$scope.$parent.sourceData = null
						$scope.$parent.wizardProgress = 15;
						$scope.$parent.backButton = null;
					};
				};

				function takeFirstFileAndGo() {
					$scope.$parent.sourceData = $scope.filesData[0];
					$state.go('wizardDS.step2');
				}

				$scope.continueModal = function(hide) {
					hide();
					combineFilesAndShow();
				};

				$scope.$parent.continueButton = function() {
					if ($scope.$parent.sourceData) {
						$state.go('wizardDS.step2');
						return;
					}
					if ($scope.filesData.length === 1) {
						takeFirstFileAndGo();
						return;
					}
					if (!checkIfAllCombined())
						return;
					combineFilesAndShow();
				};

				$scope.$parent.canContinue = function() {
					return $scope.filesData.length > 0;
				};
			}])
		.controller('datasetWizardStep2Controller', ['$scope', '$state', '$filter', 'ngTableParams',
			function($scope, $state, $filter, ngTableParams) {
				$scope.$parent.wizardProgress = 40;
				$scope.$parent.step = '2';
				$scope.$parent.backButton = function() {
					$scope.$parent.sourceData = null; //On reset ici, inutile d'afficher l'apercu.
					$state.go('wizardDS.step1');
				};
				$scope.$parent.continueButton = function() { $state.go('wizardDS.step3') };
				$scope.$parent.canContinue = function() { return true; };

			    $scope.tableParams = new ngTableParams({
			        page: 1,
			        count: 10
			    }, {
			        total: $scope.$parent.sourceData.datas.length,
			        getData: function($defer, params) {
			            var filteredData = params.filter() ?
			                    $filter('filter')($scope.$parent.sourceData.datas, params.filter()) :
			                    $scope.$parent.sourceData.datas;
			            var orderedData = params.sorting() ?
			                    $filter('orderBy')(filteredData, params.orderBy()) :
			                    $scope.$parent.sourceData.datas;

			            params.total(orderedData.length);
			            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
			        }
			    });

			    $scope.sortTable = function(name) {
			    	var obj = {};
			    	obj[name] = $scope.tableParams.isSortBy(name, 'asc') ? 'desc' : 'asc';
			    	$scope.tableParams.sorting(obj);
			    }

			    $scope.filterTable = function(name) {
			    	var obj = {};
			    	obj[name] = 'text';
			    	return obj;
			    }

			    $scope.addColModal = {
				  "title": "Ajout d'une colonne",
				  "content": "TODO"
				};
			}])
		.controller('datasetWizardStep3Controller', ['$scope', '$state',
			function($scope, $state) {
				$scope.$parent.wizardProgress = 60;
				$scope.$parent.step = '3';
				$scope.$parent.backButton = function() { $state.go('wizardDS.step2'); };
				$scope.$parent.continueButton = function() { $state.go('wizardDS.step4') };
				$scope.$parent.canContinue = function() {
					return true; //TODO Demande au moins 1 binding.
				};

				console.log('todo step3');
				console.log($scope.$parent.sourceData);
			}])
		.controller('datasetWizardStep4Controller', ['$scope', '$state',
			function($scope, $state) {
				$scope.$parent.wizardProgress = 80;
				$scope.$parent.step = '4';
				$scope.$parent.backButton = function() { $state.go('wizardDS.step3'); };
				$scope.$parent.continueButton = function() { $state.go('wizardDS.step5') };
				$scope.$parent.canContinue = function() {
					return true; //TODO Check champs obligatoires
				};
				$scope.$parent.endButton = null;

				console.log('todo step4');
				console.log($scope.$parent.sourceData);
			}])
		.controller('datasetWizardStep5Controller', ['$scope', '$state',
			function($scope, $state) {
				$scope.$parent.wizardProgress = 100;
				$scope.$parent.step = '5';
				$scope.$parent.backButton = function() { $state.go('wizardDS.step4'); };
				$scope.$parent.continueButton = null;
				$scope.$parent.endButton = function() {
					//TODO Enjoy
				};

				console.log('todo step5');
				console.log($scope.$parent.sourceData);
			}])
})();