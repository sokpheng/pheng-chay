<?php

namespace App\Classes;

use \Agent;
use \Log;
use \Session;
use \Cookie; 
use \Meta; 
use \Cache;
use \View;
use \Request;
use \Config;
use \Redirect; 
use \URL; 
use \LaravelLocalization;

class HungryModule extends RequestGateway{


    public function cacheDataFilter(){

        try{
            Cache::forget('filter_data');
            if (!Cache::has('filter_data')){
                // die();
                $filterData = RequestGateway::get("v1/startups/menu/items", array());
                // echo '<pre>'. print_r($filterData,true).'</pre>'; die();
               if(isset($filterData['responseText']['status']) && $filterData['responseText']['status']!='error'){

                    $filterData = $filterData['responseText']['result'];
                    if(sizeof($filterData)>0){
                        // store all category to cache in one day
                        $expiresAt = 1440;
                        Cache::put('filter_data', $filterData, $expiresAt);
                    }
                    // echo '<pre>'. print_r($filterData['newRes'],true).'</pre>'; die();
                    View::share('filterData',$filterData); // share var to all view (globle)

               }
               else{
                    View::share('filterData',[]); // share var to all view (globle)
               }
            }
            else{

                // get data from cache
                $allCategory = Cache::get('filter_data');
                // echo '<pre>'. print_r($allCategory,true).'</pre>'; die();
                // if something error when get data remove the cache and redirect to get data again
                if(sizeof($allCategory)<=0){
                    Cache::forget('filter_data');
                    Redirect::to('/');
                }
                // echo '<pre>'. print_r($allCategory['recomendations'],true).'</pre>'; die();
                View::share('filterData', $allCategory); // share var to all view (globle)
                
            }

        }catch(\Exception $e){
            print_r($e->getMessage()); 
            die();
        }

    }


    

    // ============================= cache =======================
    // cache some data of all category of product
    public function cacheDataCategory(){

        try{
            // Cache::forget('all_category');
            if (!Cache::has('all_category')){
                // die();
                $allCategory = RequestGateway::get("/categories?cache=0", array());
                // echo '<pre>'. print_r($allCategory,true).'</pre>'; die();
               if(isset($allCategory['responseText']['status']) && $allCategory['responseText']['status']!='error'){

                    $allCategory = $allCategory['responseText']['result'];
                    if(sizeof($allCategory)>0){
                        // store all category to cache in one day
                        $expiresAt = 1440;
                        Cache::put('all_category', $allCategory, $expiresAt);
                    }
                    // echo '<pre>'. print_r($allCategory['newRes'],true).'</pre>'; die();
                    View::share('allCategory',$allCategory); // share var to all view (globle)

               }
               else{
                    View::share('allCategory',[]); // share var to all view (globle)
               }
            }
            else{

                // get data from cache
                $allCategory = Cache::get('all_category');
                // echo '<pre>'. print_r($allCategory,true).'</pre>'; die();
                // if something error when get data remove the cache and redirect to get data again
                if(sizeof($allCategory)<=0){
                    Cache::forget('all_category');
                    Redirect::to('/');
                }
                // echo '<pre>'. print_r($allCategory['recomendations'],true).'</pre>'; die();
                View::share('allCategory', $allCategory); // share var to all view (globle)
                
            }

        }catch(\Exception $e){
            print_r($e->getMessage()); 
            die();
        }

    }

