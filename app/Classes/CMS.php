<?php

namespace App\Classes;

class CMS {

    public function getTheme()
    {
        return env('THEME', 'default');
    }

    public function extractInfo($content){
        $delimiter = '#';
        $startTag = '{INFO}';
        $endTag = '{/INFO}';
        $regex = $delimiter . preg_quote($startTag, $delimiter) 
                            . '(.*?)' 
                            . preg_quote($endTag, $delimiter) 
                            . $delimiter 
                            . 's';
        $matches = [];
        preg_match($regex,$content,$matches);
        return $matches;
    }

    public function replaceInfo($content, $replacement){
        $delimiter = '#';
        $startTag = '{INFO}';
        $endTag = '{/INFO}';
        $regex = $delimiter . preg_quote($startTag, $delimiter) 
                            . '(.*?)' 
                            . preg_quote($endTag, $delimiter) 
                            . $delimiter 
                            . 's';
        $matches = [];
        return preg_replace($regex, '{INFO}' . $replacement . '{/INFO}', $content);
        // return $content;
    }

    /*
     * Retrieve page list from themes directory
     */
    public function getPages(){
        $defaultTheme = env('THEME', 'default');
        $path = app_path() . "/../resources/views/themes/$defaultTheme/";
        $pagePath = $path . "pages";
        $metaFilePath = $path . "$defaultTheme.json";

        try{

            $validator = file_exists($metaFilePath) && is_dir($pagePath);
            if ($validator){
                // Read file list from directory
                $pages = [];
                if ($dh = opendir($pagePath)){
                    while (($file = readdir($dh)) !== false){
                        $filePath = $pagePath . '/' . $file;                    
                        if ($file == '.' || $file == '..') {
                            continue;
                        }
                        $content = file_get_contents($filePath);
                        $info = $this->extractInfo($content);
                        $pages[] = [
                            'name' => $file,
                            'page-name' => substr($file, 0, strpos($file, '.')),
                            'info' => isset($info[1]) ? json_decode($info[1], true) : null
                        ];
                    }
                    closedir($dh);
                }
                return $pages;
            }
            else{
                return [];
            }
        }
        catch (\Exception $e){          
            return [];
        }
    }

    /*
     * Retrieve layouts from current themes layout path
     */
    public function getLayouts(){

        $defaultTheme = env('THEME', 'default');
        $path = app_path() . "/../resources/views/themes/$defaultTheme/";
        $layoutPath = $path . "layouts";
        $metaFilePath = $path . "$defaultTheme.json";
        try{
            $validator = file_exists($metaFilePath) && is_dir($layoutPath);
            if ($validator){

                // Read layouts
                $layouts = [];
                if ($dh = opendir($layoutPath)){
                    while (($file = readdir($dh)) !== false){
                        $filePath = $layoutPath . '/' . $file;                  
                        if ($file == '.' || $file == '..') {
                            continue;
                        }
                        $content = file_get_contents($filePath);
                        $info = $this->extractInfo($content);
                        $layouts[] = [
                            'name' => $file,
                            'info' => isset($info[1]) ? json_decode($info[1], true) : null
                        ];
                    }
                    closedir($dh);
                }
                return $layouts;
            }
            else{
                return [];
            }
        }
        catch (\Exception $e){          
            return [];
        }
    }

    /*
     * Retrieve view name by link url that page is created from dashboard and have predefined link url
     */
    public function getViewNameByLink($link){
        $pages = $this->getPages();
        $current = null;
        foreach ($pages as $key => $page) {
            if ($page['info']['link'] === $link){
                $current = $page;
                break;
            }
        }
        if ($current){
            return $this->view(substr($current['name'], 0, strpos($current['name'], '.')));
        }
        else{
            throw new \Exception('Cannot find view name by link');
        }
    }
    /*
     * Exchange view name for blade view path
     */
    public function view($viewName){
        $defaultTheme = env('THEME', 'default');
        return "themes.$defaultTheme.pages." . $viewName;
    }

    /*
     * Exchange view info
     */
    public function getPageInfo($pageName){
        $defaultTheme = env('THEME', 'default');
        $path = app_path() . "/../resources/views/themes/$defaultTheme/";
        $pagePath = $path . "pages/" . $pageName . '.blade.php';
        if (file_exists($pagePath)){            
            $content = file_get_contents($pagePath);
            $info = $this->extractInfo($content);
            return isset($info[1]) ? json_decode($info[1], true) : null;
        }
        else{
            return null;
        }
    }

