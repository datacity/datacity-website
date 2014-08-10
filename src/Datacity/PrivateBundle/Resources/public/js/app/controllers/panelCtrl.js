(function () {
	angular
		.module('app')
		.controller('panelController', 
			function() {
				this.tab = 1;
				this.subTab = 1;
				this.selectTab = function(value) {
					this.tab = value;
				}
				this.isSelected = function(value) {
					return this.tab === value;
				}
				this.selectSubTab = function(value) {
					this.subTab = value;
				}
				this.isSubSelected = function(value) {
					return this.subTab === value;
				}
		});
})();