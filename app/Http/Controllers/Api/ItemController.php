<?php namespace App\Http\Controllers\Api;

use \Input;
use \Hash;
use \Uuid;
use \App\Item;
use \Auth;
use \DateTime;
use \DateInterval;

class ItemController extends ApiController {

	public function index(){
		try{
			$items = [];
			$type = Input::get('type');
			if ($type == null){
				$items = Item::whereRaw('1 = 1');
			}
			else{
				$items = Item::where('item_type', '=', $type);
			}
			$parentId = Input::get('parent_id');

			if ($parentId != null){
				if ($parentId == 0){
					$items = $items->whereRaw('(parent_id = 0 OR parent_id IS NULL)');	
				}
				else{
					$items = $items->where('parent_id', '=', $parentId);
				}
				
			}

			$parentName = Input::get('parent_name');
			if ($parentName != null){
				$items = $items->whereRaw('parent_id IN (SELECT id from items WHERE name = ? )', [$parentName]);
			}

			$name = Input::get('name');
			if ($name != null){
				$items = $items->whereRaw('name = ?', [$name]);
			}

			if (Input::get('ignore-offset') != 1){
				$items = $items->take(Input::get('limit') ? Input::get('limit') : 20);
				$items = $items->skip(Input::get('offset') ? Input::get('offset') : 0);
			}
			if ($type == 'category'){
				$items = $items->with('type')->get()->toArray();
			}
			else{
				$items = $items->get()->toArray();
			}
			return $this->ok($items);
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}

	public function show($id){
		try{
			$item = Item::find($id);
			if (!$item){
				throw new \Exception('The item cannot be found to update');
			}
			return $this->ok($item);
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}

	public function store(){
		try{
			$data = Input::all();
			$validation = \Validator::make($data, [
	            'display_name' => 'required|max:255',
	            'name' => 'required|max:255|unique:items',
	            'parent_id' => 'exists:items,id',
	            'item_type' => 'required'
	        ]);
	        if ($validation->passes()){
	        	$data['created_by'] = Auth::user()->id;
	        	$data['updated_by'] = Auth::user()->id;
	        	$item = Item::create($data);
	        	return $this->ok($item);
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
			$item = Item::find($id);
			if (!$item){
				throw new \Exception('The item cannot be found to update');
			}
			if (Input::get('item_type')){
				$item->item_type = Input::get('item_type');
			}
			if (Input::get('display_name')){
				$item->display_name = Input::get('display_name');
			}
			if (Input::get('name')){
				$items = Item::where('name', '=', Input::get('name'))->where('id', '!=', $id)->get()->toArray();
				if (count($items)){
					throw new \Exception('Name of item cannot be duplicated');
				}
				$item->name = Input::get('name');
			}
			if (Input::get('parent_id')){
				$item->parent_id = Input::get('parent_id');
			}	
			if (Input::get('description')){
				$item->description = Input::get('description');
			}
			if (Input::get('seq_number')){
				$item->seq_number = Input::get('seq_number');
			}	
			if (Input::get('status')){
				$item->status = Input::get('status');
			}		
	        $item->updated_by = Auth::user()->id;
			$item->save();
			return $this->ok($item);
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}

	public function destroy($id){
		try{

			$item = Item::find($id);

			if (!$item){
				throw new \Exception('The item cannot be found to delete');
			}	

			if ($item->indeletable)	{
				throw new \Exception('The item is default and cannot be deleted');
			}

			// Check permission
			/*
			if (no-permission){
				throw new \Exception('You do not have permission to access this transaction');
			}
			*/
			// Check this item in transaction
			$sql = "SELECT count(i.id) as count
				FROM items i
				WHERE (exists(SELECT type_id FROM articles WHERE type_id = i.id AND deleted_at IS NULL) OR 
					exists(SELECT category_id FROM articles WHERE category_id = i.id AND deleted_at IS NULL) OR
					exists(SELECT parent_id FROM items WHERE parent_id = i.id AND deleted_at IS NULL)) AND
					i.id = ?
				";
			// return $this->ok($sql);
			$count = \DB::select($sql, [$id]);
			$count = count($count) > 0 ? $count[0]->count : 0;

			if ($count > 0){
				throw new \Exception('The item cannot be deleted');
			}

			$item = $item->delete();
			return $this->ok(['id' => $id]);
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}

	public function locale($id){
		try{
			$item = Item::find($id);
			if (!$item){
				throw new \Exception('The item cannot be found to update locale');
			}
			$array = [];
			$data = Input::all();
			if (!is_array($data)){
				throw new \Exception('Malformatted locale data');
			}

			// Should be in config
			$availableLanguages = ['kh', 'cn'];
			$prep = [];
			foreach ($data as $key => $value) {
				if (!isset($value['language']) || !isset($value['text'])){
					throw new \Exception('Malformatted locale data');
				}
				if (!in_array($value['language'], $availableLanguages)){
					throw new \Exception('Malformatted locale data');
				}
				if (isset($prep[$value['language']]) && $prep[$value['language']] >= 1){
					throw new \Exception('Malformatted locale data');
				}
				$array[] = [
					'language' => $value['language'],
					'text' => $value['text']
				];
				if (!isset($prep[$value['language']])) {
					$prep[$value['language']] = 1;	
				}
				
			}
			$item->locale = json_encode($array);
			$item->save();
			return $this->ok($item);
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}


}
