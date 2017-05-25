<?php

namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class RequestGateway extends Facade{
    protected static function getFacadeAccessor() { return 'requestgateway'; }
}