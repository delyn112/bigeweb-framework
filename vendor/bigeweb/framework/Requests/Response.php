<?php

namespace illuminate\Support\Requests;

use illuminate\Support\Facades\Config;

class Response
{

    protected $url;
    public function __construct(
        private string $content = '',
        private int    $statusCode = 200,
        private array  $header = [
            'Content-Type: text/html',
            'Cache-Control: no-cache',
            'Set-Cookie: sessionId=12345; Path=/',
            'Expires: Thu, 01 Dec 2022 16:00:00 GMT',
            'ETag: "abc123"',
            'Last-Modified: Tue, 01 Jan 2024 12:00:00 GMT',
            'Allow: GET, POST, PUT',
        ],
    )
    {
    }


    public function send()
    {
        http_response_code($this->statusCode);
        return $this->content;
    }

    /**
     * @param string|null $url
     * @param int $status
     * @return void
     */
    public static function redirect(?string $url, int $status = 302)
    {
        if (empty($url) && $url != "") {
            throw new \InvalidArgumentException("A valid URL must be provided for redirection.");
            file_put_contents('error.log', "A valid URL must be provided for redirection.", FILE_APPEND);
        }

        if(strpos($url, Config::get('app.url')) === 0){
            throw new \InvalidArgumentException("url is invalid.Use redirectRoute instead");
            file_put_contents('error.log', "url is invalid.Use redirectRoute instead", FILE_APPEND);
        }

        if(strpos($url, 'http') !== 0)
        {
            $url = rtrim(Config::get('app.url'), '/').'/'.ltrim($url, '/');
        }
        header('Location: ' . $url, true, $status);
        exit();
    }


    public static function redirectRoute(?string $route, int $status = 302)
    {
        if (empty($route)) {
            throw new InvalidArgumentException("A valid URL must be provided for redirection.");
            file_put_contents('error.log', "A valid URL must be provided for redirection.", FILE_APPEND);
        }

        if(stripos($route, Config::get('app.url')) === false)
        {
            $route = Route($route);
        }

        header('Location: ' . $route, true, $status);
        exit();
    }


    public static function redirectBack()
    {
        $previousUrl  = $_SERVER['HTTP_REFERER'] ?? '/';

        header('Location: ' . $previousUrl, true, 302);
        exit();
    }

    public static function json(array $data, int $status = 200)
    {
        http_response_code($status);
        // header('Content-Type: application/json');
        return json_encode($data);

    }


    public static function pdf(string $content, string $filename, string $mime = 'application/pdf', int $status = 200)
    {
        http_response_code($status);
        header('Content-Type: ' . $mime);
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . strlen($content));

        echo $content;
        exit;
    }

}