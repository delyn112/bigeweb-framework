<?php

namespace illuminate\Support\Facades;

use bigeweb\app\models\Admin_Setting;
use bigeweb\app\Repositories\Eloquents\Admin\EmailConfigurationRepository;
use bigeweb\app\Repositories\Eloquents\Admin\UserAdvanceConfigurationRepository;
use illuminate\Support\Supports\Advance_config;

class BaseControllerFacades
{

    protected UserAdvanceConfigurationRepository $userAdvanceConfigurationRepository;

    public function __construct()
    {
        $this->userAdvanceConfigurationRepository = new UserAdvanceConfigurationRepository();
    }



    public  static  function advance_model()
    {
        $support = new Advance_config();
        return $support;
    }

    public static function date_format()
    {

        return self::advance_model()::date_format();
    }


    public static function business_sector()
    {
        return self::advance_model()::allowed_business();
    }

    public static  function business_category()
    {
        $data = require(asset('config/business_category.php')) ;
        return ($data['categories']);
    }

    public static  function sub_business_category(string $param)
    {
        $data = require(asset('config/business_category.php')) ;
        return ($data['sub-category'][$param]);
    }


    public static function email_is_enabled()
    {
        $email = (new EmailConfigurationRepository())->find(1);
        if($email)
        {
            if($email['mailer'] && $email['port'] && $email['host'] &&
                $email['password'] && $email['username'] && $email['encryption'])
            {
                return true;
            }
        }

        return false;
    }

}