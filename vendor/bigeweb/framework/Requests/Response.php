<?php

namespace illuminate\Support\Requests;

class Response
{
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

}