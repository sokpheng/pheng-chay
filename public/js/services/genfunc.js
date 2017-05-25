/*
 * @Author: yinseng
 * @Date:   2016-10-17 09:04:22
 * @Last Modified by:   yinseng
 * @Last Modified time: 2016-10-26 11:48:22
 */

(function() {

    app.service('genfunc', ['$http', '$rootScope', '$window', function($http, $rootScope, $window) {

        var public_method = {
            // header path
            getSessionId: function() {
                var session = $('meta[name="api:session"]');        
                session = session ? session.attr('content') : '';
                return session;
            },
            getLang: function() {
                var _lang = $('meta[name="se:lang"]');        
                _lang = _lang ? _lang.attr('content') : '';
                return _lang;
            },
            getUrlLang: function(){
                var _lang = $('meta[name="se:lang"]');        
                _lang = _lang ? _lang.attr('content') : '';

                if(_lang == 'kh' || _lang == '')
                    return '';
                else
                    return '/'+_lang;
            },
            getURL: function() {
                var _domain = $('meta[name="se:url"]');        
                _domain = _domain ? _domain.attr('content') : '';
                return atob(_domain);
            },
            getToken: function() {
                var token = $('meta[name="api:bearer"]');
                token = token ? token.attr('content') : '';
                return token;
            },
            getRequestId: function() {
                var request = $('meta[name="api:request"]');
                request = request ? request.attr('content') : '';
                return request;
            },
            getUser : function(){
                var user = $('meta[name="se:info"]');
                user = user ? user.attr('content') : '';
                // console.log("user",user);
                if(!user || user== "undefined") 
                    return '';
                user = atob(user);
                // console.log(user);
                return JSON.parse(user);
            },
            getRemote: function(){
                var remote = $('meta[name="se:remoteUrl"]');
                remote = remote ? remote.attr('content') : '';
                return atob(remote);
            },
            timeFromNow: function(date) {
                if(!date) return moment().local().fromNow();
                // check null and is valid date formate
                if (typeof moment != "undefined" && (!date || !moment(date).isValid()))
                    return;

                // if timesteam conver to string
                if (_.isNumber(date)) {
                    date = new Date(date);
                }


                // return moment([moment(date).get('year'), moment(date).get('month'), moment(date).get('date')]).local().fromNow();
                return moment(date).local().fromNow();

            },
            formatMoney: function() {
                Number.prototype.formatMoney = function(c, d, t) {
                    var n = this,
                        c = isNaN(c = Math.abs(c)) ? 2 : c,
                        d = d == undefined ? "." : d,
                        t = t == undefined ? "," : t,
                        s = n < 0 ? "-" : "",
                        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                        j = (j = i.length) > 3 ? j % 3 : 0;
                    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
                };
            },
            //  local storage
            addLocalstorage: function(storage, scope, data) {
                var obj = JSON.parse(localStorage.getItem(storage));
                obj.result.push(data.result);
                localStorage.setItem(storage, JSON.stringify(obj));
                scope.push(data.result);
            },
            updateLocalstorage: function(storage, scope, data) {},
            deleteLocalstorage: function(storage, scope, _id) {
                scope = _.filter(scope, function(v) {
                    return v._id != _id;
                });
                public_method.modifyLocalstorage(storage, scope);
                return scope;
            },
            modifyLocalstorage: function(storage, scope) {
                localStorage.setItem(storage, JSON.stringify(scope));
            },
            setNavPath: function(_path) {
                localStorage.navPath = _path;
            },
            getNavPath: function() {
                $rootScope.path = localStorage.navPath;
            },
            // date functions
            convertLocalDate: function(_date) {
                return _date ? moment.utc(_date).local().format('DD MMM YYYY') : null;
            },
            // validation
            isNumber: function(n) {
                return !isNaN(parseFloat(n)) && isFinite(n);
            },
            // handle error
            onError: function(data, status, headers, config) {
                if (status == 500) {
                    console.dir(data);

                }

                if (status == 401) {
                    console.dir(data);
                }
            },
            toPercent: function(total, amount) {
                return Math.round(amount / total * 100) || 0;
            },
            callLayzr: function(time) {
                setTimeout(function() {
                    var layzr = new Layzr({
                        container: "category-item-listing",
                        selector: '[data-layzr]',
                        attr: 'data-layzr',
                        retinaAttr: 'data-layzr-retina',
                        bgAttr: 'data-layzr-bg',
                        hiddenAttr: 'data-layzr-hidden',
                        threshold: 50,
                        callback: null
                    });
                }, time);

            },
            notify: function(status, message, duration) {
                console.log('duration', duration);
                UIkit.notify(message, {
                    status: status,
                    pos: 'top-center',
                    timeout: duration || 2000
                });
            },
            closeSpinner: function(uri, data, headers, query) {
                $('.spinner-container').addClass('spinner-close');
            },
            openSpinner: function(uri, data, headers, query) {
                $('.spinner-container').removeClass('spinner-close');

            },
            hideElement: function(selector) {
                $(selector).addClass('disable-display');
            },
            showElement: function(selector) {
                $(selector).removeClass('disable-display');
            }

        };

        return public_method;
    }]);

}());