    // ============================= cache =======================
    // cache some data of category with some of product for tab
    public function cacheDataCategoryProduct(){

        try{

            // Cache::forget('all_category_with_product');

            if (!Cache::has('all_category_with_product')){
                // die();
                $allCategoryWithPro = RequestGateway::get("/categories/posts?limit=10&offset=0&limit_item=9&offset_item=0", array());
                // echo '<pre>'. print_r($allCategoryWithPro,true).'</pre>'; die();
               if(isset($allCategoryWithPro['responseText']['status']) && $allCategoryWithPro['responseText']['status']!='error'){

                    $allCategoryWithPro = $allCategoryWithPro['responseText']['result'];

                    if(sizeof($allCategoryWithPro)>0){
                        // store all category to cache in one day
                        $expiresAt = 1440;
                        Cache::put('all_category_with_product', $allCategoryWithPro, $expiresAt);
                    }

                    // echo '<pre>'. print_r($allCategoryWithPro['newRes'],true).'</pre>'; die();
                    View::share('allCategoryWithPro',$allCategoryWithPro); // share var to all view (globle)

               }
               else{
                    View::share('allCategoryWithPro',[]); // share var to all view (globle)
               }
            }
            else{

                // get data from cache
                $allCategoryWithPro = Cache::get('all_category_with_product');
                // echo '<pre>'. print_r($allCategoryWithPro,true).'</pre>'; die();
                // if something error when get data remove the cache and redirect to get data again
                if(sizeof($allCategoryWithPro)<=0){
                    Cache::forget('all_category_with_product');
                    Redirect::to('/');
                }
                // echo '<pre>'. print_r($allCategoryWithPro['recomendations'],true).'</pre>'; die();
                View::share('allCategoryWithPro', $allCategoryWithPro); // share var to all view (globle)
                
            }

        }catch(\Exception $e){
            print_r($e->getMessage()); 
            die();
        }

    }
    // ============================= cache =======================
    // cache some data of category with some of product for tab
    public function cacheDataBrand(){

        try{

            // Cache::forget('all_brand');

            if (!Cache::has('all_brand')){
                // die();
                $allBrand = RequestGateway::get("/brands?cache=0&scope=primary_photo", array());
                // echo '<pre>'. print_r($allBrand,true).'</pre>'; die();
               if(isset($allBrand['responseText']['status']) && $allBrand['responseText']['status']!='error'){
 
                    $allBrand = $allBrand['responseText']['result'];

                    if(sizeof($allBrand)>0){
                        // store all category to cache in one day
                        $expiresAt = 1440;
                        Cache::put('all_brand', $allBrand, $expiresAt);
                    }

                    // echo '<pre>'. print_r($allBrand['newRes'],true).'</pre>'; die();
                    View::share('allBrand',$allBrand); // share var to all view (globle)

               }
               else{
                    View::share('allBrand',[]); // share var to all view (globle)
               }
            }
            else{

                // get data from cache
                $allBrand = Cache::get('all_brand');
                // echo '<pre>'. print_r($allBrand,true).'</pre>'; die();
                // if something error when get data remove the cache and redirect to get data again
                if(sizeof($allBrand)<=0){
                    Cache::forget('all_brand');
                    Redirect::to('/');
                }
                // echo '<pre>'. print_r($allBrand['recomendations'],true).'</pre>'; die();
                View::share('allBrand', $allBrand); // share var to all view (globle)
                
            }

        }catch(\Exception $e){
            print_r($e->getMessage()); 
            die();
        }

    }

    // put booking search to session & replace new info if it's already has
    public function storeBookingSearchInfo($input){

        $chkExisted = Session::get('bookingSearchInfo',array());
        // echo '<pre>'. print_r($chkExisted,true).'</pre>'; die(); 

        if($chkExisted){
            // echo 'have';
            Session::forget('bookingSearchInfo');
        }
        

        Session::put('bookingSearchInfo', $input);

        // $chkAgain = Session::get('bookingSearchInfo',array());
        // echo '<pre>'. print_r($chkExisted,true).'</pre>'; die(); 

    }

    // get booking search to session & share it !!
    public function getBookingSearchInfo(){

        $chkExisted = Session::get('bookingSearchInfo',array());
        // echo '<pre>'. print_r($chkExisted,true).'</pre>'; die(); 

        // Session::put('bookingSearchInfo', $input);
        
        View::share('bookingSearchInfo',$chkExisted); // share var to all view (globle)

        // $chkAgain = Session::get('bookingSearchInfo',array());
        // echo '<pre>'. print_r($chkExisted,true).'</pre>'; die(); 

    }


