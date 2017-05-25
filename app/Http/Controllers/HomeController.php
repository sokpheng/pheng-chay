<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Http\Requests;
use Mail;
use \Session;
use \Google;
// use \PulkitJalan\Google\Client;
use \RequestGateway;
use \AuthGateway;
use \HungryModule;
use \URL;
use App\Mail\contact;
use \Response;


class HomeController extends Controller{

  //   public function index(){
  //   	return view('layouts.default');
 	// }

 	public function table(){

        try{
			HungryModule::cacheDataFilter();

            $tableData = RequestGateway::get("v1/startups?mode=specials&tags=", array());
            // $filterData = RequestGateway::get("/v1/startups?mode=specials&tags=education,information-technology", array());
            // echo '<pre>'. print_r($tableData,true).'</pre>'; die();
           if(isset($tableData['responseText']['status']) && $tableData['responseText']['status']!='error'){

           		return view('frontend.innovation.table',array('tableData'=>$tableData['responseText']['result']));

           }

            return view('frontend.innovation.table');

        }catch(\Exception $e){
            print_r($e->getMessage()); 
            die();
        }

 		
 	}

 	public function map(){
 		// die('wowowo');

        try{
			HungryModule::cacheDataFilter();

            $mapData = RequestGateway::get("v1/startups?mode=special&tags=", array());
            // $filterData = RequestGateway::get("/v1/startups?mode=specials&tags=education,information-technology", array());
            // echo '<pre>'. print_r($mapData,true).'</pre>'; die();
           if(isset($mapData['responseText']['status']) && $mapData['responseText']['status']!='error'){

           		return view('frontend.innovation.map',array('mapData'=>$mapData['responseText']['result']));

           }

            return view('frontend.innovation.map',array('mapData'=>[]));

        }catch(\Exception $e){
            print_r($e->getMessage()); 
            die();
        }
 		
 	}

 	// booking search & store it in session

 	public function bookingSearch(){

		try{

			$input = Input::all();

			// echo '<pre>'. print_r($input,true).'</pre>'; die(); 

			HungryModule::getBookingSearchInfo();

			HungryModule::storeBookingSearchInfo($input);

			// echo '<pre>'. print_r($urlLang,true).'</pre>'; die(); 

			if(isset($input['re']))
				return redirect($input['re']);
			else
				return redirect(HungryModule::getLang().'/select-hotel');


		}catch(\Exception $e){
			
			// print_r($e->getMessage()); die();

			return Response::view('errors.404',
				array(
					'canonical' => URL::to('/'),
					'menuTitle' => '',
					'web_title'	=> 'Page not found',
					// 'rest_type' => $type,
					'emptyData'	=> true,
					'restuarntInfo'	=> [],
					'isSearchOnMenu' => true,
					// 'lang' => LaravelLocalization::getCurrentLocale()
				)
			, 404);

      	}

 	}


 	public function index(){
 		HungryModule::getBookingSearchInfo();

		return view('frontend.home', 
						array(
							'canonical' => URL::to('/'),
							'menuTitle' => 'Home',
							// 'lang' => LaravelLocalization::getCurrentLocale(),
							'product'	=> [],
							// 'newArrival'	=> $newArrival
						)
					);
 	}


 	// select hotel page
 	public function selectHotel(){


		try{

			$input = Input::all();

			// echo '<pre>'. print_r(config('seo_config.defaults._desc'),true).'</pre>'; die(); 

			HungryModule::getBookingSearchInfo();

			return view('frontend.select-hotel', 
							array(
								'description'=>'Search and select your hotel for your relax time & holiday. ' . config('seo_config.defaults._desc'),
								'web_title' => 'Search hotel in city and privince in Cambodia',
								'canonical' => URL::to('/'),
								'menuTitle' => 'Home',
								// 'lang' => LaravelLocalization::getCurrentLocale(),
								'product'	=> [],
								// 'newArrival'	=> $newArrival
							)
						);

		}catch(\Exception $e){
			
			// print_r($e->getMessage()); die();

			return Response::view('errors.404',
				array(
					'canonical' => URL::to('/'),
					'menuTitle' => '',
					'web_title'	=> 'Page not found',
					'emptyData'	=> true,
					'restuarntInfo'	=> [],
					'isSearchOnMenu' => true,
					// 'lang' => LaravelLocalization::getCurrentLocale()
				)
			, 404);

      	}

 	}


