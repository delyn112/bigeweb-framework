<?php

namespace Bigeweb\Acl\Http\Controllers;

use illuminate\Support\Facades\Config;
use illuminate\Support\Requests\Request;

class RegionalJsonController
{

    protected $configFile;

    public function __construct()
    {
        $this->configFile = Config::get('region');
    }

    public function getStates(Request $request)
    {
        $country = $request->input('country');
        $type = $request->input('type');
        $state = $request->input('state');
        $country = strtolower($country);

        if($type == 'country' && isset($this->configFile['countries'][$country]))
        {
            $CountryArray = $this->configFile['countries'][$country];
            return json_encode([
                'status' => 200,
                'data' => $CountryArray
            ]);
        }elseif($type == 'state' && isset($this->configFile['countries'][$country]['zipcode'][$state]))
        {
            $StateArray = $this->configFile['countries'][$country]['zipcode'][$state];
            return json_encode([
                'status' => 200,
                'data' => $StateArray
            ]);
        }else{
            return json_encode([
                'status' => 400,
                'data' => 'Others'
            ]);
        }
    }
}