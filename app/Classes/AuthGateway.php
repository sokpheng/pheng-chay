<?php

namespace App\Classes;

use \Agent;
use \Log;
use \Session;
use \Cookie; 
use \Meta; 
use \Cache;
use \View;

class AuthGateway {

    

    public function login($userData){
        Session::put('user', $userData);
    }

    public function update($data){
        if ($this->isLogin()){
            $user = $this->user();    
            $data['access_token'] = $user['access_token'];
            $this->login($data);
        }        
    }

    public function updateInfo($data){
        if ($this->isLogin()){
            $user = $this->user();    
            $user['profile']['photo'] = $data;
            $this->login($user);
        }        
    }

    public function updateToken($data){
        if ($this->isLogin()){
            $user = $this->user();    
            $user['access_token'] = $data;
            $this->login($user);
        }        
    }

    public function user(){
        $user = Session::get('user');
        // echo '<pre>'.print_r(json_encode( $user) ,true).'</pre>'; die();
        return $user;
    }

    public function userIgnoreToken(){
        if ($this->isLogin()){
            $user = Session::get('user');
            unset($user['access_token']);
            return $user;            
        }
    }

    public function getProperty($properties, $user = null){

        if (!$this->isLogin()){
            return '';
        }

        if ($user == null){
            $user = $this->user();
        }
  
        $split = explode('.', $properties);
        $value = '';
        if (count($split) <= 0){
            return '';
        }
        $value = $split[0];
        unset($split[0]);
        if (!isset($user[$value])){
            return '';
        }
        if (is_array($user[$value]) && count($split) > 0){
            return $this->getProperty(implode('.', $split), $user[$value]);
        }
        else{
            return $user[$value];
        }

    }

    public function isLogin(){
        $user = $this->user();
        if ( is_array($user) && isset($user['id']) && isset($user['access_token']) ){
            return true;
        }
        else{
            return false;
        }
    }

    public function logout(){
        Session::forget('user');
        // Session::flush();
    }

    public function checkRole($userRole){
        $chk = false;
        if(AuthGateway::isLogin()){
            $profile = AuthGateway::user();
            return $profile['role']['name'] == $userRole;
        }
        return $chk;   
    }

    /* ADMIN PART */

    public function isAdminLogin(){
        $user = $this->admin();
        if ( is_array($user) && isset($user['id']) && isset($user['access_token']) ){
            return true;
        }
        else{
            return false;
        }
    }


    public function loginAdmin($userData){
        Session::put('admin', $userData);
    }

    public function updateAdmin($data){
        if ($this->isAdminLogin()){
            $user = $this->admin();    
            $data['access_token'] = $user['access_token'];
            $this->login($data);
        }        
    }

    public function updateAdminToken($data){
        if ($this->isAdminLogin()){
            $user = $this->admin();    
            $user['access_token'] = $data;
            $this->login($user);
        }        
    }

    public function admin(){
        $user = Session::get('admin');
        // echo '<pre>'.print_r(json_encode( $user) ,true).'</pre>'; die();
        return $user;
    }

    public function userAdminIgnoreToken(){
        if ($this->isAdminLogin()){
            $user = Session::get('admin');
            unset($user['access_token']);
            return $user;            
        }
    }

    public function getPropertyAdmin($properties, $user = null){

        if (!$this->isAdminLogin()){
            return '';
        }

        if ($user == null){
            $user = $this->admin();
        }
  
        $split = explode('.', $properties);
        $value = '';
        if (count($split) <= 0){
            return '';
        }
        $value = $split[0];
        unset($split[0]);
        if (!isset($user[$value])){
            return '';
        }
        if (is_array($user[$value]) && count($split) > 0){
            return $this->getProperty(implode('.', $split), $user[$value]);
        }
        else{
            return $user[$value];
        }

    }

    public function logoutAdmin(){
        Session::forget('admin');
        // Session::flush();
    }

    public function checkRoleAdmin($userRole){
        $chk = false;
        if(AuthGateway::isAdminLogin()){
            $profile = AuthGateway::admin();
            return $profile['role']['name'] == $userRole;
        }
        return $chk;   
    }

    /* END ADMIN PART */

    public function checkUserAdmin(){
        return $this->checkRole('admin');
    }

    public function checkUserMerchant(){
        return $this->checkRole('merchant');
    }


    // ultility function
    public function getDollarSimbol($price_rate_val){

        $price_rate = '';
        for ($i=1; $i<=$price_rate_val;$i++) { 
            $price_rate .= '$';
        }
        if($price_rate == '')
            $price_rate = '$$$';

        return $price_rate;

    }


