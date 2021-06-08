<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\View\View;

class WeatherTypeNotInDataBaseException extends Exception
{
    public function render(string $message): View
    {
        return view('errors.error', ['json' => json_encode(['error' => ['code' => '', 'message' => $message]],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)]);
    }
}

