<?php namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;

abstract class ApiController extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	protected function ok($content, $options = null, $code = null, $status = 200){
		$result = [
			'result' => $content,
			'options' => $options,
			'code' => $code,
			'error' => null
		];
		return (new Response($result, $status))
                  ->header('Content-Type', 'application/json');
	}

	protected function error($content, $error_type = 'general', $options = null, $code = null, $status = 400){

		$result = [
			'result' => $content,
			'options' => $options,
			'code' => $code ? $code : $status,
			'error' => $error_type
		];

		return (new Response($result, $status))
                  ->header('Content-Type', 'application/json');
	}

	public function checkPrimaryPhoto(&$article, $key = 0, &$list = null){
		$story_media = [];
		if (!isset($article['photos'])){
			return;
		}
		foreach ($article['photos'] as $k => $value) {
			if ($list){
				$list[$key]['photos'][$k]['is_primary'] = $article['primary_photo_id'] == $value['id'];
			}
			else{
				$article['photos'][$k]['is_primary'] = $article['primary_photo_id'] == $value['id'];
			}

			if ($list){
				$list[$key]['photos'][$k]['is_poster'] = $article['game_photo_id'] == $value['id'];
			}
			else{
				$article['photos'][$k]['is_poster'] = $article['game_photo_id'] == $value['id'];
			}

			if ($value['storage_type'] == 'local' && !in_array('photo', $story_media)){
				$story_media[] = 'photo';
			}

			if ($value['storage_type'] == 'youtube' && !in_array('video', $story_media)){
				$story_media[] = 'video';
			}
		}
		if ($list){
			$list[$key]['story_types'] = $story_media;;
		}
		else{
			$article['story_types'] = $story_media;
		}
	}
}
