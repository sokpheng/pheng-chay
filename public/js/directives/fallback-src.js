// content-editable.js

(function() {

    define([], function() {
        var fallBackModule = angular.module('fallBackControl', []);
        fallBackModule.directive('fallbackSrc', [

            function(validator) {
                return {
                    restrict: 'A',
                    link: function postLink(scope, iElement, iAttrs) {
                        iElement.bind('error', function() {
                            if (angular.element(this).hasClass('img-owl-carousel'))
                                angular.element(this).parent().parent().parent().addClass("no-img");
                            else if (iAttrs.parentLevel == 1)
                                angular.element(this).parent().addClass("no-img");
                            else
                                angular.element(this).parent().parent().addClass("no-img");
                        });
                    }
                }
            }
        ]);
        return fallBackModule;
    });

}());