    // cache some data of home page
    public function cacheDataHome(){
        try{
            // Cache::forget('cache_rest_section');
            if (!Cache::has('cache_rest_section')){
                // die();
                $restSection = RequestGateway::get("/directories/home?limit=12", array());
                // echo '<pre>'. print_r($restSection['newRes'],true).'</pre>'; die();
               if(isset($restSection['responseText']['status']) && $restSection['responseText']['status']!='error'){

                    $restSection = $restSection['responseText']['result'];
                    if(sizeof($restSection)>0){
                        // store all category to cache in one day
                        $expiresAt = 1440;
                        Cache::put('cache_rest_section', $restSection, $expiresAt);
                    }
                    // echo '<pre>'. print_r($restSection['newRes'],true).'</pre>'; die();
                    View::share('restSection',$restSection); // share var to all view (globle)

               }
            }
            else{

                // get data from cache
                $restSection = Cache::get('cache_rest_section');
                // echo '<pre>'. print_r(sizeof($restSection),true).'</pre>'; die();
                // if something error when get data remove the cache and redirect to get data again
                if(sizeof($restSection)<=0){
                    Cache::forget('cache_rest_section');
                    Redirect::to('/');
                }
                // echo '<pre>'. print_r($restSection['recomendations'],true).'</pre>'; die();
                View::share('restSection', $restSection); // share var to all view (globle)
            }

        }catch(\Exception $e){
            print_r($e->getMessage()); 
            // die();
        }

    }

    // cauch data on second section top-category
    public function cacheDataHomeTopCate(){
        try{
            // Cache::forget('cache_rest_section');
            if (!Cache::has('cache_top_cate_home')){
                // die();
                $topCategoryHome = RequestGateway::get("/directories/home/menu?limit=15", array());
                // echo '<pre>'. print_r($topCategoryHome,true).'</pre>'; die();
               if(isset($topCategoryHome['responseText']['status']) && $topCategoryHome['responseText']['status']!='error'){

                    $topCategoryHome = $topCategoryHome['responseText']['result'];
                    if(sizeof($topCategoryHome)>0){
                        // store all category to cache in one day
                        $expiresAt = 1440;
                        Cache::put('cache_top_cate_home', $topCategoryHome, $expiresAt);
                    }
                    // echo '<pre>'. print_r($topCategoryHome['newRes'],true).'</pre>'; die();
                    View::share('topCategoryHome',$topCategoryHome); // share var to all view (globle)

               }
               else{
                    View::share('topCategoryHome', []);
               }
            }
            else{

                // get data from cache
                $topCategoryHome = Cache::get('cache_top_cate_home');
                // echo '<pre>'. print_r(sizeof($topCategoryHome),true).'</pre>'; die();
                // if something error when get data remove the cache and redirect to get data again
                if(sizeof($topCategoryHome)<=0){
                    Cache::forget('cache_top_cate_home');
                    Redirect::to('/');
                }
                // echo '<pre>'. print_r($topCategoryHome['recomendations'],true).'</pre>'; die();
                View::share('topCategoryHome', $topCategoryHome); // share var to all view (globle)
            }

        }catch(\Exception $e){
            // print_r($e->getMessage()); 
            View::share('topCategoryHome', []);
            // die();
        }

    }

    // cache data on category section
    public function cacheDataCategory(){
        try{
            // Cache::forget('cache_category');
            if (!Cache::has('cache_category')){
                // die();
                $categories = RequestGateway::get("/dimensions/category", array());
                // echo '<pre>'. print_r($categories,true).'</pre>'; die();
               if(isset($categories['responseText']['status']) && $categories['responseText']['status']!='error'){

                    $categories = $categories['responseText']['result'];
                    if(sizeof($categories)>0){
                        // store all category to cache in one day
                        $expiresAt = 1440;
                        Cache::put('cache_category', $categories, $expiresAt);
                    }
                    // echo '<pre>'. print_r($categories['newRes'],true).'</pre>'; die();
                    View::share('categories',$categories); // share var to all view (globle)

               }
               else{
                    View::share('categories', []);
               }
            }
            else{

                // get data from cache
                $categories = Cache::get('cache_category');
                // echo '<pre>'. print_r($categories,true).'</pre>'; die();
                // if something error when get data remove the cache and redirect to get data again
                if(sizeof($categories)<=0){
                    Cache::forget('cache_category');
                    Redirect::to('/');
                }
                // echo '<pre>'. print_r($categories['recomendations'],true).'</pre>'; die();
                View::share('categories', $categories); // share var to all view (globle)
            }

        }catch(\Exception $e){
            // print_r($e->getMessage()); 
            View::share('categories', []);
            // die();
        }

    }


}
