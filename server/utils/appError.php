<?php

class AppError extends Exception
{
    public $statusCode;
    public $status;
    public $isOperational;

    public function __construct($message, $statusCode)
    {
        parent::__construct($message);

        $this->statusCode = $statusCode;
        $this->status = strpos((string)$statusCode, '4') === 0 ? 'fail' : 'error';
        $this->isOperational = true;

        // Optionally, set the stack trace
        $this->file = __FILE__;
        $this->line = __LINE__;
    }
}
