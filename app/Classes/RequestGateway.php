<?php

namespace App\Classes;

use \Log;
// use AuthGateway;
use \Config;

class RequestGateway extends AuthGateway {

	protected $address = null;
	protected $ws_address = null;

    public function __construct(){
        // echo env('REMOTE_API'); die();
        $this->address = env('REMOTE_API','http://128.199.202.82:3771/v2');
        $this->ws_address = env('REMOTE_API', 'http://128.199.202.82:3771/v2');
    }

    public function getServerAddress()
    {
        return $this->address;
    }

    public function getClientIp()
    {
         return '127.0.0.1';
    }


    public function getSocketServerAddress()
    {
        return $this->ws_address;
    }

    private function sanitizeUri($uri){
        return str_replace('$', '/', $uri);
    }

    private function response($res, $resp){
        $encodedResp = $resp;

        try{
            $encodedResp = json_decode($encodedResp, true);

        }
        catch(\Exception $e){
        }
        $result = array(
            'headers' => curl_getinfo( $res ),
            'responseText' => $encodedResp
        );
        curl_close( $res );

        // Check unauthorized requested
        if (isset($result['responseText']['result'])){
            if ($result['responseText']['result'] === 'Your request is not authorized'){
                AuthGateway::logout();
            }
        }
        
        return $result;
    }

    private function translateHeaders($header){
        if (AuthGateway::isLogin()){
            $user = AuthGateway::user();
            $header['Authorization'] = 'Bearer ' . $user['access_token'];
        }
        else{
            
            // $header['Authorization'] = 'Basic bVRoL3JVZUVhY2trQkxNc0djUEs4TDJkOGlhVFNRaFY2N0xyZWRVMjVEcz0='; // old auth

            // $header['Authorization'] = 'Basic bVRoL3JVZUVhY2trQkxNc0djUEs4TDJkOGlhVFNRaFY2N0xyZWRVMjVEcz06WGJNa0s4c2NxM2hPUWRmKzQzbll5a2w1aDFvYVVxbWpLbXZxbW9nek03b1JyZVptOE84VnJrTGYvSHg5eW5wUEhnNFVTWGE0eDVuTW5pOG5EY1Y3cVg0bHQwS2hvbkErUUUyV3doOFJRMWVYZ2hvYVRWSzAxYmJybGJYZHlWME9RVjZCbVN6amlLTlN5eTlQeEVIQnRGLzJQblhDU0VCRG1KeG83dmY5cWhBNUNXYTVuVFMwejJYL0l6NFdzbE9mdjR0ZTdWQnZ4OG43NCtMUkNmTldxSzRkaHBuU1VyNFNNY1RTVm9DZDFVbkF0T2RDV2RLMDl2NXo1TFA5YUMyYTBzK0wxZCtrUUxyN1JXZklqQmJPcVhGcTJhWEw1bWIyRGwyK09GUTRZNHpZMDk5Mk1TN3l5dUluYStzY09qRkhXV0p3Z25pU3VzMlYvUEFIV2JDeWNnPT0=';

        }

        if (Config::get('meem.useXForwardFor') == true){
            $header['X-Forwarded-For'] = \Request::getClientIp();    
        }

        if (!isset($header['Content-Type'])){
            $header['Content-Type'] = 'application/json';
        }

        // 'YzUzYzcxNjJkODhjMWEzZGZjNWE4Yzc2MWNkYTZkYzU5MTllZDJhOTYyMmFkZDY1ZDUwZGIwMjI4YTNkYzFhNQ==';
        if (!isset($header['X-IG-Request-ID'])){
            $header['X-IG-Request-ID'] = 'YzUzYzcxNjJkODhjMWEzZGZjNWE4Yzc2MWNkYTZkYzU5MTllZDJhOTYyMmFkZDY1ZDUwZGIwMjI4YTNkYzFhNQ==';
        }

        if (!isset($header['X-IG-Connect-ID'])){
            $header['X-IG-Connect-ID'] = base64_encode(\Session::getId() . 'U');
        }
        // $header['X-HH-Request-ID'] = 'ZDZmY2FhZWZjMmNhOGNmOWM4MGVkMTZhYjhmMWE0ZjdjOWZjMmI1M2VhYzEwZDlhYzIyNzEwZWRmZjAzNThmYw==';
        // $header['X-HH-Connect-ID'] = Config::get('meem.sm_api_token');

        // echo '<pre>'. print_r($header,true).'</pre>'; die();

        $result = array();
        foreach($header as $key => $value){
            if ($key == 'key'){
                $result[] = 'X-IG-Sign-Key: ' . $value;
            }
            else{
                $result[] = $key . ': ' . $value;    
            }
            
        }
        return $result;
    }

