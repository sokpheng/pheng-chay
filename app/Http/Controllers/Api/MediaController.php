<?php namespace App\Http\Controllers\Api;

use \Input;
use \Hash;
use \Uuid;
use \App\Item;
use \App\Media;
use \Auth;
use \DateTime;
use \DateInterval;
use Illuminate\Http\Request;

class MediaController extends ApiController {


	public function show($id){
		try{
			$media = Media::find($id);
			return $this->ok($media);
		}
		catch (\Exception $e){
			return $this->error($e->getMessage());
		}
	}

	public function update($id){
		try{
			$media = Media::find($id);
			if (!$media){
				throw new \Exception('Could not find media to update');
			}
			if (Input::get('description')){
				$media->description = Input::get('description');	
			}
			if (Input::get('caption')){
				$media->caption = Input::get('caption');	
			}
			if (Input::get('album_id')){
				$media->album_id = Input::get('album_id');	
			}
			if (Input::get('seq_no')){
				$media->seq_no = Input::get('seq_no');	
			}
			if (Input::get('path_name')){
				$media->path_name = Input::get('path_name');	
			}
			if (Input::get('file_name')){
				$media->file_name = Input::get('file_name');	
			}
			if (Input::get('link')){
				$media->link = Input::get('link');	
			}
			$data = Input::all();
			if (isset($data['is_home_image'])) {
				$media->is_home_image = Input::get('is_home_image');	
			}
			$media->save();
			return $this->show($id);
		}
		catch (\Exception $e){
			return $this->error($e->getMessage());
		}

	}


	public function index(){
		try{
			if (Input::get('limiter') && Input::get('limiter') == 'off'){
				$media = Media::with('album');
				if (Input::get('album')){
					$media = $media->where('album_id', '=', Input::get('album'));
				}
				if (Input::get('type')){
					$media = $media->where('type', '=', Input::get('type'));
				}
				$media = $media->orderBy('created_at', 'DESC')->get()->toArray();
				return $this->ok($media);
			}
			else{

				$offset = Input::get('offset') ? Input::get('offset') : 0;
				$limit = Input::get('limit') ? Input::get('limit') : 30;
				$total = 0;
				$media = Media::with('album');
				if (Input::get('album')){
					$media = $media->where('album_id', '=', Input::get('album'));
				}
				if (Input::get('type')){
					$media = $media->where('type', '=', Input::get('type'));
				}
				$media = $media->orderBy('created_at', 'DESC')->take($limit)->skip($offset)->get()->toArray();
				$total = \DB::table('media')->whereRaw('deleted_at IS NULL')->count();
				return $this->ok($media, ['offset' => $offset, 'limit' => $limit, 'total' => $total]);
			}
		}
		catch (\Exception $e){
			return $this->error($e->getMessage());
		}
	}

	public function storeLink(){
		try{
			$data = Input::all();		

			$validation = Media::validate($data, Media::$rules);
			$user = Auth::user();

			if($validation->passes()) {										
				$media = new Media($data);  
				$media->user_id = Auth::user()->id;
				$media->site_id = Auth::user()->site_id;
				$result = $media->save();
				return $this->show($media->id);	    			
			} else {
				return $this->error($validation->messages());
			}
		}
		catch (\Exception $e){
			return $this->error($e->getMessage());
		}
	}

