(function() {
    app
        .service('CoResource', function($timeout, $http, $window, $resource, $rootScope) {
            var port = location.port || (location.protocol === 'http' ? 80 : 443);
            var $remoteUrl = namespace.domain + "v1/admin/";
            // if ($rootScope.remoteUrl){
            // 	$remoteUrl = $rootScope.remoteUrl + 'api/admin/';
            // }
            function initializeRequest() {
                var session = $('meta[name="api:session"]');
                session = session ? session.attr('content') : '';
                var token = $('meta[name="api:bearer"]');
                token = token ? token.attr('content') : '';
                var request = $('meta[name="api:request"]');
                request = request ? request.attr('content') : '';

                $http.defaults.headers.common['X-IG-Connect-ID'] = session;
                $http.defaults.headers.common['X-IG-Request-ID'] = request;
                $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;

            }

            console.log(base + 'directories/:directoryId');

            initializeRequest();

            function guid() {
                function s4() {
                    return Math.floor((1 + Math.random()) * 0x10000)
                        .toString(16)
                        .substring(1);
                }
                return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
                    s4() + '-' + s4() + s4() + s4();
            }

            var base = $remoteUrl;

            var resources = {
                Hotel: $resource(base + 'hotels/:hotelId', {
                    hotelId: '@id',
                    roomtypeId: '@id',
                    cache: false
                }, {
                    'update': { method: 'PUT' },
                    'list': {
                        method: 'GET',
                        cache: false
                    },
                    'getRoomtype': {
                        method: 'GET',
                        url: base + 'hotels/:hotelId/roomtypes/:roomtypeId',
                        photoId: '@id'
                    },
                    'deletePhoto': {
                        method: 'DELETE',
                        url: base + 'hotels/galleries/:photoId',
                        roomtypeId: '@id',
                    },
                    'setCoverPhoto': {
                        method: 'PUT',
                        url: base + 'hotels/:hotelId/cover/media/:photoId',
                        roomtypeId: '@id',
                    },
                    'addRoomtype': {
                        url: base + 'hotels/:hotelId/roomtypes',
                        method: 'POST',
                        cache: false
                    },
                    'editRoomtype': {
                        url: base + 'hotels/:hotelId/roomtypes/:roomtypeId',
                        method: 'PUT',
                        cache: false
                    },
                    'deleteRoomtype': {
                        url: base + 'hotels/:hotelId/roomtypes/:roomtypeId',
                        method: 'DELETE',
                        cache: false
                    },
                    'deletePhotoRoomtype': {
                        method: 'DELETE',
                        url: base + 'hotels/roomtypes/galleries/:photoId',
                        roomtypeId: '@id',
                    },
                    'setRoomtypeCoverPhoto': {
                        method: 'PUT',
                        url: base + 'hotels/roomtypes/:roomtypeId/cover/media/:photoId',
                        roomtypeId: '@id',
                        photoId: '@id'
                    },
                }),
                Booking: $resource(base + 'booking/:itemId', { itemId: '@id' }, {
                    'list': {
                        method: 'GET',
                        cache: false
                    },
                    'setStatusApprove': {
                        method: 'POST',
                        url: base + 'booking/:itemId/approve',
                        itemId: '@id',
                        cache: false
                    },
                    'setStatusActive': {
                        method: 'POST',
                        url: base + 'booking/:itemId/active',
                        itemId: '@id',
                        cache: false
                    },
                    'setStatusCancel': {
                        method: 'POST',
                        url: base + 'booking/:itemId/cancel',
                        itemId: '@id',
                        cache: false
                    },
                })
            };

            //

            // var caches = {};
            // caches['Item'] = resources.Item.list(function (){
            // 	caches['Item'] = caches['Item'].result;
            // });

            return {
                resources: resources,
                caches: function(cacheName) {
                    return caches[cacheName];
                },
                textifyError: function(object) {
                    if (!object) {
                        return '';
                    }
                    if (object.error === 'general') {
                        return object.result;
                    } else if (object.error === 'validation-error') {
                        return _.map(object.result, function(v) {
                            return v
                        }).join(' ,');
                    } else {
                        return object.result;
                    }
                }
            };
        });
}());