 	// select hotel page
 	public function hotelDetail($hotelId, $hotelName){



		try{

			$input = Input::all();

			// echo '<pre>'. print_r($input,true).'</pre>'; die(); 

			HungryModule::getBookingSearchInfo();

			$hotelInfo = RequestGateway::get('v1/hotels/'.$hotelId.'?&populate=cover', array());

			// echo '<pre>'. print_r($hotelInfo,true).'</pre>'; die(); 
				
			$desc = $hotelName.' - '.config('seo_config.defaults._desc');

			 // $hotelInfo

			if(HungryModule::emptyDataFromApi($hotelInfo)){
				$hotelInfo = $hotelInfo['responseText']['result'];
				$desc = $hotelInfo['description'];

				return view('frontend.review', 
							array(
								'description' => $desc,
								'imgSEO' => $hotelInfo['cover_media']['preview_url_link'],
								'web_title' => $hotelInfo['name'],
								'canonical' => URL::to('/'),
								'menuTitle' => 'Home',
								// 'lang' => LaravelLocalization::getCurrentLocale(),
								'product'	=> [],
								'hotelId'	=> $hotelId,
								'hotelName'	=> $hotelName,
								// 'newArrival'	=> $newArrival
							)
						);

			}
			else{
				throw new Exception('Cannot Connect To The API');
			}

		}catch(\Exception $e){
			
			// print_r($e->getMessage()); die();

			return Response::view('errors.404',
				array(
					'canonical' => URL::to('/'),
					'menuTitle' => '',
					'web_title'	=> 'Page not found',
					'emptyData'	=> true,
					'restuarntInfo'	=> [],
					'isSearchOnMenu' => true,
					// 'lang' => LaravelLocalization::getCurrentLocale()
				)
			, 404);

      	}

 	}

 	// select hotel page
 	public function myBooking($bookingId){


		try{

			$input = Input::all();

			// echo '<pre>'. print_r($input,true).'</pre>'; die(); 

	        if(isset($input['s']) && $input['s']==1){ // s=1 it mean booking success so remove session for search hotel
	            Session::forget('bookingSearchInfo');
	        }
	        else{

				HungryModule::getBookingSearchInfo();

			}


			$hotelInfo = RequestGateway::get('v1/booking/'.$bookingId, array());

			// echo '<pre>'. print_r($hotelInfo,true).'</pre>'; die(); 


			if(HungryModule::emptyDataFromApi($hotelInfo)){
				$hotelInfo = $hotelInfo['responseText']['result'];

				$hotelName = $hotelInfo['room_type']['hotel']['name'];
					
				$desc = $hotelName.' - '.config('seo_config.defaults._desc');

				$desc = $hotelInfo['room_type']['hotel']['description'];


				return view('frontend.review', 
							array(
								'noSearchEngine' => true,
								'imgSEO' => $hotelInfo['room_type']['hotel']['cover_media']['preview_url_link'],
								'description'=> $desc,
								'web_title' => $hotelName,
								'canonical' => URL::to('/'),
								'menuTitle' => 'Home',
								// 'lang' => LaravelLocalization::getCurrentLocale(),
								'product'	=> [],
								'bookingId'	=> $bookingId,
								// 'hotelName'	=> $hotelName,
								// 'newArrival'	=> $newArrival
							)
						);

			}
			else{
				throw new Exception('Cannot Connect To The API');
			}

		}catch(\Exception $e){
			
			print_r($e->getMessage()); die();

			return Response::view('errors.404',
				array(
					'canonical' => URL::to('/'),
					'menuTitle' => '',
					'web_title'	=> 'Page not found',
					'emptyData'	=> true,
					'restuarntInfo'	=> [],
					'isSearchOnMenu' => true,
					// 'lang' => LaravelLocalization::getCurrentLocale()
				)
			, 404);

      	}

 	}


	public function sendMailContact(Request $request){

		$inputAll=Input::all();

        // $client = new \GuzzleHttp\Client();
        // $client->setDefaultOption('verify', false);

		// echo '<pre>'. print_r($inputAll,true).'</pre>'; die(); 

		try{
			// Validate input
			if (Input::get('name') && 
				Input::get('email') && 
				Input::get('phone') && 
				Input::get('message'))
			{

				Mail::to(env('CONTACT_MAIL','panhaseng12@gmail.com'))->send(new contact);

				$inputAll = [];
				$inputAll['error_msg'] = 'Thank you! Your submission is complete';
				$inputAll['error_type'] = 'success';
				
				// echo '<pre>'. print_r($inputAll,true).'</pre>'; die(); 

				return redirect(HungryModule::getLang().'/contact-us')->with($inputAll);
			}
			else{
				$inputAll = Input::all();
				$inputAll['error_msg'] = 'Sorry, you have not filled all information required.';
				$inputAll['error_type'] = 'error';
				return redirect(HungryModule::getLang().'/contact-us')->with($inputAll);
			}

		}
		catch (\Exception $e){	
			$inputAll = Input::all();
			$inputAll['error_msg'] = 'Something\'s wrong with sending email to us! ' . $e->getMessage();
			$inputAll['error_type'] = 'error';
			// echo '<pre>'. print_r($inputAll,true).'</pre>'; die(); 
			return redirect(HungryModule::getLang().'/contact-us')->with($inputAll);
		}

	}


}
