<?php

use Base\Project\Admin\Acl\App\Repositories\Eloquents\CountryRepository;
use illuminate\Support\Facades\Config;

if(!function_exists('countries'))
{
    function countries()
    {
       return CountryRepository::all();
    }
}

if(!function_exists('states'))
{
    function states($param)
    {
        $param = strtolower($param);
        $file = Config::get('region');

        if(isset($file['countries'][$param]))
        {
            $state = $file['countries'][$param]['states'];
        }else{
            $state = ['Others'];
        }

        return $state;
    }
}


if(!function_exists('zipcode'))
{
    function zipcode($countryParam, $stateParam)
    {
        $countryParam = strtolower($countryParam);
        $file = Config::get('region');
        if(isset($file['countries'][$countryParam]['zipcode'][$stateParam]))
        {
            $postcode = $file['countries'][$countryParam]['zipcode'][$stateParam];
        }else{
            $postcode = ['Others'];
        }

        return $postcode;
    }
}

if(!function_exists('banks'))
{
    function banks() {
        $file = Config::get('region');
        return $file['banks'];
    }
}

?>