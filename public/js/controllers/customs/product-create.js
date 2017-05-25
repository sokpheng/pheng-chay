(function() {
    app.controller('ProductArticleCtrl', function($scope, $timeout, $mdSidenav,
        $mdUtil, $log, $rootScope, MockService, $mdDialog, $routeParams, $location,
        $mdToast, CoResource, Upload) {
    	$scope.parentName = "ArticleCtrl";

        $scope.toastPosition = {
            bottom: false,
            top: true,
            left: false,
            right: true
        };

        $scope.getToastPosition = function() {
            return Object.keys($scope.toastPosition)
                .filter(function(pos) {
                    return $scope.toastPosition[pos];
                })
                .join(' ');
        };

        // Predefined custom field by category
        $scope.predefinedCustomFieldByCategory = {
            'do-you-know-detail': {
                description: true,
                customFields: [{
                    name: 'caption',
                    display_name: 'Caption',
                    type: 'text',
                    model: '',
                    not_removable: true
                }, {
                    name: 'stat',
                    display_name: 'Statistic Number',
                    type: 'number',
                    model: '',
                    not_removable: true
                }, {
                    name: 'icon-class',
                    display_name: 'Icon Class',
                    type: 'text',
                    model: '',
                    not_removable: true
                }]
            },
            'game-news': {                
                customFields: [{
                    custom_field_type: 'game-news',
                    name: 'more-info',
                    type: 'editor',
                    display_name: 'Info',
                    model: '',
                    not_removable: true
                }, {
                    custom_field_type: 'game-news',
                    name: 'requirement',
                    type: 'editor',
                    display_name: 'Requirements',
                    model: '',
                    not_removable: true
                }, {
                    custom_field_type: 'game-news',
                    name: 'env-type',
                    display_name: 'Running On',
                    type: 'array-game-type',
                    model: [],
                    not_removable: true
                }, {
                    custom_field_type: 'game-news',
                    name: 'download-links',
                    type: 'download-link-group',
                    display_name: 'Download Links',
                    addDownloadType: function (e, model){
                        model.push({
                            display_name: '',
                            links: []
                        });
                    },
                    removeDownloadType: function (e, item, model){
                        var index = model.indexOf(item);
                        if (index > -1){
                            var result = confirm('Are you sure to remove this download type?');
                            if (!result){
                                return;
                            }
                            model.splice(index, 1);
                        }
                    },
                    model: [{
                        display_name: '',
                        links: []
                    }],
                    not_removable: true
                }]
            }
        };

        $scope.predefinedCustomField = {
            'solution': {
                description: true,
                customFields: [{
                    name: 'short-description',
                    display_name: 'Short Description',
                    model: '',
                    not_removable: true
                }]
            },
            'industry': {
                description: true,
                customFields: [{
                    name: 'short-description',
                    display_name: 'Short Description',
                    model: '',
                    not_removable: true
                }]
            }
        };

        // Custom field

        $scope.status = {
            description: true
        };

    	$scope.data = {
    		category_id: $routeParams.sectionId || null,
    		type_id: $routeParams.typeId || null
    	};

        $scope.albums = CoResource.resources.Item.list({ type: 'album' }, function (){
            $scope.albums = $scope.albums.result;
        });

    	// Get product information

		$scope.product = CoResource.resources.Product.get({ productId: $routeParams.id}, function (){
			$scope.product = $scope.product.result;
		});

        // $scope.categories = MockService.categories.list();
        $scope.categories = CoResource.resources.Item.list({
            'type': 'category',
            'ignore-offset': 1
        }, function(s) {
            $scope.categories = $scope.categories.result;

            var category = _.filter($scope.categories, function (v){
            	return v.id == $routeParams.sectionId;
            });
	       
            if (!$scope.data || !$scope.data.id){
    	    	$scope.data = {
    	    		category_id: $routeParams.sectionId || null,
    	    		type_id: $routeParams.typeId || null
    	    	};
            }

	    	$scope.category = category[0];

            if (category && category[0]){
                if (!$scope.data || !$scope.data.id){
                	$scope.data.type_id = category[0].parent_id;

                    if (category[0].name == 'grid-image' || category[0].name == 'cover-image'){
                        $scope.data.title = category[0].display_name;
                    }
                }
                $scope.articleTypeChanged($scope.data.type_id);
            }
        });

        // $scope.types = MockService.types.list();

        $scope.types = CoResource.resources.Item.list({
            type: 'type',
            'offset-limitor': 0
        }, function(s) {
            $scope.types = $scope.types.result;

            // Article Parent
            if ($routeParams.typeId){
                var tmp = _.filter($scope.types, function (v){
                    return v.id == $routeParams.typeId;
                });

                if (tmp && tmp.length){
                	$scope.type = tmp[0];
                    $scope.data.type_id = tmp[0].id;
                    $scope.articleTypeChanged(tmp[0].id);
                    var type = tmp[0].name;
                    if ($scope.predefinedCustomField[type]){
                        $scope.status['description'] = $scope.predefinedCustomField[type].description;
                        if ($scope.mode === 'create'){

                            $scope.customFields = angular.copy($scope.predefinedCustomField[type].customFields);
                            
                        }
                        else{
                            var names = _.map($scope.customFields, function (v){
                                return v.name;
                            });
                            var customFields = _.filter($scope.predefinedCustomField[type].customFields, function (v){
                                return names.indexOf(v.name) <= -1;
                            });
                            $scope.customFields = $scope.customFields.concat(customFields);
                        }
                    }
                    
                }
            }
        });

        $scope.data = {
        };
        $scope.mode = "create";

        $scope.articleTypeChanged = function(type_id) {
        	var type = _.filter($scope.types, function (v){
        		return v.id == type_id;
        	});
        	if (type && type[0]){
        		$scope.type = type[0];
        	}
            var categoriesResult = CoResource.resources.Item.list({
                type: 'category',
                'offset-limitor': 0,
                parent_id: type_id
            }, function(s) {
                $scope.categories = categoriesResult.result;

            });
        };

        // Category: predefinedCustomFieldByCategory
        $scope.$watch('data.category_id', function (category_id){
            var tmp = _.filter($scope.categories, function (v){
                return v.id * 1 === category_id * 1;
            });
            if (tmp && tmp.length){
                tmp = tmp[0];
                $scope.categoryName = tmp.name;

                if ($scope.predefinedCustomFieldByCategory[tmp.name]){
                    if ($scope.mode === 'create'){
                        $scope.categoryCustomFields = angular.copy($scope.predefinedCustomFieldByCategory[tmp.name].customFields);                        
                    }
                    else{
                        var names = _.map($scope.categoryCustomFields, function (v){
                            return v.name;
                        });
                        var customFields = _.filter($scope.predefinedCustomFieldByCategory[tmp.name].customFields, function (v){
                            return names.indexOf(v.name) <= -1;
                        });

                        $scope.categoryCustomFields = $scope.categoryCustomFields || [];
                        $scope.categoryCustomFields = $scope.categoryCustomFields.concat(customFields);
                        var gameCustomField = _.filter($scope.data.customs, function (v){
                            return v.custom_field_type === 'game-news' 
                        }); 

                        var categoryCustomFields = _.map(gameCustomField, function (v){
                            return v
                        }); 

                        _.each(categoryCustomFields, function (v, k){
                            var tmp = _.where($scope.categoryCustomFields, {
                                name: v.name
                            });
                            categoryCustomFields[k] = _.extend(categoryCustomFields[k], {
                                addDownloadType: tmp.addDownloadType,
                                removeDownloadType: tmp.removeDownloadType
                            });
                        });

                        // Get which is not in original
                        var tmpNotInList = _.filter($scope.categoryCustomFields, function (v){
                            return _.map(categoryCustomFields, function (v){
                                return v.name;
                            }).indexOf(v.name) <= -1;
                        }); 

                        $scope.categoryCustomFields = tmpNotInList.concat(categoryCustomFields);

                        // Get select game type
                        var gamePlatform = _.where(categoryCustomFields, {
                            name: 'env-type'
                        });
                        if (gamePlatform && gamePlatform.length){
                            $scope.select_gameTypes = gamePlatform[0].model;
                        }



                    }
                }
                    
            }
        });


        if ($routeParams.hash) {
            // Load data from mock
            // $scope.data = MockService.posts.get($routeParams.id);
            $rootScope.loading('show');
            if (($routeParams.hash) && !$routeParams.locale) {
                var data = CoResource.resources.Article.get({
                    articleId: $routeParams.hash
                }, function() {
                    if (data.result){

                        $scope.data = data.result;
                        $scope.data.seq_no = $scope.data.seq_no * 1;

                        //default custom field
                        var typeCustomField = _.filter($scope.data.customs, function (v){
                            return v.custom_field_type != 'game-news' 
                        }); 

                        var gameCustomField = _.filter($scope.data.customs, function (v){
                            return v.custom_field_type === 'game-news' 
                        }); 
                        $scope.customFields = _.map(typeCustomField, function (v){
                            return v
                        });

                        console.log( $scope.customFields);

                        // var categoryCustomFields = _.map(gameCustomField, function (v){
                        //     return v
                        // }); 

                        // _.each(categoryCustomFields, function (v, k){
                        //     var tmp = _.where($scope.predefinedCustomFieldByCategory['game-news'].customFields, {
                        //         name: v.name
                        //     });
                        //     categoryCustomFields[k] = _.extend(categoryCustomFields[k], {
                        //         addDownloadType: tmp.addDownloadType,
                        //         removeDownloadType: tmp.removeDownloadType
                        //     });
                        // });

                        $timeout(function() {

                            var watcher = $scope.$watch('tags', function (v){
                                if (v){
                                    watcher();
                                    var cat = angular.copy($scope.tags);
                                    var ids = _.map($scope.data.tags, function (v){
                                        return v.id
                                    });
                                    cat = _.filter(cat, function (v){
                                        return ids.indexOf(v.id) > -1;
                                    });
                                    $scope.select_tags = cat;
                                }
                            });

                            var watcherProducts = $scope.$watch('products', function (v){
                                if (v){
                                    watcherProducts();
                                    var cat = angular.copy($scope.products);
                                    var ids = _.map($scope.data.products, function (v){
                                        return v.id
                                    });
                                    cat = _.filter(cat, function (v){
                                        return ids.indexOf(v.id) > -1;
                                    });
                                    $scope.select_products = cat;
                                    console.log(cat);
                                }
                            });

                            $rootScope.loading('hide');
                        }, 1000);
                        $scope.mode = "edit";

                    }
                    else{

                        $scope.mode = "create";
                        $rootScope.loading('hide');
                    }                    
                    setTimeout(function (){
                        renderMagnific();
                    }, 200);
                }, function() {
                    if ($scope.parentName){

                        $scope.mode = "create";
                        $rootScope.loading('hide');

                    }
                    else{

                        $rootScope.loading('hide');
                        var dialog = $mdDialog.show(
                            $mdDialog.alert()
                            .parent(angular.element(document.body))
                            .title('Post not found')
                            .content('Sorry, we cannot view this post! Maybe you try to view the deleted one!')
                            .ariaLabel('Post not found')
                            .ok('Got it!')
                            .targetEvent(function(ev) {
                                $location.path('/posts');
                            })
                        );
                    }
                });
            } else if ($routeParams.hash && $routeParams.locale) {
                $scope.locale = $routeParams.locale;

                if ($routeParams.locale != null && !$rootScope.locales[$routeParams.locale]) {
                    $location.path('/posts/' + $routeParams.hash);
                }
                var data = CoResource.resources.Article.get({
                    articleId: $routeParams.hash,
                    language: $routeParams.locale
                }, function() {
                    $scope.data = data.result;
                    if (!$scope.data.customs){
                        $scope.data.customs = $scope.data.parent.customs;
                    }
                    $scope.customFields = _.map($scope.data.customs, function (v){
                        return v
                    });

                    if (!$scope.data.id) {
                        $scope.data.title = $scope.data.parent.title;
                        $scope.data.description = $scope.data.parent.description;
                        $scope.data.type_id = $scope.data.parent.type_id;
                        $scope.data.category_id = $scope.data.parent.category_id;
                    }

                    $timeout(function() {
                        $('#post-editor').val($scope.data.description);
                        $rootScope.loading('hide');
                    }, 500);
                    $scope.mode = "locale";
                }, function() {
                    $rootScope.loading('hide');
                    var dialog = $mdDialog.show(
                        $mdDialog.alert()
                        .parent(angular.element(document.body))
                        .title('Post not found')
                        .content('Sorry, we cannot view this post! Maybe you try to view the deleted one!')
                        .ariaLabel('Post not found')
                        .ok('Got it!')
                        .targetEvent(function(ev) {
                            $location.path('/posts');
                        })
                    );
                });
            }
        }

        $scope.save = function($event, callback) {

            $scope.data.customs = $scope.customFields;
            var customsName = _.map($scope.customFields, function (val){
                return val.name;
            });
            $scope.data.customs = $scope.customFields.concat(_.map(_.filter($scope.categoryCustomFields, function (val){
                return customsName.indexOf(val.name) == -1;
            }) || [], function (v){
                return {
                    custom_field_type: v.custom_field_type,
                    name: v.name,
                    type: v.type,
                    display_name: v.display_name,
                    model: v.model,
                    not_removable: v.not_removable
                };
            }));

            // Update tag game platform
            _.each($scope.data.customs, function (v, k){
                if (v.name === 'env-type'){
                    $scope.data.customs[k].model = $scope.select_gameTypes
                }
            }); 

            $scope.data.select_tags = _.map($scope.select_tags, function (v){
                return _.pick(v, 'id', 'display_name', 'name');
            });

            $scope.data.select_products = _.map($scope.select_products, function (v){
                return _.pick(v, 'id', 'display_name', 'name');
            });

            $scope.data.status = $scope.data.status || 'draft';

            $rootScope.loading('show');
            $scope.data.product_id = $routeParams.id;
            if ($scope.mode == 'edit') {
                // $scope.data.updated_time = new Date();
                // MockService.posts.update($scope.data);	
                CoResource.resources.Article.update({
                    articleId: $scope.data.id
                }, {
                    description: $scope.data.description,
                    title: $scope.data.title,
                    type_id: $scope.data.type_id,
                    category_id: $scope.data.category_id,
                    collection_id: $scope.data.collection_id,
                    seq_no: $scope.data.seq_no,
                    select_tags: $scope.data.select_tags,
                    select_products: $scope.data.select_products,
                    customs: $scope.data.customs,
                    primary_photo_id: $scope.data.primary_photo_id,
                    game_photo_id: $scope.data.game_photo_id
                }, function(s) {

                    $rootScope.$emit('articleUpdated');

                    if ($scope.parentName){
                        $scope.savePendingUploads();
                    }

                    // default custom field
                    // var typeCustomField = _.filter(s.result.customs, function (v){
                    //     return v.custom_field_type != 'game-news' 
                    // }); 

                    // var gameCustomField = _.filter(s.result.customs, function (v){
                    //     return v.custom_field_type === 'game-news' 
                    // }); 

                    // $scope.customFields = _.map(typeCustomField, function (v){
                    //     return v;
                    // });

                    // var tmp = _.filter($scope.categories, function (v){
                    //     return v.id * 1 === category_id * 1;
                    // });
                    // if (tmp && tmp.length && tmp[0].name === 'game-news'){
                    //     $scope.categoryCustomFields = _.map(typeCustomField, function (v){
                    //         return v;
                    //     });
                    // }

                    $rootScope.loading('hide');
                    $mdToast.show(
                        $mdToast.simple()
                        .content('Article updated')
                        .position($scope.getToastPosition())
                        .hideDelay(3000)
                    );
                }, function(e) {
                    $rootScope.loading('hide');
                    alert('There was an error while trying to update your article.');
                });
            } else if ($scope.mode == 'create') {
                // $scope.data.time = new Date();
                // $scope.data = MockService.posts.store($scope.data);	
                $scope.data.hash = $routeParams.hash;
                var article = new CoResource.resources.Article($scope.data);
                article.$save(function(s) {
                    $scope.data = s.result;
                    $rootScope.$emit('articleUpdated');

                    if ($scope.parentName){
                        $scope.savePendingUploads();
                    }
                    $scope.mode = 'edit'
                    $rootScope.loading('hide');
                        
                    if (callback){
                        callback();
                    }
                    else{
                        var dialog =
                            $mdDialog.confirm()
                            .parent(angular.element(document.body))
                            .title('Article Saved')
                            .content('Your article has been saved')
                            .ariaLabel('Your article has been saved')
                            .ok('Got it!')
                            .targetEvent($event);

                        $mdDialog.show(dialog).then(function() {
                            if (!$scope.parentName){
    
                                $location.path('/posts/' + $scope.data.id);
                            }
                        });
                        
                    }
                }, function(e) {
                    $rootScope.loading('hide');
                    alert('There was an error while trying to save your article');
                });
            } else if ($scope.mode == 'locale') {
                CoResource.resources.ArticleLocale.save({
                    articleId: $scope.data.parent.id,
                    language: $scope.locale
                }, $scope.data, function(s) {
                    $rootScope.loading('hide');

                    $rootScope.$emit('articleUpdated');
                    $mdToast.show(
                        $mdToast.simple()
                        .content('Article updated')
                        .position($scope.getToastPosition())
                        .hideDelay(3000)
                    );
                }, function(e) {
                    $rootScope.loading('hide');
                    alert('There was an error while trying to update your article locale.');
                });
            }
        };
        
        $scope.publish = function ($event){
            if ($scope.mode == 'edit') {
                CoResource.resources.Article.publish({
                    articleId: $scope.data.id
                }, {}, function(s) {
                    $rootScope.loading('hide');
                    $scope.data.status = 'published';
                    $scope.data.published_at = moment().utc().format('YYYY-MM-DD HH:mm:ss');
                    $mdToast.show(
                        $mdToast.simple()
                        .content('Article published')
                        .position($scope.getToastPosition())
                        .hideDelay(3000)
                    );
                }, function(e) {
                    $rootScope.loading('hide');
                    alert('There was an error while trying to update your article. Error: ' + e.result);
                });
            }
            else{
                $scope.save($event, function (){
                    CoResource.resources.Article.publish({
                        articleId: $scope.data.id
                    }, {}, function(s) {
                        $rootScope.loading('hide');
                        $scope.data.status = 'published';
                        var dialog =
                            $mdDialog.confirm()
                            .parent(angular.element(document.body))
                            .title('Article Published')
                            .content('Your article has been published')
                            .ariaLabel('Your article has been published')
                            .ok('Got it!')
                            .targetEvent($event);
    
                        $mdDialog.show(dialog).then(function() {
                            if (!$scope.parentName){
                                $location.path('/posts/' + $scope.data.id);
                            }
                        });
                    }, function(e) {
                        $rootScope.loading('hide');
                        alert('There was an error while trying to update your article. Error: ' + e.result);
                    });
                    
                });
            }
        };
        
        $scope.draft = function ($event){
            if ($scope.mode == 'edit') {
                var result = confirm("Are you sure to drop back to draft?");
                if (!result){
                    return;
                }
                CoResource.resources.Article.putDraft({
                    articleId: $scope.data.id
                }, {}, function(s) {
                    $rootScope.loading('hide');
                    $scope.data.status = 'draft';
                    $mdToast.show(
                        $mdToast.simple()
                        .content('Article has been put back to draft')
                        .position($scope.getToastPosition())
                        .hideDelay(3000)
                    );
                }, function(e) {
                    $rootScope.loading('hide');
                    alert('There was an error while trying to update your article back to draft. Error: ' + e.result);
                });
            }
            else{
            }
        };
        
        $scope.removeArticle = function ($event){
            if ($scope.mode == 'edit') {
                var result = confirm("Are you sure to remove this article?");
                if (!result){
                    return;
                }
                CoResource.resources.Article.delete({
                    articleId: $scope.data.id
                }, {}, function(s) {
                    $rootScope.loading('hide');

                    $location.path('/articles');
                    $mdToast.show(
                        $mdToast.simple()
                        .content('Article has been deleted')
                        .position($scope.getToastPosition())
                        .hideDelay(3000)
                    );
                }, function(e) {
                    $rootScope.loading('hide');
                    alert('There was an error while trying to delete your article. Error: ' + e.result);
                });
            }
            else{
            }
        };
        
        $scope.schedule = function ($event){
            
            var fn = function (){
                $mdDialog.show({
                    controller: 'ScheduleArticleDialogCtrl',
                    templateUrl: '/templates/schedule-post',
                    parent: angular.element(document.body),
                    targetEvent: $event,
                    locals: {
                        $current: $scope.data,
                        $data: {
                        }
                    }
                })
                .then(function(answer) {
                    $scope.alert = 'You said the information was "' + answer + '".';
                }, function() {
                    $scope.alert = 'You cancelled the dialog.';
                });
            };
            // fn();
            if ($scope.mode == 'edit') {
                fn();
            }
            else{
                $scope.save($event, function (){
                    fn();
                });
            }
        };
        
        $rootScope.$on('articleScheduled', function (e, data){
            if (data.id === $scope.data.id){
                $scope.data.status = 'scheduled';
                $scope.data.scheduled_at = data.scheduled_at;
            }
        });

        $scope.choosePostLocale = function(ev) {
            $mdDialog.show({
                controller: 'PostLocaleDialogCtrl',
                templateUrl: '/templates/choose-post-locale',
                parent: angular.element(document.body),
                targetEvent: ev,
                locals: {
                    $current: $scope.data.parent ? $scope.data.parent : $scope.data,
                    $locale: $scope.locale
                }
            })
                .then(function(answer) {

                }, function() {

                });
        };

        CoResource.resources.Collection.list({
            'ignore-offset': 1
        }, function (data){
            $scope.collections = data.result;
        });  

        if ($scope.parentName !== 'ArticleCtrl'){        
 

            $scope.$watch('data.category_id', function (v){
                if (v){
                    var category = _.filter($scope.categories, function (val){
                        return val.id == v;
                    });
                    if (category && category.length){
                        category = category[0];
                        category = category.name;
                        if ($scope.predefinedCustomField[category]){
                            $scope.status['description'] = $scope.predefinedCustomField[category].description;
                            if ($scope.mode === 'create'){

                                $scope.customFields = angular.copy($scope.predefinedCustomField[category].customFields);
                                
                            }
                            else{
                                var names = _.map($scope.customFields, function (v){
                                    return v.name;
                                });
                                var customFields = _.filter($scope.predefinedCustomField[category].customFields, function (v){
                                    return names.indexOf(v.name) <= -1;
                                });
                                $scope.customFields = $scope.customFields.concat(customFields);
                            }
                        }
                    }
                }
            });
        }
        
        $scope.customFields = [];

        $scope.customFieldStatus = {
            showControl: false,
            fieldName: ''
        };
        $scope.toggleControl = function (){
            $scope.customFieldStatus.showControl = !$scope.customFieldStatus.showControl;
        };
        $scope.addCustomField = function ($e){
            if ($e.keyCode == 13){
                $e.stopPropagation();
                $e.preventDefault();
                $scope.customFields.push({
                    name: namespace.urlify($scope.customFieldStatus.fieldName),
                    display_name: $scope.customFieldStatus.fieldName,
                    model: ''
                });
                $scope.customFieldStatus = {
                    showControl: false,
                    fieldName: ''
                };
            }
        };
        $scope.removeField = function (field, index){
            if (index > 0 && $scope.customFields[index] && !field.not_removable){
                $scope.customFields.splice(index, 1);
            }
        };

        $scope.uploadingFile = {
            src: '',
            obj: null
        };

        $scope.pendingUploads = [];
        $scope.savePendingUploads = function ()
        {

            _.each($scope.pendingUploads, function (v, k){
                v.loading = true;
                if (v.type == 'logo'){                                  
                    $scope.chooseFile(v, function (data){               
                        $scope.uploadingFile.loading = false;
                        var result = data.result;
                        $scope.data.logo_id = result.id;
                        $scope.submit(true);
                        $rootScope.loading('hide');
                        $mdDialog.hide();
                        $scope.data.logo = result;
                    });
                }
                else{                   
                    $scope.chooseFile($scope.pendingUploads[k], function (data, file){
                        $scope.data.photos = $scope.data.photos || [];
                        $scope.data.photos.push(data.result);
                        for(var i = $scope.pendingFiles.length - 1; i >= 0; i--){
                            if (file.id === $scope.pendingFiles[i].id){
                                $scope.pendingFiles.splice(i, 1);
                            }
                        }
                        setTimeout(function (){
                            renderMagnific();
                        }, 200);
                    });
                }
            });
            $scope.pendingUploads = [];
        };

        $scope.uploadLogo = function (files){
            if (!files.length){
                return;
            }
            $scope.uploadingFile = {
                file: files[0],
                type: 'logo',
                src: window.URL.createObjectURL(files[0])
            };
            if ($scope.mode === 'create'){              
                $scope.pendingUploads = _.filter($scope.pendingUploads, function (v){
                    return v.type != 'logo';
                });
                $scope.pendingUploads.push($scope.uploadingFile);
            }
            else{           
                $scope.uploadingFile.loading = true;
                $scope.chooseFile($scope.uploadingFile, function (data){                
                    $scope.uploadingFile.loading = false;
                    $scope.uploadingFile.src = false;
                    var result = data.result;
                    $scope.data.logo_id = result.id;
                    $scope.submit(true);
                    $rootScope.loading('hide');
                    $mdDialog.hide();
                    $scope.data.logo = result;
                });
            }
        };

        $scope.pendingFiles = [];
        $scope.uploadMedia = function (files){
            _.each(files, function (v, k){
                var file = {
                    file: files[k],
                    id: namespace.guid(),                   
                    type: 'gallery',
                    src: window.URL.createObjectURL(v)
                };
                $scope.pendingFiles.push(file);
                if ($scope.mode === 'create'){   
                    $scope.pendingUploads.push(file);
                }
                else{
                    file.loading = true;
                    $scope.chooseFile(file, function (data, file){
                        $scope.data.photos = $scope.data.photos || [];
                        $scope.data.photos.push(data.result);
                        for(var i = $scope.pendingFiles.length - 1; i >= 0; i--){
                            if (file.id === $scope.pendingFiles[i].id){
                                $scope.pendingFiles.splice(i, 1);
                            }
                        }
                        
                        if ($scope.data.photos.length == 1){
                            $scope.setPrimary($scope.data.photos[0]);
                        }

                        setTimeout(function (){
                            renderMagnific();
                        }, 200);
                    });
                }
            });
        };

        $scope.chooseFile = function (filetmp, callback){
            
            filetmp.loading = true;
            $rootScope.loading('show');

            $scope.upload = Upload.upload({
                url: $rootScope.remoteUrl ?  $rootScope.remoteUrl + 'api/v1/media' : '/api/v1/media', // upload.php script, node.js route, or servlet url
                method: 'POST',
                //headers: {'Authorization': 'xxx'}, // only for html5
                //withCredentials: true,
                method: 'POST',
                headers: {
                }, // only for html5
                data: {
                    "caption": $scope.data.title,
                    "description": $scope.data.title,
                    "imagable_type": "Article",
                    "imagable_id": $scope.data.id,
                    "type": filetmp.type,
                    "album_id": 0
                },
                file: filetmp.file, 
            }).progress(function(evt) {
                // evt.config.file.progress = parseInt(100.0 * evt.loaded / evt.total);
                filetmp.progress = parseInt(100.0 * evt.loaded / evt.total);
            }).success(function(data, status, headers, config) {
                if (callback){
                    callback(data, filetmp);
                }

                $rootScope.loading('hide');
                $mdToast.show(
                    $mdToast.simple()
                        .content('File uploaded')
                        .position($scope.getToastPosition())
                        .hideDelay(3000)
                );
                
            }).error(function(data, status, headers, config) {
                alert('There was an error while trying to upload file.');
                $scope.uploadingFile.loading = false;
                $rootScope.loading('hide');
            });
        };

        $rootScope.$on('dataLinkUploaded', function ($e, data){
            $scope.data.photos = $scope.data.photos || [];
            if (data.mode === 'create'){
                $scope.data.photos.unshift(data.data);
            }
            else{
                var index = _.findIndex($scope.data.photos, function(v){
                    return v.id === data.data.id
                });
                if (index === -1){
                    return ;
                }
                $scope.data.photos[index] = data.data;
            }
            $timeout(function(){
                renderMagnific();
            }, 700);
        });

        $scope.addYoutubeLink = function(object, ev) {
            if ($scope.mode === 'create'){
                if (!$scope.data.title){
                    $scope.data.title = 'Video Upload';
                }
                $scope.save(ev, function (){
                    $scope.mode = 'edit';
                    $scope.addYoutubeLink(object, ev);
                });
                return;
            }
            $mdDialog.show({
                controller: 'YouTubeDialogCtrl',
                templateUrl: '/templates/youtube-link',
                parent: angular.element(document.body),
                targetEvent: ev,
                locals: {
                    $current: object,
                    $data: {
                        imagable_type: 'Article',
                        imagable_id: $scope.data.id
                    },
                    $albums: $scope.albums
                }
            })
            .then(function(answer) {
                $scope.alert = 'You said the information was "' + answer + '".';
            }, function() {
                $scope.alert = 'You cancelled the dialog.';
            });
        };

        $rootScope.$on('dataLinkUploaded', function (ev, data){
            if (!data.photos){
                data.photos = [];
            }
            data.photos.push(data.data);
        });

        $scope.deletePhoto = function (item, ev){
            // Appending dialog to document.body to cover sidenav in docs app
            if (!item){
                return;
            }
            var confirm = $mdDialog.confirm()
                .parent(angular.element(document.body))
                .title('Delete this gallery?')
                .content('Are sure to do so? Once you deleted, you won\'t be able to retrieve it back!')
                .ariaLabel('Delete Media')
                .ok('Yes')
                .cancel('No')
                .targetEvent(ev);
            $mdDialog.show(confirm).then(function() {
                $rootScope.loading('show');
                CoResource.resources.Media.delete({
                    mediaId: item.id
                }, function (s){
                    $rootScope.loading('hide');
                    for(var i = $scope.data.photos.length - 1; i >= 0; i--){
                        if (item.id === $scope.data.photos[i].id){
                            $scope.data.photos.splice(i, 1);
                        }
                    }
                    $mdToast.show(
                        $mdToast.simple()
                            .content('Gallery removed')
                            .position($scope.getToastPosition())
                            .hideDelay(3000)
                    );
                }, function (e){
                    $rootScope.loading('hide');
                    alert('Sorry, this media cannot be deleted due to some reason, please contact administrator for more information');
                });
                
            }, function() {
            });
        };

        $scope.setPrimary = function (item, ev){
            // Appending dialog to document.body to cover sidenav in docs app
            if (!item){
                return;
            }
            for(var i = $scope.data.photos.length - 1; i >= 0; i--){
                if (item.id !== $scope.data.photos[i].id){
                    $scope.data.photos[i].is_primary = 0;
                }
            }
            item.is_primary= 1;
            $scope.data.primary_photo_id = item.id;
            $scope.save();
            $rootScope.loading('hide');
        };

        $scope.setPoster = function (item, ev){
            // Appending dialog to document.body to cover sidenav in docs app
            if (!item){
                return;
            }
            for(var i = $scope.data.photos.length - 1; i >= 0; i--){
                if (item.id !== $scope.data.photos[i].id){
                    $scope.data.photos[i].is_poster = 0;
                }
            }
            item.is_poster= 1;
            $scope.data.game_photo_id = item.id;
            $scope.save();
            $rootScope.loading('hide');
        };

        $scope.setBestVideo = function (item, ev){
            // Appending dialog to document.body to cover sidenav in docs app
            if (!item){
                return;
            }
            if (!item.is_best_video){
                CoResource.resources.Media.setBestVideo({
                    mediaId: item.id
                }, {}, function(s) {
                    item.is_best_video = true;
                    $mdToast.show(
                        $mdToast.simple()
                        .content('Video set as best')
                        .position($scope.getToastPosition())
                        .hideDelay(3000)
                    );
                }, function(e) {
                    alert('There was an error while trying to set your video. Error: ' + e.result);
                });
            }
            else{
                CoResource.resources.Media.unsetBestVideo({
                    mediaId: item.id
                }, {}, function(s) {
                    item.is_best_video = false;
                    $mdToast.show(
                        $mdToast.simple()
                        .content('Video has been unset as best')
                        .position($scope.getToastPosition())
                        .hideDelay(3000)
                    );
                }, function(e) {
                    alert('There was an error while trying to unset your video. Error: ' + e.result);
                });
            }
        };

        $scope.tags = CoResource.resources.Item.list({
            'type': 'tag',
            'ignore-offset': 1
        }, function(s) {
            $scope.tags = s.result;
        });

        $scope.products = CoResource.resources.Item.list({
            'parent_name': 'product',
            'type': 'category',
            'ignore-offset': 1
        }, function(s) {
            $scope.products = s.result;
            console.log(s.result);
        });


        // Tag functions
        
        $scope.select_tags = [];
        $scope.itemChange = function (v){

            $scope.select_tags = _.map($scope.select_tags, function(v){
                return _.isObject(v) ? v : {
                    display_name: v,
                    name: namespace.urlify(v)
                };
            });
        };  

        $scope.querySearch = function (query) {
            var results = query && _.isArray($scope.tags) ? _.filter($scope.tags, function (v){
                return v.display_name.toLowerCase().indexOf(query.toLowerCase()) > -1
            }) : [];
            return results;
        }

        // Solution for Product functions

        $scope.select_products = [];
        $scope.itemChangeProducts = function (v){

            $scope.select_products = _.filter($scope.select_products, function(v){
                return _.isObject(v);
            });
        };  

        $scope.querySearchProducts = function (query) {
            var results = query && _.isArray($scope.products) ? _.filter($scope.products, function (v){
                return v.display_name.toLowerCase().indexOf(query.toLowerCase()) > -1
            }) : [];
            return results;
        }

        $scope.gameTypes = [{
            id: 1,
            display_name: 'PC'
        }, {
            id: 2,
            display_name: 'PS4'
        }, {
            id: 3,
            display_name: 'XBox'
        }, {
            id: 4,
            display_name: 'Android/Tablet'
        }, {
            id: 5,
            display_name: 'iPhone/iPad'
        }, {
            id: 6,
            display_name: 'Console'
        }];

        $scope.select_gameTypes = [];
        $scope.itemGameTypeChange = function (model){
            $scope.select_gameTypes = _.map($scope.select_gameTypes, function(v){
                return _.isObject(v) ? v : {
                    display_name: v,
                    name: namespace.urlify(v)
                };
            });
            model = $scope.select_gameTypes;
        };  

        $scope.querySearchGameType = function (query) {
            var results = query && _.isArray($scope.gameTypes) ? _.filter($scope.gameTypes, function (v){
                return v.display_name.toLowerCase().indexOf(query.toLowerCase()) > -1
            }) : [];
            return results;
        }

        $scope.itemDownloadLinkChange = function (index, model){
            model.links = _.map(model.links, function(v){
                return _.isObject(v) ? v : {
                    display_name: v,
                    name: namespace.urlify(v)
                };
            });
        };  

        $scope.querySearchDownloadLink = function (query, index, model) {
            var results = query && _.isArray(model.links ) ? _.filter(model.links , function (v){
                return v.display_name.toLowerCase().indexOf(query.toLowerCase()) > -1
            }) : [];
            return results;
        }

        // Manific
        function renderMagnific(){
            $('.media-gallery .media.uploaded.photo').magnificPopup({
                type: 'image',
                removalDelay: 300,
                mainClass: 'mfp-with-zoom',
                delegate: 'span.icon-search', // the selector for gallery item,
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

            $('.media-gallery .media.uploaded.youtube').magnificPopup({
                disableOn: 700,
                type: 'iframe',
                mainClass: 'mfp-with-zoom',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: false,
                callbacks: {
                    open: function() {
                    },
                    close: function() {
                        this.wrap.removeClass('mfp-image-loaded');
                    },
                },
                delegate: 'span.icon-search', // the selector for gallery item,
            });
        }

    	
    });
}());