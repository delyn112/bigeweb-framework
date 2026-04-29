<?php

namespace illuminate\Support;

use illuminate\Support\Facades\Config;

class SessionConfiguration
{

    public function __construct()
    {
        $_SESSION['timeout'] = Config::get('Session.lifetime');

        if (isset($_SESSION['timeout']) && time() > $_SESSION['timeout']) {
            // Session has timed out, destroy the session and redirect to login page
            Session::session_flush();
            header("Location: /");
            exit();
        }

        //make the sesion folder
        $saveSession = Config::get('Session.files');
        // On the PHP server side, the garbage collector should delete
        // old sessions after the same lifetime value.
        ini_set('session.gc_maxlifetime', $_SESSION['timeout']);
        // Fire the garbage collector only every 100 requests to save CPU.
// On some OS this is done by a cron job so it could be commented.
        ini_set('session.gc_probability', 1);
        ini_set('session.gc_divisor', 100);

// Improve some session settings:
        ini_set('session.use_cookies ', 1);
        ini_set('session.use_only_cookies  ', 1);
        ini_set('session.use_strict_mode ', 1);



// Simulate user's data from the database.
        $appName = Config::get('app.name');
// A salt per user is good. It avoids an attacker to be able
// to calculate the session cookie name himself if he discovers that
// it is just done by hashing the user's e-mail.
        $user_salt = 'nbVzr432';

// Change the session cookie name so that an attacker cannot find it.
        $session_cookie_name = 'SESS_' . sha1($appName . $user_salt);

// Detect if we are over HTTPS or not. Needs improvement if behind a SSL reverse-proxy.
// It's just used for the cookie secure option to make this POC work everywhere.
        $is_https = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']);

        $session_cookie_options = [
            // Set the cookie lifetime (the browser sets an expire to delete it automatically).
            'lifetime' => $_SESSION['timeout'],
            // The cookie path defines under which relative URL the cookie should be sent.
            // If your app is running under https://your-site.com/shop/ then the cookie path
            // should be set to /shop/ instead of the default / as there's no reason to send
            // your shop's session cookie to another app running at https://your-site.com/forum/.
            'path' => '/',
            // Cookie domain. Use null to let PHP handle that. But if you want a session
            // cookie accross multiple sub-domains such as forum.your-site.com and shop.your-site.com
            // then you should set the domain to ".your-site.com".

            'domain' => Config::get('app.url'),

            // If we are in HTTPS then don't let cookies be sent over HTTP.
            // Here I used $is_https to make it run everywhere but if you have
            // HTTPS on your domain then replace it by 1 to lock it!
            'secure' => $is_https ? 1 : 0, // IMPORTANT: Replace by 1 if you have both HTTP and HTTPS enabled.
            // Don't let JavaScript access the session cookie.
            'httponly' => 1,
            // If another site has a link pointing to your website then don't send
            // the session cookie (POST or GET). This mitigates somes kind of attacks.
            'samesite' => 'Strict',
        ];

        ini_set('session.save_path', $saveSession);
        ini_set('imagick.skip_version_check', true);

// Apply all the session cookie settings without ini_set() for maximum portability:
//session_name($session_cookie_name);
//session_set_cookie_params($session_cookie_options); // Since PHP 7.3 only
        session_start();
    }

}