    /**
     * [emptyDataFromApi check data from api is empty or not]
     * @param  [type] $_data [data from api]
     * @return [type]        [false = empty data or no data, true = have data]
     */
    public function emptyDataFromApi($_data){

        if(!$_data['responseText'])
            return false;
        else if($_data['responseText']['status'] == 'error' || $_data['responseText']['code'] != 200 || !$_data['responseText']['result'])
            return false;
        else
            return true;
    }



    // ======================== ultility function =======================

    // get simbol $ bigger is cheap, smaller is expensive
    public function getDollarSimbol($price_rate_val){
        if($price_rate_val>5)
            $price_rate_val = 5;
        $price_rate = '';
        for ($i=1; $i<=$price_rate_val;$i++) { 
            $price_rate .= '$';
        }
        if($price_rate == '')
            $price_rate = '$$$';

        return $price_rate;

    }

    // get star rate mod with 5 star ( rate-score = 8.0 so star = 4)
    public function getStarRate($restItem){

        $ranNum = rand(2, 10);
        $rateCount = isset($restItem['avg_rate']) ? $restItem['avg_rate'] : 0;
        $rateCount = $rateCount % 5;
        return $rateCount;
    }


    // get highlight category
    public function getHighlightCate($cate){
        // return sizeof($cate);
        if(sizeof($cate)>0){
            $cateSummary = array_pluck($cate, 'display_name');
            $_cateStr = '';
            foreach($cateSummary as $key => $_cateSumm){

                $_cateStr.= $_cateSumm;

                if($key == sizeof($cateSummary)-2)
                    $_cateStr.= " and ";

                if($key+1 != sizeof($cateSummary) && $key != sizeof($cateSummary)-2){
                    $_cateStr.= ", ";
                }

            }
            return $_cateStr;
        }
        else{
            return '...&nbsp;';
        }
    }


    // get feature icon
    public function getFeatureIcon($_features){

        $_available_icon =  array(
                                array(
                                    'name'  => 'Free Wifi',
                                    'icon_name' => 'icon-wifi'
                                ),
                                array(
                                    'name'  => 'Reservations',
                                    'icon_name' => 'icon-cake'
                                ),
                                array(
                                    'name'  => 'Parking Available',
                                    'icon_name' => 'icon-smoking_rooms'
                                ),
                                array(
                                    'name'  => 'Takeout',
                                    'icon_name' => 'icon-wifi'
                                ),
                                array(
                                    'name'  => 'Seating',
                                    'icon_name' => 'icon-wifi'
                                ),
                                array(
                                    'name'  => 'Street Parking',
                                    'icon_name' => 'icon-wifi'
                                ),
                                array(
                                    'name'  => 'Serves Alcohol',
                                    'icon_name' => 'icon-wifi'
                                ),
                                array(
                                    'name'  => 'Wheelchair Accessible',
                                    'icon_name' => 'icon-wifi'
                                ),
                            );

        // echo '<pre>'. print_r($_features['features'],true).'</pre>'; die();

        if(sizeof($_features['features'])>0){

            $tmp = [];
            $maxIcon = 1;

            foreach ($_available_icon as $key_main => $mainItem) {

                foreach ($_features['features'] as $key => $item) {
                    
                    if(isset($item['display_name']) && array_search($item['display_name'],$mainItem)){
                        
                        if($maxIcon<=3){
                            array_push($tmp, $mainItem);
                            $maxIcon++;
                        }
                         
                        if($maxIcon==3)
                            break;
                        

                    }

                }
                if($maxIcon==3)
                    break;

            }
            // echo '<pre>'. print_r($tmp,true).'</pre>';
            return $tmp;

        }
        else{

            return [];

        }

        
    }

