<?php

return [
    /*
       |--------------------------------------------------------------------------
       | Session Lifetime
       |--------------------------------------------------------------------------
       |
       | Here you may specify the number of minutes that you wish the session
       | to be allowed to remain idle before it expires. If you want them
       | to immediately expire on the browser closing, set that option.
       |
       */

    'lifetime' =>   time() + (86400 * 30),


    /*
  |--------------------------------------------------------------------------
  | Session File Location
  |--------------------------------------------------------------------------
  |
  | When using the native session driver, we need a location where session
  | files may be stored. A default has been set for you but a different
  | location may be specified. This is only needed for file sessions.
  |
  */

    'files' => storage_path('storage/framework/sessions'),
]

?>