angular.module('app').directive('datepicker', function() {
    return {
        restrict: 'A',
        require : 'ngModel',
        link : function (scope, element, attrs, ngModelCtrl) {
            $(element).datepicker({
                    startView: "decade",
                }).on('changeDate', function(ev) {
                    var date = ev.date.valueOf();
                    ngModelCtrl.$setViewValue(new Date(date));
                    scope.$apply();
                });
        }
    }
});
