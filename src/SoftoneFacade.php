<?php

namespace NikosIoannidis\Softone;
use Illuminate\Support\Facades\Facade;

class SoftoneFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Softone::class;
    }
}