    /*
     * Save view info back
     */
    public function setPageInfo($pageName, $info, $layout = []){
        $defaultTheme = env('THEME', 'default');
        $path = app_path() . "/../resources/views/themes/$defaultTheme/";
        $pagePath = $path . "pages/" . $pageName . '.blade.php';
        if (file_exists($pagePath)){            
            $content = file_get_contents($pagePath);

            if (isset($layout['old-layout']) && $layout['old-layout']){
                if (isset($layout['layout']) && $layout['layout']){
                    $content = str_replace($layout['old-layout'], $layout['layout'], $content);
                }
                
            }
            else{
                if (isset($layout['layout']) && $layout['layout']){
                    $content = "@extends('" . $layout['layout'] . "')\n\n" . $content;
                }
            }
            $content = $this->replaceInfo($content, json_encode($info, JSON_PRETTY_PRINT));
            file_put_contents($pagePath, $content);
            return true;
        }
        else{
            return false;
        }
    }

    private function format_uri($string, $separator = '-')
    {
        $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
        $special_cases = array( '&' => 'and', "'" => '');
        $string = mb_strtolower( trim( $string ), 'UTF-8' );
        $string = str_replace( array_keys($special_cases), array_values( $special_cases), $string );
        $string = preg_replace( $accents_regex, '$1', htmlentities( $string, ENT_QUOTES, 'UTF-8' ) );
        $string = preg_replace("/[^a-z0-9]/u", "$separator", $string);
        $string = preg_replace("/[$separator]+/u", "$separator", $string);
        return $string;
    }

    public function getSlug($name, $id){
        return $id . '-' . $this->format_uri($name);
    }

    public function getSlugId($slug){
        return explode('-', $slug)[0];
    }

    public function getPaths(){

    }

    // Piece title must be unique to get from it
    public function getPiece($title, $default = '', $locale = ''){
        $post = \App\Article::where('title', '=', $title)->first();
        return $post ? $post->description : $default;
    }

    public function getPost($title, $locale = ''){

        $post = \App\Article::where('title', '=', $title)->first();
        if ($locale == ''){
            return $post;
        }
        else{
            $locale = \App\Article::where('parent_id', '=', $post->id)->where('language', '=', $locale)->first();
            if (!$locale){
                return $post;
            }
            return $locale;
        }
    }

    public function getPostById($id, $options = []){
        $with = isset($options['with']) && is_array($options['with']) ? $options['with'] : [];
        $locale = isset($options['locale']) ? $options['locale'] : '';
        $post = \App\Article::with($with)->where('id', '=', $id)->first();
        if ($locale == ''){
            return $post->toArray();
        }
        else{
            $locale = \App\Article::with($with)->where('parent_id', '=', $post->id)->where('language', '=', $locale)->first();
            if (!$locale){
                return $post->toArray();
            }
            return $locale->toArray();
        }
    }

    // Get posts by type
    public function postsByType($type, $options = []){
        $order = isset($options['order']) && $options['order'] ? $options['order'] : null;
        $limit = isset($options['limit']) && $options['limit'] ? $options['limit'] : null;
        $offset = isset($options['offset']) && $options['offset'] ? $options['offset'] : null;

        $type = \App\Item::where('item_type', '=', 'type')->where('name', '=', $type)->first();
        if ($type){
            $post = \App\Article::with('category')->where('type_id', '=', $type->id);
            if ($order){
                $post = $post->orderByRaw($order);
            }
            if ($limit){
                $post = $post->take($limit);
            }
            if ($offset){
                $post = $post->offset($offset);
            }
            $post = $post->get()->toArray();
            return $post;
        }
        else{
            return [];
        }
    }

    public function postsByTypeId($type, $options = []){
        $order = isset($options['order']) && $options['order'] ? $options['order'] : null;
        $limit = isset($options['limit']) && $options['limit'] ? $options['limit'] : null;
        $offset = isset($options['offset']) && $options['offset'] ? $options['offset'] : null;

        $type = \App\Item::where('item_type', '=', 'type')->where('id', '=', $type)->first();
        if ($type){
            $post = \App\Article::with('category')->where('type_id', '=', $type->id);
            if ($order){
                $post = $post->orderByRaw($order);
            }
            if ($limit){
                $post = $post->take($limit);
            }
            if ($offset){
                $post = $post->offset($offset);
            }
            $post = $post->get()->toArray();
            return $post;
        }
        else{
            return [];
        }
    }

