<?php

namespace illuminate\Support\Requests;

class Errorbags
{
    public ValidationMessages $validationMessages;

    public function __construct()
    {
        $this->validationMessages = new ValidationMessages();
    }

    public function addErrorBag($ruleName, $attr)
    {
        $msg = $this->validationMessages->errorMessages()[$ruleName];
        $message = str_replace('This', ucfirst($attr), $msg);
        $message = str_replace(['_', '-'], ' ', $message);
        return ($message);
    }
}