(function() {
    app.controller('BrowseMediaCtrl', function($scope, CoResource) {

        $scope.albums = CoResource.resources.Item.list({ type: 'album' }, function (){
            $scope.albums = $scope.albums.result;
        });

        $scope.media = CoResource.resources.Media.list({ limiter: 'off' }, function() {
            $scope.media = $scope.media.result;
            // Group media
            $scope.mediaGroups = _.groupBy($scope.media, function (v){
                return v.album_id;
            });
            var tmp = [];
            _.each($scope.mediaGroups, function (v){
                tmp.push({
                    group: v[0].album || { id: '', display_name: 'No Name'},
                    media: v
                })
            });
            $scope.mediaGroups = tmp;
        });

        // Helper function to get parameters from the query string.
        function getUrlParam(paramName) {
            var reParam = new RegExp('(?:[\?&]|&)' + paramName + '=([^&]+)', 'i');
            var match = window.location.search.match(reParam);

            return (match && match.length > 1) ? match[1] : null;
        }

        var funcNum = getUrlParam('CKEditorFuncNum');

        $scope.selectFile = function(item) {        	
	        var fileUrl = item.file_name;
	        window.opener.CKEDITOR.tools.callFunction(funcNum, fileUrl);
	        window.close();
        };
    });
}());