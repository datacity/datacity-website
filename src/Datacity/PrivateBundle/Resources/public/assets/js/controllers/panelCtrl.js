(function () {
	angular
		.module('app')
		.controller('panelController', 
			function() {
				this.tab = 1;
				this.selectTab = function(value) {
					this.tab = value;
				}
				this.isSelected = function(value) {
					return this.tab === value;
				}
		});
})();