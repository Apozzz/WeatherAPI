<?php

namespace Tests\Unit\Exceptions;

use App\Exceptions\CannotConnectToMeteoAPIException;
use Tests\TestCase;
use Mockery;

class CannotConnectToMeteoAPIExceptionTest extends TestCase
{
    public function testCannotConnectToMeteoApiException(): void
    {
        $mock = Mockery::mock();
        $mock->shouldReceive('callAPI')->andThrow(CannotConnectToMeteoAPIException::class);
        $this->expectException(CannotConnectToMeteoAPIException::class);
        $mock->callAPI();
    }
}
