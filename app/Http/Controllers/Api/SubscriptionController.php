<?php namespace App\Http\Controllers\Api;

use \Input;
use \Hash;
use \Uuid;
use \App\Subscription;
use \App\Media;
use \Auth;
use \DateTime;
use \DateInterval;
use \Validator;
/*
    Handling check if email has already been subscribed or not
    Subscribe the email
    And unsubscribe using token
*/
class SubscriptionController extends ApiController {
    
    public function checkEmail(){
        try{
            $validator = Validator::make(Input::all(), [
                'email' => 'required|email|unique:subscriptions,email'
            ]);
            if($validator->fails()) {	
                return $this->error("The email address is invalid", $validator->messages());
            }
            return $this->ok('Email is valid and not being used');
        }
        catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

	public function store(){
		try{
			$validation = Validator::make(Input::all(), [
                'email' => 'required|email|unique:subscriptions,email'
            ]);
            if($validation->fails()) {	
                return $this->error("The email address is invalid", $validation->messages());
            }

			if($validation->passes()) {			
			    $subscription = new Subscription;
			    $subscription->email = Input::get('email');
			    $subscription->status = 'active';
			    $subscription->token = \Hash::make(\Uuid::generate(4) . '');
			    $subscription->save();
			    return $this->ok('Subscription is completed');
			} else {
				return $this->error($validation->messages());
			}
		}
		catch (\Exception $e){
			return $this->error($e->getMessage());
		}
	}


}
