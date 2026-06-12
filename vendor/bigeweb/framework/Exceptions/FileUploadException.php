<?php

namespace illuminate\Support\Exceptions;

class FileUploadException extends \Exception
{
    protected static array $messages = [
        UPLOAD_ERR_INI_SIZE   => 'The uploaded file exceeds upload_max_filesize.',
        UPLOAD_ERR_FORM_SIZE  => 'The uploaded file exceeds the MAX_FILE_SIZE directive.',
        UPLOAD_ERR_PARTIAL    => 'The file was only partially uploaded.',
        UPLOAD_ERR_NO_FILE    => 'No file was uploaded.',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary upload directory.',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
        UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload.',
    ];

    public function __construct(
        string $message = '',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        if (empty($message) && isset(static::$messages[$code])) {
            $message = static::$messages[$code];
        }

        parent::__construct($message, $code, $previous);
    }

    public static function fromUploadError(int $errorCode): self
    {
        return new self(
            static::$messages[$errorCode] ?? 'Unknown upload error.',
            $errorCode
        );
    }

    public static function invalidMimeType(string $mime): self
    {
        return new self("Invalid file type: {$mime}");
    }

    public static function fileTooLarge(int $size): self
    {
        return new self("File size {$size} bytes exceeds the allowed limit.");
    }

    public static function missingParameters(): self
    {
        return new self('Request, request file name, and folder are required.');
    }

    public static function arrayFileExpected(): self
    {
        return new self('Request file should be an array.');
    }
    public static function uploadFailed(string $reason): self
    {
        return new self($reason);
    }
}