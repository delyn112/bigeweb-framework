<?php

namespace illuminate\Support;

use illuminate\Support\Facades\Config;

class Trans
{
    public function lang(string $text, array $replace = [])
    {
        $translationBaseFile = file_path('/vendor/bigeweb/langLocation/translation.php');

        if (!file_exists($translationBaseFile)) {
            throw new \Exception("Translation root directory file is not found", 404);
        }

        $translationDirectories = require $translationBaseFile;

        $pathKey = null;
        $languageKey = $text;

        // Handle namespaced keys like "package::file.key"
        if (strpos($text, '::') !== false) {
            $parts = explode('::', $text);
            if (count($parts) > 1) {
                $pathKey = $parts[0];
                $languageKey = $parts[1];
            }
        }

        $segments = explode('.', $languageKey);
        $langFile = array_shift($segments);
        $nestedKey = implode('.', $segments);

        // Use session locale if set, otherwise fallback to config
        $locale = Session::session_get('locale') ?? Config::get('app.locale');

        foreach ($translationDirectories as $directoryPath) {
            $directoryKey = null;

            if (strpos($directoryPath, '::') !== false) {
                [$directoryPath, $directoryKey] = explode('::', $directoryPath);
            }

            // Skip if a namespace is provided and doesn't match
            if ($pathKey && $directoryKey && $directoryKey !== $pathKey) {
                continue;
            }

            $languageFile = rtrim($directoryPath, '/') . "/{$locale}/{$langFile}.php";

            if (!file_exists($languageFile)) {
                continue;
            }

            $translations = require $languageFile;

            if (!is_array($translations)) {
                continue;
            }

            // Support dot notation lookup
            $value = $this->arrayGet($translations, $nestedKey);

            if ($value !== null) {
                return $this->replaceText($replace, $value);
            }
        }

        // Fallback: replace placeholders in original text
        return $this->replaceText($replace, $text);
    }

    /**
     * Replace placeholders in a string like ":key" with actual values.
     */
    public function replaceText(array $param, string $text): string
    {
        foreach ($param as $key => $value) {
            $placeholder = ':' . strtolower($key);
            $text = str_replace($placeholder, $value, $text);
        }

        return $text;
    }

    /**
     * Get a value from a nested array using dot notation.
     */
    private function arrayGet(array $array, string $key)
    {
        $keys = explode('.', $key);

        foreach ($keys as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return null;
            }
            $array = $array[$segment];
        }

        return $array;
    }
}
