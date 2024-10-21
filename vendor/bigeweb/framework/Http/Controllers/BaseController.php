<?php

namespace illuminate\Support\Http\Controllers;

use illuminate\Support\Exceptions\httpPageNotFoundException;

class BaseController
{
    public $viewFrom = '/resources/views/';
    public $pageContent = null;
    public $title = null;
    public $description = null;

    public function view($file, $param = [])
    {
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
        require getPath().$this->viewFrom.$masterFile.'.blade.php';
        return $page = ob_get_clean();
    }


    public function pageContent(mixed $file, $param = [])
    {
        if(!empty($param))
        {
            extract($param);
        }
        ob_start();
        require getPath().$this->viewFrom.$file.'.blade.php';
        return ob_get_clean();
    }
}