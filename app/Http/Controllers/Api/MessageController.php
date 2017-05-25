<?php namespace App\Http\Controllers\Api;

use \Input;
use \Hash;
use \Uuid;
use \App\Article;
use \App\Message;
use \App\Item;
use \Auth;
use \DateTime;
use \DateInterval;
use \DateTimeZone;

class MessageController extends ApiController {


	public function index(){
		try{
			$messages = [];
			$messages = Message::whereRaw('1 = 1');

			if (Input::get('query')){
				$queryVal = '%' . Input::get('query') . '%';
				$messages = $messages->whereRaw("(sender_name LIKE ? OR sender_phone LIKE ? OR sender_email LIKE ?)", [$queryVal, $queryVal, $queryVal]);
			}

			if (Input::get('scope')){
				$scope = Input::get('scope');
				if ($scope == 'not-seen'){
					$messages = $messages->where('is_seen', '=', '0');
				}
				else if ($scope == 'not-read'){
					$messages = $messages->where('is_read', '=', '0');
				}
			}

			$messages = $messages->orderBy('created_at', 'DESC');
			$total = count($messages->get()->toArray());

			if (Input::get('ignore-offset') != 1){
				$messages = $messages->take(Input::get('limit') ? Input::get('limit') : 20);
				$messages = $messages->skip(Input::get('offset') ? Input::get('offset') : 0);
			}

			$messages = $messages->get()->toArray();

			if (Input::get('ignore-offset') != 1){
				return $this->ok($messages, ['count' => $total, 'limit' => Input::get('limit') ? Input::get('limit') : 20, 'offset' => Input::get('offset') ? Input::get('offset') : 0]);
			}
			else{
				return $this->ok($messages, ['count' => $total]);
			}
			return $this->ok($messages);
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}

	public function show($id){
		try{
			if (is_numeric($id)){
				$message = Message::where('id', '=', $id)->get()->first();
			}
			else{
				$message = Message::where('hash', '=', $id)->get()->first();
			}		
			
			if (!$message){
				throw new \Exception('The message cannot be found');
			}

			$result = $message->toArray();

			return $this->ok($result);
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}

	public function store(){
		try{
			$data = Input::all();
			$validation = Message::validate($data);

	        if ($validation->passes()){
	        	$data['created_by'] = Auth::user()->id;
	        	$data['updated_by'] = Auth::user()->id;
	        	$data['status'] = 'active';
	        	$message = Message::create($data);

	        	return $this->ok($message);
	        }
	        else{
	        	return $this->error($validation->messages(), 'validation-error');
	        }
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}

	public function updateSeen($id){
		try{
			$message = Message::find($id);
			if (!$message){
				throw new \Exception('The message cannot be found to update');
			}
			$message->is_seen = true;
	        $message->updated_by = Auth::user()->id;
			$message->save();
			return $this->ok($message);
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}

	public function updateRead($id){
		try{
			$message = Message::find($id);
			if (!$message){
				throw new \Exception('The message cannot be found to update');
			}
			$message->is_read = true;
	        $message->updated_by = Auth::user()->id;
			$message->save();
			return $this->ok($message);
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}

	public function destroy($id){
		try{

			$message = Message::find($id);

			if (!$message){
				throw new \Exception('The message cannot be found to delete');
			}	

			// Check permission
			/*
			if (no-permission){
				throw new \Exception('You do not have permission to access this transaction');
			}
			*/
			$message = $message->delete();
			return $this->ok(['id' => $id]);
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}

}
