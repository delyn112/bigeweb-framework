<?php

namespace illuminate\Support\Mail\Supports;

class GenerateMailAltText
{

    public static function altText($html)
    {
        // Convert HTML to plain text
        $text = strip_tags($html);

        // Optional: Replace multiple spaces and newlines with a single space
        $text = preg_replace('/\s+/', ' ', $text);

        // Trim whitespace from the beginning and end
        return trim($text);
    }
}