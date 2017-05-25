<?php


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// die('fuck');

$baseUrl=URL::to('/'); // baseUrl use every where with translate
$lang=LaravelLocalization::getCurrentLocale();
$langSeg = Request::segment(1);
$langSupported = array_map(function ($key, $value){
    return $key;
}, array_keys(Config::get('laravellocalization.supportedLocales')), Config::get('laravellocalization.supportedLocales'));

if (in_array($langSeg, $langSupported) == true ){
    $lang = $langSeg;
}
else{
    $lang = env('locale');
}
// LaravelLocalization::getLocalizedURL('kh')
// die(LaravelLocalization::getLocalizedURL('kh'));
if($lang==env('locale')) // check is lang now === default the url is normal without lang
    $baseUrlLang=URL::to('/');
else
    $baseUrlLang=URL::to('/' . $lang) ; // baseUrl use every where with translate


View::share('baseUrl',$baseUrl); // share baseUrl Normal(without language) to all view (globle)
View::share('baseUrlLang',$baseUrlLang); // share baseUrlLang (with language) to all view (globle)
View::share('lang',$lang); // share baseUrlLang (with language) to all view (globle)

// Public route group
Route::group(['prefix' => '', 'middleware' => ['web']], function()
{

	Route::get('/dashboard', ['middleware' => ['api.auth'], 'as' => 'dashboard', 'uses' => function () {
	    return view('dashboard.index');
	}]);

	Route::get('/dashboard/login', ['middleware' => ['api.guest'], 'as' => 'login', 'uses' => function () {
	    return view('dashboard.login');
	}]);

	Route::get('/dashboard/browse-media', function () {
	    return view('dashboard.browse-media');
	});
	Route::post('/dashboard/login', ['uses' => 'Auth\AuthController@login']);
	Route::get('/dashboard/signout', ['middleware' => ['api.auth'], 'uses' => 'Auth\AuthController@getLogout']);
	Route::get('/dashboard/api/signout', ['uses' => 'Auth\AuthController@getApiLogout']);

	Route::get('/partials/{name}', function ($name) {
	    return view('dashboard.partials.' . $name);
	});

	Route::get('/templates/{name}', function ($name) {
	    return view('dashboard.templates.' . $name);
	});

});


// API 

// @inuse in this dashboard version
// Public auth route group
Route::group(['prefix' => 'api/v1', 'namespace' => 'Auth', 'middleware' => []], function()
{
    Route::post('/login', ['uses' => 'AuthController@apiLogin']);
    // Route::post('/setup', ['uses' => 'AuthController@apiMerchantSetup']);

});
	

	Route::get('/', function () {

	    return view('frontend.innovation.map');
	   
	});

	// Route::get('table', function () {
		// HungryModule::cacheDataFilter();  
	Route::get('/map','HomeController@map'); 
		Route::get('/table','HomeController@table'); 
	    
	   
	// });

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([

        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localize' ] // Route translate middleware

],function(){

 // 	Route::get('/', function () {
	//     return view('frontend.index');
	// });
	Route::get('/', function () {
	    return view('frontend.innovation.map');
	   
	});
	Route::get('/', function () {
	    return view('frontend.innovation.table');
	   
	});
	// Route::get('/contact-us', function () {
	//     return view('frontend.contact-us',array('hide_subcription'=>true));
	// });

	// Route::get('/terms-privacy', function () {
	//     return view('frontend.terms-privacy',array('hide_subcription'=>true));
	// });

	// Route::get('/', function () {
	//     return view('frontend.home');
	// });

    // Route::post('/send-mail', 'HomeController@sendMailContact');

	// Route::get('/','HomeController@index'); 

	// Route::get('/select-hotel','HomeController@selectHotel'); 

	// Route::get('/hotel/{id}-{name}','HomeController@hotelDetail'); 
 	// Route::get('/hotel/{id}-{name}','HomeController@hotelDetail'); 

	// Route::get('/booking-success', function () {
	//     return view('frontend.review',array('is_success'=>true));
	// });

	// Route::any('/booking-search','HomeController@bookingSearch');


	// Route::any('/booking/{id}','HomeController@myBooking');


	//  alba test

	// Route::get('/sheet-api', function () {
	//     return view('frontend.sheet-api');
	// });
	// Route::get('/move-file', function () {
	//     return view('frontend.move-file');
	// });
	// Route::get('/drive-picker', function () {
	//     return view('frontend.drive-picker');
	// });
	// Route::get('/get-file-to-drive', function () {
	//     return view('frontend.upload-file-to-drive');
	// });

 //    Route::get('/upload-file','HomeController@uploadFile');


});