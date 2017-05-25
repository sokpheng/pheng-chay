<?php namespace App\Http\Controllers\Api;

use \Input;
use \Hash;
use \Uuid;
use \App\Directory;
use \App\Item;
use \Auth;
use \DateTime;
use \DateInterval;

class DirectoryController extends ApiController {

	public function index(){
		try{
			$directories = [];
			$directories = Directory::with(['logo', 'category', 'photos', 'categories']);
			if (Input::get('active') && Input::get('active') === 1){
				$directories = $directories->where('is_active', '=', 1);
			}
			if (Input::get('category')){
				$directories = $directories->where('category_id', '=', Input::get('category'));
			}
			if (Input::get('q')){
				$directories = $directories->whereRaw("name like ? OR short_description LIKE ? OR description LIKE ?", 
					['%' . Input::get('q') . '%', '%' . Input::get('q') . '%', '%' . Input::get('q') . '%'])
					->orWhereRaw("id IN (SELECT dc.directory_id FROM items i INNER JOIN directory_categories dc ON i.id = dc.category_id WHERE item_type = 'category' AND display_name LIKE ?)", ['%' . Input::get('q') . '%']);
			}
			$total = count($directories->get()->toArray());

			if (Input::get('ignore-offset') != 1){
				$directories = $directories->take(Input::get('limit') ? Input::get('limit') : 20);
				$directories = $directories->skip(Input::get('offset') ? Input::get('offset') : 0);
			}

			if (Input::get('sort') && Input::get('sort') == 'asc') {
				$directories = $directories->orderBy('name', 'ASC');
			}
			else if (Input::get('sort') && Input::get('sort') == 'desc') {
				$directories = $directories->orderBy('name', 'DESC');
			}

			$directories = $directories->get()->toArray();
			if (Input::get('ignore-offset') != 1){
				return $this->ok($directories, ['count' => $total, 'limit' => Input::get('limit') ? Input::get('limit') : 20, 'offset' => Input::get('offset') ? Input::get('offset') : 0]);
			}
			else{
				return $this->ok($directories, ['count' => $total]);
			}
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}

	public function indexByCategory (){
		try{
			$categories = Item::with(['directories' => function ($query) {
				    $query->where('is_active', '=', 1);
				}, 'directories.logo', 'directories.photos', 'directories.categories'])
				->where('item_type', '=', 'category')
				->whereRaw("parent_id IN (SELECT id FROM items WHERE name LIKE 'enterprise-category')")
				->get()
				->toArray();
			
			return $this->ok($categories);
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}

	public function show($id){
		try{
			if (is_numeric($id)){

				$directory = Directory::with(['logo', 'category', 'photos', 'categories'])->where('id', '=', $id)->get()->first();
			}
			else{
				$directory = Directory::with(['logo', 'category', 'photos', 'categories'])->where('hash', '=', $id)->get()->first();	
			}
			
			return $this->ok($directory);
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}

	public function store(){
		try{
			$data = Input::all();
			$validation = \Validator::make($data, [
	            'name' => 'required|max:255',
	            'hash' => 'required',
	            // 'category_id' => 'required|exists:items,id',
	            'description' => 'required',
	            'phones' => 'required',
	            'websites' => 'required',
	            'emails' => 'required',
	            'address' => 'required',
	            'category_ids' => 'required|array'
	        ]);
	        if ($validation->passes()){
	        	$category_ids = $data['category_ids'];
	        	unset($data['category_ids']);
	        	$data['created_by'] = Auth::user()->id;
	        	$data['updated_by'] = Auth::user()->id;
	        	$directory = Directory::create($data);
	        	$directory->categories()->sync($category_ids);
	        	return $this->ok($directory);
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
			$directory = Directory::find($id);
			if (!$directory){
				throw new \Exception('The item cannot be found to update');
			}
			if (Input::get('title')){
				$directory->title = Input::get('title');
			}
			if (Input::get('description')){
				$directory->description = Input::get('description');
			}
			if (Input::get('short_description')){
				$directory->short_description = Input::get('short_description');
			}
			if (Input::get('category_id')){
				$directory->category_id = Input::get('category_id');
			}
			if (Input::get('logo_id')){
				$directory->logo_id = Input::get('logo_id');
			}
			if (Input::get('latitude')){
				$directory->latitude = Input::get('latitude');
			}
			if (Input::get('longitude')){
				$directory->longitude = Input::get('longitude');
			}
			if (Input::get('phones')){
				$directory->phones = Input::get('phones');
			}
			if (Input::get('websites')){
				$directory->websites = Input::get('websites');
			}
			if (Input::get('address')){
				$directory->address = Input::get('address');
			}
			if (Input::get('emails')){
				$directory->emails = Input::get('emails');
			}
			if (Input::get('is_active')){
				$directory->is_active = Input::get('is_active');
			}
			if (Input::get('social_issues')){
				$directory->social_issues = Input::get('social_issues');
			}
			if (Input::get('main_activities')){
				$directory->main_activities = Input::get('main_activities');
			}
			if (Input::get('impact')){
				$directory->impact = Input::get('impact');
			}
			if (Input::get('solutions')){
				$directory->solutions = Input::get('solutions');
			}
			if (Input::get('category_ids') && is_array(Input::get('category_ids'))){
				$directory->categories()->sync(Input::get('category_ids'));
			}
	        $directory->updated_by = Auth::user()->id;
			$directory->save();
			return $this->show($directory->id);
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}

	public function destroy($id){
		try{

			$directory = Directory::find($id);

			if (!$directory){
				throw new \Exception('The item cannot be found to delete');
			}	

			// Check permission
			/*
			if (no-permission){
				throw new \Exception('You do not have permission to access this transaction');
			}
			*/

			$directory = $directory->delete();
			return $this->ok(['id' => $id]);
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}

}
