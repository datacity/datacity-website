(function () {
	angular
		.module('app')
		.controller('navController', function() {
			this.elements = [
				{
					link: "{{ path('datacity_private_dashboard') }}",
					icon: "fa-home",
					title: "Tableau de bord"
				},
				{
					link: "{{ path('datacity_private_usersmanager') }}",
					icon: "fa-user",
					title: "Gestion d'utilisateurs"
				},
				{
					link: "{{ path('datacity_private_newsmanager') }}",
					icon: "fa-file-text",
					title: "Gestion des actualités"
				}
			];
		});
})();