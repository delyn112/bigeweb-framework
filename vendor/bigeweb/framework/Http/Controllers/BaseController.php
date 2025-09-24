<?php

namespace illuminate\Support\Http\Controllers;

class BaseController
{

    public $viewFrom;
    private $fileKey;
    private $filePath;
    private $fileName;
    private $masterFileName;
    private $masterFileKey;
    private $viewFileExtension = ".blade.php";
    private $masterPageToRemove;


    public function __construct()
    {
        $getViewsPath = file_path('/vendor/bigeweb/viewsLocation/views.php');
        if(file_exists($getViewsPath))
        {
            $this->viewFrom =  require $getViewsPath;
        }
    }


    public function getViewPath(string $fileName, string $functionName = null)
    {
        if($fileName === null)
        {
            throw new \InvalidArgumentException("View file name cannot be null.");
        }


        /**
         *
         *
         * check if the requested file name is from package or direct resources view
         *
         *
         */
        if(!$functionName)
        {
            if(strpos($fileName, "::") === false)
            {
                $this->fileName = $fileName;
            }else{
                $splitFileName = explode("::", $fileName);
                if(count($splitFileName) > 1)
                {
                    $this->fileKey = $splitFileName[0];
                    $this->fileName = $splitFileName[1];
                }
            }

        }else{
            if(strpos($fileName, "::") === false)
            {
                $this->masterFileName = $fileName;
            }else{
                $splitFileName = explode("::", $fileName);
                if(count($splitFileName) > 1)
                {
                    $this->masterFileKey = $splitFileName[0];
                    $this->masterFileName = $splitFileName[1];
                }
            }
        }
        /**
         *
         *
         * Get the file path based on the detected file key
         *
         *
         */

        $baseViewPath = file_path("resources/views");
        if(count($this->viewFrom) > 0)
        {
            foreach($this->viewFrom as $viewPath)
            {
                if(strpos($viewPath, "::") !== false)
                {
                    $pathToArray = explode("::", $viewPath);
                    /**
                     *
                     * Compare if the key with the file location is same as the key with what was splited above
                     * Then merge together if same
                     *
                     *
                     */
                    if(!$functionName)
                    {
                        if(count($pathToArray) > 0 && end($pathToArray) === $this->fileKey)
                        {
                            $baseViewPath = (reset($pathToArray));
                        }
                    }else{
                        if(count($pathToArray) > 0 && end($pathToArray) === $this->masterFileKey)
                        {
                            $baseViewPath = (reset($pathToArray));
                        }
                    }
                }
            }
        }

        /**
         *
         * Finally if the key is same the view path will be location set with the view location
         * Else the view path will be our basic view location which is resouces/views
         *
         */
        return ($baseViewPath);
    }



    public function view($fileName, $param = [])
    {
        /**
         *
         *
         * merge the baseview path abode with the file name and check its existence
         *
         */
        $viewFileName = "{$this->getViewPath($fileName)}/{$this->fileName}{$this->viewFileExtension}";
        if(!file_exists($viewFileName))
        {
            throw new \InvalidArgumentException("{$this->fileName}{$this->viewFileExtension} file does not exist in ".$this->getViewPath($fileName));
        }



        /***
         *
         * Generate the page content from the file
         *
         *
         */


        $Rawpage = file_get_contents($viewFileName);
        $mainPage = $this->mainPage($viewFileName, $param);
        $masterPage = $this->masterPage($viewFileName);
        return $this->formatedView($mainPage, $masterPage, $Rawpage, $param);
    }


    public function masterPage(string $fileContentName)
    {
        $fileContent = file_get_contents($fileContentName);
        /**
         *
         * Find the first line which has our master layout name
         *
         */
        $masterPageName = null;
        if(preg_match('/@extends\([\'"](.+?)[\'"]\)/', $fileContent, $matches)) {
            $masterPageName = end($matches);
            $this->masterPageToRemove = $masterPageName;
            $this->masterFileName = reset($matches);
        }

        if($masterPageName === null)
        {
            return;
        }

        $viewPath = $this->getViewPath($masterPageName, "masterPage");
        $masterPageBasePath = "$viewPath/{$this->masterFileName}{$this->viewFileExtension}";

        if(file_exists($masterPageBasePath))
        {
            ob_start();
            require $masterPageBasePath;
            $fileContent = ob_get_clean();
            return $fileContent;
        }
    }