    /**
     * Create a web friendly URL slug from a string.
     * 
     * Although supported, transliteration is discouraged because
     *     1) most web browsers support UTF-8 characters in URLs
     *     2) transliteration causes a loss of information
     *
     * @author Sean Murphy <sean@iamseanmurphy.com>
     * @copyright Copyright 2012 Sean Murphy. All rights reserved.
     * @license http://creativecommons.org/publicdomain/zero/1.0/
     *
     * @param string $str
     * @param array $options
     * @return string
     */
    public function url_slug($str, $options = array()) {
        // Make sure string is in UTF-8 and strip invalid UTF-8 characters
        $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
        
        $defaults = array(
            'delimiter' => '-',
            'limit' => null,
            'lowercase' => true,
            'replacements' => array(),
            'transliterate' => false,
        );
        
        // Merge options
        $options = array_merge($defaults, $options);
        
        $char_map = array(
            // Latin
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C', 
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 
            'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O', 
            'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH', 
            'ß' => 'ss', 
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c', 
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 
            'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o', 
            'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th', 
            'ÿ' => 'y',

            // Latin symbols
            '©' => '(c)',

            // Greek
            'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
            'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
            'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
            'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
            'Ϋ' => 'Y',
            'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
            'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
            'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
            'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
            'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

            // Turkish
            'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
            'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g', 

            // Russian
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',

            // Ukrainian
            'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
            'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',

            // Czech
            'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U', 
            'Ž' => 'Z', 
            'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
            'ž' => 'z', 

            // Polish
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z', 
            'Ż' => 'Z', 
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
            'ż' => 'z',

            // Latvian
            'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N', 
            'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
            'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
            'š' => 's', 'ū' => 'u', 'ž' => 'z'
        );

        // Make custom replacements
        $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
        
        // Transliterate characters to ASCII
        if ($options['transliterate']) {
            $str = str_replace(array_keys($char_map), $char_map, $str);
        }
        
        // Replace non-alphanumeric characters with our delimiter
        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
        
        // Remove duplicate delimiters
        $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
        
        // Truncate slug to max. characters
        $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
        
        // Remove delimiter from ends
        $str = trim($str, $options['delimiter']);
        
        return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
    }


    // get restaurant detail link
    public function getRestDetailLink($restItem){

        $baseUrl=URL::to('/'); // baseUrl use every where with translate
        $lang=LaravelLocalization::getCurrentLocale();

        // die(Config::get('app.locale'));
        if($lang=='en') // check is lang now === default the url is normal without lang
            $baseUrlLang=URL::to('/');
        else
            $baseUrlLang=URL::to('/'.LaravelLocalization::getCurrentLocale()); // baseUrl use every where with translate

        $_slug = $restItem['slug'];

        if($_slug === ''){
            if (strlen($restItem['directory_name']) != strlen(utf8_decode($restItem['directory_name']))){
                $_slug = HungryModule::url_slug($restItem['directory_name']);
            }
            else{
                $_slug = str_slug($restItem['directory_name'],'-');
            }
        }
        else{
             if (strlen($restItem['directory_name']) != strlen(utf8_decode($restItem['directory_name']))){
                $_slug = HungryModule::url_slug($restItem['directory_name']);
             }
        }

        return $baseUrlLang. '/restaurant/' .$restItem['_id'].'-'.$_slug;

    }


    public function getRestDetailLinkSEO($restItem){

        $_slug = $restItem['slug'];

        if($_slug === ''){
            if (strlen($restItem['directory_name']) != strlen(utf8_decode($restItem['directory_name']))){
                $_slug = HungryModule::url_slug($restItem['directory_name']);
            }
            else{
                $_slug = str_slug($restItem['directory_name'],'-');
            }
        }
        else{
             if (strlen($restItem['directory_name']) != strlen(utf8_decode($restItem['directory_name']))){
                $_slug = HungryModule::url_slug($restItem['directory_name']);
             }
        }

        return '/restaurant/' .$restItem['_id'].'-'.$_slug;

    }


