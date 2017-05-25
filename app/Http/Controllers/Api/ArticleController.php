<?php namespace App\Http\Controllers\Api;

use \Input;
use \Hash;
use \Uuid;
use \App\Article;
use \App\Item;
use \App\ProductSection;
use \Auth;
use \DateTime;
use \DateInterval;
use \DateTimeZone;
use \App\Jobs\PublishArticle;

class ArticleController extends ApiController {


	public function index(){
		try{
			$articles = [];
			$articles = Article::with(['type', 'category', 'photos', 'tags', 'primaryMedia', 'createdByUser', 'localizations', 'products'])->whereRaw('(parent_id = 0 OR parent_id IS NULL)');

			if (Input::get('type-name')){
				if (Input::get('strict-type')){
					$articles = $articles->whereRaw("(type_id IN (SELECT id FROM items WHERE name LIKE ?))", [Input::get('type-name')]);
				}
				else{
					$articles = $articles->whereRaw("(type_id IN (SELECT id FROM items WHERE name LIKE ?))", ['%' . Input::get('type-name') . '%']);
				}				
			}

			if (Input::get('category-name')){
				if (Input::get('strict-type')){
					$articles = $articles->whereRaw("(category_id IN (SELECT id FROM items WHERE name LIKE ?))", [Input::get('category-name')]);
				}
				else{
					$articles = $articles->whereRaw("(category_id IN (SELECT id FROM items WHERE name LIKE ?))", ['%' . Input::get('category-name') . '%']);
				}				
			}
			// return $this->ok(Input::get('ignore-type-name'));
			if (Input::get('ignore-type-name')){
				$types = explode(',', Input::get('ignore-type-name'));
				foreach ($types as $key => $value) {
					
					$articles = $articles->whereRaw("(type_id NOT IN (SELECT id FROM items WHERE name LIKE ?))", [$value . '']);
				}
			}

			$articles = $articles->orderBy('created_at', 'DESC');
			$total = count($articles->get()->toArray());

			if (Input::get('ignore-offset') != 1){
				$articles = $articles->take(Input::get('limit') ? Input::get('limit') : 20);
				$articles = $articles->skip(Input::get('offset') ? Input::get('offset') : 0);
			}

			$result = $articles->get()->toArray();
			foreach ($result as $key => $value) {
				$this->checkPrimaryPhoto($value, $key, $result);
				// $result[$key]['url'] = env('DOMAIN', 'https://www.flexitech.io/') . \CMS::slugify($value);
			}

			if (Input::get('ignore-offset') != 1){
				return $this->ok($result, ['count' => $total, 'limit' => Input::get('limit') ? Input::get('limit') : 20, 'offset' => Input::get('offset') ? Input::get('offset') : 0]);
			}
			else{
				return $this->ok($result, ['count' => $total]);
			}
			return $this->ok($result);
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}

	public function show($id){
		try{


			if (is_numeric($id)){

				$article = Article::with(['type', 'category', 'photos', 'tags', 'primaryMedia', 'createdByUser', 'collection', 'products'])->where('id', '=', $id)->get()->first();
			}
			else{
				$article = Article::with(['type', 'category', 'photos', 'tags', 'primaryMedia', 'createdByUser', 'collection', 'products'])->where('hash', '=', $id)->get()->first();
			}			
			
			if (Input::get('language')){
				$tmp = Article::where('parent_id', '=', $id)->where('language', '=', Input::get('language'))->get()->first();
				if ($tmp){
					$tmp->parent = $article;
					$article = $tmp;
				}
				else{
					$article = ['parent' => $article];
				}
				
			}
			if (!$article){
				throw new \Exception('The article cannot be found');
			}

			$result = $article;
			$this->checkPrimaryPhoto($result);

			//$result['url'] = env('DOMAIN', 'https://www.flexitech.io/') . \CMS::slugify($result);

			return $this->ok($result);
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}
	
	public function publish($id){
	    try{
	       $article = Article::find($id);
	       if ($article && $article->status === 'draft'){
	           $dateTime = new \DateTime();
	           $article->published_at = $dateTime->format('Y-m-d H:i:s');
	           $article->status = 'published';
	           $article->save();
	           return $this->ok($article);
	       } 
	       else{
	           return $this->error('Sorry, we cannot find draft article to publish');
	       }
	    }
	    catch (\Exception $e){
			return $this->error($e->getMessage());
	    }
	}
	
	public function pullAsDraft($id){
	    try{
	       $article = Article::find($id);
	       if ($article){
	           $dateTime = new \DateTime();
	           $article->status = 'draft';
	           $article->save();
	           return $this->ok($article);
	       } 
	       else{
	           return $this->error('Sorry, we cannot find article to pull back to draft');
	       }
	    }
	    catch (\Exception $e){
			return $this->error($e->getMessage());
	    }
	}
	
	public function schedule($id){
	    try{
	       
    		$data = Input::all();
    		$validation = \Validator::make($data, [
                'scheduled_at' => 'required|date'
            ]); 
            
	        if (!$validation->passes()){
	        	return $this->error($validation->messages(), 'validation-error');
	        }
            $currentTime = new DateTime("now", new DateTimeZone('UTC'));
            $time = new DateTime($data['scheduled_at'], new DateTimeZone('UTC'));
            $diff = $time->getTimestamp() - $currentTime->getTimestamp();
            if ($diff <= 0){
                return $this->error('Scheduled date must be ahead of current time');
            }
	        $article = Article::find($id);
	        if ($article && ($article->status === 'draft' || $article->status === 'scheduled') ){ // Allow rescheduled
                $dateTime = new \DateTime();
                $article->scheduled_at = $data['scheduled_at'];
                $article->status = 'scheduled';
                $article->save();
        
                $job = (new PublishArticle($article))->delay($diff);
                $this->dispatch($job);
                
                $article->scheduled_duration = $diff;
                
                return $this->ok($article);
	        } 
	        else{
	            return $this->error('Sorry, we cannot find draft article to publish');
	        }
	    }
	    catch (\Exception $e){
			return $this->error($e->getMessage());
	    }
	}

	public function store(){
		try{
			$data = Input::all();
			$validation = \Validator::make($data, [
	            'title' => 'required|max:255',
	            'type_id' => 'required|exists:items,id',
	            'category_id' => 'required|exists:items,id',
	            // 'description' => 'required'
	        ]);

	        if (isset($data['customs'])){
	        	if (!is_array($data['customs'])){
	        		throw new \Exception('Malformat custom fields data');
	        	}
	        	else{
	        		$data['customs'] = json_encode($data['customs']);
	        	}
	        }

	        if ($validation->passes()){
	        	$data['created_by'] = Auth::user()->id;
	        	$data['updated_by'] = Auth::user()->id;
	        	$data['language'] = 'en';
	        	$data['parent_id'] = 0;
	        	$data['status'] = 'draft';
	        	$article = Article::create($data);

	        	if (isset($data['product_id'])){
	        		$productSection = ProductSection::create([
	        			'article_section_id' => $article->id,
	        			'product_id' => $data['product_id']
	        		]);
	        	}

		        if (isset($data['select_tags'])){
		        	$tags = $data['select_tags'];
		        	if (is_array($tags)){
		        		$ids = [];
		        		foreach ($tags as $key => $value) {
		        			if (isset($value['id'])){
		        				$ids[] = $value['id'];
		        			}
		        			else{
		        				$tag = Item::where('display_name', '=', $value['display_name'])->first();
		        				if (!$tag){
			        				$tagParent = Item::where('name', '=', 'tag-type')->first();
						        	$value['created_by'] = Auth::user()->id;
						        	$value['updated_by'] = Auth::user()->id;
			        				$item = new Item($value);
			        				$item->item_type = 'tag';
			        				$item->parent_id = $tagParent ? $tagParent->id : 0;
						        	$item->save();
		        					$ids[] = $item->id;
						        }
						        else{
		        					$ids[] = $tag->id;
						        }
		        			}
		        		}
		        		$article->tags()->sync($ids);
		        	}
		        }
		        if (isset($data['select_products'])){
		        	$products = $data['select_products'];
		        	if (is_array($products)){
		        		$ids = [];
		        		foreach ($products as $key => $value) {
		        			if (isset($value['id'])){
		        				$ids[] = $value['id'];
		        			}
		        		}
		        		$article->products()->sync($ids);
		        	}
		        }

	        	return $this->ok($article);
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
			$article = Article::find($id);
			if (!$article){
				throw new \Exception('The item cannot be found to update');
			}
			if (Input::get('title')){
				$article->title = Input::get('title');
			}
			if (Input::get('description')){
				$article->description = Input::get('description');
			}
			if (Input::get('type_id')){
				$article->type_id = Input::get('type_id');
			}
			if (Input::get('category_id')){
				$article->category_id = Input::get('category_id');
			}
			if (Input::get('primary_photo_id')){
				$article->primary_photo_id = Input::get('primary_photo_id');
			}	
			if (Input::get('game_photo_id')){
				$article->game_photo_id = Input::get('game_photo_id');
			}	
			if (Input::get('seq_no')){
				$article->seq_no = Input::get('seq_no');
			}		
			if (Input::get('collection_id')){
				$article->collection_id = Input::get('collection_id');
			}			
	        
	        if (Input::get('customs') != null){
	        	if (!is_array(Input::get('customs'))){
	        		throw new \Exception('Malformat custom fields data');
	        	}
	        	else{
	        		$article->customs = json_encode(Input::get('customs'));
	        	}
	        }

        	if (Input::get('product_id') != null){

        		$tmpQuery = ProductSection::where('product_id', '=', Input::get('product_id'))
        			->where('article_section_id', '=', $id);
        		$tmp = $tmpQuery->first();
        		if ($tmp){

        		}
        		else{
        			$tmp->delete();
        			$productSection = ProductSection::create([
	        			'article_section_id' => $id,
	        			'product_id' => Input::get('product_id')
	        		]);	
        		}
        		
        	}

	        if (Input::get('select_tags') != null){
	        	$tags = Input::get('select_tags');
	        	if (is_array($tags)){
	        		$ids = [];
	        		foreach ($tags as $key => $value) {
	        			if (isset($value['id'])){
	        				$ids[] = $value['id'];
	        			}
	        			else{	
		        			$tagParent = Item::where('name', '=', 'tag-type')->first();        				
	        				$tag = Item::where('display_name', '=', $value['display_name'])
	        					->where('parent_id', '=', $tagParent ? $tagParent->id : 0)->first();
	        				if (!$tag){
					        	$value['created_by'] = Auth::user()->id;
					        	$value['updated_by'] = Auth::user()->id;
		        				$item = new Item($value);
		        				$item->item_type = 'tag';
		        				$item->parent_id = $tagParent ? $tagParent->id : 0;
					        	$item->save();
	        					$ids[] = $item->id;
					        }
					        else{
	        					$ids[] = $tag->id;
					        }
	        			}
	        		}
	        		$article->tags()->sync($ids);
	        	}
	        }

	        if (Input::get('select_products') != null){
	        	$products = Input::get('select_products');
	        	if (is_array($products)){
	        		$ids = [];
	        		foreach ($products as $key => $value) {
	        			if (isset($value['id'])){
	        				$ids[] = $value['id'];
	        			}
	        		}
	        		$article->products()->sync($ids);
	        	}
	        }
	        $article->updated_by = Auth::user()->id;
			$article->save();
			return $this->ok($article);
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}

	public function destroy($id){
		try{

			$article = Article::find($id);

			if (!$article){
				throw new \Exception('The item cannot be found to delete');
			}	

			// Check permission
			/*
			if (no-permission){
				throw new \Exception('You do not have permission to access this transaction');
			}
			*/
			$article->hash = $article->hash . '_DEL';
			$article->save();
			$article = $article->delete();
			$articles = Article::where('parent_id', '=', $id)->get();
			foreach ($articles as $key => $value) {
				$value->hash = $value->hash . '_DEL';
				$value->save();
				$value->delete();
			}
			return $this->ok(['id' => $id]);
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}

	public function locale($id, $language){
		try{
			if ($language == 'en' && !in_array($language, ['kh', 'cn'])){ // Available languages
				throw new \Exception('Invalid language value. Available languages are Khmer and Chinese.');
			}
			$data = Input::all();
			$parentArticle = Article::find($id);
			if (!$parentArticle){
				throw new \Exception("Could find the original edition of this article");				
			}

			$article = Article::where('parent_id', '=', $id)->where('language', '=', $language)->get()->first();
			if ($article){
				if (Input::get('title')){
					$article->title = Input::get('title');
				}
				if (Input::get('description')){
					$article->description = Input::get('description');
				}
				if (Input::get('type_id')){
					$article->type_id = Input::get('type_id');
				}
				if (Input::get('category_id')){
					$article->category_id = Input::get('category_id');
				}
				if (Input::get('seq_no')){
					$article->seq_no = Input::get('seq_no');
				}		

		        if (Input::get('customs') != null){
		        	if (!is_array(Input::get('customs'))){
		        		throw new \Exception('Malformat custom fields data');
		        	}
		        	else{
		        		$article->customs = json_encode(Input::get('customs'));
		        	}
		        }
		        
		        $article->updated_by = Auth::user()->id;
				$article->save();
				return $this->ok($article->toArray());
			}
			else{
				$validation = \Validator::make($data, [
		            'title' => 'required|max:255',
		            'type_id' => 'required|exists:items,id',
		            'category_id' => 'required|exists:items,id',
		            //'description' => 'required'
		        ]);
		        if ($validation->passes()){
					
			        if (isset($data['customs'])){
			        	if (!is_array($data['customs'])){
			        		throw new \Exception('Malformat custom fields data');
			        	}
			        	else{
			        		$data['customs'] = json_encode($data['customs']);
			        	}
			        }

		        	$data['created_by'] = Auth::user()->id;
		        	$data['updated_by'] = Auth::user()->id;
		        	$data['language'] = $language;
		        	$data['parent_id'] = $id;
		        	unset($data['parent']);
		        	unset($data['select_tags']);
		        	$article = Article::create($data);
		        	return $this->ok($article);
		        }
		        else{
		        	return $this->error($validation->messages(), 'validation-error');
		        }
			}			
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}


}
