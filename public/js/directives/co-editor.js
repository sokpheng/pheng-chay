app.
	directive('coEditor', ['$timeout', '$parse', function($timeout, $parse) {
	  	return {
	        restrict: 'A',
        	link: function (scope, element, attribs){

		    	var id = element.id;
		    	if (!id){
		    		id = (new Date()).getTime() + '';
		    	}
		    	element.attr('id', id);
		        var editor = CKEDITOR.replace(id, {
	                filebrowserBrowseUrl: '/dashboard/browse-media',
	                filebrowserUploadUrl: '/api/v1/media/editor'
	            });

		      	var modelAccessor = $parse(attribs['ngModel']);
		        editor.on( 'change', function( evt ) {
	          		if (!CKEDITOR.instances[id]){
	          			return modelAccessor.assign($scope, null);
	          		}
	            	modelAccessor.assign(scope, CKEDITOR.instances[id].getData());
				});

		        var timeout = null;
		        editor.on( 'key', function( evt ) {
		        	if (timeout){
		        		$timeout.cancel(timeout);
		        	}
		        	timeout = $timeout(function (){
		          		if (!CKEDITOR.instances[id]){
		          			return modelAccessor.assign($scope, null);
		          		}
		            	modelAccessor.assign(scope, CKEDITOR.instances[id].getData());
	            	}, 500);
				});

	        	scope.$watch(modelAccessor, function (val) {	     
	        		if (!CKEDITOR.instances[id]){
	        			return;
	        		}     		
	        		if (CKEDITOR.instances[id].getData() == val){
	        			return;
	        		}
                    CKEDITOR.instances[id].setData(val);
                    element.val(val);
	        	});

	        	scope.$on('$destroyed', function (v){
	        	});

        	}
	  	};
	}]);