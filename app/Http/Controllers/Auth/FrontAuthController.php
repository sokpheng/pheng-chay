<?php

namespace App\Http\Controllers\Auth;

use App\User;
use \RequestGateway;
use \AuthGateway;
use Validator;
use \Input;
use \Response;
use App\Http\Controllers\Controller;
use \LaravelLocalization;
use \HungryModule;

class FrontAuthController extends Controller
{

    protected function ok($content, $code = null, $options = null, $status = 200){
        $result = [
            'result' => $content,
            'options' => $options,
            'code' => $code,
            'error' => null
        ];
        return response($result, $status)
                  ->header('Content-Type', 'application/json');
    }

    protected function error($content, $error_type = 'general', $code = null, $options = null, $status = 400){

        $result = [
            'result' => $content,
            'options' => $options,
            'code' => $code ? $code : $status,
            'error' => $error_type
        ];

        return response($result, $status)
                  ->header('Content-Type', 'application/json');
    }

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /***
     * Login via dashboard database access
     */
    public function login(){
        $data = \Input::all();
        if (\Auth::attempt(['email' => $data['username'], 'password' => $data['password']])) {
            // Authentication passed...
            return redirect('/dashboard');
        }
        else{
            return redirect('/dashboard/login');   
        }
    }

    public function getLogout(){
        \Auth::logout();
        return redirect('/dashboard/login');  
    }

    /***
     * Login via API call
     */

    public function apiLogin(){
        try{
            $input = Input::all();

            // $headers = RequestGateway::translateHeaders();

            // echo '<pre>'. print_r($input,true).'</pre>'; die();

            $body = array('data'=>$input['data']);

            // $data = isset($input['data']) ? $input['data'] : array();
            $headers = array(
                        'key'  => $input['data_pass']
                    );
            // echo '<pre>'. print_r($data,true).'</pre>';
            // echo '<pre>'. print_r($headers,true).'</pre>'; die();
            $tmp = RequestGateway::post('/signin', $body, $headers);
            // echo '<pre>'. print_r($tmp,true).'</pre>'; die();
            if ($tmp['responseText'] && isset($tmp['responseText']['result']) && isset($tmp['responseText']['result']['id']) && isset($tmp['responseText']['result']['access_token']) && isset($tmp['responseText']['result']['email']) ){

                AuthGateway::login($tmp['responseText']['result']);
                // echo '<pre>'. print_r(AuthGateway::user(),true).'</pre>'; die();
                
                if(isset($input['redirect_back']))  
                    return redirect($input['redirect_back']);
                else
                    return redirect('/'.HungryModule::getLang());

            }
            else{

                return back()->withInput();
                // return $this->error('Sorry, the username or password is not correct', 'authentication', [], 0);
            }
        }
        catch (\Exception $e){
            // print_r($e->getMessage()); die();
            return back()->withInput();
        }
    }

    /***
     * Login via API call
     */

    public function fbLogin(){
        try{
            $input = Input::all();

            // $headers = RequestGateway::translateHeaders();

            // echo '<pre>'. print_r($input,true).'</pre>'; die();

            $body = array('data'=>$input['data']);

            // $data = isset($input['data']) ? $input['data'] : array();
            $headers = array(
                        'key'  => $input['data_pass']
                    );
            // echo '<pre>'. print_r($data,true).'</pre>';
            // echo '<pre>'. print_r($headers,true).'</pre>'; die();
            $tmp = RequestGateway::post('/login/facebook', $body, $headers);
            // echo '<pre>'. print_r($tmp,true).'</pre>'; die();
            if ($tmp['responseText'] && isset($tmp['responseText']['result']) && isset($tmp['responseText']['result']['_id']) && isset($tmp['responseText']['result']['access_token']) && isset($tmp['responseText']['result']['email']) ){

                AuthGateway::login($tmp['responseText']['result']);

                return redirect('/'.HungryModule::getLang());

            }
            else{

                return back()->withInput();
                // return $this->error('Sorry, the username or password is not correct', 'authentication', [], 0);
            }
        }
        catch (\Exception $e){
            // print_r($e->getMessage()); die();
            return back()->withInput();
        }
    }

    public function register(){
        try{
            $input = Input::all();

            // $headers = RequestGateway::translateHeaders();

            // echo '<pre>'. print_r($input,true).'</pre>'; die();

            $body = array('data'=>$input['data'], 'full_name'   => $input['full_name']);

            // $data = isset($input['data']) ? $input['data'] : array();
            $headers = array(
                        'key'  => $input['data_pass']
                    );
            // echo '<pre>'. print_r($data,true).'</pre>';
            // echo '<pre>'. print_r($headers,true).'</pre>'; die();
            $tmp = RequestGateway::post('/register', $body, $headers);
            // echo '<pre>'. print_r($tmp,true).'</pre>'; die();
            if ($tmp['responseText'] && isset($tmp['responseText']['result']) && isset($tmp['responseText']['result']['_id']) && isset($tmp['responseText']['result']['access_token']) && isset($tmp['responseText']['result']['email']) ){

                AuthGateway::login($tmp['responseText']['result']);

                // if(isset($input['redirect_back']))
                //     return redirect($input['redirect_back']);
                // else
                //     return redirect('/'.HungryModule::getLang());

                return redirect(HungryModule::getLang());
                // return redirect(HungryModule::getLang().'/favorite-food');

            }
            else{

                return back()->withInput();
                // return $this->error('Sorry, the username or password is not correct', 'authentication', [], 0);
            }
        }
        catch (\Exception $e){
            // print_r($e->getMessage()); die();
            return back()->withInput();
        }
    }

    public function getApiLogout(){
        \AuthGateway::logout();
        // echo LaravelLocalization::getCurrentLocale();
        // die();
        return redirect('/'.HungryModule::getLang());  
    }
}
