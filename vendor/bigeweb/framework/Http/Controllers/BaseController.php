<?php

namespace illuminate\Support\Http\Controllers;

class BaseController
{

    public $viewFrom;
    protected $fileKey;
    protected $filePath;
    protected $fileName;
    public $pageContent = null;
    public $title = null;
    public $description = null;


    public function __construct()
    {
        $getViewsPath = file_path('/vendor/bigeweb/viewsLocation/views.php');
        if(file_exists($getViewsPath))
        {
            $this->viewFrom =  require $getViewsPath;
        }
    }

    public function makeFilePath($viewFile)
    {
        if ($viewFile === null) {
            log_Error("View file cannot be null.");
            throw new \InvalidArgumentException("View file cannot be null.");
        }

        if(strpos($viewFile, "::") !== false)
        {
            $viewFileArray = explode("::", $viewFile);
            $this->fileKey = $viewFileArray[0];
            $this->fileName = $viewFileArray[1];
        }else{
            $this->fileName = $viewFile;
        }

        $filePath = file_path("resources/views");
        foreach($this->viewFrom as $viewFilePath)
        {
            if(strpos($viewFilePath, "::") !== false)
            {
                $pathToArray = explode("::", $viewFilePath);
                //check if the name of the key is present
                if(count($pathToArray) > 1 && $pathToArray[1] == $this->fileKey)
                {
                    $filePath = $pathToArray[0];
                }

            }
        }

        return($filePath);
    }


    public function view($file, $param = [])
    {
        $file = $this->makeFilePath($file)."/".$this->fileName.".blade.php";
        if(!file_exists($file))
        {
            log_Error($this->fileName." View file does not exist in ".$this->makeFilePath($file));
            throw new \InvalidArgumentException($this->fileName." View file does not exist in ".$this->makeFilePath($file));
        }
        if(!empty($param))
        {
            extract($param);
        }
        $pageDetails = $this->pageContent($file, $param);


        $rawPageTitle = $this->generatePageTitle($pageDetails);

        $pageLayout = $pageDetails;
        //trim the rawTitle and get only the text
        if($rawPageTitle) {
            $titlePartent = '';
            if (preg_match("/@section\('title', '([^']+?)'\)/", $rawPageTitle, $matches)
                || preg_match("/@section\('title',\s*([^']+?)\s*\)/", $rawPageTitle, $matches)) {
                // Extracted text is in the first capturing group
                $titlePartent =  preg_quote($rawPageTitle, '/');
                $this->title = $matches[1];
            }
            $pageLayout = preg_replace("/$titlePartent/", '', $pageLayout);
        }

        //trim the rawDescription and get only the text
        $description = $this->generatePageDesc($pageDetails);
        if($description) {
            $descriptionPattern = '';
            if (preg_match("/@section\('description', '([^']+?)'\)/", $description, $matches)
                || preg_match("/@section\('description',\s*([^']+?)\s*\)/", $description, $matches)) {
                // Extracted text is in the first capturing group
                $descriptionPattern =  preg_quote($description, '/');
                $this->description = $matches[1];
            }

            $pageLayout = preg_replace("/$descriptionPattern/", '', $pageLayout);
        }


        $rawMaster = $this->generateMasterPage($pageDetails);
        if($rawMaster)
        {
            if(preg_match("/'([^']+?)'/", $rawMaster, $matches)){
                $masterPageName = $matches[1];
                $masterPageLayout =  $this->LoadMasterPage($masterPageName);
            }
            //replace content with subpage
            $this->pageContent = $masterPageLayout;
            $this->pageContent = str_replace("@yield('content')", $pageLayout, $this->pageContent);
            $this->pageContent = str_replace($rawMaster, '', $this->pageContent);

        }else{
            $this->pageContent = $pageLayout;
        }

        if($this->title !== null)
        {
            $this->pageContent = preg_replace("/@yield\('title'\)/", $this->title, $this->pageContent);
        }else{
            $this->pageContent = preg_replace("/@yield\('title'\)/", '', $this->pageContent);
        }

        if ($this->description !== null) {
            $this->pageContent = preg_replace("/@yield\('description'\)/", $this->description, $this->pageContent);
        }else{
            $this->pageContent = preg_replace("/@yield\('description'\)/", '', $this->pageContent);
        }
        return $this->pageContent;
    }


    public function generateMasterPage($initialPage)
    {
        //get the main page;
        $splitPageContent = explode("\n", trim($initialPage));
        $masterPage = null;
        foreach($splitPageContent as $param)
        {
            if(strpos($param, "@extends") !== false)
            {
                $masterPage = $param;
            }
        }
        return $masterPage;
    }


    public function generatePageTitle($initialPage)
    {
        //Split the content to get the title
        $splitPageContent = explode("\n", trim($initialPage));
        $title = null;
        foreach($splitPageContent as $param)
        {
            if(strpos($param, "@section('title") !== false)
            {
                $title = $param;
            }
        }
        return $title;
    }



    public function generatePageDesc($initialPage)
    {
        //Split the content to get the title
        $splitPageContent = explode("\n", trim($initialPage));
        $description = null;
        foreach($splitPageContent as $param)
        {
            if(strpos($param, "@section('description") !== false)
            {
                $description = $param;
            }
        }
        return $description;
    }



    public function LoadMasterPage($masterFile)
    {
        if(strpos($masterFile, "::") !== false)
        {
            $masterFileArray = explode("::", $masterFile);
            $masterfileKey = $masterFileArray[0];
            $masterfileName = $masterFileArray[1];
        }else{
            $masterfileName = $masterFile;
            $masterfileKey = null;
        }


        $masterFilePath = null;
        foreach ($this->viewFrom as $masterFile)
        {
            $getPath = explode("::", $masterFile);
            if(isset($getPath[1]))
            {
                if($getPath[1] == $masterfileKey)
                {
                    $masterFilePath = $getPath[0];
                }
            }else{
                $masterFilePath = file_path("resources/views");
            }
        }

        $masterFilePath = $masterFilePath."/".$masterfileName.".blade.php";

        if(file_exists($masterFilePath))
        {
            ob_start();
            require $masterFilePath;
            return $page = ob_get_clean();
        }
        log_Error("View file does not exist.: ".$masterFilePath);
        throw new \InvalidArgumentException("View $masterFilePath file does not exist.");
    }


    public function pageContent(string $file, $param = [])
    {
        if(!empty($param))
        {
            extract($param);
        }
        if(file_exists($file))
        {
            ob_start();
            require $file;
            return ob_get_clean();
        }
        log_Error("View file does not exist.: $file");
        throw new \InvalidArgumentException("View file does not exist. $file");
    }
}