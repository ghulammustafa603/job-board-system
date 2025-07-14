<?php
namespace App\Http\Middleware;
use Illuminate\Http\Middleware\TrustProxies as Middleware;
class TrustProxies extends Middleware {
    protected $proxies;
    protected $headers = self::HEADER_X_FORWARDED_ALL;
} 