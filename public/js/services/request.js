/*
* @Author: yinseng
* @Date:   2016-10-15 10:18:35
* @Last Modified by:   yinseng
* @Last Modified time: 2016-10-29 14:43:27
*/

(function() {

    app.service('Request', ['$http', '$rootScope', '$window','genfunc', function($http, $rootScope, $window,genfunc) {
        // namespace.api_domain = 'http://localhost:3000';

        var api_domain = $('meta[name="se:remoteUrl"]');
        api_domain = api_domain ? api_domain.attr('content') : '';
        
        if(api_domain)
            api_domain = atob(api_domain);

        // console.log('=== api domain: ',api_domain);
        
        namespace.api_domain = api_domain;
    	var api = namespace.api_domain;
        var cleanup = function() {
        };            

        var request;

        function initializeRequest(){
            var _token = genfunc.getToken();
            var _reqeust = genfunc.getRequestId();
            var _session = genfunc.getSessionId();


            $http.defaults.headers.common['X-IG-Connect-ID'] = _session;
            $http.defaults.headers.common['X-IG-Request-ID'] = _reqeust;
            $http.defaults.headers.common['Content-Type'] = 'application/json';
            if(_token)
                $http.defaults.headers.common['Authorization']   = 'Bearer ' + (_token ? _token : '');

            // console.log($http.defaults);

        }

        initializeRequest();


        var queryBuilder = function(keyValuePair) {

            var query = "";

            _.each(keyValuePair, function(v, k) {

                if (v != null && v != undefined) {
                    if (query != '') {
                        query = query + "&" + k + "=" + v;
                    } else {
                        query = "?" + k + "=" + v;
                    }
                }
            });

            return query;

        };

        var public_method = {
            get: function (uri, query, headers){
                return $http.get(api + uri + queryBuilder(query || {}), {
                    headers: _.extend({

                    }, headers || {})
                });
            },
            post: function (uri, data, headers, query){
                return $http.post(api + uri + queryBuilder(query || {}), data, {
                    headers: _.extend({

                    }, headers || {})
                });
            },
            put: function (uri, data, headers, query){

                return $http.put(api + uri + queryBuilder(query || {}), data, {
                     headers: _.extend({

                    }, headers || {})
                });
            },
            delete: function (uri, data, headers, query){

                return $http.delete(api + uri + queryBuilder(query || {}), {
                    data : data,
                    headers: _.extend({

                    }, headers || {})
                });
            },
            getApi: function (){
                return api;
            }
        };

        return public_method;
    }]);

}());
