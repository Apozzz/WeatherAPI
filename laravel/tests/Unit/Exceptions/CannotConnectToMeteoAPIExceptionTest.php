<?php

namespace Tests\Unit\Exceptions;

use App\Exceptions\CannotConnectToMeteoAPIException;
use Tests\TestCase;

class CannotConnectToMeteoAPIExceptionTest extends TestCase
{
    public function testCannotConnectToMeteoApiException(): void
    {
        $this->expectException(CannotConnectToMeteoAPIException::class);
        throw new CannotConnectToMeteoAPIException();
    }
}
