<?php
namespace App\Helpers\Models;

use DateTimeImmutable;
use Psr\Clock\ClockInterface;

class OTPClock implements ClockInterface
{
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}