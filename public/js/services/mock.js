(function (){
	app
		.service('MockService', function ($timeout, $http, $window){
			var $remoteUrl = location.protocol + '//' + document.domain + ":" + (location.port || '80') + "/api/v1.1/";
			function guid() {
			  	function s4() {
			    	return Math.floor((1 + Math.random()) * 0x10000)
			      	.toString(16)
			      	.substring(1);
			  	}
			  	return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
			    s4() + '-' + s4() + s4() + s4();
			}

			function write(data, name){
				localStorage[name] = angular.toJson(data);
			}
			function read(name){
				if (localStorage[name]){
					return angular.fromJson(localStorage[name]);
				}
				else{
					return null;
				}
			}
			// Variable
			var $data = {
				posts: read('posts') || [],
				pages: read('pages') || [],
				albums: read('albums') || [],
				menu: read('menu') || [],
				types: read('types') || [],
				categories: read('categories') || []
			};
			// Load data

			return {
				posts: {
					store: function (data){
						data.id = guid();
						$data.posts.push(data);
						write($data.posts, 'posts');
						return data;
					},
					update: function (data){
						if (data.id){
							for(var key in $data.posts){
								if ($data.posts[key].id == data.id){
									$data.posts.splice(key, 1, data);
								}
							}
							write($data.posts, 'posts');
						}
					},
					get: function (id){
						return _.where($data.posts, {id: id});
					},
					list: function (){
						return read('posts') || [];
					}
				},
				albums: {
					store: function (data){
						var old = _.where($data.posts, {name: data.name});
						if (old.length <= 0){
							data.id = guid();
							$data.albums.push(data);
							write($data.albums, 'albums');
							return data;
						}
						return old[0];
					},
					list: function (){
						return read('albums') || [];
					}
				},
				menu: {
					store: function (data){
						data.id = guid();
						$data.menu.push(data);
						write($data.menu, 'menu');
						return data;
					},
					update: function (data){
						if (data.id){
							for(var key in $data.menu){
								if ($data.menu[key].id == data.id){
									$data.menu.splice(key, 1, data);
								}
							}
							write($data.menu, 'menu');
						}
					},
					list: function (){
						return read('menu') || [];
					},
					where: function (condition){
						return _.where($data.menu, condition);
					},
					remove: function (id){
						var item = _.where($data.menu, {
							id: id
						});
						if (item && item[0]){
							var index = $data.menu.indexOf(item[0]);
							$data.menu.splice(index, 1);
							write($data.menu, 'menu');
						}
					}
				},
				pages: {
					list: function (){
						return read('pages') || [];
					},
					remote: {
						list: function(){
							return $http
								.get($remoteUrl + 'sites/pages');
						},
						store: function (data){
							return $http
								.post($remoteUrl + 'sites/pages', data);
						},
						update: function (data){
							return $http
								.put($remoteUrl + 'sites/pages/' + data['page-name'], data);
						}
					}
				},
				types: {
					list: function (){
						return read('types') || [];
					},
					store: function (data){
						data.id = guid();
						$data.types.push(data);
						write($data.types, 'types');
						return data;
					},
					update: function (data){
						if (data.id){
							for(var key in $data.types){
								if ($data.types[key].id == data.id){
									$data.types.splice(key, 1, data);
								}
							}
							write($data.types, 'types');
						}
					},
					get: function (id){
						return _.where($data.types, {
							id: id
						})[0];
					},
					remove: function (id){
						for(var key in $data.types){
							if ($data.types[key].id == id){
								$data.types.splice(key, 1);
							}
						}
						write($data.types, 'types');
					}
				},
				categories: {
					list: function (){
						return read('categories') || [];
					},
					store: function (data){
						data.id = guid();
						$data.categories.push(data);
						write($data.categories, 'categories');
						return data;
					},
					update: function (data){
						if (data.id){
							for(var key in $data.categories){
								if ($data.categories[key].id == data.id){
									$data.categories.splice(key, 1, data);
								}
							}
							write($data.categories, 'categories');
						}
					},
					remove: function (id){
						for(var key in $data.categories){
							if ($data.categories[key].id == id){
								$data.categories.splice(key, 1);
							}
						}
						write($data.categories, 'categories');
					}
				}
			};
		});
}());
