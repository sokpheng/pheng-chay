<?php namespace App\Http\Controllers\Api\Custom;

use \Input;
use \Hash;
use \Uuid;
use \App\Item;
use \Auth;
use \App\Http\Controllers\Api\ApiController;
use \DateTime;
use \DateInterval;

class ProductController extends ApiController {

	public function show($id){
		try{
			$item = Item::with('sections', 'sections.articleSection')->find($id);
			if (!$item){
				throw new \Exception('The item cannot be found');
			}
			return $this->ok($item);
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}

}
