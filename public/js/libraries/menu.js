(function() {
    namespace.menus = [{
            name: 'Hotel-engine',
            text: 'Hotel Engine',
            items: [{
                    name: 'Hotels',
                    extraScreen: 'hotels',
                    icon: 'icon-office',
                    enabled: true,
                    path: '/'
                },
                {
                    name: 'Bookings',
                    extraScreen: 'bookings',
                    icon: 'icon-bubbles4',
                    enabled: true,
                    path: '/bookings'
                }
                // {
                // 	name: 'Locations',
                // 	extraScreen: 'locations',
                // 	icon: 'icon-map',
                // 	enabled: true,
                // 	path: '/locations'
                // }
            ]
        },
        /*{
        		name: 'coupon-engine',
        		text: 'Coupon & Advertisement',
        		items: [
        	        {
        	        	name: 'Coupons',
        	        	extraScreen: 'coupons',
        	        	icon: 'icon-gift',
        	        	enabled: true,
        	        	path: '/coupons'
        	        },
        	        {
        	        	name: 'Promotions',
        	        	extraScreen: 'coupons',
        	        	icon: 'icon-gift',
        	        	enabled: true,
        	        	path: '/promotions'
        	        },
        	        {
        	        	name: 'Advertisements',
        	        	extraScreen: 'advertisements',
        	        	icon: 'icon-rocket',
        	        	enabled: true,
        	        	path: '/advertisements'
        	        }
        	    ]
        	},*/
        /*{
		name: 'post-engine',
		text: 'Post Engine',
		items: [
	        {
	        	name: 'Create new',
	        	extraScreen: 'Create menu',
	        	icon: 'icon-quill',
	        	enabled: true,
	        	path: '/posts/create'
	        },
	        { name: 'My posts', extraScreen: 'My post menu', icon: 'icon-book', enabled: false, path: '/posts' },
	        // { name: 'Pages', extraScreen: 'Create page', icon: 'icon-stack', enabled: true, path: '/pages' },
	        { name: 'Media', extraScreen: 'Media menu', icon: 'icon-images', enabled: true, path: '/media' },
	    ]
	}, {
		name: 'news-engine',
		text: 'News Engine',
		items: [
	        {
	        	name: 'Create Article',
	        	extraScreen: 'Create Article',
	        	icon: 'icon-quill',
	        	enabled: true,
	        	path: '/articles/create',
	        	event: function ($rootScope){
	        		$rootScope.createNewArticle();
	        	}
	        },
	        { name: 'My articles', extraScreen: 'My articles', icon: 'icon-book', enabled: false, path: '/articles' },
	        { name: 'Collections', extraScreen: 'Collections', icon: 'icon-books', enabled: false, path: '/collections' }
	    ]
	}, */
        /*{
        	name: 'layout-engine',
        	text: 'Layout Engine',
        	items: [
                { name: 'Manage Cuisine', extraScreen: 'Manage origin', icon: 'icon-leaf', enabled: true, path: '/dimensions/origin'},
                { name: 'Manage Purpose', extraScreen: 'Manage category', icon: 'icon-tree', enabled: false, path: '/dimensions/category' },
                { name: 'Manage Feature', extraScreen: 'Manage feature', icon: 'icon-lab', enabled: false, path: '/dimensions/feature' },
                { name: 'Manage Time', extraScreen: 'Manage menu', icon: 'icon-spoon-knife', enabled: false, path: '/dimensions/food' },
                { name: 'Manage Category', extraScreen: 'Manage foods', icon: 'icon-mug', enabled: false, path: '/dimensions/drink' },
                { name: 'Manage Payment methods', extraScreen: 'Manage payment methods', icon: 'icon-credit-card', enabled: false, path: '/dimensions/payment_method' },
                { name: 'Manage Parkings', extraScreen: 'Manage parkings', icon: 'icon-truck', enabled: false, path: '/dimensions/parking' },
            ]
        },*/
        /*
        {
        	name: 'customer-engine',
        	text: 'Customer Relation',
        	items: [
                {
                	name: 'Customers',
                	extraScreen: 'customers',
                	icon: 'icon-accessibility',
                	enabled: true,
                	path: '/customers'
                },
                {
                	name: 'Feedback',
                	extraScreen: 'feedbacks',
                	icon: 'icon-lifebuoy',
                	enabled: true,
                	path: '/feedback'
                },
              
                { name: 'Media', extraScreen: 'Media menu', icon: 'icon-images', enabled: true, path: '/media' },
            ]
        },
        */
        {
            name: 'settings',
            text: 'Settings',
            items: [
                // { name: 'Message', extraScreen: 'Message information', icon: 'icon-mail3', enabled: true, path: '/messages' },
                //{ name: 'Your account', extraScreen: 'Your account', icon: 'icon-user', enabled: false, path: '/account' },
                {
                    name: 'Sign out',
                    extraScreen: 'Sign out',
                    icon: 'icon-lock',
                    enabled: false,
                    path: '/signout',
                    'event': function($scope) {
                        $scope.logout();
                    }
                }
            ]
        }
    ];
}());