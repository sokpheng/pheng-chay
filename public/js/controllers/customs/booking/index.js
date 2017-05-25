(function() {
    app.controller('BookingListingCtrl', ['$scope', '$timeout', '$mdSidenav',
        '$mdUtil', '$log', 'MockService', '$location', '$mdDialog', '$rootScope', 'CoResource',
        '$mdToast', 'filterFilter', '$routeParams',
        function($scope, $timeout, $mdSidenav,
            $mdUtil, $log, MockService, $location, $mdDialog, $rootScope, CoResource,
            $mdToast, filterFilter, $routeParams) {


            /***********************/
            /****** declaration ****/
            /***********************/
            $scope.products = [];
            $scope.selected = [];

            $scope.data = { created_at_from: null, created_at_to: null }


            $scope.search = {
                query: $location.search().search || '',
                filter: $location.search().filter || '',
                sort: $location.search().sort || '',
            };

            // Pagination
            $scope.pagination = {
                limit: 15,
                offset: $location.search().offset || 1,
                current: 1
            };

            $scope.toastPosition = {
                bottom: false,
                top: true,
                left: false,
                right: true
            };




            var timer = null;


            $scope.sort = '';



            /***********************/
            /* init function call **/
            /***********************/
            loadData();


            /***********************/
            /**** scope function ***/
            /***********************/

            $scope.getToastPosition = function() {
                return Object.keys($scope.toastPosition)
                    .filter(function(pos) { return $scope.toastPosition[pos]; })
                    .join(' ');
            };

            $scope.view = function(item, ev) {

                $mdDialog.show({
                        controller: 'BookingDialogCtrl',
                        templateUrl: '/templates/customs.booking.detail',
                        parent: angular.element(document.body),
                        targetEvent: ev,
                        locals: {
                            $current: item
                        },
                        skipHide: true,
                        autoWrap: false,
                        clickOutsideToClose: true,
                    })
                    .then(function(answer) {
                        $scope.alert = 'You said the information was "' + answer + '".';
                    }, function() {
                        $scope.alert = 'You cancelled the dialog.';
                    });


            };

            $scope.createProduct = function(directory) {
                $location.path('products/create');
            };

            $scope.changePage = function(current) {
                $scope.pagination.current = current;
            };

            $scope.preparePagination = function() {
                var amount = $scope.pagination.total_record > $scope.pagination.limit ? Math.ceil($scope.pagination.total_record / $scope.pagination.limit) : 0;

                console.log($scope.pagination.total_record / $scope.pagination.limit, amount);
                $scope.pagination.total_record = amount;
                $scope.pagination.total = _.map(new Array(amount), function(value, key) {
                    return key + 1;
                });


                console.log($scope.pagination.total);
            };

            $scope.changeOffset = function(offset) {
                $scope.pagination.offset = offset;
            };


            $scope.onPageChanged = function() {
                $location.search('offset', $scope.pagination.offset);
                //   	$rootScope.loading('show');
                // loadData(function (){
                // 	$rootScope.loading('hide');
                // }, $scope.pagination.offset, 10);
            };

            $scope.changeSort = function() {
                if ($scope.sort == '') {
                    $scope.sort = 'desc';
                } else if ($scope.sort == 'desc') {
                    $scope.sort = 'asc';
                } else {
                    $scope.sort = '';
                }

                $rootScope.loading('show');
                loadData(function() {
                    $rootScope.loading('hide');
                });

            };

            $scope.changeStatus = function() {


                $rootScope.loading('show');
                loadData(function() {
                    $rootScope.loading('hide');
                });

            };


            // Set Status Booking

            function setStatus(type, item, ev) {

                console.log("item", item);
                if ($scope.selected.length != 1) {

                    var confirm = $mdDialog.confirm()
                        .parent(angular.element(document.body))
                        .title(type + ' this item ?')
                        .content('Please select only one item to' + type)
                        .ariaLabel(type + ' Item')
                        .ok('Ok')
                        .targetEvent(ev);

                    $mdDialog.show(confirm);

                    console.log($scope.selected.length);
                    return;
                }
                // Appending dialog to document.body to cover sidenav in docs app
                // if (item.indeletable * 1) {
                //     return alert('This type is default and cannot be deleted');
                // }
                item = $scope.selected[0];
                if (!item) {
                    return;
                }

                var hotel_name = '';
                if (item.room_type) {
                    hotel_name = item.room_type.hotel.name;
                }

                var confirm = $mdDialog.confirm()
                    .parent(angular.element(document.body))
                    .title(type + ' this item `' + hotel_name + '` ?')
                    .content('Are sure to ' + type.toLowerCase() + ' this?')
                    .ariaLabel(type + ' Item')
                    .ok('Yes')
                    .cancel('No')
                    .targetEvent(ev);
                $mdDialog.show(confirm).then(function() {
                    $rootScope.loading('show');

                    function callback(s, h) {
                        $rootScope.loading('hide');

                        console.log(0);
                        // $rootScope.$emit('dataTypeSaved');
                        $scope.selected = [];
                        loadData();
                        $mdToast.show(
                            $mdToast.simple()
                            .content('Booking ' + type.toLowerCase())
                            .position($scope.getToastPosition())
                            .hideDelay(3000)
                        );
                    }

                    console.log(item._id);

                    if (type == 'Approve') {
                        CoResource.resources.Booking.setStatusApprove({
                            'itemId': item._id
                        }, {}, callback, function(e) {
                            $rootScope.loading('hide');
                            alert('Sorry, this type item cannot be deleted due to some reason, please contact administrator for more information');
                        });


                    } else if (type == 'Active') {
                        CoResource.resources.Booking.setStatusActive({
                            'itemId': item._id
                        }, {}, callback, function(e) {
                            $rootScope.loading('hide');
                            alert('Sorry, this type item cannot be deleted due to some reason, please contact administrator for more information');
                        });
                    } else if (type == 'Cancel') {
                        CoResource.resources.Booking.setStatusCancel({
                            'itemId': item._id
                        }, {}, callback, function(e) {
                            $rootScope.loading('hide');
                            alert('Sorry, this type item cannot be deleted due to some reason, please contact administrator for more information');
                        });
                    }



                }, function() {});
            }

            $scope.setApproveItems = function(item, ev) {
                setStatus('Approve', item[0], ev);
            }

            $scope.setCancelItems = function(item, ev) {
                setStatus('Cancel', item[0], ev);
            }

            $scope.setActiveItems = function(item, ev) {
                setStatus('Active', item[0], ev);
            }


            // $scope.$watch('search.query', function(v, old) {
            //     if (v == old) {
            //         return;
            //     }
            //     // $rootScope.loading('show');

            //     // loadData(function (){
            //     // 	$rootScope.loading('hide');
            //     // });
            //     $location.search('search', v);
            // });

            // $scope.$watch('search.brand', function(v, old) {
            //     console.log("v==old", v, old);
            //     if (v == old) {

            //         return;


            //     }

            //     // console.log("watch search.brand");
            //     // $rootScope.loading('show');

            //     // loadData(function (){
            //     // 	$rootScope.loading('hide');
            //     // });
            //     $location.search('brand', v);
            // });

            // $scope.$watch('search.category', function(v, old) {
            //     if (v == old) {
            //         return;
            //     }
            //     // $rootScope.loading('show');

            //     // loadData(function (){
            //     // 	$rootScope.loading('hide');
            //     // });
            //     $location.search('category', v);
            // });

            // $scope.$watch('search.sub_category', function(v, old) {
            //     if (v == old) {
            //         return;
            //     }
            //     // $rootScope.loading('show');

            //     // loadData(function (){
            //     //  $rootScope.loading('hide');
            //     // });
            //     $location.search('sub_category', v);
            // });


            // $scope.$watch('search.filter', function(v, old) {
            //     if (v == old) {
            //         return;
            //     }
            //     // $rootScope.loading('show');

            //     // loadData(function (){
            //     //  $rootScope.loading('hide');
            //     // });
            //     $location.search('filter', v);
            // });

            // $scope.$watch('search.sort', function(v, old) {
            //     if (v == old) {
            //         return;
            //     }
            //     // $rootScope.loading('show');

            //     // loadData(function (){
            //     //  $rootScope.loading('hide');
            //     // });
            //     $location.search('sort', v);
            // });

            $scope.$watch('data.created_at_from', function(v, old) {
                if (v == old) {
                    return;
                }

                $location.search('created_at_from', v);
            });

            $scope.$watch('data.created_at_to', function(v, old) {
                if (v == old) {
                    return;
                }
                $location.search('created_at_to', v);
            });


            /* EVENT WATCHERS */

            var watchers = {};

            watchers['created_at_from'] = $scope.$watch(function() {
                return $location.search().created_at_from;
            }, function(v, old) {

                if (v == old) {
                    return;
                }

                // $scope.search.query = v;
                console.log($scope.data.created_at_from, $scope.data.created_at_to);
                startCalling();
            });

            watchers['created_at_to'] = $scope.$watch(function() {
                return $location.search().created_at_to;
            }, function(v, old) {

                if (v == old) {
                    return;
                }

                // $scope.search.query = v;
                console.log($scope.data.created_at_from, $scope.data.created_at_to);
                startCalling();
            });



            // watchers['search'] = $scope.$watch(function() {
            //     return $location.search().search;
            // }, function(v, old) {

            //     if (v == old) {
            //         return;
            //     }

            //     $scope.search.query = v;
            //     startCalling();
            // });


            // watchers['brand'] = $scope.$watch(function() {
            //     return $location.search().brand;
            // }, function(v, old) {

            //     if (v == old) {
            //         return;
            //     }

            //     // console.log("watch down side");

            //     $scope.search.brand = v;
            //     startCalling();
            // });


            // watchers['category'] = $scope.$watch(function() {
            //     return $location.search().category;
            // }, function(v, old) {

            //     if (v == old) {
            //         return;
            //     }

            //     $scope.search.category = v;
            //     startCalling();
            // });

            // watchers['sub_category'] = $scope.$watch(function() {
            //     return $location.search().sub_category;
            // }, function(v, old) {

            //     if (v == old) {
            //         return;
            //     }

            //     $scope.search.sub_category = v;
            //     startCalling();
            // });

            // watchers['filter'] = $scope.$watch(function() {
            //     return $location.search().filter;
            // }, function(v, old) {

            //     if (v == old) {
            //         return;
            //     }

            //     $scope.search.filter = v;
            //     startCalling();
            // });

            // watchers['sort'] = $scope.$watch(function() {
            //     return $location.search().sort;
            // }, function(v, old) {

            //     if (v == old) {
            //         return;
            //     }

            //     $scope.search.sort = v;
            //     startCalling();
            // });


            watchers['offset'] = $scope.$watch(function() {
                return $location.search().offset;
            }, function(v, old) {

                if (v == old) {
                    return;
                }

                $scope.pagination.offset = v;
                startCalling();
            });

            $scope.$on('$destroy', function() {
                for (var key in watchers) {
                    watchers[key]();
                }
                $location.search('offset', null);
                $location.search('search', null);
            });

            $scope.categoryChange = function(category) {
                $scope.sub_categories = {};
                $rootScope.loading('show');
                var promise = CoResource.resources.Category.get({
                    // itemId: category.id,
                    'ignore-offset': 1,
                    type: 'subcategory',
                    parent_id: category.id,
                    // ignore_parent: 1,
                    // ignore_root:1,
                    cache: 0
                }, function() {
                    console.log(promise.result);
                    $scope.sub_categories = promise.result;
                    $rootScope.loading('hide');
                });
            }

            // $scope.dateChange = function() {
            //     alert($scope.data.created_at_from);
            // }

            /***********************/
            /******  functions *****/
            /***********************/

            function startCalling() {
                if (timer) {
                    $timeout.cancel(timer);
                }
                timer = $timeout(function() {

                    $rootScope.loading('show');

                    loadData(function() {
                        $rootScope.loading('hide');
                    });
                }, 700);

            }


            function loadData(callback, offset, limit) {
                offset = offset || $scope.pagination.offset;
                // limit = limit || 10;

                // getCategory();
                // $scope.data.new_at = moment.utc($scope.data.new_at).local().format('YYYY-MM-DD');
                // $scope.data.new_at = moment().add(1, 'months').format('YYYY-MM-DD');	

                $scope.booking = CoResource.resources.Booking.list({
                    // 'status': $scope.search,
                    'offset': (offset - 1) * $scope.pagination.limit || 0,
                    'limit': $scope.pagination.limit || 10,
                    'ignore-offset': 0,
                    'populate': 'deep',
                    'status': getStatus(),
                    'created_at_from': getDate($scope.data.created_at_from),
                    'created_at_to': getDate($scope.data.created_at_to)
                        // created_at_from created_at_to

                    // 'search': $scope.search.query || '',
                    // 'filters': $scope.search.filter || '',
                    // 'sorts': $scope.search.sort || 'seq_number'
                }, function(s) {
                    $scope.booking = s.result;

                    $scope.pagination.total_record = s.options.total;
                    console.log("total", $scope.booking);

                    $scope.preparePagination();
                    setTimeout(function() {
                        renderMagnific();
                    }, 2000);

                    if (callback) {
                        callback();
                    }
                });


            }

            // init();

            // function init() {
            //     var promise_brand = CoResource.resources.Brand.list({
            //         // type: $routeParams.type,
            //         // 'ignore-offset': 1,
            //         // type: 'category',
            //         // parent_id: null,
            //         // ignore_parent: 1,
            //         cache: 0
            //     }, function() {
            //         $scope.brands = promise_brand.result;
            //     });

            //     var promise_category = CoResource.resources.Category.list({
            //         // type: $routeParams.type,
            //         // 'ignore-offset': 1,
            //         type: 'category',
            //         parent_id: null,
            //         ignore_parent: 1,
            //         ignore_root: 1,
            //         cache: 0
            //     }, function() {
            //         $scope.categories = promise_category.result;
            //     });

            // }

            function getStatus() {
                if ($scope.search.status === 'Default') {
                    return '';
                } else if ($scope.search.status === 'approved') {
                    return 'approved';
                } else if ($scope.search.status === 'canceled') {
                    return 'canceled';
                }

                return '';
            }

            function getDate(date) {
                if (date) {
                    return date;
                } else {
                    return '';
                }


            }



            // Manific
            function renderMagnific() {
                $('.mini-gallery-list').magnificPopup({
                    type: 'image',
                    removalDelay: 300,
                    mainClass: 'mfp-with-zoom',
                    delegate: 'li.gallery-item', // the selector for gallery item,
                    titleSrc: 'title',
                    tLoading: '',
                    gallery: {
                        enabled: true
                    },
                    callbacks: {
                        imageLoadComplete: function() {
                            var self = this;
                            setTimeout(function() {
                                self.wrap.addClass('mfp-image-loaded');
                            }, 16);
                        },
                        open: function() {
                            // $('#header > nav').css('padding-right', getScrollBarWidth() + "px");
                        },
                        close: function() {
                            this.wrap.removeClass('mfp-image-loaded');
                            // $('#header > nav').css('padding-right', "0px");
                        },
                    }
                });
            }


        }
    ]);
}());