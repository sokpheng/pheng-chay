<?php namespace App\Http\Controllers\Api;

use \Input;
use \Hash;
use \Uuid;
use \App\User;
use \App\ResetPassword;
use \Auth;
use \DateTime;
use \DateInterval;

class SiteController extends ApiController {

	private function getThemePath($theme = null){
		$defaultTheme = $theme ? $theme : env('THEME', 'default');
		$path = app_path() . "/../resources/views/themes/$defaultTheme/";
		$pagePath = $path . "pages";
		$layoutPath = $path . "layouts";
		$metaFilePath = $path . "$defaultTheme.json";

		$validator = file_exists($metaFilePath) && is_dir($pagePath) && is_dir($layoutPath);
		if ($validator){			
			return [
				'page' => $pagePath,
				'layout' => $layoutPath,
				'error' => false,
				'theme' => $defaultTheme
			];
		}
		else{
			return [
				'page' => $pagePath,
				'layout' => $layoutPath,
				'error' => true,
				'theme' => $defaultTheme
			];
		}
	}

	private function validateTheme(){		
		$defaultTheme = env('THEME', 'default');
		$path = app_path() . "/../resources/views/themes/$defaultTheme/";
		$pagePath = $path . "pages";
		$layoutPath = $path . "layouts";
		$metaFilePath = $path . "$defaultTheme.json";

		try{

			$validator = file_exists($metaFilePath) && is_dir($pagePath) && is_dir($layoutPath);
			if ($validator){
				// Read file list from directory
				$pages = \CMS::getPages();			

			  	// Read layouts
			  	$layouts = \CMS::getLayouts();

			  	// Read file
			  	$content = json_decode(file_get_contents($metaFilePath), true);
			  	$content['themePath'] = "[PROJECT_ROOT]/resources/views/themes/$defaultTheme/";
			  	$content['theme'] = $defaultTheme;
				return [
					'pages' => $pages,
					'layouts' => $layouts,
					'meta' => $content,
					'error' => false
				];
			}
			else{
				return [
					'pages' => [],
					'layouts' => [],
					'meta' => null,
					'error' => true
				];
			}
		}
		catch (\Exception $e){			
			return [
				'pages' => [],
				'layouts' => [],
				'meta' => $e->getMessage(),
				'error' => true
			];
		}
	}

	public function availablePages(){
		return $this->ok($this->validateTheme());
	}

	public function createPage(){
		try{

			// Validation
			$data = Input::all();
			if (!isset($data['title'])){
				throw new \Exception('Title information is not provided');		
			}

			if (!isset($data['description'])){
				throw new \Exception('Description information is not provided');		
			}

			if (!isset($data['link'])){
				throw new \Exception('URL link is not provided');		
			}

			$layout = '';

			$path = $this->getThemePath();

			if (isset($data['layout'])){
				$layout = 'themes.' . $path['theme'] . '.layouts.' . substr($data['layout'], 0, strpos($data['layout'], '.'));
			}

			// Write file
			if ($path['error']){
				throw new \Exception('Sorry, the theme structure is malformed');
			}			

			$name = str_replace(' ', '-', strtolower($data['title'])) . '.blade.php';
			if (file_exists($path['page'] . '/' . $name)){
				throw new \Exception('Sorry, page with this title has already existed');
			}
			$dataTime = new \DateTime();
			$info = [
				'name' => $name,
				'info' => [
					'title' => $data['title'],
					'description' => $data['description'],
					'author' => 'FlexiTech Admin',
					'created_at' => $dataTime->format('Y-m-d H:i:s'),
					'updated_at' => $dataTime->format('Y-m-d H:i:s'),
					'id' => Uuid::generate(4) . '',
					'link' => $data['link'],
					'layout' => $data['layout']
				]
			];

			// Store this to database
			$content = $layout ? "@extends('" . $layout . "')\n\n" : "";
			$content .= "<?php\n    /*\n        {INFO}\n" . json_encode($info['info'], JSON_PRETTY_PRINT) . "\n       {/INFO}\n    */\n?>";

			file_put_contents($path['page'] . '/' . $name, $content);
			chmod($path['page'] . '/' . $name, 0775);

			return $this->ok($info);
		}
		catch (\Exception $e){
			return $this->error($e->getMessage());
		}
	}

	public function updatePage($pageName){
		try{
			$info = \CMS::getPageInfo($pageName);
			$data = Input::all();
			if (!$info){
				throw new \Exception('Sorry, invalid page name');
			}
			$dataTime = new \DateTime();
			$info['info']['updated_at'] = $dataTime->format('Y-m-d H:i:s');
			$hasData = false;
			if (isset($data['title'])){
				$hasData = true;
				$info['title'] = $data['title'];
			}
			if (isset($data['description'])){
				$hasData = true;
				$info['description'] = $data['description'];
			}
			if (isset($data['link'])){
				$hasData = true;
				$info['link'] = $data['link'];
			}

			$layout = '';
			$oldLayout = '';

			$path = $this->getThemePath();

			if (isset($data['layout'])){
				$layout = 'themes.' . $path['theme'] . '.layouts.' . substr($data['layout'], 0, strpos($data['layout'], '.'));
				if (isset($info['layout'])) {
					$oldLayout = 'themes.' . $path['theme'] . '.layouts.' . substr($info['layout'], 0, strpos($info['layout'], '.'));	
				}
				$info['layout'] = $data['layout'];
			}

			if ($hasData){
				\CMS::setPageInfo($pageName, $info, [
					'old-layout' => $oldLayout,
					'layout' => $layout
				]);	
			}
			
			return $this->ok($info);
		}	
		catch (\Exception $e){
			return $this->error($e->getMessage());
		}
	}
}