    /**
     * Do Get Request to Gateway
     */
    public function get($uri, $headers = array()){

        $uri = $this->getServerAddress() . $this->sanitizeUri($uri);

        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $uri,
            CURLOPT_USERAGENT => 'HungryHungry',
            CURLOPT_HTTPHEADER => $this->translateHeaders($headers),
            CURLOPT_SSL_VERIFYPEER => false
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        return $this->response($curl, $resp);
    }

    /**
     * Do Post Request
     */
    public function post($uri, $data, $headers = array()){
        $uri = $this->getServerAddress() . $this->sanitizeUri($uri);
        // Get cURL resource
        $curl = curl_init();
        \Log::info($this->translateHeaders($headers));
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $uri,
            CURLOPT_USERAGENT => 'HungryHungry',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => $this->translateHeaders($headers),
            CURLINFO_HEADER_OUT => true,
            CURLOPT_SSL_VERIFYPEER => false
        ));

        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        return $this->response($curl, $resp);
    }

    /**
     * Do Put Request
     */
    public function put($uri, $data, $headers = array()){
        $uri = $this->getServerAddress() . $this->sanitizeUri($uri);
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $uri,
            CURLOPT_USERAGENT => 'HungryHungry',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => $this->translateHeaders($headers),
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_SSL_VERIFYPEER => false
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        return $this->response($curl, $resp);
    }

    /**
     * Do Delete Request
     */
    public function delete($uri, $data, $headers = array()){
        $uri = $this->getServerAddress() . $this->sanitizeUri($uri);
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $uri,
            CURLOPT_USERAGENT => 'HungryHungry',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => $this->translateHeaders($headers),
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_SSL_VERIFYPEER => false
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        return $this->response($curl, $resp);
    }

    /**
     * Do any request
     */
    public function any($method, $url, $data = array(), $headers = array()){
        $curl = curl_init();
        switch ($method) {
            case 'DELETE':                
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => $url,
                    CURLOPT_USERAGENT => 'HungryHungry',
                    CURLOPT_POSTFIELDS => json_encode($data),
                    CURLOPT_HTTPHEADER => $this->translateHeaders($headers),
                    CURLOPT_CUSTOMREQUEST => 'DELETE',
                    CURLOPT_SSL_VERIFYPEER => false
                ));
                break;
            case 'PUT': 
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => $url,
                    CURLOPT_USERAGENT => 'HungryHungry',
                    CURLOPT_POSTFIELDS => json_encode($data),
                    CURLOPT_HTTPHEADER => $this->translateHeaders($headers),
                    CURLOPT_CUSTOMREQUEST => 'PUT',
                    CURLOPT_SSL_VERIFYPEER => false
                ));
                break;
            case 'POST':   
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => $url,
                    CURLOPT_USERAGENT => 'HungryHungry',
                    CURLOPT_POST => 1,
                    CURLOPT_POSTFIELDS => $data,
                    CURLOPT_HTTPHEADER => $this->translateHeaders($headers),
                    CURLINFO_HEADER_OUT => true,
                    CURLOPT_SSL_VERIFYPEER => false
                ));
                break;
            case 'GET':
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => $url,
                    CURLOPT_USERAGENT => 'HungryHungry',
                    CURLOPT_HTTPHEADER => $this->translateHeaders($headers),
                    CURLOPT_SSL_VERIFYPEER => false
                ));
            break;
        }
        $resp = curl_exec($curl);
        return $this->response($curl, $resp);
    }


    public function chkEmptyResponse($result){

        if($result['responseText']['result']){

        }

    }


}