    public function mainPage(string $fileContent, $param = [])
    {
        /***
         *
         * if the parameter array are not empty,
         * then make it available for use
         *
         *
         */

        if(!empty($param))
        {
            extract($param);
        }

        ob_start();
        require $fileContent;
        $content = ob_get_clean();

        return $content;
    }



    public function formatedView($mainPage, $masterPage, $Rawpage)
    {
        /**
         *
         * The initial page to display first is the master page
         * Then if the page is a page without master page
         * then display the page content
         *
         */
        $pageTodisplay = $masterPage;
        if(!$masterPage)
        {
            $pageTodisplay = $mainPage;
        }

        /***
         *
         * Before displaying the page. lets insert the page content into the master page
         *
         *Meaning main container swallaow the small content
         *
         *
         */

        $pageTodisplay = preg_replace('/@yield\(["\']content["\']\)/', $mainPage, $pageTodisplay);
        $escapedLayout = $this->masterPageToRemove;
        $escapedLayout = preg_quote($escapedLayout ?? '', '/');
        $pageTodisplay = preg_replace('/@extends\s*\(\s*[\'"]' . $escapedLayout . '[\'"]\s*\)/', '', $pageTodisplay);
        $pageContent = $this->cleanPage($pageTodisplay);
        return $pageContent;
    }


    public function cleanPage($pageContent)
    {

        /**
         *
         * Find the replacement title
         *
         *
         */


        $pattern = '/@section\(["\']title["\'],\s*(?:(["\'])(.*?)\1|(.+?))\)/';

        if (preg_match($pattern, $pageContent, $matches)) {
            // Get the title from either quoted or unquoted group
            $titleText = isset($matches[2]) && $matches[2] !== '' ? $matches[2] : trim($matches[3]);
            $titleText = ucfirst($titleText);
            $pattern = reset($matches);
            $pageContent = preg_replace('/@yield\(["\']title["\']\)/', $titleText, $pageContent);
            $pageContent = str_replace($pattern, '', $pageContent);
        }else{
            $pageContent = preg_replace('/@yield\(["\']title["\']\)/', '', $pageContent);
        }


        /**
         *
         * Find the replacement description
         *
         *
         */

    // $pattern = '/@section\(\s*[\'"]description[\'"]\s*,\s*((?:[^()\'"]++|"(?:[^"\\\\]++|\\\\.)*"|\'(?:[^\'\\\\]++|\\\\.)*\'|\((?1)\))*)\)/s';
        $pattern = $pattern = '/@section\(\s*[\'"]description[\'"]\s*\)(.*?)@endsection/s';


        if (preg_match($pattern, $pageContent, $matches)) {
    $descriptionRaw = trim($matches[1]);
    // Optionally decode HTML entities
    $descriptionText = html_entity_decode($descriptionRaw, ENT_QUOTES | ENT_HTML5);

    // Replace the @yield('description') with the actual description
    $pageContent = preg_replace('/@yield\(\s*[\'"]description[\'"]\s*\)/', $descriptionText, $pageContent);

    // Remove the original @section('description', ...) block
    $pageContent = preg_replace($pattern, '', $pageContent);
}
else{
            $pageContent = preg_replace('/@yield\(["\']description["\']\)/', '', $pageContent);
        }


        /**
         *
         * Find the replacement keywords
         *
         *
         */

        $pattern = '/@section\(\s*[\'"]keywords[\'"]\s*\)(.*?)@endsection/s';
        if (preg_match($pattern, $pageContent, $matches)) {
            $keywords = trim($matches[1]); // Only $matches[1] is valid here
            $pattern = reset($matches);
            $pageContent = preg_replace('/@yield\(["\']keywords["\']\)/', $keywords, $pageContent);
            $pageContent = str_replace($pattern, '', $pageContent);
        }else{
            $pageContent = preg_replace('/@yield\(["\']keywords["\']\)/', '', $pageContent);
        }



        return $pageContent;
    }




    public function partialView(string $file, $param = [])
    {
        if(!empty($param))
        {
            extract($param);
        }
        $path = $this->getViewPath($file)."/{$this->fileName}{$this->viewFileExtension}";
        if(!file_exists($path))
        {
            throw new \InvalidArgumentException("{$this->fileName}{$this->viewFileExtension} file does not exist in ".$this->getViewPath($file));
        }

        include $path;
    }
}