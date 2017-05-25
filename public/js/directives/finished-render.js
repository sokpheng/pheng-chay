// finished render repeat.js

(function() {

 
        var onFinishRenderRepeatModule = angular.module('onFinishRenderRepeat', []);
        onFinishRenderRepeatModule.directive('onFinishRender', ['$timeout',

            function($timeout, moduleUtilities) {
                return {
                    restrict: 'A',
                    link: function(scope, element, attr) {
                        // console.log(scope);
                        if (scope.$last === true) {
                            $timeout(function() {
                                if (attr.onFinishRender != ''){
                                    // console.log('emit func', attr.onFinishRender);
                                    scope.$emit(attr.onFinishRender);
                                }
                                else{
                                    scope.$emit('ngRepeatFinished');
                                }

                                // trigger lazyr image load
                                // moduleUtilities.triggerLazyr();

                            });
                        }
                    }
                }
            }

        ]);
        return onFinishRenderRepeatModule;
 

}());