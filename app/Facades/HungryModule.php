<?php

namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class HungryModule extends Facade{
    protected static function getFacadeAccessor() { return 'hungrymodule'; }
}