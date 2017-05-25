<?php

namespace App\Http\Controllers\Auth;

use App\User;
use \RequestGateway;
use \AuthGateway;
use Validator;
use \Input;
use \Response;
use App\Http\Controllers\Controller;

class AuthController extends Controller
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
        $this->middleware('api.guest', ['except' => 'getLogout']);
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
        \AuthGateway::logoutAdmin();
        return redirect('/dashboard/login');  
    }

    /***
     * Login via API call
     */

    public function apiLogin(){
        try{
            $input = Input::all();
            $data = isset($input['data']) ? $input['data'] : array();
            $headers = isset($input['headers']) ? $input['headers'] : array();

            // Admin api key 
            
            $headers['X-CR-Request-ID'] = 'YzUzYzcxNjJkODhjMWEzZGZjNWE4Yzc2MWNkYTZkYzU5MTllZDJhOTYyMmFkZDY1ZDUwZGIwMjI4YTNkYzFhNQ==';

            $headers['X-CR-Connect-ID'] = base64_encode(\Session::getId() . 'A');
            
            $tmp = RequestGateway::post('/v1/admin/signin', $data, $headers);

            if ($tmp['responseText'] && isset($tmp['responseText']['result']) && isset($tmp['responseText']['result']['id']) && isset($tmp['responseText']['result']['access_token']) && isset($tmp['responseText']['result']['email']) ){
                AuthGateway::loginAdmin($tmp['responseText']['result']);

                return $this->ok('You have successfully logged in', 0, [
                    'redirect' =>'/dashboard']);
            }
            else{


                return $this->error('Sorry, the username or password is not correct', 'authentication', [], 0);
            }
        }
        catch (\Exception $e){
            return $this->error($e->getMessage(), 'general', [], 401);
        }
    }

    /***
     * Merchant Setup via API call
     */

    public function apiMerchantSetup(){
        try{
            $input = Input::all();
            $data = isset($input['data']) ? $input['data'] : array();
            $headers = isset($input['headers']) ? $input['headers'] : array();

            // Admin api key 
            
            $headers['X-SM-Request-ID'] = 'oEJnfLk+f3J3Mw1zwVKWhawhYcSkW2Z3NUoev6Uk2lk=';

            $headers['X-SM-Connect-ID'] = base64_encode(\Session::getId() . 'A');
            
            $tmp = RequestGateway::post('/reseller/register', $data, $headers);

            if ($tmp['responseText'] && isset($tmp['responseText']['result']) /*&& isset($tmp['responseText']['result']['_id']) && isset($tmp['responseText']['result']['access_token']) && isset($tmp['responseText']['result']['email'])*/ ){
                AuthGateway::loginAdmin($tmp['responseText']['result']);

                return $this->ok('You have successfully setup in', 0, [
                    'redirect' =>'/dashboard/login']);
            }
            else{


                return $this->error('Sorry, the username or password is not correct', 'authentication', [], 0);
            }
        }
        catch (\Exception $e){
            return $this->error($e->getMessage(), 'general', [], 401);
        }
    }

    public function getApiLogout(){
        \AuthGateway::logoutAdmin();
        return redirect('/dashboard/login');  
    }
}