    // Get posts by category
    public function postsByCategory($category, $options = []){
        $order = isset($options['order']) && $options['order'] ? $options['order'] : null;
        $limit = isset($options['limit']) && $options['limit'] ? $options['limit'] : null;
        $offset = isset($options['offset']) && $options['offset'] ? $options['offset'] : null;
        $lang = isset($options['lang']) && $options['lang'] ? $options['lang'] : 'en';
        
        if (is_numeric($category)){
            $category = \App\Item::where('item_type', '=', 'category')->where('id', '=', $category)->first();
        }
        else{
            $category = \App\Item::where('item_type', '=', 'category')->where('name', '=', $category)->first();    
        }
        
        if ($category){
            $post = \App\Article::with('category')->where('category_id', '=', $category->id)->whereRaw('language = \'en\'');
            if ($lang == 'en'){
            }
            else{
                $post = \App\Article::whereRaw('(category_id = ? AND language = ? AND (parent_id IS NOT NULL AND parent_id > 0))', [$category->id, $lang]);
            }
            if ($order){
                $post = $post->orderByRaw($order);
            }
            if ($limit){
                $post = $post->take($limit);
            }
            if ($offset){
                $post = $post->offset($offset);
            }
            $post = $post->get()->toArray();
            return $post;
        }
        else{
            return [];
        }
    }

    // Get posts by category
    public function itemsByType($type, $options = []){
        $order = isset($options['order']) && $options['order'] ? $options['order'] : null;
        $limit = isset($options['limit']) && $options['limit'] ? $options['limit'] : null;
        $offset = isset($options['offset']) && $options['offset'] ? $options['offset'] : null;
        $lang = isset($options['lang']) && $options['lang'] ? $options['lang'] : 'en';
        $with = isset($options['with']) && is_array($options['with']) ? $options['with'] : [];
        
        $type = \App\Item::where('item_type', '=', 'type')
            ->where('name', '=', $type)->first();
        if ($type){
            $items = \App\Item::with($with)->where('parent_id', '=', $type->id);
            if ($order){
                $items = $items->orderByRaw($order);
            }
            if ($limit){
                $items = $items->take($limit);
            }
            if ($offset){
                $items = $items->offset($offset);
            }
            $items = $items->get()->toArray();
            return $items;
        }
        else{
            return [];
        }
    }

    // Get posts by category
    public function itemById($id, $options = []){

        $with = isset($options['with']) && is_array($options['with']) ? $options['with'] : [];
        $locale = isset($options['locale']) ? $options['locale'] : '';
        $item = \App\Item::with($with)->where('id', '=', $id)->first()->toArray();
        return $item;
    }


    // Get media by album
    public function mediaByAlbum($album, $options = []){
        $order = isset($options['order']) && $options['order'] ? $options['order'] : null;
        $limit = isset($options['limit']) && $options['limit'] ? $options['limit'] : null;
        $offset = isset($options['offset']) && $options['offset'] ? $options['offset'] : null;
        
        $album = \App\Item::where('item_type', '=', 'album')->where('name', '=', $album)->first();
        if ($album){
            $media = \App\Media::with('album')->where('album_id', '=', $album->id);
            if ($order){
                $media = $media->orderByRaw($order);
            }
            if ($limit){
                $media = $media->take($limit);
            }
            if ($offset){
                $media = $media->offset($offset);
            }
            $media = $media->get();
            return $media->toArray();
        }
        else{
            return [];
        }
    }

    // Get media by album
    public function mediaByAlbums($albums, $options = []){
        $order = isset($options['order']) && $options['order'] ? $options['order'] : null;
        $limit = isset($options['limit']) && $options['limit'] ? $options['limit'] : null;
        $offset = isset($options['offset']) && $options['offset'] ? $options['offset'] : null;
        
        $album = \App\Item::where('item_type', '=', 'album');//->where('name', '=', $album)->first();
        // foreach ($albums as $key => $value) {
        //     $album = $album->orWhere('name', '=', $value);
        // }
        $album = $album->whereIn('name', $albums);
        $album = $album->get();
        foreach ($album as $key => $value) {
            $album[$key]->media = \App\Media::where('album_id', '=', $value->id);
            if ($order){
                $album[$key]->media = $album[$key]->media->orderByRaw($order);
            }
            $album[$key]->media = $album[$key]->media->get()->toArray();
        }
        
        return $album->toArray();
    }
}