    // get restaurant cover
    public function getRestCover($restItem, $size = 'thumbnail_url_link'){ // chk all it mean if no cover check logo it no  return empty


        // echo '<pre>'. print_r($restItem,true).'</pre>'; die();
        // echo print_r($restItem,true);
        if(isset($restItem['cover'])){

            if(isset($restItem['cover'][$size])){
                return $restItem['cover'][$size];
            }

        }
        else{
            if(isset($restItem['logo'])){
                if(isset($restItem['logo'][$size])){
                    return $restItem['logo'][$size];
                }
            } 
        }

        return '';


    }


    // get language translate from locale json string in category obj
    public function getLangCate($obj, $field){
        // echo '<pre>'.print_r($obj,true).'</pre>'; die();

        $lang = HungryModule::getLang();

        if($obj  && isset($obj['locale']) && array_key_exists('locale', $obj)){
            // $cateObj=json_decode($obj['locale'], true);
            $cateObj=$obj['locale'];

            if( $cateObj && array_key_exists($lang, $cateObj)){
                if(isset($cateObj[$lang][$field]) && $cateObj[$lang][$field] != '')
                    return $cateObj[$lang][$field];
                else
                    return $obj[$field];
            }
            else{
                return $obj[$field];
            }
        }
        else{
            return $obj[$field];
        }
    }


    public function getLang(){

        $langSeg = Request::segment(1);
        // echo '<pre>'. print_r('woww'.$langSeg,true).'</pre>'; die();
        $langSupported = array_map(function ($key, $value){
            return $key;
        }, array_keys(Config::get('laravellocalization.supportedLocales')), Config::get('laravellocalization.supportedLocales'));

        if (in_array($langSeg, $langSupported) == true ){
            $lang = $langSeg;
        }
        else{
            $lang = '';
        }
        // echo '<pre>'. print_r($lang,true).'</pre>'; die();
        return $lang;

    }


    public function getHttpUrl($_url, $defaultScheme = 'http'){
        $urlObj = parse_url($_url);
        if(isset($urlObj['scheme'])  && ($urlObj['scheme'] == 'http' || $urlObj['scheme'] == 'https')){
            return $_url;
        }
        else{
            return $defaultScheme.'://'.$_url;
        }
    }


    public function checkShortMetaDesc($title,$desc){
        //  The meta description should employ the keywords intelligently, but also create a compelling description
        //  that a searcher will want to click. Direct relevance to the page and uniqueness between each page’s meta
        //  description is key. The description should optimally be between 150-160 characters.
        $maxDesc=157; /* + '...' = 160 */
        $minDesc=150; /* + '...' = 160 */
        if(strlen($desc)>$maxDesc)
            return str_limit($desc,$maxDesc);
        else if(strlen($desc)<$minDesc)
            if(strlen($desc.' - '.$title)<$minDesc)
                return str_limit($desc.' - '.$title.' - buyer, seller, promote, chat, notification, online, search product, shopping',$maxDesc);
            else
                return str_limit($desc.' - '.$title,$maxDesc);
        else
            return str_limit($desc,$maxDesc);
    }

    // check device
    public function isMobile(){
        if(!Agent::isTablet() && !Agent::isDesktop() && Agent::isMobile())
            return true;
        else
            return false;
    }    

    // check device
    public function isTablet(){
        if(Agent::isTablet())
            return true;
        else
            return false;
    }   


    public function currencyFormat($price){
        return '$ '.number_format($price, 2);
    }

    public function getDiscountPrice($product){
        $price = $product['price'] - ($product['price']*$product['discount_rate']);
        return '$ '.number_format($price, 2);
    }

    //  for product 

    public function getProductDetailLink($item){

        $baseUrl=URL::to('/'); // baseUrl use every where with translate
        $lang=LaravelLocalization::getCurrentLocale();

        // die(Config::get('app.locale'));
        if($lang=='en') // check is lang now === default the url is normal without lang
            $baseUrlLang=URL::to('/');
        else
            $baseUrlLang=URL::to('/'.LaravelLocalization::getCurrentLocale()); // baseUrl use every where with translate

        return $baseUrlLang . '/product/' .  $item['id'] . '-' . $item['slug'];
    }


}