	public function store(Request $request){
		try{
			$data = Input::all();		

			$data = $request->input('data');
			$data = json_decode($data, true);

			$validation = Media::validate($data, Media::$rules);
			$user = Auth::user();
			if (!Input::hasFile('file')){
				return $this->error('There is nothing to upload');
			}

			if($validation->passes()) {	
				\DB::beginTransaction();		
				try{

					$data['imagable_type'] = ucwords($data['imagable_type']);

			        $file = Input::file('file');
			        $t = microtime(true);
					$micro = sprintf("%06d",($t - floor($t)) * 1000000);
			        $output = 'uploads/sites/' . $user->site_id . '/' . ucwords($data['imagable_type']) . '/'. $data['imagable_id'];
			        $filename =  date('Y_m_d_His') . $micro . '.' . $file->getClientOriginalExtension();

			        if (!file_exists($output)){
			        	try{
			        		mkdir($output, 0777, true);      	 	
			        	}
			        	catch(\Exception $fileError){

			        	}
			        }
									
					$media = new Media($data);
					$media->file_name = $filename;
					$media->mime_type = $file->getMimeType();
					$media->content_length = $file->getSize();
					$media->path_name = $output;
					$media->storage_type = 'local';
					$media->type = $media->type ? $media->type : 'media'; 
					$media->user_id = Auth::user()->id;
					$media->site_id = Auth::user()->site_id;
					if (isset($data['seq_no']))
					{
						$media->seq_no = $data['seq_no'];
					}
					$media->imagable_type = ucwords($data['imagable_type']);
					$media->imagable_id = $data['imagable_id'];
					if (isset($data['album_id'])){
						$media->album_id = $data['album_id'];
					}
					else{
						$media->album_id = 0;
					}

	        		$uploadSuccess = $file->move($output, $filename);			    

					$result = $media->save();

					\DB::commit();

					return $this->show($media->id);

				}catch(\Exception $e){	
				 	\DB::rollback();		
			        return $this->error($e->getMessage());
			    }		    			
			} else {
				return $this->error($validation->messages());
			}
		}
		catch (\Exception $e){
			return $this->error($e->getMessage());
		}
	}


	public function destroy($id){
		try{
			$media = Media::find($id);

			if (!$media){
				throw new \Exception('The media cannot be found to delete');
			}	
			if ($media->storage_type == 'local' && file_exists(public_path() . '/' . $media->file_name)){
				unlink(public_path() . '/' . $media->file_name);
			}
			$media = $media->delete();
			return $this->ok(['id' => $id]);
		}
		catch(\Exception $e){
			return $this->error($e->getMessage());
		}
	}

	public function storeFromEditor(){

		$data = Input::all();		

		$user = Auth::user();
		if (!Input::hasFile('upload')){
			return $this->baseError('There is nothing to upload');
		}

		\DB::beginTransaction();		
		try{

			$imagable_type = 'Shares';

	        $file = Input::file('upload');
	        $output = 'uploads/sites/' . $user->site_id . '/' . $imagable_type . '/'. Uuid::generate(4);
	        $filename =  date('Y_m_d_Hisu') . '.' . $file->getClientOriginalExtension();

	        if (!file_exists($output)){
	        	mkdir($output,0777,true);      	 	
	        }
							
			$media = new Media(Input::all());
			$media->file_name = $filename;
			$media->mime_type = $file->getMimeType();
			$media->content_length = $file->getSize();
			$media->path_name = $output;
			$media->storage_type = 'local';
			$media->type = 'media'; 
			$media->user_id = Auth::user()->id;
			$media->site_id = Auth::user()->site_id;
			$media->imagable_type = $imagable_type;
			$media->imagable_id = 0;

    		$uploadSuccess = $file->move($output, $filename);			    

			$result = $media->save();

			\DB::commit();

			$output = $output . '/' . $filename;
			return "<p>Uploaded successfully</p><script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction(1, '$output', 'File is uploaded'); </script>";

		}catch(\Exception $e){	
		 	\DB::rollback();		
	        return $e->getMessage();//'There was an error while trying to upload';
	    }	
	}
	
	public function setBestVideo($id){
	    try{
	        $media = Media::find($id);
	        if ($media && $media->storage_type == 'youtube'){
	           $media->is_best_video = true;
	           $media->save();
	           return $this->ok('Set successfully');
	        }
	        else{
	            return $this->error('Cannot find media to set as best video');
	        }
	    }
	    catch (\Exception $e){
	        return $this->error($e->getMessage());
	    }
	}
	
	public function unSetBestVideo($id){
	    try{
	        $media = Media::find($id);
	        if ($media && $media->storage_type == 'youtube'){
	           $media->is_best_video = false;
	           $media->save();
	           return $this->ok('Unset successfully');
	        }
	        else{
	            return $this->error('Cannot find media to set as best video');
	        }
	    }
	    catch (\Exception $e){
	        return $this->error($e->getMessage());
	    }
	}



}
