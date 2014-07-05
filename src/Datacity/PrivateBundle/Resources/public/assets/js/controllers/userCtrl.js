(function() {
	angular
		.module('app')
		.controller('userController', ['$scope', '$stateParams', '$modal', '$log', 'UserFactory',
			function($scope, $stateParams, $modal, $log, UserFactory) {
				$scope.user = {};
				$scope.collapsed = true;
				//$scope.imageUpload = 'http://www.placehold.it/310x170/EFEFEF/AAAAAA&text=no+image';
				var image;

				//TODO: A changer en fonction du champ image du user
				var showImg = function (img) {
		 			var reader = new FileReader();

		            reader.onload = function (e) {
		                jQuery('#profileImg').attr('src', e.target.result);
		            }
		            reader.readAsDataURL(img);
				};
				
				 UserFactory.getUserFromSession().then(function(data) {
				 	$scope.user = data;
					$scope.user.datasets = UserFactory.populateDatasetTmp();
				 });
				/*UserFactory.populate().then(function(data) {
					console.log(data);
					$scope.user.datasets = data;
				})*/

				$scope.onImageSelect = function($files) {
      				image = $files[0];
      				if (image) {
			            var reader = new FileReader();

			            reader.onload = function (e) {
			            	jQuery('#thumbnail-preview').attr('src', e.target.result);
			            	//Ne se met pas a jour ...
			            	//$scope.imageUpload = e.target.result;
			            }
			            reader.readAsDataURL(image);
			        }
			    }

				$scope.deleteImage = function() {
					image = null;
					jQuery('#thumbnail-preview').attr('src', 'http://www.placehold.it/310x170/EFEFEF/AAAAAA&text=no+image');
					//$scope.imageUpload = 'http://www.placehold.it/310x170/EFEFEF/AAAAAA&text=no+image';
				}

			    //TODO: Changer les "Then"
				$scope.uploadImage = function () {
					if (image) {
						$scope.user.img = UserFactory.uploadImage(image).then(function(data) {
							//TODO: A changer en fonction de ce qu'on recevra en retour du controller
							//+ gestion d'erreur et message de validation
					 		if (data.config.file) {
					 			showImg(data.config.file);
					        }
					 	});
				 	} else {
				 		//TODO: MESSAGE D'ERREUR
				 	}
				}
				
				$scope.updateUser = function () {
			        var userUpdated = $scope.user;

			        UserFactory.updateUser(userUpdated).then(function(data) {
				 		console.log(data);
				 	});
			    }
		}]);
})();