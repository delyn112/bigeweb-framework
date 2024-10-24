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
            $this->viewFrom =  require_once $getViewsPath;
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


        foreach($this->viewFrom as $viewFilePath)
        {
            $pathToArray = explode("::", $viewFilePath);

            //check if the name of the key is present
            if(isset($pathToArray[1]))
            {
                if($pathToArray[1] == $this->fileKey)
                {
                    $this->filePath = $pathToArray[0];
                }
            }else{
                $this->filePath = $pathToArray[0];
            }
        }

        return $this->filePath;
    }



    public function view($file, $param = [])
    {
        $file = $this->makeFilePath($file)."/".$this->fileName.".blade.php";
        if(!file_exists($file))
        {
            log_Error("View file does not exist.");
            throw new \InvalidArgumentException("View file does not exist.");
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
        ob_start();
        require $this->filePath."/".$masterFile.".blade.php";
        return $page = ob_get_clean();
    }


    public function pageContent(string $file, $param = [])
    {
        if(!empty($param))
        {
            extract($param);
        }
        ob_start();
        require $file;
        return ob_get_clean();
    }
}