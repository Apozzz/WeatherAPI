<?php declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class WeatherTypeNotInDataBaseException extends Exception
{
    public function render(string $message): Response
    {
        return response()->view('errors.error', ['json' => json_encode(['error' => ['code' => '404', 'message' => $message]],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)], 404);
    }
}

