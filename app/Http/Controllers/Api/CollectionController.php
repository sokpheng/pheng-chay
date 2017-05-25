<?php namespace App\Http\Controllers\Api;

use \Input;
use \Hash;
use \Uuid;
use \App\Article;
use \App\Collection;
use \App\Item;
use \Auth;
use \DateTime;
use \DateInterval;
use \DateTimeZone;

class CollectionController extends ApiController {


	public function index(){
		try{
			$collections = [];
			$collections = Collection::with(['articles']);

			if (Input::get('query')){
				$collections = $collections->whereRaw("(title LIKE ?)", ['%' . Input::get('query') . '%']);
			}

			$collections = $collections->orderBy('created_at', 'DESC');
			$total = count($collections->get()->toArray());

			if (Input::get('ignore-offset') != 1){
				$collections = $collections->take(Input::get('limit') ? Input::get('limit') : 20);
				$collections = $collections->skip(Input::get('offset') ? Input::get('offset') : 0);
			}

			$collections = $collections->get()->toArray();

			if (Input::get('ignore-offset') != 1){
				return $this->ok($collections, ['count' => $total, 'limit' => Input::get('limit') ? Input::get('limit') : 20, 'offset' => Input::get('offset') ? Input::get('offset') : 0]);
			}
			else{
				return $this->ok($collections, ['count' => $total]);
			}
			return $this->ok($collections);
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}

	public function show($id){
		try{


			if (is_numeric($id)){

				$collection = Collection::with(['articles', 'articles.category', 'articles.tags', 'articles.photos'])->where('id', '=', $id)->get()->first();
			}
			else{
				$collection = Collection::with(['articles', 'articles.category', 'articles.tags', 'articles.photos'])->where('hash', '=', $id)->get()->first();
			}			
			
			if (!$collection){
				throw new \Exception('The collection cannot be found');
			}

			$result = $collection->toArray();

			
			foreach ($result['articles'] as $key => $value) {
				$this->checkPrimaryPhoto($value, $key, $result['articles']);
				$result['articles'][$key]['url'] = env('DOMAIN', 'https://www.flexitech.io/') . \CMS::slugify($value);
			}


			return $this->ok($result);
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}

	public function store(){
		try{
			$data = Input::all();
			$validation = \Validator::make($data, [
	            'title' => 'required|max:255',
	            'hash' => 'required',
	        ]);


	        if ($validation->passes()){
	        	$data['created_by'] = Auth::user()->id;
	        	$data['updated_by'] = Auth::user()->id;
	        	$data['status'] = 'active';
	        	$collection = Collection::create($data);

	        	return $this->ok($collection);
	        }
	        else{
	        	return $this->error($validation->messages(), 'validation-error');
	        }
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}

	public function update($id){
		try{
			$collection = Collection::find($id);
			if (!$collection){
				throw new \Exception('The collection cannot be found to update');
			}
			if (Input::get('title')){
				$collection->title = Input::get('title');
			
	        }

	        $collection->updated_by = Auth::user()->id;
			$collection->save();
			return $this->ok($collection);
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}

	public function destroy($id){
		try{

			$collection = Collection::find($id);

			if (!$collection){
				throw new \Exception('The collection cannot be found to delete');
			}	

			// Check permission
			/*
			if (no-permission){
				throw new \Exception('You do not have permission to access this transaction');
			}
			*/
			$collection->hash = $collection->hash . '_DEL';
			$collection->save();
			$collection = $collection->delete();
			return $this->ok(['id' => $id]);
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}

}
